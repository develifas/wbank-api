<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Nette\Utils\Json;
use PharIo\Version\Exception;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
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

    public function getAccount(Request $request)
    {

        try {
            $response = $this->client->request('GET', 'https://bank.qesh.ai/accounts', [
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

    public function validatePin(Request $request)
    {

        try {
            $response = $this->client->request('GET', 'https://bank.qesh.ai/accounts/validate/password', [

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

    public function createAccount(Request $request)
    {
        try {
            $response = $this->client->request('POST', 'https://bank.qesh.ai/accounts', [
                'body' => '{"password":"'.$request->password.'"}',
                'headers' => [
                    'Accept' => 'application/json',
                    'user' => "$request->user_id",
                    'authorization' => "bearer $request->login_token",
                ],

            ]);
            return json_decode($response->getBody(),true);
        }catch (ClientException $e) {
            return $responseBody = $e->getResponse()->getBody(true);
        }

    }


    public function accountsNewBillets(Request $request)
    {
        try {

            $response = $this->client->request('POST', 'https://bank.qesh.ai/billets', [

                'body' => '{
                "description":"'.$request->description.'",
                "name":"'.$request->name.'",
                "document":"'.$request->document.'",
                "due_at":"'.$request->due_at.'",
                "address":"'.$request->address.'",
                "number":"'.$request->number.'",
                "city":"'.$request->city.'",
                "state":"'.$request->state.'",
                "zipcode":"'.$request->zipcode.'",
                "amount":'.$request->amount.',
                "logo":"https://cashpagdigital.com/index.html"
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


    public function transactions(Request $request)
    {
        try {

            $response = $this->client->request('GET', "https://bank.qesh.ai/transactions/$request->id_transaction", [


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

    public function consultUser(Request $request)
    {
        try {
            $response = $this->client->request('GET', "https://bank.qesh.ai/users", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'user' => "$request->user_id",
                    'authorization' => "bearer $request->login_token",
                ],
            ]);

            return json_decode($response->getBody(),true);
        }catch (ClientException $e) {
            return $responseBody = $e->getResponse()->getBody(true);
        }
    }


    public function getExtract(Request $request)
    {
        try {
            $response = $this->client->request('GET', "https://bank.qesh.ai/transactions?start=$request->start&end=$request->end", [
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

    public function sendMoney(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [

            CURLOPT_URL => "https://bank.qesh.ai/transactions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"beneficiary\":{\"name\":\"$request->name\",
                \"document\":\"$request->document\",
                \"bank\":\"$request->bank\",
                \"agency\":\"$request->agency\",
                \"account\":\"$request->account\",
                \"type\":\"$request->type\"
                },
                \"amount\":$request->amount,
                \"password\":\"$request->password\",
                \"save\":$request->favorite
                }",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json",
                "account: $request->account_id",
                "authorization: bearer $request->login_token",
                "user: $request->user_id"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;

        }




    }


}
