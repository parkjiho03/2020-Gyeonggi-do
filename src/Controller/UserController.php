<?php

namespace Gondr\Controller;

use Gondr\App\DB;

class UserController extends MasterController
{
    function signUpProcess()
    {
        $userId = $_POST['userId'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $userImg = $_POST['userImg'];

        $sql = "INSERT INTO user (`userId`, `password`, `name`, `userImg`, `userClass`) 
                VALUES (?, PASSWORD(?), ?, ?)";
        $result = DB::execute($sql, [$userId, $password, $name, $userImg, "유저"]);
        
        if($result != 1) {
            echo "none";
            return;
        }

    }

    function signInProcess() 
    {
        $userId = $_POST['userId'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM user WHERE userId = ? AND password = PASSWORD(?)";
        $user = DB::fetch($sql, [$userId, $password]);

        if($user != 1) {
            echo "none";
            return;
        }

        $_SESSION['user'] = $user;
    }

    public function logout() 
    {
        unset($_SESSION['user']);
        DB::msg("로그아웃", "/");
    }
}