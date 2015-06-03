<?php

/**
 * settingsController is the controller to handle user requests.
 */

class SettingsController extends CController
{
	private $method = 'settings';

	public function actionSet()
	{
		if (!Yii::app()->params->log_in)
			Message::Error('You are not logged');

		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");

		$key = Yii::app()->request->getParam('key');
		$value = Yii::app()->request->getParam('value');

		$settings = Settings::model()->findByPk($key, array(
			'select' => 'k, value',
		));
		
		$settings->value = $value;

		print_r($settings);
		

		// $settings = new Settings;

		// $setting->title = Yii::app()->request->getParam('title');

		// $teams->owner = Yii::app()->params->user['user_id'];

		// $teams->uuid_team = new CDbExpression('UUID()');
		// $teams->rating = 0;

		// $logo = Yii::app()->request->getParam('logo');
		// $teams->logo = (!empty($logo) ? $logo : '');

		// $teams->json_data = CJSON::encode(array());
		// $teams->json_security_data = CJSON::encode(array());
		
		// $teams->date_create = new CDbExpression('NOW()');
		// $teams->date_change = new CDbExpression('NOW()');


		if ($settings->save())
			Message::Success($settings);
		else
			Message::Error($settings->getErrors());

	}


	public function actionGet()
	{
		if (!Yii::app()->params->log_in)
			Message::Error('You are not logged');

		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");

		$key = Yii::app()->request->getParam('key');
		$settings = Settings::model()->findByPk($key, array(
			'select' => 'k, value',
		));

		Message::Success($settings);
	}
	public function actionDelete()
	{
		if (!Yii::app()->params->log_in)
			Message::Error('You are not logged');

		$id = (int)Yii::app()->request->getParam('id');
		if (!$id) 
			Message::Error('Parameter id is missing');

		$teams = Teams::model()->findByPk($id);

		if (!$teams)
			Message::Error("The team doesn't exists");

		print_r($teams);

		// if (!Yii::app()->params->scopes('admin'))
		// 	Message::Error("You do not have sufficient permissions");

		// if (!Yii::app()->request->getParam('id'))
		// 	Message::Error('Parameter id is missing');

		// $users = Users::model()->findByPk((int)Yii::app()->request->getParam('id'));

		// if (empty($users))
		// 	Message::Error('The user does not exist');

		// $users->delete();

		// Message::Success('1');
	}

}