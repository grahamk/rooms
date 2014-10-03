<?php
App::uses('AppModel', 'Model');
/**
 * Resident Model
 *
 * @property Relative $Relative
 * @property Stay $Stay
 */
class Resident extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'lastName';   

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Relative' => array(
			'className' => 'Relative',
			'foreignKey' => 'resident_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Stay' => array(
			'className' => 'Stay',
			'foreignKey' => 'resident_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
