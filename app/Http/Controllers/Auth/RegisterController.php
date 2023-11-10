<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $breadcrumbs = [
            ['link' => route('mainPage'), 'text' => 'Домашняя страница'],
            ['link'=>route('register'),'text'=>"Регистрация"]
        ];
        return view('pages.registrationPage', compact("breadcrumbs"));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id'=>2,
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        try {
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            $user = $this->create($request->all());
            $clientAccount = new Client();
            $clientAccount->first_name = null;
            $clientAccount->second_name = null;
            $clientAccount->middle_name = null;
            $clientAccount->number_phone = null;
            $clientAccount->address = null;
            $clientAccount->birthday = null;
            $clientAccount->city_id = null;
            $clientAccount->user_id = $user->id;
            $clientAccount->save();
            return response()->json(["error" => false, "message" => "Новый аккаунт успешно зарегистрирован!"]);
        } catch (Exception $exception) {
            return response()->json(["error" => true, "message" => $exception->getMessage()]);
        }

    }
}
