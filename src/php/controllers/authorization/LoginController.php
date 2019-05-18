<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 1/5/2019
 * Time: 12:35 AM
 */

namespace slothcms\controllers\authorization;

require_once __DIR__ . "/../BaseController.php";

use SlothCMS\controllers\BaseController;


class LoginController extends BaseController {
    public function run() {
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");

        if (strlen($username) == 0 || strlen($password) == null) {
            readfile(__DIR__ . "/../../views/login.html");
        } else {
            $userFound = -1;

            $filename = __DIR__ . "/../../../sloth.users.json";
            $users = json_decode(file_get_contents($filename));

            foreach ($users as $index => $user) {
                if (strcmp($username, $user->username) == 0 && password_verify($password, $user->passwordHash)) {
                    $userFound = $index;
                    break;
                }
            }

            if ($userFound >= 0) {
                $sessionId = uniqid();
                setcookie("sloth-session", $sessionId, time() + 1800);
                header("Location: /dashboard");
                $users[$userFound]->sessionId = $sessionId;
                file_put_contents(json_encode($users));
            } else {
                // @TODO add error handling
                header("Location: /login");
            }

        }
    }


}