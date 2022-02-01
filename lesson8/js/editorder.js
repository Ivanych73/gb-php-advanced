$(document).ready(function(){
    findOpenOrders();
    setClickHandler();
    setDetailHref();
})

const setClickHandler = () => {
    let buttons = $(`[id*='save-order-']`);
    buttons.each(function(){
        let id = $(this).attr("id").substring(11, $(this).attr("id").length);
        $(this).click(function(e){
            e.preventDefault();
            let newStatusId = $(`#orderstatus-${id}`).val();
            let newStatusText = $(`#orderstatus-${id} option:selected`).html();
            $.ajax({
                url: "index.php?path=order/changeStatusAsAjax",
                type: "POST",
                data:{
                    id: id,
                    status_id: newStatusId
                },
                error: function(){
                    alert('Ошибка ajax-запроса к серверу!');
                },
                success: function(answer){
                    alert(answer.ErrMsg);
                    if(answer.actionSuccess){
                        $(`#orderstatus-text-${id}`).html(newStatusText);
                        $(`#save-order-${id}`).prop("disabled", true);
                        if(newStatusId>3) {
                            let elem = $(`#orderstatus-${id}`).parent();
                            $(`#orderstatus-${id}`).remove();
                            elem.html('<div class="lead">Заказ закрыт и не может быть изменен!</div>')
                        }
                    }
                },
                dataType : "json"
            });
        });
    })
}

const findOpenOrders = () => {
    let selects = $("[id*='orderstatus-']");
    selects.each(function(){
        $(this).on("change", function(){
            let id = $(this).attr("id").substring(12, $(this).attr("id").length);
            $(`#save-order-${id}`).prop("disabled", false);
        })
    })
}

const setDetailHref = () => {
    const hrefs = $('.order-detail');
    hrefs.each(function(){
        $(this).attr("href", $(this).attr("href")+'&asAdmin=true');
    })
}