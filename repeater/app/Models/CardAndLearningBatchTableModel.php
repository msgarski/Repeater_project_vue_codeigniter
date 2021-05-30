<?php

namespace App\Models;

class CardAndLearningBatchTableModel extends \CodeIgniter\Model
{
    protected $table = 'course';

    protected $allowedFields = [
                        'learning_batch_id',
                        'card_id',
                        'created_at'
                            ];

    // tutaj okreslam klasę odpowiedzialną za tworzenie obiektu user:
    protected $returnType = 'App\Entities\CardAndlearningBatchEntity';

    protected $useTimestamps = true;

    protected $validationRules = [
    ];

    protected $validationMessages = [
    ];

    public function getAllCoursesByUserId($userId)
    {
        return $this->where('user_id', $userId)
                        ->findAll();
    }

    public function getCourseByCourseId($courseId)
    {
        return $this->where('id', $courseId)
                    ->first();
    }
}