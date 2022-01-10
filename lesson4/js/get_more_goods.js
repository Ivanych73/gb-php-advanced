loadMoreGoods = () => {
    count = $("#catalog").data("count")
    $.post("server/get_more_goods.php",
    {count}, function(data){
        $("#catalog").append(data)
        count++
        $("#catalog").data("count", count)
    })
}