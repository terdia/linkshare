<?php


namespace App\classes;


use Legato\Framework\Request;
use Legato\Framework\Validator\Validator;

class ValidatorHelper
{

    /**
     * Parse validation errors
     *
     * @param Request $request
     * @param Validator $validator
     * @return array|bool|mixed
     */
    public static function parseErrors(Request $request, Validator $validator)
    {
        if($request->input('g-recaptcha-response'))
        {
            $response = static::getRecaptchaResponse($request);
        }else{
            $response = null;
        }

        if($validator->fail() || is_array($response))
        {
            $validation_error = $validator->error()->get();

            return is_array($response) && count($response) ?
                array_merge($validation_error, $response) : $validation_error;
        }

        return true;
    }

    /**
     * Get recaptcha response
     *
     * @param Request $request
     * @return array|bool
     */
    public static function getRecaptchaResponse(Request $request)
    {
        return Recaptcha::verify([
            'secret' => config('RECAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->clientIp()
        ]);
    }
}