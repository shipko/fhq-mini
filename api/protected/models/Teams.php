<?php
class teams extends CActiveRecord {
	public static function model($classname=__CLASS__)
	{
		return parent::model($classname);
	}

	public function rules()
	{
		return array(
			array('nick','length','max'=>255),
			array('nick','unique', 'message'=>'This nick  is already exists.'),
			array('logo','length','max'=>255),
			array('host','length','max'=>255),
			array('network', 'length', 'max' => 255),
			array('rating','length','max'=>255),
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
		return '{{teams}}';
	}
}