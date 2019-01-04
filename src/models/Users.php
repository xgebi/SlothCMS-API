<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 1/4/2019
 * Time: 10:35 PM
 */

namespace SlothCMS\Models;


class Users {
    private $users;

    /**
     * Users constructor.
     * @param $users
     */
    public function __construct($users) {
        $this->users = count($users) > 1 ? $users : [];
    }


    /**
     * @return false|string
     */
    public function toJson() {
        return json_encode(get_object_vars($this));
    }

    public function matchUser($username, $password) {
        return false;
    }

    public function addUser($user) {
        array_push($this->users, $user);
    }

}