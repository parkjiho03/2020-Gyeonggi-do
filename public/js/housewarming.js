window.addEventListener("load", () => {
    let house = new House();
});

class House {
    constructor() {
        this.main();
    }

    main() {
        document.querySelector(".writing").addEventListener("click", () => {
            $(".signBg").fadeIn();
            $(".writingModal").fadeIn();
        });
        document.querySelector(".signBg").addEventListener("click", () => {
            $(".writingModal").fadeOut();
            $(".signBg").fadeOut();
        });
        document.querySelector(".wClose").addEventListener("click", () => {
            $(".writingModal").fadeOut();
            $(".signBg").fadeOut();
        });
    }
}