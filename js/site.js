$( document ).ready(function() {
    $(".m2mj-dialog-trigger").click(function(){
        $(".m2mj-dialog").fadeIn();
    });
    $(".m2mj-dialog-close, .dialog-background").click(function(){
        $(".m2mj-dialog").fadeOut();
    });
});

function hideDialog(){
    $(".m2mj-dialog").fadeOut();    
}

var showToast = (function () {
    var timeoutId;
    return function (message,length) {
        if(timeoutId){
            clearTimeout(timeoutId);
            $("#toast").hide();
        }
        $("#toast").html(message);
        $("#toast").fadeIn();
        timeoutId = setTimeout(function(){
            $("#toast").fadeOut();
        },length);
    }
})();