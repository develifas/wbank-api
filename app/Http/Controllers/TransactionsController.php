<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Nette\Utils\Json;
use PharIo\Version\Exception;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
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

    public function transactions(Request $request)
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


    public function transactionsConsult(Request $request,$id)
    {


        try {
            $response = $this->client->request('GET', "https://bank.qesh.ai/transactions/$id", [
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
                'body' => "{'amount':'$request->amount','description':$request->description}",
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
