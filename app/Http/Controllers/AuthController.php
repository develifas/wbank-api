<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Exception;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['cpf', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * Return status of register.
     *
     * @param array
     */
    public function register(Request $request) {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'cpf' => 'required|string|min:11|max:11|unique:users',
                'birthday' => 'required|date',
                'mother' => 'required|string|max:255',
                'email' => 'required|email:rfc,dns',
                'password' => 'required|min:8|max:32',
                'password_confirm' => 'required|same:password',
                'phone' => 'required|string|min:11|max:11',
                'zipcode' => 'required|string|min:8|max:8',
                'state' => 'required|string|min:2|max:2',
                'city' => 'required|string',
                'district' => 'required|string',
                'address' => 'required|string',
                'number' => 'string',
                'logradouro' => 'string',
                'complement' => 'string',
            ];

            $message = [
                'name.required' => 'O Nome é obrigatório.',
                'name.string' => 'O campo nome é do tipo string.',
                'name.max' => 'O nome pode conter no máximo 255 caracteres.',
                'cpf.required' => 'O CPF é obrigatório.',
                'cpf.string' => 'O campo de CPF é do tipo string.',
                'cpf.min' => 'O CPF deve conter 11 digitos.',
                'cpf.max' => 'O CPF deve conter 11 dígitos.',
                'cpf.unique' => 'O CPF informado já está cadastrado.',
                'birthday.required' => 'Precisamos saber sua data de nascimento.',
                'birthday.date' => 'Formato da data é inválido',
                'mother.required' => 'O nome mãe é obrigatório.',
                'mother.string' => 'O campo nome da mãe é do tipo string.',
                'mother.max' => 'O nome da mãe deve conter no mínimo 255 caracteres.',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'O endereço de Email é inválido.',
                'password.required' => 'A senha é obrigatória',
                'password.min' => 'A senha deve conter no mínimo 8 caracteres.',
                'password.max' => 'A senha deve conter no máximo 32 caracteres.',
                'password_confirm.required' => 'Confirme sua senha.',
                'password_confirm.same' => 'Senha não correspondem.',
                'phone.required' => 'O telefone é obrigatório.',
                'phone.string' => 'O campo do telefone é do tipo string',
                'phone.min' => 'O número de telefone deve conter 11 dígitos.',
                'phone.max' => 'O número de telefone deve conter 11 dígitos.',
                'zipcode.required' => 'O CEP é obrigatório.',
                'zipcode.string' => 'O campo CEP é do tipo string',
                'zipcode.min' => 'O CEP deve conter 8 digitos.',
                'zipcode.max' => 'O CEP deve conter 8 dígitos.',
                'state.required' => 'O estado é obrigatório',
                'state.string' => 'O campo estado é  do tipo string',
                'state.min' => 'O campo estado deve conter o formato UF.',
                'state.max' => 'O campo estado deve conter o formato UF.',
                'city.required' => 'A cidade é obrigatória.',
                'city.string' => 'O campo cidade do tipo string',
                'district.required' => 'O bairro é obrigatório.',
                'district.string' => 'O campo bairro do tipo string',
                'address.required' => 'O endereço é obrigatório.',
                'address.string' => 'O campo endereço do tipo string.',
                'number.string' => 'O campo número é do tipo string.',
                'logradouro.string' => 'O campo logradouro é do tipo string.',
                'complement.string' => 'O campo complemento é do tipo string.',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if($validator->fails()) {
                return response()->json($validator->errors());
            }

            if(! $validator->fails()) {

                $user = new User();

                $user->uid = Uuid::uuid4();
                $user->name = $request->name;
                $user->cpf = $request->cpf;
                $user->birthday = $request->birthday;
                $user->mother = $request->mother;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->phone = $request->phone;
                $user->zipcode = $request->zipcode;
                $user->state = $request->state;
                $user->city = $request->city;
                $user->district = $request->district;
                $user->address = $request->address;
                $user->number = $request->number;
                $user->public_place = $request->public_place;
                $user->complement = $request->complement;

                try {
                    if($user->save()) {
                        return response()->json([
                            'data' => $request->all(),
                            'response' => [
                                'message' => 'Cadastro realizado com sucesso.',
                                'code' => 200,
                            ]
                        ],  200);
                    } else {
                        return response()->json([
                            'message' => 'Falha ao tentar salvar os dados.Tente novamente.',
                            'code' => 400,
                        ]);
                    }
                } catch(Exception $error) {
                    return response()->json($error->getMessage());
                }
            }        
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
