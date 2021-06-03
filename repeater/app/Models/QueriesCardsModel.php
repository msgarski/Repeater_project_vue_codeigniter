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
        
        $builder->select('card.id')
                ->limit($batchLimit)
                ->join('lesson', 'card.lesson_id=lesson.id')
                ->join('course', 'lesson.course_id=course.id')
                ->where('course.id', $course_id)
                ->orderBy('priority', 'DESC');

        
    
        $score = $builder->get();
        var_dump('w pytaniuuuuuu', $score->getResult());
        exit;
        return $score->getResult();
    }




}
