<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Nette\Utils\Json;
use PharIo\Version\Exception;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
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

    public function validateTypedLine(Request $request)
    {
        try {

            $response = $this->client->request('GET', "https://bank.qesh.ai/payments/validate?digitable_line=$request->digitable_line", [
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


    public function payments(Request $request)
    {
        try {
            $response = $this->client->request('POST', 'https://bank.qesh.ai/payments', [
                'body' => '{
                "digitable_line":"'.$request->digitable_line.'",
                "amount":"'.$request->amount.'",
                "due_at":"'.$request->due_at.'"}',
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

    public function getPayments(Request $request)
    {
        try {
            $response = $this->client->request('GET', "https://bank.qesh.ai/transactions/payment/$request->id", [
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
