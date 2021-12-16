<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientSessionController;
use App\Http\Controllers\ClientRegisterController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\PaymentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


Route::group(['middleware' => 'api',
    'prefix' => 'bank'
], function ($router) {


    /*
    |--------------------------------------------------------------------------
    | API Routes TOKEN
    |--------------------------------------------------------------------------
    */
    //Controllers Generate api-token
    Route::post('token', [ClientSessionController::class, 'acessSessionToken']);

    //Controllers Generate "LOGIN TOKEN"
    Route::post('login', [ClientSessionController::class, 'accountLogin']);



    /*
    |--------------------------------------------------------------------------
    | API Routes REGISTER
    |--------------------------------------------------------------------------
    */
    //Controllers Register Users
    Route::post('register/p/user', [ClientRegisterController::class, 'accountPersonRegisterUser']);

    //Controllers Register Address
    Route::post('register/p/address', [ClientRegisterController::class, 'accountPersonRegisterAddress']);

    //Controllers Register Selfie
    Route::post('register/p/doc/selfie', [ClientRegisterController::class, 'accountPersonRegisterDocSelfie']);

    //Controllers Register Document (RG)
    Route::post('register/p/doc/id/front', [ClientRegisterController::class, 'accountPersonRegisterDocIdFront']);
    Route::post('register/p/doc/id/verse', [ClientRegisterController::class, 'accountPersonRegisterDocIdVerse']);

    //Controllers Register Document (CNH)
    Route::post('register/p/doc/driver/front', [ClientRegisterController::class, 'accountPersonRegisterDocDriverFront']);
    Route::post('register/p/doc/driver/verse', [ClientRegisterController::class, 'accountPersonRegisterDocDriverVerse']);

    //Controllers Register Users
    Route::post('register/b/user', [ClientRegisterController::class, 'accountPersonRegisterUser']);

    //Controllers Register Address
    Route::post('register/b/address', [ClientRegisterController::class, 'accountPersonRegisterAddress']);

    //Controllers Register Selfie
    Route::post('register/b/doc/selfie', [ClientRegisterController::class, 'accountPersonRegisterDocSelfie']);

    //Controllers Register Document (RG)
    Route::post('register/b/doc/id/front', [ClientRegisterController::class, 'accountPersonRegisterDocIdFront']);
    Route::post('register/b/doc/id/verse', [ClientRegisterController::class, 'accountPersonRegisterDocIdVerse']);

    //Controllers Register Document (CNH)
    Route::post('register/b/doc/driver/front', [ClientRegisterController::class, 'accountPersonRegisterDocDriverFront']);
    Route::post('register/b/doc/driver/verse', [ClientRegisterController::class, 'accountPersonRegisterDocDriverVerse']);

    //Controllers Register COMPANY (Contrato Social)
    Route::post('register/b/doc/company', [ClientRegisterController::class, 'accountPersonRegisterDocCompany']);

    /*
    |--------------------------------------------------------------------------
    | API Routes ACCOUNTS
    |--------------------------------------------------------------------------
    */
    //Controller Create New billets
    Route::post('accounts/new/billets', [AccountController::class, 'accountsNewBillets']);

    //Controller Get Account
    Route::get('accounts', [AccountController::class, 'getAccount']);

    //Controller User Query Returns
    Route::get('accounts/list/users', [AccountController::class, 'consultUser']);

    Route::get('accounts/extracts', [AccountController::class, 'getExtract']);

    //Controller Validate Secure Pin
    Route::get('accounts/validate/password', [AccountController::class, 'validatePin']);

    //Controller Create New Account
    Route::get('accounts/new/wallet', [AccountController::class, 'createAccount']);

    /*
    |--------------------------------------------------------------------------
    | API Routes TRANSACTIONS
    |--------------------------------------------------------------------------
    */

    //Controller Send Transfer
    Route::post('transactions', [TransactionsController::class, 'transactions']);
    //Controller Transactions Details By ID
    Route::get('transactions', [TransactionsController::class, 'transactionsConsult']);

    /*
    |--------------------------------------------------------------------------
    | API Routes PAYMENTS
    |--------------------------------------------------------------------------
    */

    //Controller Make Payment
    Route::post('payments', [PaymentsController::class, 'payments']);

    //Controller Validate Digitable line
    Route::get('payments/codebar', [PaymentsController::class, 'validateTypedLine']);

    //Controller Return Billets from ID
    Route::get('payments/get', [PaymentsController::class, 'getPayments']);






});
