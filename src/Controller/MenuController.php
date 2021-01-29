<?php

namespace Gondr\Controller;

use Gondr\App\DB;

class MenuController extends MasterController
{
    public function housewarming()
    {
        $sql = "SELECT * FROM housewarming;";
        $list = DB::fetchAll($sql);
        $this->render("/user/housewarming", ['list' => $list]);
    }

    public function housewarmingProcess()
    {
        $userName = $_SESSION['user']->name;
        $userId = $_SESSION['user']->userId;
        $date = date("Y-m-d H:i:s");
        $context = $_POST['context'];

        $sql = "INSERT INTO housewarming (`userName`, `userId`, `date`, `grade`, `context`) VALUES (?, ?, ?, ?, ?)";
        $result = DB::execute($sql, [$userName, $userId, $date, 0, $context]);

        // foreach($list as $item) {
        //     $id = $item->id+1;
        // }
        // for( $i = 0; $i < 2; $i++ ) {
        //     $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
        //     if ($tmpFilePath != ""){
        //         $newFilePath = "uploadImg/" . $_FILES['upload']['name'][$i];
        //         if(move_uploaded_file($tmpFilePath, $newFilePath)) {
        //             $sqls = "INSERT INTO listImg (`postId`, `img`, `writer`) VALUES (?, ?, ?)";
        //             $images = DB::execute($sqls, [$id, $newFilePath, $userName]);
        //         }
        //     }
        // }

        // if($result != 1) {
        //     DB::msg("데이터베이스 입력중 오류 발생", "/user/housewarming");
        //     return;
        // }

        // DB::msg("성공적으로 입력되었습니다.", "/user/housewarming");
    }

    public function store()
    {
        $this->render("/user/store");
    }

    public function specialist()
    {
        if(!isset($_SESSION['user'])) {
            DB::msg("로그인을 해주세요.", "/");
        }
        $sql = "SELECT * FROM user LIMIT 0, 4;";
        $list = DB::fetchAll($sql);
        $sqls = "SELECT * FROM specials;";
        $lists = DB::fetchAll($sqls);
        $this->render("/user/specialist", ['list' => $list, 'lists' => $lists]);
    }

    public function specialistProcess()
    {
        $id = $_POST['id'];
        $sql = "SELECT * FROM user WHERE id = ?;";
        $list = DB::fetchAll($sql, [$id]);
        foreach($list as $item) {
            $specialName = $item->name;
            $specialId = $item->userId;
        }
        $userName = $_SESSION['user']->name;
        $userId = $_SESSION['user']->userId;
        $money = $_POST['money'];
        $context = $_POST['context'];
        $grade = $_POST['grade'];

        if(!trim($money)) {
            DB::msgBack("비용이 비어있습니다.");
            exit;
        }

        if(!trim($context)) {
            DB::msgBack("내용이 비어있습니다.");
            exit;
        }

        if(!trim($grade)) {
            DB::msgBack("평점이 비어있습니다.");
            exit;
        }

        $sql = "INSERT INTO specials (`specialName`, `specialId`, `userName`, `userId`, `money`, `context`, `grade`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $specialist = DB::execute($sql, [$specialName, $specialId, $userName, $userId, $money, $context, $grade]);

        if($specialist != 1) {
            DB::msgBack("오류");
            exit;
        }

        DB::msgBack("평가가 되었습니다.");
    }

    public function review()
    {
        $sql = "SELECT * FROM review;";
        $list = DB::fetchAll($sql);
        $specialId = $_SESSION['user']->userId;
        $sqls = "SELECT * FROM reviewlist WHERE specialId = ?;";
        $lists = DB::fetchAll($sqls, [$specialId]);
        $reviewSql = "SELECT * FROM reviewlist;";
        $reviewLists = DB::fetchAll($reviewSql);
        $this->render("/user/review", ['list' => $list, 'lists' => $lists, 'reviewLists' => $reviewLists]);
    }

    public function reviewProcess()
    {
        $date = $_POST['date'];
        $context = $_POST['context'];
        $userName = $_SESSION['user']->name;
        $userId = $_SESSION['user']->userId;

        if(!trim($date)) {
            DB::msgBack("시공일이 비어있습니다.");
            exit;
        }

        if(!trim($context)) {
            DB::msgBack("내용이 비어있습니다.");
            exit;
        }

        $sql = "INSERT INTO review (`userName`, `userId`, `date`, `context`, `state`, `num`) VALUES (?, ?, ?, ?, ?, ?);";
        $list = DB::execute($sql, [$userName, $userId, $date, $context, "진행 중", 1]);

        DB::msgBack("요청이 완료되었습다.");
    }

    public function reviewSend()
    {
        $id = $_POST['id'];
        $sqls = "SELECT * FROM review WHERE id = ?;";
        $lists = DB::fetchAll($sqls, [$id]);
        foreach($lists as $item) {
            $userName = $item->userName;
            $userId = $item->userId;
            $date = $item->date;
            $context = $item->context;
        }
        $money = $_POST['money'];
        $specialId = $_SESSION['user']->userId;
        $specialName = $_SESSION['user']->name;

        if(!trim($money)) {
            DB::msgBack("비용이 비어있습니다.");
            exit;
        }

        $sql = "INSERT INTO reviewlist (`userName`, `userId`, `date`, `context`, `cost`, `state`, `specialId`, `specialName`, `reviewId`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $list =  DB::execute($sql, [$userName, $userId, $date, $context, $money, "선택", $specialId, $specialName, $id]);

        DB::msgBack("견적 보내기가 완료되었습니다.");
    }

    public function reviewUpdate()
    {
        $id = $_POST['id'];
        var_dump($id);
        // $sql = "UPDATE reviewlist SET `state` = ? WHERE `id` = ?";
        // $list = DB::execute($sql, ["선택", $id]);

        // DB::msgBack("선택되었습니다.");
    }
}