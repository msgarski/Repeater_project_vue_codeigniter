<?php

namespace App\Models;

class OptionsTableModel extends \CodeIgniter\Model
{
    protected $table = 'options';

    protected $allowedFields = [
                        'user_id',
                        'overlearning',
                        'batch_learning_limit',
                        'day_learning_limit',
                        'day_repeat_limit'
                            ];

    // tutaj okreslam klasę odpowiedzialną za tworzenie obiektu user:
    protected $returnType = 'App\Entities\OptionsEntity';

    protected $useTimestamps = true;

    protected $validationRules = [
    ];

    protected $validationMessages = [
    ];
}