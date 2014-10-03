<?php
App::uses('AppController', 'Controller');
/**
 * Floors Controller
 *
 * @property Floor $Floor
 * @property PaginatorComponent $Paginator
 */
class FloorsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Floor->recursive = 0;
		$this->set('floors', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Floor->exists($id)) {
			throw new NotFoundException(__('Invalid floor'));
		}
		$options = array('conditions' => array('Floor.' . $this->Floor->primaryKey => $id));
		$this->set('floor', $this->Floor->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Floor->create();
			if ($this->Floor->save($this->request->data)) {
				$this->Session->setFlash(__('The floor has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The floor could not be saved. Please, try again.'));
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
		if (!$this->Floor->exists($id)) {
			throw new NotFoundException(__('Invalid floor'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Floor->save($this->request->data)) {
				$this->Session->setFlash(__('The floor has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The floor could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Floor.' . $this->Floor->primaryKey => $id));
			$this->request->data = $this->Floor->find('first', $options);
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
		$this->Floor->id = $id;
		if (!$this->Floor->exists()) {
			throw new NotFoundException(__('Invalid floor'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Floor->delete()) {
			$this->Session->setFlash(__('The floor has been deleted.'));
		} else {
			$this->Session->setFlash(__('The floor could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
