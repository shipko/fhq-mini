<?php
class Attempts extends CActiveRecord {
	public $date_create;

	public $date_change;

	public static function model($classname=__CLASS__)
	{
		return parent::model($classname);
	}

	public function rules()
	{
		return array(
			// required
			array('user, quest, user_answer, real_answer, time','required'),
			
			//length
			array('user', 'numerical', 'integerOnly'=>true),
			array('quest', 'numerical', 'integerOnly'=>true),
			array('user_answer', 'length','min'=>8,'max'=>255),
			array('real_answer','length','min'=>8,'max'=>255),
			array('user_answer', 'filter', 'filter' => 'trim'),
			//
			// array('date_create, date_change', 
			// 	'default',
			// 	'value'=>new CDbExpression('NOW()'),
			// 	'setOnEmpty'=>false,
			// 	'on'=>'insert'
			// 	),
			);
	}

	public function relations() 
	{
		return array(
            'stitle' => array(self::BELONGS_TO, 'QuestSection', 'section'),
        );
	}

	public function published($desc=' DESC')
	{
		$this->getDbCriteria()->mergeWith(array(
			'order' => 't.id'.$desc,
		));

		return $this;
	}

	// public function primaryKey() 
	// {
	// 	return 'id';
	// }
	public function tableName()
	{
		return '{{attempts}}';
	}
}