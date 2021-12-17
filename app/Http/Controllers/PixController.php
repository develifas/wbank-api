<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Nette\Utils\Json;
use PharIo\Version\Exception;
use Illuminate\Support\Facades\Validator;

class PixController extends Controller
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




    public function pixConsult(Request $request)
    {


        try {
            $response = $this->client->request('GET', 'https://bank.qesh.ai/pix/participants', [
                'headers' => [
                    'Accept' => 'application/json',
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


    public function pixConsultKey(Request $request ,$key)
    {


        try {
            $response = $this->client->request('GET', "https://bank.qesh.ai/pix/key/$key", [
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

    public function pixQrcode(Request $request)
    {


        try {
            $response = $this->client->request('POST', 'https://bank.qesh.ai/pix/qr-code/dynamic', [
                'body' => "{
                'amount':'$request->amount',
                'description':$request->description
                }",
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

    public function pixPay(Request $request)
    {


        try {
            $response = $this->client->request('POST', 'https://bank.qesh.ai/pix/pay/key', [
                'body' => '{
                "amount":"'.$request->amount.'",
                "key":"'.$request->key.'",
                "password":"'.$request->password.'"
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

    public function getPix(Request $request,$id)
    {
        try {
            $response = $this->client->request('GET', "https://bank.qesh.ai/transactions/transfer/$id", [
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
