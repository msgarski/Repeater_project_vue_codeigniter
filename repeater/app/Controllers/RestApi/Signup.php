<?php

namespace App\Controllers\RestApi;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;


class Signup extends \CodeIgniter\Controller
{
    use ResponseTrait;


    public function create()
    {
        $data = $this->request->getPost();
        return $this->respond($data, 200);
        // albo:
        //return$this->respondCreated('udalo', 201);

        // musi  otrzymać 4 dane w tablicy asocjacyjnej:
        //dd('funkcja wywołana prawidłowo!!!');
        // $user = new \App\Entities\UserEntity($this->request->getPost());

        // //dd($user);

        // $model = service('userModel');

        // $user->activationByCode();

        // if ($model->insert($user)) {

        //     $this->sendActivationEmail($user);
        
        //     return redirect()->to("/signup/success");
            
        // } 
        // else 
        // {
        //     return redirect()->back()
        //                      ->with('errors', $model->errors())
        //                      ->with('warning', 'Nieprawidłowe dane')
        //                      ->withInput();
        // }
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