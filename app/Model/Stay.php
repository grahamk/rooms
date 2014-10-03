<?php
App::uses('AppModel', 'Model', 'CakeTime', 'Utility');
 
class Stay extends AppModel {
//}
/**
 * Stay Model
 *
 * @property Resident $Resident
 * @property Room $Room
 */
//class Stay extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'resident_id';
    
    public $virtualFields = array(
        'days' => 'IF(Stay.start BETWEEN 2014-09-01 AND 2014-09-30, DATEDIFF(Stay.end, Stay.start), "fred")'   
    );
    
    var $validate = array(
        'start'=>array(
            'rule'=>'compareDates',
            'message'=>'Start date should be before End date'
        ),
        'fee'=>array(
            'rule'=>'numeric',
            'required'=>true
        )   
    ); 
    
    public function compareDates() 
        { 
        

                return $this->data[$this->alias]['complete'] == 0;
  
        } 

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
		),
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    
}
