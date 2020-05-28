<?php

class UserRepository {

  public static function getUser($username, $password) {
    $user = new \stdClass();
    $user->username = $username;
    $user->name = $username;

    return $user;

    /*
      //this is an example using a MySql database:

      return \DbClient::queryOne('SELECT * from users where usename= :usename and password= :password;', [
      'usename' => $username,
      'password' => $password
      ]);
     */
  }

}
