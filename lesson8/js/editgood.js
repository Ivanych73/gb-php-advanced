const form_data = new FormData();

$(document).ready(function(){
    
    enableSubmitOnChange();
    
    setSubmitHandler();

    $('#editform').on('reset', function(){
        clearFile();
        $(`#apply`).prop("disabled", true);
    });

    $('#imageInput').on('change', function(){
        $('#output').attr('src', URL.createObjectURL($(this).prop('files')[0]));
        form_data.set('file', $(this).prop('files')[0]);
    })

    setDeleteHandler();
})

const setSubmitHandler = () => {
    $(`#apply`).on('click', function(e){
        e.preventDefault();
        form_data.set('id', $("[name='id']").val());
        $.ajax({
            url: "index.php?path=admin/saveGoodAsAjax",
            type: "POST",
            data: form_data,
            error: function(){
                alert('Ошибка ajax-запроса к серверу!');
            },
            success: function(answer){
                if(answer.actionSuccess) {
                    $(`#apply`).prop("disabled", true);
                }
                alert(answer.ErrMsg);
            },
            dataType : "json",
            processData: false,
            contentType: false
        })
    })
}

const setDeleteHandler = () => {
    $(`#delete`).on('click', function(e){
        e.preventDefault();
        if (confirm(`Вы действительно хотите удалить товар ${$('#titleInput').val()}?`)) {
            $.ajax({
                url: `index.php?path=admin/deleteGoodAsAjax/${$('[name="id"]').val()}`,
                type: "POST",
                data: {
                    id: $('[name="id"]').val()
                },
                error: function(){
                    alert('Ошибка ajax-запроса к серверу!');
                },
                success: function(answer){
                    if(answer.actionSuccess) {
                        $(`#apply`).prop("disabled", true);
                        let inputs = $(":input");
                        inputs.each(function(){
                            if($.inArray($(this).attr('type'), ['submit', 'reset']) < 0){
                                $(this).val('');
                            }
                        })
                        $('#output').hide();
                    }
                    alert(answer.ErrMsg);
                },
                dataType : "json"
            })
        }
    })
}

const clearFile = () => {
    const output = document.getElementById('output');
    output.src = output.dataset.src;
};

const enableSubmitOnChange = () => {
    let inputs = $(":input");
    inputs.each(function(){
        $(this).on("change", function(){
            $(`#apply`).prop("disabled", false);
            if (!$(this).prop('files')){
                form_data.set($(this).attr('name'), $(this).val());
            }
        })
    })
}