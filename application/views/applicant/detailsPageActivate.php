<script>    
    // Send ajax request to activate the applicant.
    function activateApplicant(){
        $.post('<?php echo site_url('applicant/activate') ?>', 
        $("#ApplicantActivateForm").serialize(),
        function(data) {
            hideDialog();
            if(data.trim() === "Success"){
                showToast("Activated Successfully.",3000);
                setTimeout(function(){
                    location.reload();
                }, 1000);
                return;
            }
            showToast("Error occurred.",3000);
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    }
</script>
<div class="m2mj-dialog" id="activate_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('applicant/activate','id="ApplicantActivateForm"'); ?>        
            <input type="hidden" name="applicantIds" id="applicantIds" value="<?php echo $applicant->id; ?>"  />
        </form>
    </div>
</div>