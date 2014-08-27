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
		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");

		if (!Yii::app()->request->getParam('title'))
			Message::Error('Parameter title is missing');

		if (!(int)Yii::app()->request->getParam('section'))
			Message::Error('Parameter section is missing');

		if (!Yii::app()->request->getParam('short_text'))
			Message::Error('Parameter short_text is missing');
		
		if (!Yii::app()->request->getParam('full_text'))
			Message::Error('Parameter full_text is missing');

		if (!Yii::app()->request->getParam('answer'))
			Message::Error('Parameter answer is missing');

		if (!(int)Yii::app()->request->getParam('score'))
			Message::Error('Parameter score is missing');

		$section = QuestSection::model()->findByPk((int)Yii::app()->request->getParam('section'));
		if (!$section)
			Message::Error('Quest section does not exists');

		$quest = new Quests;
		$quest->setIsNewRecord(true);

		$quest->uuid = new CDbExpression('UUID()');

		$quest->title = Yii::app()->request->getParam('title');

		$quest->section = $section->id;

		$quest->owner = Yii::app()->params->user['user_id'];
		$quest->moderate = Yii::app()->params->user['user_id'];

		$quest->short_text = Yii::app()->request->getParam('short_text');
		$quest->full_text = Yii::app()->request->getParam('full_text');
		$quest->answer = Yii::app()->request->getParam('answer');
		$quest->score = (int)Yii::app()->request->getParam('score');

		$quest->time = new CDbExpression('NOW()');

		if($quest->save())
			Message::Success($quest->id);
		else
			Message::Error($quest->getErrors());
	}

	public function actionGet() 
	{
		$id = (int)Yii::app()->request->getParam('id');
		if (!$id)
			Message::Error('Parameter id is missing');

		$quest = Quests::model()->with('stitle')->findByPk($id, array(
			'select' => 'id, title, section, short_text, full_text, score'
		));
	
		if(!$quest)
			Message::Error('Quest is not found');

		$out = $quest->getAttributes(false);

		$out['section'] = array(
			'id' => $out['section'],
			'title' => $quest->stitle->title
		);
		
		Message::Success($out);
	}

	public function actionSave() 
	{
		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");

		$id = (int)Yii::app()->request->getParam('id');
		if (!$id)
			Message::Error('Parameter id is missing');

		$quest = Quests::model()->findByPk($id);
		
		if(!$quest)
			Message::Error('Quest is not found');

		if (!Yii::app()->request->getParam('title'))
			Message::Error('Parameter title is missing');

		if (!(int)Yii::app()->request->getParam('section'))
			Message::Error('Parameter section is missing');

		if (!Yii::app()->request->getParam('short_text'))
			Message::Error('Parameter short_text is missing');
		
		if (!Yii::app()->request->getParam('full_text'))
			Message::Error('Parameter full_text is missing');

		if (!Yii::app()->request->getParam('answer'))
			Message::Error('Parameter answer is missing');

		if (!(int)Yii::app()->request->getParam('score'))
			Message::Error('Parameter score is missing');
		
		$section = QuestSection::model()->findByPk((int)Yii::app()->request->getParam('section'));
		if (!$section)
			Message::Error('Quest section does not exists');

		$quest->title = Yii::app()->request->getParam('title');

		$quest->section = $section->id;

		$quest->short_text = Yii::app()->request->getParam('short_text');
		$quest->full_text = Yii::app()->request->getParam('full_text');
		$quest->answer = Yii::app()->request->getParam('answer');
		$quest->score = (int)Yii::app()->request->getParam('score');
		
		if($quest->save())
			Message::Success($quest->id);
		else
			Message::Error($quest->getErrors());
	}

	public function actionDelete() 
	{
		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");

		$id = (int)Yii::app()->request->getParam('id');
		if (!$id)
			Message::Error('Parameter id is missing');

		$quest = Quests::model()->findByPk($id);

		if (empty($quest))
			Message::Error('Quest section does not exist');

		$quest->delete();

		Message::Success('1');
	}


	public function actionList()
	{
		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");
		
		$section = Quests::model()->
			published('')->
			with(array(
				'stitle' => array(
					'select' => 'id, title'
				)
			))->
			paginator()->
			findAll(array('select' => 'id, title, section, short_text, full_text, score'));
		// print_r($section);
		$array = array();
		$count = 0;

		foreach($section as $value) {
			$count++;
			// False - return without null values;
			$arr = $value->getAttributes(false);
			$arr['section'] = $value->stitle->getAttributes(false);
			
			$array[] = $arr;
		}

		Message::Success(array(
			'count' => $count,
			'items' => $array
		));
	}

	public function actionListSection()
	{
		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");
		// Быть может добавим пагинатор позже, но сейчас это не нужно
		$section = QuestSection::model()->published('')->findAll(array(
			'select' => 'id, title',
		));
		
		$array = array();
		$count = 0;

		foreach($section as $value) {
			$count++;
			// False - return without null values;
			$array[] = $value->getAttributes(false);
		}

		Message::Success(array(
			'count' => $count,
			'items' => $array
		));
	}

	public function actionGetSection()
	{
		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");

		$id = (int)Yii::app()->request->getParam('id');
		if (!$id)
			Message::Error('Parameter id is missing');

		$section = QuestSection::model()->findByPk($id,
			array('select' => 'id, title')
		);
		
		if (!$section)
			Message::Error('Quest section does not exists');

		Message::Success($section->getAttributes(false));
	}

	public function actionAddSection()
	{
		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");

		$title = Yii::app()->request->getParam('title');
		if (!$title)
			Message::Error('Parameter title is missing');

		$section = new QuestSection;
		
		$section->setIsNewRecord(true);
		$section->title = $title;
		$section->uuid = new CDbExpression('UUID()');

		if ($section->save())
			Message::Success(array('id' => $section->id));
		else
			Message::Error($section->getErrors());

	}

	public function actionEditSection()
	{
		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");

		$id = (int)Yii::app()->request->getParam('id');
		if (!$id)
			Message::Error('Parameter id is missing');

		$title = Yii::app()->request->getParam('title');
		if (!$title)
			Message::Error('Parameter title is missing');

		$section = QuestSection::model()->findByPk($id);

		if (!$section)
			Message::Error('Quest section does not exists');

		$section->title = $title;

		if ($section->save())
			Message::Success(array('id' => $section->id));
		else
			Message::Error($section->getErrors());

	}

	public function actionDeleteSection()
	{
		if (!Yii::app()->params->scopes('admin'))
			Message::Error("You do not have sufficient permissions");

		$id = (int)Yii::app()->request->getParam('id');
		if (!$id)
			Message::Error('Parameter id is missing');

		$section = QuestSection::model()->findByPk($id);

		if (empty($section))
			Message::Error('Quest section does not exist');

		$section->delete();

		Message::Success('1');
	}

}