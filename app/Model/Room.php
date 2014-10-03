<?php
App::uses('AppModel', 'Model');
/**
 * Room Model
 *
 * @property Stay $Stay
 */
class Room extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'number';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Stay' => array(
			'className' => 'Stay',
			'foreignKey' => 'room_id',
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
