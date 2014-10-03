<?php
App::uses('AppController', 'Controller');
/**
 * Relatives Controller
 *
 * @property Relative $Relative
 * @property PaginatorComponent $Paginator
 * @property sessionComponent $session
 * @property SessionComponent $Session
 */
class RelativesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Relative->recursive = 2;
        
        $options = array('conditions' => array('Resident.current' => 1));
		$this->set('relatives', $this->Relative->find('all', $options));
        
		//$this->set('relatives', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Relative->exists($id)) {
			throw new NotFoundException(__('Invalid relative'));
		}
		$options = array('conditions' => array('Relative.' . $this->Relative->primaryKey => $id));
		$this->set('relative', $this->Relative->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Relative->create();
			if ($this->Relative->save($this->request->data)) {
				$this->Session->setFlash(__('The relative has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The relative could not be saved. Please, try again.'));
			}
		}
		$residents = $this->Relative->Resident->find('list');
		$this->set(compact('residents'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Relative->exists($id)) {
			throw new NotFoundException(__('Invalid relative'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Relative->save($this->request->data)) {
				$this->Session->setFlash(__('The relative has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The relative could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Relative.' . $this->Relative->primaryKey => $id));
			$this->request->data = $this->Relative->find('first', $options);
		}
		$residents = $this->Relative->Resident->find('list');
		$this->set(compact('residents'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Relative->id = $id;
		if (!$this->Relative->exists()) {
			throw new NotFoundException(__('Invalid relative'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Relative->delete()) {
			$this->Session->setFlash(__('The relative has been deleted.'));
		} else {
			$this->Session->setFlash(__('The relative could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
