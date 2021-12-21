<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Nette\Utils\Json;
use PharIo\Version\Exception;
use Illuminate\Support\Facades\Validator;

class PhoneRechargeController extends Controller
{
    private $client;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->client =  new Client();
    }


    public function listOperators(Request $request,$stateCode)
    {
        try {
            $response = $this->client->request('GET', "https://bank.qesh.ai/topups/phone/providers?stateCode=$stateCode", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'account' => "$request->account_id",
                    'user' => "$request->user_id",
                    'authorization' => "bearer $request->login_token",
                ],
            ]);
            return json_decode($response->getBody(),true);
        }catch (ClientException $e) {
            return $responseBody = $e->getResponse()->getBody(true);
        }

    }


    public function availableValues(Request $request,$stateCode,$providerId)
    {
        try {
            $response = $this->client->request('GET', "https://bank.qesh.ai/topups/phone/providers/price?stateCode=$stateCode&providerId=$providerId", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'account' => "$request->account_id",
                    'user' => "$request->user_id",
                    'authorization' => "bearer $request->login_token",
                ],
            ]);
            return json_decode($response->getBody(),true);
        }catch (ClientException $e) {
            return $responseBody = $e->getResponse()->getBody(true);
        }

    }


    public function phoneCharge(Request $request)
    {
        try {
            $response = $this->client->request('POST', "https://bank.qesh.ai/topups/phone", [
                'body' => '{
                "stateCode":'.$request->stateCode.',
                "phoneNumber":'.$request->phoneNumber.',
                "providerId":'.$request->providerId.',
                "value":'.$request->value.'
                }',
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'account' => "$request->account_id",
                    'user' => "$request->user_id",
                    'authorization' => "bearer $request->login_token",
                ],
            ]);
            return json_decode($response->getBody(),true);
        }catch (ClientException $e) {
            return $responseBody = $e->getResponse()->getBody(true);
        }

    }

}
