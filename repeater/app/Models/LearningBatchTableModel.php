<?php

namespace App\Models;

class LearningBatchTableModel extends \CodeIgniter\Model
{
    protected $table = 'course';

    protected $allowedFields = [
                            'tries_median',
                            'words_amount',
                            'created_at'
                            ];

    // tutaj okreslam klasę odpowiedzialną za tworzenie obiektu user:
    protected $returnType = 'App\Entities\LearningEntity';

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