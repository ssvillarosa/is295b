<script>
    $(document).ready(function() {
        // Create a post request to delete registration/s.
        $("#approveForm").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('registration/approve') ?>', 
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
                hideDialog();
                showToast("Error occurred.",3000);
            });
        });
    });
    
    // Displays the dialog to confirm approval.
    function showApproveDialog(){
        var registrations = [];
        $('#registration_table > tbody  > tr > td > .chk').each(function() {
            if($(this).is(":checked")){
                registrations.push($(this).val());
            }
        });
        if(!registrations.length){
            showToast("Please select items to approve.",3000);
            return;
        }
        $("#update_status_dialog").fadeIn();
        $("#approveRegistrationIds").val(registrations.join(','));
    }
</script>
<div class="m2mj-dialog" id="update_status_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('registration/approve','id="approveForm"'); ?>        
            <input type="hidden" name="approveRegistrationIds" id="approveRegistrationIds"/>
            <div class="modal-body">
                <strong class="modal-text">Are you sure you want to approve registration?</strong>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-primary" id="delete_confirm">Approve</button>
            </div>
        </form>
    </div>
</div>