const validatePhpone = () => {
    let regex = /^((\+7|7|8)+([0-9]){10})$/;
    let phone = document.forms[0]["phone"].value;
     if(!regex.test(phone)) {
        alert("Некорректно заполненно поле с телефонным номером!");
        return false;
    }else {
        return true;
    }
}