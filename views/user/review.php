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
    <script src="../js/review.js"></script>
</head>
<body>
    <header class="hHeader">
        <div class="logoContainer">
            <a href="/" class="logo">AMI MAISON</a>
        </div>
        <ul>
            <li><a href="/">홈</a></li>
            <li><a href="/user/housewarming">온라인 집들이</a></li>
            <li><a href="store.php">스토어</a></li>
            <li><a href="/user/specialist">전문가</a></li>
            <li><a href="/user/review" class="nowWeb">시공 견적</a></li>
            <li style="margin:0 20px;"><p style="text-align:center;"><?= $_SESSION['user']->name ?><br>(<?= $_SESSION['user']->userId ?>)</p></li>
            <li style="margin:0 20px;"><a class="logout" href="/logout">logout</a></li>
        </ul>
    </header>
    <section id="reviewContainer">
        <div>
            <div class="specialHeader">
                <h3>시공 견적 요청 리스트</h3>
            </div>
            <table>
                <tr>
                    <th>이름</th>
                    <th>아이디</th>
                    <th>시공일</th>
                    <th>내용</th>
                    <th>상태</th>
                    <th>견적 개수</th>
                </tr>
            <?php foreach($list as $review) : ?>
                <?php
                    $sql = "SELECT * FROM reviewlist;";
                    $reviews = DB::fetchAll($sql, [$review->userId]);
                    foreach($reviews as $reviewList) {}
                ?>
                <tr>
                    <td><?= $review->userName ?></td>
                    <td><?= $review->userId ?></td>
                    <td><?= $review->date ?></td>
                    <td><?= $review->context ?></td>
                    <td><?= $review->state ?></td>
                    <td><?= $review->num ?></td>
                    <?php if($review->state == "진행 중") : ?>
                        <?php if($review->userId == $_SESSION['user']->userId) : ?>
                            <td><button class="reviewLook">견적 보기</button></td>
                        <?php elseif($_SESSION['user']->userClass == "전문가") : ?>
                            <?php if($reviewList->specialId != $_SESSION['user']->userId && $reviewList->reviewId == $review->id) : ?>
                                <td><button class="reviewGo" data-id="<?= $review->id ?>">견적 보내기</button></td>
                            <?php endif ; ?>
                        <?php endif ; ?>
                    <?php endif ;?>
                </tr>
            <?php endforeach ; ?>
            </table>
            <button class="reviewBtn">견적 요청</button>
        <?php if($_SESSION['user']->userClass == "전문가") : ?>
            <div class="specialHeader">
                <h3>보낸 견적 리스트</h3>
            </div>
            <table>
                <tr>
                    <th>회원 이름</th>
                    <th>회원 아이디</th>
                    <th>시공일</th>
                    <th>내용</th>
                    <th>비용</th>
                    <th>선택 여부</th>
                </tr>
            <?php foreach($lists as $item) : ?>
                <tr>
                    <td><?= $item->userName ?></td>
                    <td><?= $item->userId ?></td>
                    <td><?= $item->date ?></td>
                    <td><?= $item->context ?></td>
                    <td><?= $item->cost ?></td>
                    <td><?= $item->state ?></td>
                </tr>
            <?php endforeach ; ?>
            </table>
        <?php endif ; ?>
        </div>
    </section>

    <!-- 모달 팝업 -->
    <div class="signBg"></div>
    <form class="reviewForm" method="post" action="/user/review">
        <i class="fa fa-close"></i>
        <div class="reviewInput">
            <p>시공일</p>
            <input type="date" name="date" placeholder="시공일을 입력해주세요.">
        </div>
        <div class="reviewInput">
            <p>내용</p>
            <input type="text" name="context" placeholder="내용을 입력해주세요.">
        </div>
        <div class="reviewButton">
            <input type="submit" value="작성 완료">
        </div>
    </form>

    <form class="reviewPopup" action="/user/reviews" method="post">
        <i class="fa fa-close"></i>
        <input type="hidden" name="id" class="reviewId">
        <div class="reviewInput">
            <p>비용</p>
            <input type="number" name="money" placeholder="비용을 입력해주세요.">
        </div>
        <div class="reviewButton">
            <input type="submit" value="견적 보내기">
        </div>
    </form>

    <form class="reviewView" action="/user/reviewView" method="post">
        <i class="fa fa-close"></i>
        <?php foreach($reviewLists as $reviewList) : ?>
            <div class="reviewViewForm">
                <input type="hidden" name="id" value="<?= $reviewList->id ?>">
                <div><?= $reviewList->specialId ?></div>
                <div><?= $reviewList->specialName ?></div>
                <div><?= $reviewList->cost ?>원</div>
                <div class="reviewViewBtn">
                    <input type="submit" value="선택">
                </div>
            </div>
        <?php endforeach ; ?>
    </form>
</body>
</html>