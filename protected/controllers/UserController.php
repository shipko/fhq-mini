<?php

/**
 * usersController is the controller to handle user requests.
 */
class UserController extends CController
{
    private $method = 'user';

    public function __construct() {
        if (Yii::app()->params->timer['end']  < time() && !Yii::app()->params->scopes('admin')) {
            exit('The game ended');
        }
    }

    public function actionList()
    {
        if (Yii::app()->params->timer['end']  < time() && !Yii::app()->params->scopes('admin')) {
            exit('The game ended');
        }
        if (!Yii::app()->params->log_in)
            Message::Error('You are not logged');

        $order = Yii::app()->request->getParam('order');
        if ($order != 'rating')
            $order = false;

        $select = 'id, role, nick, activated, rating';
        if (Yii::app()->params->scopes('admin'))
            $select = 'id, role, nick, activated, mail, rating, json_data, date_create, date_last_signin';

        $users = Users::model()->published($order)->paginator()->findAll(array(
            'select' => $select,
            //'condition' => 'deleted=0' //проверка на удаление
        ));

        $array = array();
        $count = 0;

        foreach ($users as $value) {
            $count++;
            // False - return without null values;
            $item = $value->getAttributes(false);

            $item['passed'] = '0';
            $item['processing'] = '0';
            $array[] = $item;
        }

        Message::Success(array(
            'count' => $count,
            'items' => $array
        ));
    }

    public function actionGet()
    {
        if (Yii::app()->params->timer['end']  < time() & !Yii::app()->params->scopes('admin')) {
            exit('The game ended');
        }
        if (!Yii::app()->params->log_in)
            Message::Error('You are not logged');

        if (!Yii::app()->request->getParam('id'))
            Message::Error('Parameter id is missing');

        $select = 'id, nick, rating';
        if (Yii::app()->params->scopes('admin'))
            $select = 'id, role, nick, activated, mail, rating, json_data, date_create, date_last_signin';

        $users = Users::model()->findByPk(Yii::app()->request->getParam('id'), array(
            'select' => $select,
            'condition' => 'id=:id',
            'params' => array(':id' => Yii::app()->request->getParam('id')),
        ));

        if (empty($users))
            Message::Error('The user does not exist.');


        $quest_passed = UserQuest::model()->findAll(array(
            'condition' => 'user=:user',
            'params' => array(':user' => Yii::app()->request->getParam('id'))
        ));

        $count_passed = 0;
        $count_processing = count($quest_passed);

        foreach ($quest_passed as $value) {
            if ($value->end_time > 0)
                $count_passed++;
        }
        $array = $users->getAttributes(false);

        $array['passed'] = $count_passed;
        $array['processing'] = $count_processing;

        Message::Success($array);
    }

    public function actionDelete()
    {
        if (!Yii::app()->params->log_in)
            Message::Error('You are not logged');

        if (!Yii::app()->params->scopes('admin'))
            Message::Error("You do not have sufficient permissions");

        if (!Yii::app()->request->getParam('id'))
            Message::Error('Parameter id is missing');

        $users = Users::model()->findByPk((int)Yii::app()->request->getParam('id'));

        if (empty($users))
            Message::Error('The user does not exist');

        $users->delete();

        Message::Success('1');
    }

    // Не готово
    public function actionEdit()
    {
        if (!Yii::app()->params->log_in)
            Message::Error('You are not logged');

        if (!Yii::app()->params->scopes('admin'))
            Message::Error("You do not have sufficient permissions");

        if (!Yii::app()->request->getParam('id'))
            Message::Error('Parameter id is missing');

        if (!Yii::app()->request->getParam('mail'))
            Message::Error("Mail is empty");

        if (!Yii::app()->request->getParam('nick'))
            Message::Error("Nick is empty");

        $users = Users::model()->findByPk((int)Yii::app()->request->getParam('id'));
        // $users = Users::model()->findByPk((int)Yii::app()->request->getParam('id'));

        if (empty($users))
            Message::Error('The user does not exist');

        $users->mail = Yii::app()->request->getParam(array('mail'));
        $users->nick = Yii::app()->request->getParam('nick');
        $users->role = Yii::app()->request->getParam('role');

        if (Yii::app()->request->getParam('password') != '')
            $users->pass = CPasswordHelper::hashPassword(Yii::app()->request->getParam('password'));

        if ($users->save())
            Message::Success('1');
        else
            Message::Error($users->getErrors());
    }

    public function actionGenerate()
    {
        $array = array(
            array('mail' => 'reaper25b@yandex.ru', 'user' => 'olymp_1', 'pass' => 'StVMETEF'),
            array('mail' => 'cresexe@mail.ru', 'user' => 'olymp_2', 'pass' => 'q6rFjlhZ'),
            array('mail' => 'nikol98@ya.ru', 'user' => 'olymp_3', 'pass' => 'JU0eGRsS'),
            array('mail' => 'artem.avtandilyan@gmail.com', 'user' => 'olymp_4', 'pass' => 'zeCvWxNG'),
            array('mail' => 'sobolek-steam@bk.ru', 'user' => 'olymp_5', 'pass' => 'cHeAQpKA'),
            array('mail' => 'razborik@gmail.com', 'user' => 'olymp_6', 'pass' => '0et407rq'),
            array('mail' => 'ibragimoff.maks@mail.ru', 'user' => 'olymp_7', 'pass' => 'nYvpT43x'),
            array('mail' => 'nightowl191@gmail.com', 'user' => 'olymp_8', 'pass' => 'hFJ9YVWV'),
            array('mail' => 'kartashovslava@gmail.com', 'user' => 'olymp_9', 'pass' => 'cJJ7pZhe'),
            array('mail' => 'rafinadikus@gmail.com', 'user' => 'olymp_10', 'pass' => 'wu2JrNI7'),
            array('mail' => 'glazareyt@gmail.com', 'user' => 'olymp_11', 'pass' => 'srEx6Zgm'),
            array('mail' => 'abora.13@mail.ru', 'user' => 'olymp_12', 'pass' => 'tSYPI8iN'),
            array('mail' => 'rurunen@gmail.com', 'user' => 'olymp_13', 'pass' => 'iP08n0J0'),
            array('mail' => 'kvasovasveta@yandex.ru', 'user' => 'olymp_14', 'pass' => 'Y8otz6ta'),
            array('mail' => 'krekero4ek@gmail.com', 'user' => 'olymp_15', 'pass' => 't2I7o09Q'),
            array('mail' => 'aborilo@inbox.ru', 'user' => 'olymp_16', 'pass' => 'IBZWDx8n'),
            array('mail' => 'elenaida2@mail.ru', 'user' => 'olymp_17', 'pass' => 'DS3F1w0S'),
            array('mail' => 'ierei_evgenii@mail.ru', 'user' => 'olymp_18', 'pass' => 'XzQNQ3T3'),
            array('mail' => 'Nastya-demidovich@bk.ru', 'user' => 'olymp_19', 'pass' => 'IDrk0wCd'),
            array('mail' => 'surviror@gmail.com', 'user' => 'olymp_20', 'pass' => 'kXH0P6C9')
        );
        foreach($array as $k=>$v) {
            $users = new Users;

            $users->setIsNewRecord(true);

            $users->role = 1;


            $users->uuid = new CDbExpression('UUID()');
            $users->pass = CPasswordHelper::hashPassword($v['pass']);
            $users->mail = $v['mail'];
            $users->json_data = CJSON::encode(array());
            $users->date_activated = false;
            $users->activated = 0;
            $users->activation_code = uniqid(); // Случайное число
            $users->nick = $v['user'];
            $users->rating = 0;
            $users->date_create = new CDbExpression('NOW()');
            $users->date_last_signin = new CDbExpression('NOW()');

            // Потенциальная уязвимость!!!
            $users->ip = $_SERVER['REMOTE_ADDR'];

            $users->save();

        }
    }
    public function actionSearch()
    {
        if (Yii::app()->params->timer['end']  < time() & !Yii::app()->params->scopes('admin')) {
            exit('The game ended');
        }

        $nick = Yii::app()->request->getParam('nick');
        if (!$nick)
            Message::Error("Nick is empty");


        $users = Users::model()->search($nick)->paginator()->findAll(array(
            'select' => 'id, role, nick, activated',
        ));

        $array = array();
        $count = 0;

        foreach ($users as $value) {
            $count++;
            // False - return without null values;
            $array[] = $value->getAttributes(false);
        }

        Message::Success(array(
            'count' => $count,
            'items' => $array
        ));
    }
}