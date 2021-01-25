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

// Hide user profile settings on click outside the container
$(document).mouseup(function(e){
    var container = $("#user_profile_dropdown, #user_rows_dropdown");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide();
    }
});