$(function(){
    $("button").click(function(){
       $(this).parent("form").submit();
       $(this).prop("disabled", true);
    });
});
