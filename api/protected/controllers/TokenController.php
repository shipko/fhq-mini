<?php

/**
 * TokenController is the controller to handle user requests.
 */

class TokenController extends CController
{
	private $method = 'token';
	// 	Авторизация
 	public function actionAuth()
	{
		if (!Yii::app()->request->getParam('client_id')) 
			Message::Error('Parameter client_id is missing');
		if (!Yii::app()->request->getParam('password'))
			Message::Error('Parameter password is missing');

		if (!Yii::app()->request->getParam('username'))
			Message::Error('Parameter username is missing');

		$user=Users::model()->findByAttributes(array(
				'nick' => Yii::app()->request->getParam('username'),
			)
		);

		if (!$user)
			Message::Error('Username or password is incorrect');
		
		if (!CPasswordHelper::verifyPassword(Yii::app()->request->getParam('password'), $user->pass))
			Message::Error('Username or password is incorrect');
		// Пока закомментировано
		// Логин и пароль совпали
		$token = new Access_Tokens();

		$token->clearOldTokens($user->id);

		$obj = $token->setToken($user->id, $user->role);

		Message::Simple(
			array(
				'access_token' => $obj->access_token,
				'user_id' => $obj->user_id,
				'expires_in' => $obj->expires_in,
				'role' => $user->role
			)
		);

		Message::Error('it\'s ok');
	}
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
		echo 'Hello World';
	}
}