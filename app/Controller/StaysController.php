<?php

App::uses('AppController', 'Controller');

/**
 * Stays Controller
 *
 * @property Stay $Stay
 * @property PaginatorComponent $Paginator
 */
class StaysController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler');
    public $helpers = array('Js' => array('Jquery'), 'Number');

    /**
     * index method
     *
     * @return void
     */
    
//        public function dateArray($from, $to, $value = NULL) {
//        $begin = new DateTime($from);
//        $end = new DateTime($to);
//        $interval = DateInterval::createFromDateString('1 day');
//        $days = new DatePeriod($begin, $interval, $end);
//
//        $baseArray = array();
//        foreach ($days as $day) {
//            $dateKey = $day->format("d-M-Y");
//            $baseArray[$dateKey] = $value;
//        }
//
//    return $baseArray;
//}
    
        public function index_month_pdf() {
        $this->Stay->recursive = 0;  
            
        $rangeStart = "2014-09-01";
        $rangeEnd = "2014-09-30";
        
        $this->paginate = array(
            'limit' => 10
        );
        $stays = $this->paginate('Stay');
        $this->set(compact('stays'));
        
        // get number of rooms
        $roomcount = $this->Stay->Room->find('count');
        $this->set('roomcount', $roomcount);

        //print_r($roomcount);
        
        //delete date_range table and start again
        $this->Stay->query('CALL sp_clear_date_ranges()');
        
        foreach ($stays as $stay) {
            
            $begin = $stay['Stay']['start'];
            //if stay is current ie no end date then use today's date
            if(is_null($stay['Stay']['end']))
               {$end = date('Y-m-d');}
            else
               {$end = $stay['Stay']['end'];}
            //$end = $stay['Stay']['end'];
            $room = $stay['Stay']['room_id']; 
            $roomcount = $roomcount;
            
//            $begin = $stay['Stay']['start'];
//            $end = $stay['Stay']['end'];
//            $room = $stay['Stay']['room_id']; 
//            $roomcount = $roomcount;
            
            // call stored procedure sp_date_range on mysql db and set $room_days to results
            $room_days = $this->Stay->query('CALL sp_date_ranges("'.$begin.'", "'.$end.'", "'.$room.'", "'.$roomcount.'");'); 
        }
            
        ini_set('memory_limit', '512M');

        $this->set('room_days', $room_days);
        //print_r($room_days);

    } 
    
    public function getDatesFromRange($start, $end, $roomID){
        
        $start = strtotime($start); 
        $end = strtotime($end); 

        // Loop between timestamps, 1 day at a time 
        do {
           $start = strtotime('+1 day', $start); 
           //echo $start;
            $dates[date("d-m-Y", $start)] = 'Room ' . $roomID;
        } while ($start < $end);
        
        
        
       // $dates = array($start);
        //while(end($dates) < $end){
        //    $dates[date('Y-m-d', strtotime(end($dates).' +1 day'))] = date('Y-m-d', strtotime(end($dates).' +1 day'));
       // }
        return $dates;
    }    
    
    public function index() {
        $this->Stay->recursive = 0;  
        $this->set('stays', $this->Paginator->paginate());
    }
    
    public function indexMonth() {
        $this->Stay->recursive = 0;  
            
        //$rangeStart = "2014-09-01";
        //$rangeEnd = "2014-09-30";
        
        $this->paginate = array(
            'limit' => 10
        );
        $stays = $this->paginate('Stay');
        $this->set(compact('stays'));
        
        // get number of rooms
        $roomcount = $this->Stay->Room->find('count');
        $this->set('roomcount', $roomcount);

        //print_r($roomcount);
        
        //delete date_range table and start again
        $this->Stay->query('CALL sp_clear_date_ranges()');
        
        foreach ($stays as $stay) {
            $begin = $stay['Stay']['start'];
            //if stay is current ie no end date then use today's date
            if(is_null($stay['Stay']['end']))
               {$end = date('Y-m-d');}
            else
               {$end = $stay['Stay']['end'];}
            //$end = $stay['Stay']['end'];
            $room = $stay['Stay']['room_id']; 
            $roomcount = $roomcount;
            
            // call stored procedure sp_date_range on mysql db and set $room_days to results
            $room_days = $this->Stay->query('CALL sp_date_ranges("'.$begin.'", "'.$end.'", "'.$room.'", "'.$roomcount.'");'); 
        }

        $this->set('room_days', $room_days);
        //print_r($room_days);

    }    

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
            
        if (!$this->Stay->exists($id)) {
            throw new NotFoundException(__('Invalid stay'));
        }
        $options = array('conditions' => array('Stay.' . $this->Stay->primaryKey => $id));
        $this->set('stay', $this->Stay->find('first', $options));
        
        //setup length of stay
        $this->data = $this->Stay->read(null, $id);	             
        $date1 = new DateTime($this->data['Stay']['start']);
        $date2 = new DateTime($this->data['Stay']['end']);
        $date3 = new DateTime();
        
        //if end date is later than today then calculate stay to today
        if ($date2 < $date3) 
        {$diff = $date2->diff($date1)->format("%a");}
        else
        {$diff = $date3->diff($date1)->format("%a");}
        
        $diffYears = ($diff / 365);
        
        $this->set('date', $diff);
        $this->set('dateYears', $diffYears);
        
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        
        // named parameter passed to this action:
        //$this->params['named']['room_id']
         
        $residents = $this->Stay->Resident->find('list');
        $this->set(compact('residents'));
        
        $rooms = $this->Stay->Room->find('list');
        $this->set(compact('rooms'));
        
        //setup unavailable dates for new stay
    
        $dateRanges = ClassRegistry::init('DateRange')->find('all', array(
            'conditions' => array('DateRange.a_room' => $this->params['named']['room_id']),
            'fields' => array('DateRange.a_date')
        ));
        $this->set(compact('dateRanges')); 
        
        $dates = array();
        
        foreach ($dateRanges as $no) {
            $dates[] = $no['DateRange']['a_date'];
        }
        
        $this->set(compact('dates'));
        
        //print_r($dates);
      
        if ($this->request->is('post')) {
            $this->Stay->create();
            if ($this->Stay->save($this->request->data)) {            
                $this->Session->setFlash(__('The stay has been saved.'));
                return $this->redirect(
                    array('controller' => 'stays', 'action' => 'index')
                );
            } else {
                $this->Session->setFlash(__('The stay could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) { 
//        $residents = $this->Stay->Resident->find('list');
//        $this->set(compact('residents'));
//        
//        $rooms = $this->Stay->Room->find('list');
//        $this->set(compact('rooms'));
//        
//        if (!$this->Stay->exists($id)) {
//            throw new NotFoundException(__('Invalid stay'));
//        }
//        if ($this->request->is(array('post', 'put'))) {
//            if ($this->Stay->save($this->request->data)) {
//                $this->Session->setFlash(__('The stay has been saved.'));
//                return $this->redirect(array('action' => 'index'));
//            } else {
//                $this->Session->setFlash(__('The stay could not be saved. Please, try again.'));
//            }
//        } else {
//            $options = array('conditions' => array('Stay.' . $this->Stay->primaryKey => $id));
//            $this->request->data = $this->Stay->find('first', $options);
//        }
        
        
// named parameter passed to this action:
        //$this->params['named']['room_id']
         
        $residents = $this->Stay->Resident->find('list');
        $this->set(compact('residents'));
        
        $rooms = $this->Stay->Room->find('list');
        $this->set(compact('rooms'));
        
        //setup unavailable dates for new stay
    
        $dateRanges = ClassRegistry::init('DateRange')->find('all', array(
            'conditions' => array('DateRange.a_room' => $this->params['named']['room_id']),
            'fields' => array('DateRange.a_date')
        ));
        $this->set(compact('dateRanges')); 
        
        $dates = array();
        
        foreach ($dateRanges as $no) {
            $dates[] = $no['DateRange']['a_date'];
        }
        
        $this->set(compact('dates'));
        
        //print_r($dates);
      
        if ($this->request->is('post')) {
            $this->Stay->create();
            if ($this->Stay->save($this->request->data)) {            
                $this->Session->setFlash(__('The stay has been saved.'));
                return $this->redirect(
                    array('controller' => 'stays', 'action' => 'index')
                );
            } else {
                $this->Session->setFlash(__('The stay could not be saved. Please, try again.'));
            }
        }
    }        


    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Stay->id = $id;
        if (!$this->Stay->exists()) {
            throw new NotFoundException(__('Invalid stay'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Stay->delete()) {
            $this->Session->setFlash(__('The stay has been deleted.'));
        } else {
            $this->Session->setFlash(__('The stay could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
