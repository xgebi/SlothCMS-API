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
    public function __construct($users = null) {
        $this->users = is_array($users) && count($users) > 1 ? $users : array();
    }


    /**
     * @return false|string
     */
    public function toJson() {
        $tempUsersArray = array();
        echo "<br />";
        foreach ($this->users as $user) {
            $tempUsersArray[] = $user->getItemsAsArray();
        }
        return json_encode($tempUsersArray);
    }

    public function matchUser($username, $password) {
        return false;
    }

    public function addUser($user) {
        array_push($this->users, $user);
    }

}