<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class QueriesCardsModel
{
    protected $db;
    
    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }
    
    public function CardsForLearnFromCourse($course_id, $batchLimit)
    {
        $builder = $this->db->table('card');
        
        $builder->limit($batchLimit)
                ->join('lesson', 'lesson.id = lesson_id')
                ->join('course', 'course.id = lesson.course_id')
                ->where('course.id', $course_id)
                ->orderBy('priority', 'DESC');
                
        $score = $builder->get();
        
        return $score->getResult();
    }




}
