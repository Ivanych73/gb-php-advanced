$(document).ready(function(){
    $('.buy-button').click(function(e){
        e.preventDefault();
        let id_good = $(this).data("id");
        let no_alert = ($('.is-cart').length > 0);

        $.ajax({
            url: "index.php?path=cart/add",
            type: "POST",
            data:{
                id_good: id_good
            },
            error: function() {alert("Ошибка ajax-запроса к серверу!");},
            success: function(answer){
                if (answer.actionSuccess) {
                if (!no_alert) alert(`Товар добавлен в корзину!`);
                let count = $(`.count-item-${id_good}`);
                let quantity = parseInt(count.text());
                ++quantity;
                count.text(quantity);
                countTotalPrice();
                } else {
                alert("Ошибка добавления товара в корзину!");
                }
               
            },
            dataType : "json"
        })
    });

    $('.remove-button').click(function(e){
        e.preventDefault();
        let id_good = $(this).data("id");
        let no_alert = ($('.is-cart').length > 0);

        $.ajax({
            url: "index.php?path=cart/remove",
            type: "POST",
            data:{
                id_good: id_good
            },
            error: function() {alert("Ошибка ajax-запроса к серверу!");},
            success: function(answer){
                if (answer.actionSuccess) {
                    if (!no_alert) alert(`Товар удален из корзины!`);
                    let count = $(`.count-item-${id_good}`);
                    let quantity = parseInt(count.text());
                    --quantity;
                    if (quantity == 0) {
                        $(`.item-${id_good}`).remove();
                    } else {
                        count.text(quantity);
                    }                    
                    countTotalPrice();
                } else {
                alert("Ошибка удаления товара из корзины!");
                }            
            },
            dataType : "json"
        })
    });

    countTotalPrice();
});

countTotalPrice = () => {
    let collection = $("[class*='count-item-']");
    let counts = [];
    let prices = [];
    let total = 0;
    collection.each(function(){
        counts.push(parseInt($(this).text()));
    })
    collection = $("[class*='price-item-']");
    collection.each(function(){
        prices.push(parseInt($(this).text()));
    });
    for (let i=0; i< counts.length; i++) {
        total = total + (counts[i] * prices[i]);
    }
    $('.total-price').text(total);
}