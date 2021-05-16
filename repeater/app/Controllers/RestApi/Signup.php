<?php

namespace App\Controllers\RestApi;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

use function PHPUnit\Framework\isJson;

class Signup extends ResourceController
{
    use ResponseTrait;


    public function create()
    {
        $http = $this->request->getJSON();
        //$data = $this->request->getRawInput();
        //return $this->respond($http->email, 200);
            // $tt = json_decode($data);
            // $check = json_last_error();
         $data = [
            'name' => $http->name,
            'email' => $http->email,
            'password' => $http->password,
            'password_confirmation' => $http->password_confirmation
         ];
        //print_r($data);
        //var_dump($data);
        //d($data);
        //echo($data);
        return $this->respond(var_dump($data), 200);
        //return$this->respond(var_dump($data), 201);
        //return $this->respond($data->email, 200);
        $user = new \App\Entities\UserEntity($data);
        //return $this->respond($user, 200);
        //echo $data;
        //dd($user);
        
        $model = service('userModel');

        $user->activationByCode();

        if ($model->insert($user)) {

            $this->sendActivationEmail($user);
        
            //return redirect()->to("/signup/success");
            return $this->respond('udalo sieeeee', 200);
        } 
        else 
        {
            // return redirect()->back()
            //                  ->with('errors', $model->errors())
            //                  ->with('warning', 'Nieprawidłowe dane')
            //                  ->withInput();
            return $this->respond("ERRORRRRRRR", 400);
        }
    }

    public function success()
    {
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

		$email->setSubject('Aktywacja konta');

        $message = view('Signup/activation_email_view', [
                    'token'     =>      $user->token
        ]);

		$email->setMessage($message);

		$email->send();
    }
}