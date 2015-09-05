<?php
class Attempts extends CActiveRecord {

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
			array('user_answer', 'length','min'=>4,'max'=>255),
			array('real_answer','length','min'=>4,'max'=>255),
			array('user_answer', 'filter', 'filter' => 'trim'),
		);
	}

	public function relations() 
	{
		return array(
            'quests' => array(self::BELONGS_TO, 'Quests', 'quest'),
            'quest_section' => array(self::HAS_ONE, 'QuestSection', array('section'=>'id'), 'through'=>'quests')
        );
	}
	public function published($desc=' DESC')
	{
		$this->getDbCriteria()->mergeWith(array(
			'order' => 't.time'.$desc,
		));

		return $this;
	}
	public function primaryKey() {
		return 'time';
	}
	public function tableName()
	{
		return '{{attempts}}';
	}
}