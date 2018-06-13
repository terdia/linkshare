<?php
namespace App\Controllers;

use App\classes\Recaptcha;
use App\controllers\Auth\Gatekeeper;
use App\Models\User;
use Legato\Framework\Mail\Mail;
use Legato\Framework\Request;
use Legato\Framework\Security\Auth;
use Legato\Framework\Security\Gate;
use Legato\Framework\Validator\Validator;

class AuthController extends BaseController
{

    public function showLoginForm()
    {
        return view('auth/login');
    }

    public function showSignUpForm()
    {
       return view('auth/register');
    }

    public function signup(Request $request)
    {
        $rules = [
            'username' => ['required' => true, 'min' => 5, 'max' => 20, 'alphaNum' => true, 'unique' => 'users'],
            'email' => ['required' => true, 'email' => true, 'unique' => 'users'],
            'password' => ['required' => true, 'min' => 6],
            'g-recaptcha-response' => ['required' => true],
        ];

        $validator = new Validator($request->all(), $rules);

        $response = Recaptcha::verify([
           'secret' => config('RECAPTCHA_SECRET'),
           'response' => $request->input('g-recaptcha-response'),
           'remoteip' => $request->clientIp()
        ]);

        /**
         * handle validation errors
         */
        if($validator->fail() || is_array($response)) {
            $validation_errors = $validator->error()->get();

            is_array($response) && count($response) ?
                $errors = array_merge($validation_errors, $response) : $errors = $validation_errors;

            return view('auth/register', compact('errors'));
        }

        /**
         * Persist user in database
         */
        $user = $this->persistUser($request);

        if(!$user instanceof User){
            $error = $user;
            return view('auth/register', compact('error'));
        }

        $params = [
            'to' => [$user->email => $user->username],
            'from' => ['no-reply@linkshare.com' => config('APP_NAME')],
            'subject' => 'Account Activation',
            'body' => ['code' => $user->activation_code, 'name' => $user->username],
            'view' => 'emails/activation.php',
        ];

        Mail::send($params);

        return view('auth/register',
            ['success' => 'Account Created successfully please verify your email']);

    }

    public function login(Request $request)
    {
        $rules = [
            'username' => ['required' => true],
            'password' => ['required' => true],
            'g-recaptcha-response' => ['required' => true],
        ];

        $validator = new Validator($request->all(), $rules);

        $response = Recaptcha::verify([
            'secret' => config('RECAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->clientIp()
        ]);

        /**
         * handle validation errors
         */
        if($validator->fail() || is_array($response)) {
            $validation_errors = $validator->error()->get();

            is_array($response) && count($response) ?
                $errors = array_merge($validation_errors, $response) : $errors = $validation_errors;

            return view('auth/login', compact('errors'));
        }

        $credentials = [
            'username' => $request->input('username'), 'password' => $request->input('password')
        ];

        $request->input('remember') == 'on' ? $remember = true : $remember = false;
        $authenticate = Gate::authenticate($credentials, $remember);

        if($authenticate !== true){
            return view('auth/login', ['error' => $authenticate]);
        }

       return redirectTo('/links');

    }

    /**
     * Activation controller
     *
     * @param Request $request
     * @param $code
     */
    public function activate(Request $request, $code)
    {
        $user = User::where('activation_code', $code)->where('activated', 0)->first();

        if(!$user instanceof User) {
            return view('auth/activation',
                ['error' => 'Please login if you have already activated your account.']);
        }

        $user->activate();

        return view('auth/activation',
            ['success' => 'Your email address is confirmed.']);
    }

    /**
     * Logout the user
     */
    public function logout()
    {
        Gatekeeper::logout();
    }

    private function persistUser($request)
    {
        $user = new User;
        $user->username = $request->input('username');
        $user->password = secret($request->input('password'));
        $user->email = $request->input('email');
        $user->activation_code = str_random(15);

        if($request->file()->has('avatar') && $request->file()->get('avatar') != null){
            $file = $request->file()->get('avatar');
            $extension = $file->guessClientExtension();

            if(!in_array($extension, ['png', 'jpeg', 'jpg'])){
                return 'File extension is not valid';
            }

            if( $file->getSize() > 30864 ){
                return 'File size is too big';
            }

            $filename = $request->input('username').'.'.$extension; //$file->getClientOriginalName()
            $file->move(BASE_PATH.'public/avatars', $filename);
            $user->avatar = '/avatars/'.$filename;
        }

        $user->save();

        return $user;
    }
}