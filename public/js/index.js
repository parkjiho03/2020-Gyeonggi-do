window.addEventListener("load", (e) => {
    let idx = new Index();
});

function signUpProcess() {
    if($.trim($(".rId").val()) == "") {
        alert("아이디가 비어있습니다.");
        return;
    }

    if($.trim($(".rPassword").val()) == "") {
        alert("비밀번호가 비어있습니다.");
        return;
    }

    if($.trim($(".rName").val()) == "") {
        alert("이름이 비어있습니다.");
        return;
    }

    if($.trim($(".rPhoto").val()) == "") {
        alert("사진이 비어있습니다.");
        return;
    }

    if($.trim($(".captcha").val()) == "") {
        alert("자동입력방지 문자가 비어있습니다.");
        return;
    }

    if($("#captchaText").val() != $(".captcha").val()) {
        alert("자동입력방지 문자를 잘못 입력하였습니다.");
        return;
    }

    let data = {};
    data.userId = $(".rId").val();
    data.password = $(".rPassword").val();
    data.name = $(".rName").val();
    data.userImg = $(".rPhoto").val();
    $.ajax({
        url: "/signUp",
        method: "POST",
        data:data,
        success: function(e) {
            console.log(e);
            if(e == "none") {
                alert("중복되는 아이디입니다. 다른 아이디를 사용해주세요.");
                return;
            } else {
                alert("회원가입성공");
                location.href="/";
            }
        }
    });
    return false;
}

function signInProcess() {
    if($.trim($(".lId").val()) == "") {
        alert("아이디가 비어있습니다.");
        return;
    }

    if($.trim($(".lPassword").val()) == "") {
        alert("비밀번호가 비어있습니다.");
        return;
    }

    let data = {};
    data.userId = $(".lId").val();
    data.password = $(".lPassword").val();
    $.ajax({
        url: "/signIn",
        method: "POST",
        data:data,
        success: function(e) {
            if(e == "none") {
                alert("아이디 또는 비밀번호가 일치하지 않습니다.");
                return;
            } else {
                alert("로그인이 성공적으로 되었습니다.");
                location.href="/";
            }
        }
    });
    return false;
}

class Index {
    constructor() {
        this.main();
    }

    main() {
        let text = "";
        let cap = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for(let i = 0; i < 5; i++) text += cap.charAt(Math.floor(Math.random() * cap.length));
        $("#captchaText").val(text);
        let canvas = document.getElementById("captcha");
        let ctx = canvas.getContext("2d");
        let width = 440;
        let height = 150;
        canvas.width = width;
        canvas.height = height;
        ctx.font = "30px Arial";
        ctx.textAlign = "center";
        ctx.fillText(text, width/2, height/2);
        document.querySelector(".register").addEventListener("click", () => {
            $(".signBg").fadeIn();
            $(".registerContainer").fadeIn();
            $(".registerInput > input").val("");
        });
        document.querySelector(".login").addEventListener("click", () => {
            $(".signBg").fadeIn();
            $(".loginContainer").fadeIn();
            $(".loginInput > input").val("");
        });
        $(".rClose").on("click", () => {
            $(".signBg").fadeOut();
            $(".registerContainer").fadeOut();
        });
        $(".lClose").on("click", () => {
            $(".signBg").fadeOut();
            $(".loginContainer").fadeOut();
        });
    }
}