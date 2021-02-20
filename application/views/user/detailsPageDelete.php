<script>
    $(document).ready(function() {
        // Create a post request to delete user/s.
        $("#UserDetailsDeleteForm").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('user/delete') ?>', 
            $(this).serialize(),
            function(data) {
                hideDialog();
                if(data.trim() === "Success"){
                    showToast("Deleted Successfully.",3000);
                    setTimeout(function(){
                        window.location.replace("<?php echo site_url('user/userList') ?>");
                    }, 1000);
                    return;
                }
                showToast("Error occurred.",3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
    });
    
    // Displays the dialog to confirm deletion.
    function showDeleteDialog(){
        $("#delete_dialog").fadeIn();
    }
</script>
<div class="m2mj-dialog" id="delete_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('user/delete','id="UserDetailsDeleteForm"'); ?>        
        <input type="hidden" name="delUserIds" id="delUserIds" value="<?php echo $user->id; ?>"/>
            <div class="modal-body">
                <strong class="modal-text">Are you sure you want to delete?</strong>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-danger" id="delete_confirm">Delete</button>
            </div>
        </form>
    </div>
</div>