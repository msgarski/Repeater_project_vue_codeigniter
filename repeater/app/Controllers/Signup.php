<?php

//namespace App\Controllers\RestApi;
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\ProductModel;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use function PHPUnit\Framework\isJson;

class Signup extends ResourceController
{
    use ResponseTrait;

    public function create()
    {

        // var_dump('w tworzeniu usera');
        // exit;
        /*
        *   Method is ready for succesfully creating new user
        *
        */
        $http = $this->request->getJSON();

        $data = [
                    'name' => $http->name,
                    'email' => $http->email,
                    'password' => $http->password,
                    'password_confirmation' => $http->password_confirmation
                ];
        //return $this->respond($http->email, 200);
            
        //return $this->respond($data, 222);

        $user = new \App\Entities\UserEntity($data);
        
        $model = service('userModel');

        $user->activationByCode();

        if ($model->insert($user)) {

            $this->sendActivationEmail($user);
            
            $user_id = $model->getUserByEmail($http->email);

            // var_dump('oto nowy user: ', $user_id->id);
            // exit;
            
            return $this->respond($user_id->id, 200);
        }
        else 
        {
            // return redirect()->back()
            //                  ->with('errors', $model->errors())
            //                  ->with('warning', 'Nieprawidłowe dane')
            //                  ->withInput();
            return $this->respond("ERRORRRRRRR tworzenia usera", 400);
        }
    }

    public function success()
    {
        //todo ta funkcja niepotrzebna w vue...
		return view('Signup/success_view');
    }

    public function activate($token)
    {
        $model = service('userModel');

        $model->activateByToken($token);

        return view('Signup/account_activated_view');
    }

    public function sendActivationEmail($user)
    {
        $email = service('email');

		$email->setTo($user->email);

		$email->setFrom('garski@wp.pl');

		$email->setSubject('Aktywacja konta w programie Repeater');

        $message = view('Signup/activation_email_view', [
                    'token'     =>      $user->token
        ]);

		$email->setMessage($message);

		$email->send();
    }
}