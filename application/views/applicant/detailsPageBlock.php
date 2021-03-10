<script>
    $(document).ready(function() {
        // Create a post request to delete applicant/s.
        $("#ApplicantBlockForm").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('applicant/block') ?>', 
            $(this).serialize(),
            function(data) {
                hideDialog();
                if(data.trim() === "Success"){
                    showToast("Blocked Successfully.",3000);
                    setTimeout(function(){
                        location.reload();
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
    function showBlockDialog(){
        $("#block_dialog").fadeIn();
    }
</script>
<div class="m2mj-dialog" id="block_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('applicant/delete','id="ApplicantBlockForm"'); ?>        
            <input type="hidden" name="applicantIds" id="applicantIds" value="<?php echo $applicant->id; ?>"  />
            <div class="modal-body">
                <strong class="modal-text">Are you sure you want to block?</strong>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-danger" id="delete_confirm">Block</button>
            </div>
        </form>
    </div>
</div>