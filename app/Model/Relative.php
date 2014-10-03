<?php
App::uses('AppModel', 'Model');
/**
 * Relative Model
 *
 * @property Resident $Resident
 */
class Relative extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'lastName';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Resident' => array(
			'className' => 'Resident',
			'foreignKey' => 'resident_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
