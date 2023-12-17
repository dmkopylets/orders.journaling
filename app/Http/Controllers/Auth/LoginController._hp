<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;



class LoginController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = 'welcome';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //public function logout()
    //{
    //        $this->middleware('guest')->except('logout');
    //    }


      protected function credentials(Request $request)
    {
        return [
            //'uid' => $request->get('username'),
            'samaccountname' => $request->get('username'),
            'password' => $request->get('password'),
             // масив в облікових даних, що дозволяють аутентифікувати користувачів
             // локальної бази даних, якщо відсутнє з'єднання LDAP :
              'fallback' => [
             //               'email' => $request->get('email'),
             //               'samaccountname' => $request->get('username'),
                              'username' => $request->get('username'),
                              'password' => $request->get('password'),
                            ],
            // Если пользователь пытается войти в систему с указанным выше адресом электронной почты,
            // и этот пользователь не существует в вашем каталоге LDAP, то вместо этого будет
            // выполняться стандартная аутентификация Eloquent                           
            // Если вы хотите, чтобы ваши пользователи LDAP могли входить в ваше приложение,
            // когда подключение LDAP не удается или отсутствует, необходимо включить опцию 
            // синхронизации паролей , чтобы пользователи LDAP могли входить, используя свой последний использованный пароль.
            // Если пароль пользователей LDAP не был синхронизирован, они не смогут войти в систему
        ];
    }

    //protected function validateLogin(Request $request)
    //{
    //        $this->validate($request, [
    //            $this->username() => 'required|string|regex:/^[A-Za-z]+\.[A-Za-z]+$/',
    //            'password' => 'required|string',
    //        ]);     
    //    }

  
    public function username()
    {
        return 'username';
    }


 
}