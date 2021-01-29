window.addEventListener("load", (e) => {
    $.getJSON('./store/store.json', function(j) {
        let app = new App(j);
        j.forEach((x) => {
            x.cnt = 1;
        })
    });
});

function uncomma(str) {
    str = parseInt(str.replace(/,/g,""));
    return str;
}

class App {
    constructor(list) {
        this.list = list;
        this.word = $("#word");
        this.main();
        this.shoppingCart();
        this.productList = [];
    }

    main() {
        this.list.forEach(x=>{
            let product = this.storeLists(x);
            document.querySelector(".storeLists").appendChild(product);
            $(product).draggable({
                containment:"#store",
                cancel: ".listInfo",
                cursor:"pointer",
				helper:"clone",
				revert: true,
				// start : function(e){
				// 	$(this).hide();
				// },
				// stop : function(e){
				// 	$(this).show();
                // }
                start : function(e){
					$(".cartListWrapper").fadeIn();
				},
				stop : function(e){
					$(".cartListWrapper").fadeOut();
				}
            });
            $(".dropList, .cartListWrapper").droppable({
                accept:".storeList",
			    drop:(e,ui)=>{
                    let idx = ui.draggable[0].dataset.id;
                    let item = this.list[idx-1];
				    let find = this.productList.find(function(x){
				    	return x.id == item.id;
				    });
                    if(find === undefined) this.cartItem(item);
                    else alert("이미 장바구니에 담긴 상품입니다.");
			    }
            });
            $(".storeList").disableSelection();
        });
        $('#word').on('input', this.search);
        $(".searchIcon").on("click", this.search);
        document.querySelector(".popupBtn > button").addEventListener("click", (e) => {
            if($.trim($(".popupName").val()) == ""){
				alert("구매자 이름을 입력해주세요.");
				return;
			}
			if($.trim($(".popupAddress").val()) == ""){
				alert("주소를 입력해주세요.");
				return;
            }
            $(".modalPopup").fadeIn();
            let canvas = document.createElement("canvas");
            let width = 460;
            let height = 500;
            canvas.width = width;
            canvas.height = height;
            let total = 0;
            let tot = 0;
            let num = 2;
            let ctx = canvas.getContext("2d");
            ctx.fillStyle = "#fff";
            ctx.fillRect(0,0,width,height);
            ctx.font = "20px Arial";
            ctx.fillStyle = "#48b9a0";
            ctx.textAlign = "center";
            ctx.fillText("구매 내역서", width/2, 50);
            ctx.fillStyle = "#000";
            let date = new Date();
            let day = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
            this.productList.forEach((x)=>{
                total =  x.cnt * uncomma(x.price);
                let txt = `${x.product_name} ${x.price}원 ${x.cnt}개 ${total.toLocaleString()}원`;
                ctx.fillText(txt,width/2,60 + num * 20);
                num++;
            });
            ctx.font = "20px Arial";
            ctx.fillText("총합계", width/2, 400);
            this.productList.forEach((x) => {
                tot += x.cnt * uncomma(x.price);
            });
            ctx.fillText(tot.toLocaleString() + "원", width/2, 450);
            ctx.fillText(day, width/2, 480);
            document.querySelector(".modalPopup").appendChild(canvas);
        });
    }

    cartItem(item) {
        this.productList.push(item);
		let div = document.createElement("div");
		div.classList.add("productInfo");
        div.innerHTML = `
            <div class="productImg">
                <img src="store/storeImg/${item.photo}" alt="">
            </div>
            <div>
                <p class="Brand">${item.brand}</p>
                <p class="name">${item.product_name}</p>
            </div>
            <p class="price">${item.price}원</p>
            <div class="numberBtn">
                <input class="productNum" type="number" value="${item.cnt}" min="1" max="99" maxlength="2">
            </div>
            <span class="productTotal">${item.price}원</span>
            <i class="fa fa-close closeIcon"></i>
        `;
        document.querySelector(".cartList").appendChild(div);
        if(document.querySelector(".allTotal").innerHTML == "0원") {
            document.querySelector(".allTotal").innerHTML = item.price + "원";
        } else {
            let tot = 0;
            this.productList.forEach((x) => {
                tot += x.cnt * uncomma(x.price);
            });
            document.querySelector(".allTotal").innerHTML = tot.toLocaleString() + "원";
        }
        $(".cartProduct").hide();
        div.querySelector(".productNum").addEventListener("input", (e) => {
            let cnt = div.querySelector(".productNum").value;
            item.cnt = cnt;
            let total = cnt * uncomma(item.price);
            div.querySelector(".productTotal").innerHTML = total.toLocaleString() + "원";
            let allTot = 0;
            this.productList.forEach((x) => {
                allTot += x.cnt * uncomma(x.price);
            });
            document.querySelector(".allTotal").innerHTML = allTot.toLocaleString() + "원";
        });
        div.querySelector(".closeIcon").addEventListener("click", (e) => {
                let cnt = div.querySelector(".productNum").value;
            item.cnt = cnt;
            let list = this.productList.findIndex(function(x){
                return x.id === item.id;
            });
            if(list != -1){
                this.productList.splice(list,1);
                $(div).remove();
            }
            let allTot = 0;
            this.productList.forEach((x) => {
                allTot += x.cnt * uncomma(x.price);
            });
            document.querySelector(".allTotal").innerHTML = allTot.toLocaleString() + "원";
            cnt = 1;
            item.cnt = cnt;
            if(document.querySelector(".cartList").childElementCount == 1) {
                $(".cartProduct").show();    
            }
        });
        document.querySelector(".popupBtn > button").addEventListener("click", (e) => {
            if($.trim($(".popupName").val()) != "" && $.trim($(".popupAddress").val()) != "") {
                let list = this.productList.findIndex(function(x){
                    return x.id === item.id;
                });
                this.productList.splice(list,1);
                $(div).remove();
                document.querySelector(".allTotal").innerHTML = "0원";
                $(".cartProduct").show();
                let cnt = div.querySelector(".productNum").value;
                cnt = 1;
                item.cnt = cnt;
            }
        });
    }

    // 스토어 리스트
    storeLists(e) {
        let div = document.createElement("div");
        div.classList.add("storeList");
        div.dataset.id = e.id;
        div.innerHTML = `
            <img class="photo" src="./store/storeImg/${e.photo}">
            <div class="listInfo">
                <p class="listProductName">${e.product_name}</p>
                <p class="listBrand">${e.brand}</p>
                <p class="listPrice">${e.price}원</p>
            </div>
        `;
        return div;
    }

    // 쇼핑카트
    shoppingCart() {
        let cartContainer = document.querySelector(".shoppingCartContainer");
        let storeList = document.querySelector(".storeListContainer");
        let dropList = document.querySelector(".dropListContainer");
        document.querySelector(".shoppingCartIcon").addEventListener("click", (e) => {
            cartContainer.classList.toggle("cartActive");
            storeList.classList.toggle("active");
            dropList.classList.toggle("active");
        });
        document.querySelector(".productBuy").addEventListener("click", (e) => {
            $(".popupInput input").val("");
            $(".popupContainer").fadeIn();
            $(".popup").fadeIn();
        });
        document.querySelector(".popupContainer").addEventListener("click", (e) => {
            $(".popupContainer").fadeOut();
            $(".popup").fadeOut();
            $(".modalPopup").fadeOut();
            $(".modalPopup > canvas").fadeOut();
        });
        document.querySelector(".popupClose").addEventListener("click", (e) => {
            $(".popupContainer").fadeOut();
            $(".popup").fadeOut();
        });
        document.querySelector(".modalClose").addEventListener("click", (e) => {
            $(".popupContainer").fadeOut();
            $(".popup").fadeOut();
            $(".modalPopup").fadeOut();
            $(".modalPopup > canvas").fadeOut();
        });
    }

    search = () => {
        let word = this.word.val();
        let regex = new RegExp(word,"gi");
        if($.trim(word) == "") {
            $(".searchs").hide();
            document.querySelector(".storeLists").innerHTML = "";
            this.list.forEach(x=>{
                let product = this.storeLists(x);
                document.querySelector(".storeLists").appendChild(product);
                $(product).draggable({
                    containment:"#store",
                    cancel: ".listInfo",
                    cursor:"pointer",
                    helper:"clone",
                    revert: true,
                    start : function(e){
                        $(".cartListWrapper").fadeIn();
                    },
                    stop : function(e){
                        $(".cartListWrapper").fadeOut();
                    }
                });
            });
        } else {
            document.querySelector(".storeLists").innerHTML = "";
            this.list.forEach(x=> {
                console.log(x.product_name.search(regex));
                if(x.product_name.search(regex) != -1 || x.product_name.search(regex) != -1) {
                    // x.product_name = x.product_name.replace(regex, `<span class="searchColor">$&</span>`);
                    let product = this.storeLists(x);
                    document.querySelector(".storeLists").appendChild(product);
                    $(product).draggable({
                        containment:"#store",
                        cancel: ".listInfo",
                        cursor:"pointer",
                        helper:"clone",
                        revert: true,
                        start : function(e){
                            $(".cartListWrapper").fadeIn();
                        },
                        stop : function(e){
                            $(".cartListWrapper").fadeOut();
                        }
                    });
                } else {
                    $(".searchs").show();
                }
            });
        }
    }
}