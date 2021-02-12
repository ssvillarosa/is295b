<script>
    $(document).ready(function() {
        // Create a post request to toggle user status.
        $("#statusForm").submit(function(e){
            e.preventDefault();
            var api = '<?php echo site_url('user') ?>/'+$("#action").val();
            $.post(api, 
            $(this).serialize(),
            function(data) {
                hideDialog();
                if(data.trim() === "Error"){
                    showToast("Error occurred.",3000);
                    return;
                }
                var rowButton = "#statusUser"+$("#userId").val(); 
                var done;
                var newStatus;
                if($("#action").val() === "activate"){
                    done = "activated";
                    newStatus = "Active";
                    $(rowButton).removeClass('btn-status-'+USER_STATUS_BLOCKED);
                    $(rowButton).addClass('btn-status-'+USER_STATUS_ACTIVE);
                }else{
                    done = "blocked";
                    newStatus = "Blocked";
                    $(rowButton).removeClass('btn-status-'+USER_STATUS_ACTIVE);
                    $(rowButton).addClass('btn-status-'+USER_STATUS_BLOCKED);
                }
                var message = "User "+$("#username").val()
                        +" successfully "+done+".";
                $(rowButton+" span").text(newStatus);
                showToast(message,3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
    });
    
    // Displays the dialog to toggle user status.
    function toggleUserStatus(userId,username){
        var action;
        var status = $("#statusUser"+userId+" span").text() != "Active";
        $("#userId").val(userId);
        if(status){
            action = "activate";
            $("#modal-action").addClass("btn-warning");
            $("#modal-action").removeClass("btn-danger");
        }else{
            action = "block";
            $("#modal-action").addClass("btn-danger");
            $("#modal-action").removeClass("btn-warning");
        }        
        var message = "Do you want to "+action+" "+username+"?";
        $("#modal-action").html(action);
        $("#action").val(action);
        $("#username").val(username);
        $(".modal-text").html(message);
        $("#status_dialog").fadeIn();
    }
</script>
<div class="m2mj-dialog" id="status_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('user/block','id="statusForm"'); ?>
            <input type="hidden" name="userId" id="userId"/>
            <input type="hidden" name="username" id="username"/>
            <input type="hidden" name="action" id="action"/>
            <div class="modal-body">
                <strong class="modal-text"></strong>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-primary" id="modal-action">Save</button>
            </div>
        </form>
    </div>
</div>