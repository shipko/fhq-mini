<?php
class Instastream extends CActiveRecord {

	public static function model($classname=__CLASS__)
	{
		return parent::model($classname);
	}

	public function rules()
	{
		return array(

			array('nick','length','max'=>30),
			array('title, author, src', 'required'),
			array('time', 
				'default',
				'value'=>new CDbExpression('NOW()'),
				'setOnEmpty'=>false,
				'on'=>'insert'
				),
			);
	}

	public function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->date_create = new CDbExpression('NOW()');
			$this->rating = 0;
		}

		$this->date_last_signup = new CDbExpression('NOW()');

		return parent::beforeSave();
	}
	public function primaryKey() 
	{
		return 'id';
	}
	public function instastream()
	{
		return 'instastream';
	}
}