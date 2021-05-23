<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
use Faker\Provider\Base;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use function PHPUnit\Framework\isJson;

class Login extends ResourceController
{
    use ResponseTrait;

    public function entering()
    {

        helper('jwt_helper');

        $http = $this->request->getJSON();

        $email = $http->email;

        $password = $http->password;
        
        
        $authentic = service('authentication');

        $userData = $authentic->loginAuthentication($email, $password);

        $userId = $userData[0];
        $userEmail = $userData[1];
        
        
        if($userId)
        {   
            $jwt = getSignedJWTForUser($userEmail);

            $response = [
                'token'    =>  $jwt,
                'userId'    =>  $userId
            ];
            
            return $this->respond($response, 200);
        }
        else
        {
            var_dump('NIE udalo sie zalogować');
            exit;
            return $this->respond('Nieprawidlowe dane logowania', 200);
        }   
    }

    public function success()
    {
        return view('Porch/porch_view');
    }

    public function exiting()
    {
        $authentic = service('authentication');

        $authentic->logout();

        return redirect()->to('/')
                        ->with('info', 'Wylogowano');
    }
}

