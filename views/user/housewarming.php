<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../fontawesome/css/font-awesome.css">
    <script src="../js/housewarming.js"></script>
    <script src="../js/jquery-3.4.1.min.js"></script>
</head>
<body>
    <!-- 헤더 -->
    <header class="hHeader">
        <div class="logoContainer">
            <a href="/user/housewarming" class="logo">AMI MAISON</a>
        </div>
        <ul>
            <li><a href="/">홈</a></li>
            <li><a href="/user/housewarming" class="nowWeb">온라인 집들이</a></li>
            <li><a href="store.php">스토어</a></li>
            <li><a href="/user/specialist">전문가</a></li>
            <li><a href="/user/review">시공 견적</a></li>
            <li><a href="#" class="writing"><i class="fa fa-pencil"></i>글쓰기</a></li>
            <li style="margin:0 20px;"><p style="text-align:center;"><?= $_SESSION['user']->name ?><br>(<?= $_SESSION['user']->userId ?>)</p></li>
            <li style="margin:0 20px;"><a class="logout" href="/logout">logout</a></li>
        </ul>
    </header>

    <section id="house">
        <?php foreach($list as $item) : ?>
            <div><?= $item->userName ?></div>
            <div><?= $item->userId ?></div>
            <div><?= $item->date ?></div>
            <div><?= $item->grade ?></div>
            <div><?= $item->context ?></div>
            <div><button>평점 주기</button></div>
        <?php endforeach ; ?>
    </section>

    <!-- 팝업창 -->
    <div class="signBg"></div>
    <form class="writingModal" method="post" action="/user/housewarming">
        <i class="fa fa-close wClose"></i>
        <div class="writingInput">
            <p>Before 사진</p>
            <input type="file" id="beforeImg" name="beforeImg">
        </div>
        <div class="writingInput">
            <p>After 사진</p>
            <input type="file" id="afterImg" name="afterImg">
        </div>
        <div class="writingInput">
            <p>노하우 필드</p>
            <textarea cols="30" name="context" rows="10" id="knowHow"></textarea>
        </div>
        <div class="writingBtn">
            <button type="submit">작성 완료</button>
        </div>
    </form>
</body>
</html>