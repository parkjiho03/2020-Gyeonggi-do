window.addEventListener("load", () => {
    let specialist = new Specialist();
});

class Specialist {
    constructor() {
        this.main();
    }
    main() {
        document.querySelectorAll(".specialBtn").forEach((x) => {
            x.addEventListener("click", () => {
                document.querySelector(".id").value = x.dataset.id;
                $(".signBg").fadeIn();
                $(".specialistPopup").fadeIn();
                $(".specialistInput > input").val("");
            });
        });
        document.querySelector(".specialistClose").addEventListener("click", () => {
            $(".signBg").fadeOut();
            $(".specialistPopup").fadeOut();
        });
    }
}