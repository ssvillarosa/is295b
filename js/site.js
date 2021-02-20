const USER_STATUS_ACTIVE = 1;
const USER_STATUS_BLOCKED = 2;
const USER_STATUS_DELETED = 3;

$( document ).ready(function() {
    
    /**
    * Shows dialog when button is clicked.
    */
    $(".m2mj-dialog-trigger").click(function(){
        $(".m2mj-dialog").fadeIn();
    });
    
    /**
    * Hides dialog background when button is clicked.
    */
    $(".m2mj-dialog-close, .dialog-background").click(function(){
        $(".m2mj-dialog").fadeOut();
    });
    
    /**
    * Creates clone of date field when user selects From condition.
    */
    $("[id^=date_field_] .date-field-select").change(function(){
        $mainDiv = $(this).parent().parent();
        if($(this).val()=='R'){
            $dateField = $mainDiv.find("[id^=value_]");
            $dateFieldClone = $dateField.clone();
            $dateFieldClone.attr("id",$dateField.attr('id')+"_2");
            $dateFieldClone.attr("name",$dateField.attr('id')+"_2");
            $dateDiv = $dateField.parent();
            $dateDiv.append('<span class="date_label_2">To: </span>');
            $dateDiv.append($dateFieldClone);
        }else{
            $mainDiv.find("[id$=_2]").remove();
            $mainDiv.find("[class$=_2]").remove();
        }
    });
    
    /**
    * Clears empty parameters for get request forms.
    */
    $(".get-form-clear-params").submit(function(e) {
        $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true;
    });	
});

/**
* Hides dialog when button is clicked.
*/
function hideDialog(){
    $(".m2mj-dialog").fadeOut();    
}

/**
 * Creates toast message.
 *
 * @param {string}  message     The message to display.
 * @param {number}  length      The duration of the toast in millisec.
 */
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

/**
* Hides dropdown when user clicks outside the container
*/
$(document).mouseup(function(e){
    var container = $("#user_profile_dropdown, #user_rows_dropdown, #number_of_rows_dropdown");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide();
    }
});

/**
* Creates a pill button.
 *
 * @param {string}  id              The ID of the button
 * @param {string}  buttonText      The text of the button
 * @param {string}  pillText        The text of the pill
 * @param {boolean} removable       Indicates whether the button is removable or not
 */
function createPill(id,buttonText,pillText,removable){
    var cls = removable ? "pill-button-removable" : "pill-button";
    var pillBtn = "<button type='button' id='"+id+"' class='btn btn-primary badge-pill btn-sm "+cls+" mr-1'>";
        pillBtn += "<span class='pill-button-text mr-1'>"+buttonText+"</span>";
        pillBtn += removable ? "<span class='remove-pill d-none'>Remove</span>" : "";
        pillBtn += pillText ? "<span id='skill-"+buttonText+"' class='badge badge-light badge-pill pill-text'>"+pillText+"</span>" : "";
        pillBtn += "</button>";
    return pillBtn;
}

/**
* Applying events for removable pill buttons.
 */
function applyPillEvents(){
    $(".pill-button-removable").click(function(){
        $(this).remove();
    });

    $('.pill-button-removable').hover(
        function() {
            $(this).width($(this).width());
            $(this).find(".pill-button-text").hide();
            $(this).find(".pill-text").hide();
            $(this).find(".remove-pill").removeClass("d-none");
        },
        function() {
            $(this).find(".pill-button-text").show();
            $(this).find(".pill-text").show();
            $(this).find(".remove-pill").addClass("d-none");
        }
    );
}
