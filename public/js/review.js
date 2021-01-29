window.addEventListener("load", () => {
    let review = new Review();
});

class Review {
    constructor() {
        this.main();
    }

    main(){
        document.querySelector(".reviewBtn").addEventListener("click", () => {
            $(".signBg").fadeIn();
            $(".reviewForm").fadeIn();
        });
        document.querySelector(".reviewForm > i").addEventListener("click", () => {
            $(".signBg").fadeOut();
            $(".reviewForm").fadeOut();
        });
        document.querySelectorAll(".reviewGo").forEach((x) => {
            x.addEventListener("click", () => {
                $(".reviewId").val(x.dataset.id);
                $(".signBg").fadeIn();
                $(".reviewPopup").fadeIn();
            });
        });
        document.querySelector(".reviewPopup > i").addEventListener("click", () => {
            $(".signBg").fadeOut();
            $(".reviewPopup").fadeOut();
        });
        document.querySelector(".reviewLook").addEventListener("click", () => {
            $(".signBg").fadeIn();
            $(".reviewView").fadeIn();
        });
        document.querySelector(".reviewView > i").addEventListener("click", () => {
            $(".signBg").fadeOut();
            $(".reviewView").fadeOut();
        });
    }
}