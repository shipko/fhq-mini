<?php

/**
 * TimerController is the controller to handle user requests.
 */

class TimerController extends CController
{
	private $method = 'timer';
	
	public function __construct() {
		if (!Yii::app()->params->log_in) {
			Message::Error('You are not logged');
		}
	}

	public function actionGet()
	{
		if(!Yii::app()->params->timer['avaiable']) {
			Message::Error('The timer is not avaiable');
		}

		$diff = Yii::app()->params->timer['start'] - time();
		Message::Success(array(
			'start' => ($diff > 0 ? $diff : 0)
		));
	}
	
	
}