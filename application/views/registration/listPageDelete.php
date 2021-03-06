<script>
    $(document).ready(function() {
        // Create a post request to delete registration/s.
        $("#deleteForm").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('registration/delete') ?>', 
            $(this).serialize(),
            function(data) {
                hideDialog();
                if(data.trim() === "Success"){
                    showToast("Deleted Successfully.",3000);
                    location.reload();
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
        var registrations = [];
        $('#registration_table > tbody  > tr > td > .chk').each(function() {
            if($(this).is(":checked")){
                registrations.push($(this).val());
            }
        });
        if(!registrations.length){
            showToast("Please select items to delete.",3000);
            return;
        }
        $("#delete_dialog").fadeIn();
        $("#delRegistrationIds").val(registrations.join(','));
    }
</script>
<div class="m2mj-dialog" id="delete_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('registration/delete','id="deleteForm"'); ?>        
            <input type="hidden" name="delRegistrationIds" id="delRegistrationIds"/>
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