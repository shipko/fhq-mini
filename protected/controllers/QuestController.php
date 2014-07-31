<?php

/**
 * usersController is the controller to handle user requests.
 */

class QuestController extends CController
{
	private $method = 'quest';

	public function __construct() {
		if (!Yii::app()->params->log_in) {
			Message::Error('You are not logged');
		}
	}

	public function actionCreate()
	{
		if (!Yii::app()->request->getParam('title'))
			Message::Error('Parameter password is missing');

		if (!Yii::app()->request->getParam('nick'))
			Message::Error('Parameter nick is missing');

		if (!Yii::app()->request->getParam('mail'))
			Message::Error('Parameter mail is missing');

		$users = new Users;

	}

	public function actionSave() 
	{
		
	}
	public function actionGetProfileInfo()
	{
		$id = Yii::app()->params->user['user_id'];
		$user = Users::model()->findByPk($id,array(
			'select' => 'id, role, nick, mail, activated, json_data, date_create, date_last_signin',
			'condition'=>'id=:id',
    		'params'=>array(':id'=> $id),
		));

		if(empty($user))
			Message::Error('The user does not exist.');
		
		Message::Success($user->getAttributes(false));
	
	}

	public function actionSaveProfileInfo()
	{
		if (!Yii::app()->request->getParam('mail'))
			Message::Error("Mail is empty");

		if (!Yii::app()->request->getParam('nick'))
			Message::Error("Nick is empty");
		
		$users = Users::model()->findByPk(Yii::app()->params->user['user_id']);

		if (empty($users))
			Message::Error('The user does not exist');
				
		$users->mail = Yii::app()->request->getParam('mail');
		$users->nick = Yii::app()->request->getParam('nick');
		$users->json_data = Yii::app()->request->getParam('json_data');

		$users->date_last_signup = new CDbExpression('NOW()');

		
		if ($users->save())
			Message::Success('1');
		else
			Message::Error($users->getErrors());		
	}

	public function actionchangePassword()
	{
		if (!Yii::app()->request->getParam('pass'))
			Message::Error("pass is empty");

		$users = Users::model()->findByPk(Yii::app()->params->user['user_id']);
		
		if (empty($users))
			Message::Error('The user does not exist');
		
		$id = Yii::app()->params->user['user_id'];
		$pass = Yii::app()->request->getParam('pass'); 
		Users::model()->updateByPk($id, array('pass' => $pass));
	}
}