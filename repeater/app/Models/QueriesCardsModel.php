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
                ->join('lesson', 'card.lesson_id = lesson.lesson_id')
                ->join('course', 'lesson.course_id = course.course_id')
                ->where('course.course_id', $course_id)
                ->where('card.learned_at', null)
                ->where('card.awkward', false)
                ->orderBy('card.priority', 'DESC');

        $score = $builder->get();
        
        return $score->getResult();
    }
    public function getFullInfoOfUserCourses($user_id)
    {
        // var_dump('w pytaniu: ', $user_id);
        // exit;
        // $builder = $this->db->table('course');

        // $builder->select('course.course_id, course.name, lesson.name')
        //         ->join('lesson', 'course.course_id = lesson.course_id', 'left')
        //         ->where('course.user_id', $user_id);

            // query for reaching by given user_id courses: 
            // num of lessons, cards, awkwards, to_learning, for_repeating
        $query = $this->db->query("
        select c.user_id, c.course_id, count(l.lesson_id) as lesson_amount, 
            (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id) as card_amount,
            (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id AND card.awkward = 1) as awkward_amount,
            (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id AND card.learned_at IS NULL) as for_learning,
            (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id AND card.next_repeat < NOW()) as for_repeating
                    from course as c
                    left join lesson as l
                    on c.course_id = l.course_id
                    WHERE c.user_id = " .$this->db->escape($user_id)."
                    group by c.course_id
            ;"
        );

        return $query->getResult();
        //$score = $builder->get();

        //return $score->getResult();
        
    }
    public function updateCard($card_id)
    {
        


        $builder = $this->db->table('card');
        
        // if card exists:
        

        $score = $builder->get();
        
        return $score->getResult();
    }
    public function pytania()
    {
        $query = ("select c.course_id, count(l.lesson_id) as lesson_amount, 
        (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id) as card_amount,
        (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id AND card.awkward = 1) as awkward_amount,
        (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id AND card.learned_at IS NULL) as for_learning
                from course as c
                left join lesson as l
                on c.course_id = l.course_id
                group by c.course_id;");

        // w kursie ile jest: lekcji, kart, trudnych, do nauki, do powtórki
        $query = ("select c.course_id, count(l.lesson_id) as lesson_amount, 
                (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id) as card_amount,
                (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id AND card.awkward = 1) as awkward_amount,
                (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id AND card.learned_at IS NULL) as for_learning,
                (SELECT COUNT(*) FROM card WHERE card.lesson_id = l.lesson_id AND card.next_repeat < NOW()) as for_repeating
                        from course as c
                        left join lesson as l
                        on c.course_id = l.course_id
                        group by c.course_id;");
    }




}
