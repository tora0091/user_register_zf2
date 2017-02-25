$(function(){
    $("#number").blur(function(){
        number = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/check_number',
            timeout: 10000,
            cache: false,
            dataType: 'json',
            data: {
                "number": number
            }
        }).done(function(response, status) {
            // true: 利用可能 false: 利用不可（すでに登録されている）
            // console.log(response);
            if (response.result) {
                // クリア処理
                $("#error-text-for-number").text("");
            } else {
                // エラーメッセージはPHP側のMessage.phpでも定義している
                $("#error-text-for-number").text("社員番号はすでに登録されています");
            }
        }).fail(function(response, status, error) {
            console.log("Ajex json error. check number.");
            console.log(response);
            console.log(status);
            console.log(error);
        });
    });
});
