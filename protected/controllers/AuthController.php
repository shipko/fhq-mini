<?php

/**
 * AuthController is the controller to handle user requests.
 */

class AuthController extends CController
{
	private $method = 'auth';
// 	Регистрация
 	public function actionSignup()
	{
		if (!Yii::app()->params->registration_allow)
			Message::Error('Registration is closed');

		if (!Yii::app()->request->getParam('password'))
			Message::Error('Parameter password is missing');

		if (!Yii::app()->request->getParam('nick'))
			Message::Error('Parameter nick is missing');

		if (!Yii::app()->request->getParam('mail'))
			Message::Error('Parameter mail is missing');

		$users = new Users;

		$users->setIsNewRecord(true);

		$users->role = 1;

		$users->uuid = new CDbExpression('UUID()');
		$users->pass = CPasswordHelper::hashPassword(Yii::app()->request->getParam('password'));
		$users->mail = Yii::app()->request->getParam('mail');
		$users->json_data = CJSON::encode(array());
		$users->date_activated = false;
		$users->activated = 0;
		$users->activation_code = uniqid(); // Случайное число
		$users->nick = Yii::app()->request->getParam('nick');
		$users->rating = 0;
		$users->date_create = new CDbExpression('NOW()');
		$users->date_last_signup = new CDbExpression('NOW()');

		if ($users->save())
			Message::Success(array('id' => $users->id));
		else
			Message::Error($users->getErrors());

	}
}