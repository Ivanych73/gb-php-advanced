$(document).ready(function(){
    const pass1 = $('#InputPassword1');
    const pass2 = $('#InputPassword2');
    const submitButton = $('.submit-button');
    const message = $('.action-message');
    const postData = {};

    const enableSubmit = () => {
        submitButton.prop('disabled', false);
        message.text('');
    }

    const disableSubmit = (error) => {
        submitButton.prop('disabled', false);
        message.text(error);
    }
    
    $('#logininput').on('input', function(){
        postData[$(this).attr('name')] = $(this).val();
    });
    
    pass1.on('input', function(){
        if ($(this).val() != pass2.val()){            
            disableSubmit('Введенные пароли не совпадают!');
        }else{
            enableSubmit();
            postData["pass"] = $(this).val();
        }
    })

    pass2.on('input', function(){
        if ($(this).val() != pass1.val()){
            disableSubmit('Введенные пароли не совпадают!');
        }else{
            enableSubmit();
            postData["pass"] = $(this).val();
        }
    })

    submitButton.click(function(e){
        e.preventDefault();
        $.ajax({
            url: "index.php?path=user/newAsAjax",
            type: "POST",
            data: postData,
            error: function(){
                message.text('Ошибка ajax-запроса к серверу!');
            },
            success: function(answer){
                if (answer.actionSuccess) {
                    message.text('Вы успешно зарегистрированы!')
                }else {
                    message.text(answer.ErrMsg);
                }
            },
            dataType : "json"
        });
    });

});