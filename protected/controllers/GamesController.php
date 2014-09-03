<?php

/**
 * usersController is the controller to handle user requests.
 */

class GamesController extends CController
{
	private $method = 'games';

	public function __construct() {
		if (!Yii::app()->params->log_in) {
			Message::Error('You are not logged');
		}
	}

	public function actionCreate()
	{
		if (!Yii::app()->request->getParam('title'))
			Message::Error("Title is empty");

		$games = new Games;
		
		$games->setIsNewRecord(true);

		$games->title = Yii::app()->request->getParam('title');

		if (Yii::app()->request->getParam('logo'))
			$games->logo = Yii::app()->request->getParam('logo');

		// В первой версии у нас не будет типов игр
		$games->type_game = 1;

		$games->date_create = new CDbExpression('NOW()');
		$games->date_change = new CDbExpression('NOW()');
		
		if (Yii::app()->request->getParam('date_start'))
			$games->date_start = Yii::app()->request->getParam('date_start'); // Нужно проверить
		else
			$games->date_start = new CDbExpression('NOW()');

		if (Yii::app()->request->getParam('date_stop'))
			$games->date_stop = Yii::app()->request->getParam('date_stop'); // Нужно проверить
		else
			$games->date_stop = time();

		$games->rating = 0;
		$games->owner = Yii::app()->params->user['user_id'];

		$games->uuid_game = new CDbExpression('UUID()');

		$games->json_data = new CDbExpression('UUID()');
		$games->json_security_data = new CDbExpression('UUID()');

		if ($games->save())
			Message::Success('1');
		else
			Message::Error($games->getErrors());
	}

	public function actionList()
	{
		$pages = Pages::model()->findAll(array(
			'select' => 'id, title',
		));
		
		$array = array();
		$count = 0;

		foreach($pages as $value) {
			$count++;
			// False - return without null values;
			$array[] = $value->getAttributes(false);
		}

		Message::Success(array(
			'count' => $count,
			'items' => $array
		));
	}
	
	public function actionGet()
	{
		if (!Yii::app()->request->getParam('id'))
			Message::Error('Parameter id is missing');

		$pages = Users::model()->findByPk(Yii::app()->request->getParam('id'),array(
			'select' => 'id,title,text',
			'condition'=>'id=:id',
    		'params'=>array(':id'=> Yii::app()->request->getParam('id')),
		));

		if(empty($pages))
			Message::Error('The pages does not exist.');
		
		Message::Success($pages->getAttributes(false));
	}

	public function actionDelete()
	{
		if (!Yii::app()->request->getParam('id'))
			Message::Error('Parameter id is missing');

		$pages = Pages::model()->findByPk((int)Yii::app()->request->getParam('id'));

		if (empty($pages))
			Message::Error('The pages does not exist');

		$pages->delete();

		Message::Success('1');
	}

	public function actionSave()
	{
		if (!Yii::app()->request->getParam('id'))
			Message::Error('Parameter id is missing');

		if (!Yii::app()->request->getParam('title'))
			Message::Error("title is empty");

		if (!Yii::app()->request->getParam('text'))
			Message::Error("text is empty");

		$pages = Pages::model()->findByPk(19);
		
		if (empty($pages))
			Message::Error('The pages does not exist');
				
		$pages->title = Yii::app()->request->getParam('title');
		$pages->text = Yii::app()->request->getParam('text');

		
		if ($pages->save())
			Message::Success('1');
		else
			Message::Error($pages->getErrors());
	}
	
	
}