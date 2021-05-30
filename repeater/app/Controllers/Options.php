<?php

namespace App\Controllers;

use App\Libraries\MassCardInput;
use App\Libraries\Queries;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\Controller;
use Faker\Provider\Base;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use function PHPUnit\Framework\isJson;
use App\Controllers\Porch;

//class User extends ResourceController - może tak?

    
class Options extends BaseController
{
    use ResponseTrait;

    protected $optionsModel;

    public function __construct()
    {
        $this->optionsModel = service('optionsModel');
    }

    public function insertOptions()
    {
        $http = $this->response->getJSON();

        $data = [
            'question'          =>  $http->question,
            'answer'            =>  $http->answer,
            'pronounciation'    =>  $http->pronounciation,
            'sentence'          =>  $http->sentence,
            'image'             =>  $http->image,
        ];
        
        if ($this->model->insert($data)) 
        {
        
            //$data['recent'] = $this->model->amountOfCards();
            
            return $this->respond('słowo zapisane', 200);            
        } 
        else 
        {
            return $this->respond('zapis nieudany', 401);
        }
    }
}