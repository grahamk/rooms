<?php
App::uses('AppController', 'Controller');
/**
 * Residents Controller
 *
 * @property Resident $Resident
 * @property PaginatorComponent $Paginator
 */
class ResidentsController extends AppController {

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
	public function index() {
		$this->Resident->recursive = 0;
        
        if(!isset($this->params['named']['current']))
            {
                //$this->set('residents', $this->Paginator->paginate());
                $this->set('residents', $this->Resident->find('all')); 
                // get number of residents
                $residentcount = $this->Resident->find('count');
                $this->set('residentcount', $residentcount);
                $this->set('title_for_layout', "All Residents (" . $residentcount . ")");            
            
            }
        else
            {
            
                if($this->params['named']['current']==1)
                    {
                        // get number of residents
                        $residentcount = $this->Resident->find('count', 
                                                    array('conditions' =>
                                                    array('Resident.current' => 1)
                                                         )
                                                     );
                        $this->set('residentcount', $residentcount); 
                        $this->set('title_for_layout', "Current Residents (" . $residentcount . ")");                    
                
                    }
                if($this->params['named']['current']==0)
                    {
                        // get number of residents
                        $residentcount = $this->Resident->find('count', 
                                                    array('conditions' =>
                                                    array('Resident.current' => 0)
                                                         )
                                                     );
                        $this->set('residentcount', $residentcount); 
                        $this->set('title_for_layout', "Past Residents (" . $residentcount . ")");                    
                    }
                //$options = array('conditions' => array('Resident.current' => $this->params['named']['current']));
                $this->set('residents', $this->Resident->find('all', 
                                                    array('conditions' =>
                                                    array('Resident.current' => $this->params['named']['current'])
                                                         )
                                                     ));
            }
        


		//$this->set('residents', $this->Paginator->paginate());
	}
    
	public function contactlist_pdf() {
		$this->Resident->recursive = 2;
        
        if(!isset($this->params['named']['current']))
            {
            
                // get number of residents
                $residentcount = $this->Resident->find('count', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => 1
                                                        )
                                                    )
                                            );
                $this->set('residentcount', $residentcount);
            
                $this->set('title_for_layout', 'Resident contact list');
            
                $this->set('residents', $this->Resident->find('all', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => 1
                                                        )
                                                    )
                                                )                                                  
                                            );
            }
        else
            {
            
                if($this->params['named']['current']==1){$this->set('title_for_layout', 'Current Resident contact list');}
                if($this->params['named']['current']==0){$this->set('title_for_layout', 'Past Resident contact list');}
                $this->set('residents', $this->Resident->find('all', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => $this->params['named']['current']
                                                        )
                                                    )
                                                )                                                  
                                            );
            }
	}    
    
	public function postalvote_pdf() {
		$this->Resident->recursive = 0;
        
        if(!isset($this->params['named']['current']))
            {
            
                // get number of residents
                $residentcount = $this->Resident->find('count', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => 1,
                                                        'Resident.postalvote' => 1 
                                                        )
                                                    )
                                            );
                $this->set('residentcount', $residentcount);
            
                $this->set('title_for_layout', 'All current Residents who require a postal vote (' . $residentcount . ')');
            
                $this->set('residents', $this->Resident->find('all', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => 1,
                                                        'Resident.postalvote' => 1
                                                        )
                                                    )
                                                )                                                  
                                            );            
            }
        else
            {
            
                if($this->params['named']['current']==1){$this->set('title_for_layout', 'Current Residents who require a postal vote');}
                if($this->params['named']['current']==0){$this->set('title_for_layout', 'Past Residents who require a postal vote');}
                $this->set('residents', $this->Resident->find('all', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => $this->params['named']['current'],
                                                        'Resident.postalvote' => 1
                                                        )
                                                    )
                                                )                                                  
                                            );
            }

	}    
    
	public function tv_pdf() {
		$this->Resident->recursive = 0;
        
        if(!isset($this->params['named']['current']))
            {
            
                // get number of residents
                $residentcount = $this->Resident->find('count', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => 1,
                                                        'Resident.tv' => 1 
                                                        )
                                                    )
                                            );
                $this->set('residentcount', $residentcount);
            
                $this->set('title_for_layout', 'All current Residents who have a TV (' . $residentcount . ')');
            
                $this->set('residents', $this->Resident->find('all', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => 1,
                                                        'Resident.tv' => 1
                                                        )
                                                    )
                                                )                                                  
                                            );            
            }
        else
            {
            
                if($this->params['named']['current']==1){$this->set('title_for_layout', 'Current Residents who have a TV');}
                if($this->params['named']['current']==0){$this->set('title_for_layout', 'Past Residents who have a TV');}
                $this->set('residents', $this->Resident->find('all', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => $this->params['named']['current'],
                                                        'Resident.tv' => 1
                                                        )
                                                    )
                                                )                                                  
                                            );
            }

	}     
    
	public function birthday_pdf() {
		$this->Resident->recursive = 0;
        
        if(!isset($this->params['named']['current']))
            {
                //$this->set('residents', $this->Paginator->paginate());
                $this->set('title_for_layout', 'All current Residents who have a Birthday this month');
            
                $this->set('residents', $this->Resident->find('all', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => 1,
                                                        //'MONTH(Resident.dob)' => date('m', strtotime('+30 days'))
                                                        'MONTH(Resident.dob)' => date('m')
                                                        )
                                                    )
                                                )                                                  
                                            );            
            }
        else
            {
            
                if($this->params['named']['current']==1){$this->set('title_for_layout', 'Current Residents Birthdays');}
                if($this->params['named']['current']==0){$this->set('title_for_layout', 'Past Residents Birthdays');}
                //$options = array('conditions' => array('Resident.current' => $this->params['named']['current']));
                $this->set('residents', $this->Resident->find('all', array(
                                                        'conditions' =>array(
                                                        'Resident.current' => $this->params['named']['current'],
                                                        'MONTH(Resident.dob)' => date('m', strtotime('+120 days'))
                                                        )
                                                    )
                                                )                                                  
                                            );
            }

	} 

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
        $this->Resident->recursive = 2;
		if (!$this->Resident->exists($id)) {
			throw new NotFoundException(__('Invalid resident'));
		}
		$options = array('conditions' => array('Resident.' . $this->Resident->primaryKey => $id));
		$this->set('resident', $this->Resident->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Resident->create();
			if ($this->Resident->save($this->request->data)) {
				$this->Session->setFlash(__('The resident has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The resident could not be saved. Please, try again.'));
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
		if (!$this->Resident->exists($id)) {
			throw new NotFoundException(__('Invalid resident'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Resident->save($this->request->data)) {
				$this->Session->setFlash(__('The resident has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The resident could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Resident.' . $this->Resident->primaryKey => $id));
			$this->request->data = $this->Resident->find('first', $options);
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
		$this->Resident->id = $id;
		if (!$this->Resident->exists()) {
			throw new NotFoundException(__('Invalid resident'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Resident->delete()) {
			$this->Session->setFlash(__('The resident has been deleted.'));
		} else {
			$this->Session->setFlash(__('The resident could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
