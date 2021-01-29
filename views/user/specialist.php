<?php use Gondr\App\DB; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../fontawesome/css/font-awesome.css">
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/specialist.js"></script>
</head>
<body style="background-color:#f3f3f3;">
    <header class="hHeader">
        <div class="logoContainer">
            <a href="/" class="logo">AMI MAISON</a>
        </div>
        <ul>
            <li><a href="/">홈</a></li>
            <li><a href="/user/housewarming">온라인 집들이</a></li>
            <li><a href="store.php">스토어</a></li>
            <li><a href="/user/specialist" class="nowWeb">전문가</a></li>
            <li><a href="/user/review">시공 견적</a></li>
            <li style="margin:0 20px;"><p style="text-align:center;"><?= $_SESSION['user']->name ?><br>(<?= $_SESSION['user']->userId ?>)</p></li>
            <li style="margin:0 20px;"><a class="logout" href="/logout">logout</a></li>
        </ul>
    </header>
    <section id="special">
        <div class="specialHeader">
            <h3>전문가 리스트</h3>
        </div>
        <?php foreach($list as $item) : ?>
            <?php
                $sql = "SELECT * FROM specials WHERE specialId = ?;";
                $grad = DB::fetchAll($sql, [$item->userId]);
                $len = sizeof($grad);
                $grade = 0;
                foreach($grad as $grd) $grade += $grd->grade;
                if($len != 0) $grade = floor($grade/$len);
            ?>
            <div class="specialContainer">
                <figure>
                    <img src="/specialist/<?= $item->userImg ?>" alt="">
                </figure>
                <div class="specialInfo">
                    <p><?= $item->name ?></p>
                    <p><?= $item->userId ?></p>
                </div>
                <div class="specialGrade">
                    <div class="specialStar">
                        <?php for($i = 0; $i < 5; $i++) : ?>
                            <?php if($grade > $i) : ?>
                                <i class="fa fa-star"></i>
                            <?php else : ?>
                                <i class="fa fa-star-o"></i>
                            <?php endif ; ?>
                        <?php endfor ; ?>
                    </div>
                    <p>(5/<?= $grade ?>)</p>
                </div>
                <div class="specialBtns">
                    <button data-id="<?= $item->id ?>" class="specialBtn">시공 후기작성</button>
                </div>
            </div>
        <?php endforeach ; ?>
        <div class="specialHeader">
            <h3>시공 후기 리스트</h3>
        </div>
        <?php foreach($lists as $item) : ?>
            <div class="specialWrapper">
                <?= $item->specialName ?>
                <?= $item->specialId ?>
                <?= $item->userName ?>
                <?= $item->userId ?>
                <?= $item->money ?>원
                <?= htmlspecialchars(nl2br($item->context)) ?>
                <?= $item->grade ?>점
            </div>
        <?php endforeach; ?>
    </section>

    <!-- 모달 팝업 -->
    <div class="signBg"></div>
    <form class="specialistPopup" style="display:none;" method="POST" action="/user/specialist">
        <i class="fa fa-close specialistClose"></i>
        <input type="hidden" name="id" class="id">
        <div class="specialistInput">
            <p>비용</p>
            <input type="number" name="money" placeholder="비용을 입력해주세요.">
        </div>
        <div class="specialistInput">
            <p>내용</p>
            <input type="text" name="context" placeholder="내용을 입력해주세요.">
        </div>
        <div class="specialistInput">
            <p>평점</p>
            <input type="number" name="grade" min="1" max="5" placeholder="평점을 입력해주세요.(1 ~ 5)">
        </div>
        <div class="specialistBtn">
            <input type="submit" value="작성 완료">
        </div>
    </form>
</body>
</html>