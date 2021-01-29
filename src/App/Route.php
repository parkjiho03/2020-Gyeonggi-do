<?php

namespace Gondr\App;

use Gondr\App\DB;

class Route
{
    private static $actions = [];
    
    public static function __callStatic($method, $args)
    {
        $req = strtolower($_SERVER['REQUEST_METHOD']);

        if($req == $method) {
            self::$actions[] = $args;
        }
    }

    public static function init()
    {
        $path = explode("?", $_SERVER['REQUEST_URI']);
        $path = $path[0];

        foreach(self::$actions as $req) {
            if($req[0] === $path) {
                $action = explode("@", $req[1]);
                $controller = 'Gondr\\Controller\\' . $action[0];
                $controllerInstance = new $controller();
                $controllerInstance->{$action[1]}();
                return;
            }
        }

        if(!isset($_SESSION['user'])) {
            DB::msgBack("로그인을 해주세요.");
            exit;
        }
        // DB::msgBack("잘못된 접근입니다.");
    }
}