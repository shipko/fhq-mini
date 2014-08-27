<?php
class Quests extends CActiveRecord {
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
			array('title, section, owner, moderate, short_text, full_text, answer, score, time','required'),
			
			//length
			array('title','length','min'=>3,'max'=>100),
			array('short_text','length','min'=>5),
			array('full_text','length','min'=>20),
			array('answer', 'length','min'=>8,'max'=>255),

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
            'stitle'=>array(self::BELONGS_TO, 'QuestSection', 'id'),
        );
	}

	public function published($desc=' DESC')
	{
		$this->getDbCriteria()->mergeWith(array(
			'order' => 'id'.$desc,
		));

		return $this;
	}

	public function primaryKey() 
	{
		return 'id';
	}
	public function tableName()
	{
		return '{{quests}}';
	}
}