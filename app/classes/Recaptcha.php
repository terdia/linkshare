<?php


namespace App\classes;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Recaptcha
{

    /**
     * Verify recaptcha with Google
     *
     *
     * @param array $data
     * @return array|bool
     */
    public static function verify(array $data)
    {
        $client = new Client;

        try{
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => $data
            ]);

            $response = json_decode($response->getBody());

            if(isset($response->success) && !$response->success == true) {
                $error['recaptcha'] = ['Recaptcha verification failed'];
            }

            if(isset($response->hostname) && !$response->hostname == config('APP_URL')){
                $error['recaptcha'] = ['Request originates from a different server'];
            }

            if(isset($error) && count($error)){
                return $error;
            }

            return true;

        }catch (ClientException $exception) {
            return $error['recaptcha'] = [$exception->getMessage()];
        }
    }
}