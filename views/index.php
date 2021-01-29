<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome/css/font-awesome.css">
    <script src="js/index.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
</head>
<body>
    <!-- 헤더 -->
    <header id="header">
        <div class="leftHeader">
            <div class="logoContainer">
                <a href="/" class="logo">AMI MAISON</a>
            </div>
        </div>
        <div class="rightHeader">
            <ul>
                <li><a href="/" class="nowWeb">홈</a></li>
                <li><a href="/user/housewarming">온라인 집들이</a></li>
                <li><a href="/user/store">스토어</a></li>
                <li><a href="/user/specialist">관리자</a></li>
                <li><a href="/user/review">시공 견적</a></li>
                <?php 
                    if(!isset($_SESSION['user'])) {
                ?>
                <li class="login"><a href="#">로그인</a></li>
                <li><a class="register" href="#">회원가입</a></li>
                <?php 
                    } else {
                ?>
                <li style="margin:0 20px;"><p style="text-align:center;"><?= $_SESSION['user']->name ?><br>(<?= $_SESSION['user']->userId ?>)</p></li>
                <li style="margin:0 20px;"><a class="logout" href="/logout">logout</a></li>
                <?php 
                    }
                ?>
            </ul>
        </div>
    </header>

    <!-- 회원가입 -->
    <div class="signBg"></div>
    <form class="registerContainer" onsubmit="return signUpProcess();">
        <i class="fa fa-close rClose"></i>
        <div class="registerInput">
            <p>아이디</p>
            <input type="text" id="rId" class="rId" placeholder="아이디를 입력해주세요.">
        </div>
        <div class="registerInput">
            <p>비밀번호</p>
            <input type="password" id="rPassword" class="rPassword" placeholder="비밀번호를 입력해주세요.">
        </div>
        <div class="registerInput">
            <p>이름</p>
            <input type="text" id="rName" class="rName" placeholder="이름을 입력해주세요.">
        </div>
        <div class="registerInput">
            <p>사진</p>
            <input type="file" id="rPhoto" class="rPhoto">
        </div>
        <input type="hidden" id="captchaText">
        <div class="registerInput">
            <p>Captcha</p>
            <canvas id="captcha"></canvas>
            <input type="text" class="captcha" placeholder="자동입력방지 문자를 입력해주세요.">
        </div>
        <div class="registerBtn">
            <button type="submit">가입 완료</button>
        </div>
    </form>

    <!-- 로그인 -->
    <form class="loginContainer" onsubmit="return signInProcess();">
        <i class="fa fa-close lClose"></i>
        <div class="loginInput">
            <p>아이디</p>
            <input type="text" id="lId" class="lId" placeholder="아이디를 입력해주세요.">
        </div>
        <div class="loginInput">
            <p>비밀번호</p>
            <input type="password" id="lPassword" class="lPassword" placeholder="비밀번호를 입력해주세요.">
        </div>
        <div class="loginBtn">
            <button type="submit">로그인</button>
        </div>
    </form>

    <!-- 비주얼 -->
    <section id="visual">
        <div class="visualBgImg">
            <figure>
                <img src="image/wall-416060_1280.jpg" alt="backgroundImg1" title="backgroundImg1">
                <img src="image/wall-823611_1920.jpg" alt="backgroundImg2" title="backgroundImg2">
                <img src="image/brick-wall-1834784_1920.jpg" alt="backgroundImg3" title="backgroundImg3">
                <img src="image/wall-823611_1920.jpg" alt="backgroundImg2" title="backgroundImg2">
                <img src="image/wall-416060_1280.jpg" alt="backgroundImg1" title="backgroundImg1">
            </figure>
        </div>
        <div class="visualText">
            <h1>AMI<br>MAI<br>SON</h1>
            <p class="visualTXT">Easy Home Transformation</p>
        </div>
        <div class="visualContainer">
            <div class="leftVisual">
                <div class="visualTitle">
                    <h2>about<br> ami maison</h2>
                    <p>AMI MAISON<br>it mean friend's home.<br></p>
                </div>
                <div class="visualImgContainer">
                    <div class="visualImg">
                        <figure>
                            <img src="image/wall-416060_1280.jpg" alt="smallImg1" title="smallImg1">
                            <img src="image/wall-823611_1920.jpg" alt="smallImg2" title="smallImg2">
                            <img src="image/brick-wall-1834784_1920.jpg" alt="smallImg3" title="smallImg3">
                            <img src="image/wall-823611_1920.jpg" alt="smallImg2" title="smallImg2">
                            <img src="image/wall-416060_1280.jpg" alt="smallImg1" title="smallImg1">
                        </figure>
                    </div>
                </div>
            </div>
            <div class="rightVisual"></div>
        </div>
    </section>
</body>
</html>