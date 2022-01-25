$(document).ready(function(){
    const pass1 = $('#InputPassword1');
    const pass2 = $('#InputPassword2');
    const submitButton = $('.submit-button');
    const message = $('.action-message');
    const phone = $('input[name=phone]');
    const postData = {};

    const enableSubmit = () => {
        submitButton.prop('disabled', false);
        message.text('');
    }

    const disableSubmit = (error) => {
        submitButton.prop('disabled', false);
        message.text(error);
    }
    
    $('.user-input').on('input', function(){
        enableSubmit();
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

    phone.on('input', function(){
        const regex = /^((\+7|7|8)+([0-9]){10})$/;
        if (!regex.test($(this).val())) {
            disableSubmit('Некорректно заполненно поле с телефонным номером!');
        }else {
            enableSubmit();
        }
    })

    submitButton.click(function(e){
        e.preventDefault();
        $.ajax({
            url: "index.php?path=user/saveAsAjax",
            type: "POST",
            data: postData,
            error: function(){
                message.text('Ошибка ajax-запроса к серверу!');
            },
            success: function(answer){
                if (answer.actionSuccess) {
                    message.text('Данные успешно обновлены!')
                }else {
                    message.text(answer.ErrMsg);
                }
            },
            dataType : "json"
        });
    });

});