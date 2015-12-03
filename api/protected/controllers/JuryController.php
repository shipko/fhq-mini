<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 05.11.15
 * Time: 10:16
 */

class JuryController extends CController
{
    private $method = "jury";

    public function actionGet()
    {
        echo json_encode(array(
            "method" => "get",
            "response" => array(
            "settings" => array(
                "time" => array(
                    "start" => mktime(0,0,0, 11,1,2015),
                    "end" => mktime(0,0,0, 12, 1, 2015)
                ),
                "name" => "",
                "round_length" => 10,
                "flags" => array(
                    "port" => 2605
                ),
                "admin" => array(
                    "login" => "root",
                    "pass" => "qwe"
                )
            ),
            "teams" => array(
                array(
                    "name" => "keva",
                    "network" => "127.0.1.0/24",
                    "host" => "127.0.0.1"
                ),
//                array(
//                    "name" => "mustang",
//                    "network" => "127.0.2.0/24",
//                    "host" => "127.0.0.1"
//                ),
//                array(
//                    "name" => "hetto",
//                    "network" => "127.0.3.0/24",
//                    "host" => "127.0.0.1"
//                ),
//                array(
//                    "name" => "test_team",
//                    "network" => "127.0.4.0/24",
//                    "host" => "127.0.0.1"
//                ),

            ),
            "services" => array(
                array(
                    "name" => "CTFgram",
                    "timeout" => 1,
                    "program" => '#!/usr/bin/perl \n print \"911\"; \n exit 102;'
                ),
//                array(
//                    "name" => "O\"Foody",
//                    "timeout" => 1,
//                    "program" => "#!/usr/bin/perl \n print \"911\"; \n exit 102;"
//                ),
//                array(
//                    "name" => "Crychat",
//                    "timeout" => 1,
//                    "program" => "#!/usr/bin/perl \n print \"911\"; \n exit 103;"
//                ),
//                array(
//                    "name" => "Test service",
//                    "timeout" => 1,
//                    "program" => "#!/usr/bin/perl \n print \"911\"; \n exit 104;"
//                )
            )
        )), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}