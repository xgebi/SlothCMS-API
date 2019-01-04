<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 1/4/2019
 * Time: 10:43 PM
 */

namespace SlothCMS\Models;


class User {
    private $username;
    private $passwordHash;
    private $email;
    private $displayName;
    private $permissions;

    /**
     * User constructor.
     * @param $username
     * @param $passwordHash
     * @param $email
     * @param $displayName
     * @param $permissions
     */
    public function __construct($username, $passwordHash, $email, $displayName, $permissions) {
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->email = $email;
        $this->displayName = $displayName;
        $this->permissions = $permissions;
    }

    public function getItemsAsArray() {
        return get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPasswordHash() {
        return $this->passwordHash;
    }

    /**
     * @param mixed $passwordHash
     */
    public function setPasswordHash($passwordHash) {
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * @param mixed $displayName
     */
    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }

    /**
     * @return mixed
     */
    public function getPermissions() {
        return $this->permissions;
    }

    /**
     * @param mixed $permissions
     */
    public function setPermissions($permissions) {
        $this->permissions = $permissions;
    }




}