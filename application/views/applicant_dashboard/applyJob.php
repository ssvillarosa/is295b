<script>
    $(document).ready(function() {
        $("#apply_job_dialog .m2mj-dialog-close,#apply_job_dialog .dialog-background").click(function(){
            $(".m2mj-dialog").fadeOut();
        });
        $("#form_submit_application").submit(function(e){
            e.preventDefault();
            showLoading();
            $.ajax({
                url:'<?php echo site_url('pipeline/applicantSubmitAjax') ?>', 
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    hideDialog();
                    hideLoading();
                    if(data.trim() === "Success"){
                        showToast("Application submitted successfully.",3000);
                        return;
                    }
                    showToast(data,3000);
                },
                error: function() {
                    hideLoading();
                    showToast("Error occurred.",3000);
                },
            });
        });
    });
    
    function openApplicationForm(jobOrderId){
        <?php if($this->session->has_userdata(SESS_IS_APPLICANT_LOGGED_IN)) : ?>
            $("#job_order_id").val(jobOrderId);
            $('#apply_job_dialog').fadeIn();
        <?php else: ?>
            window.location.replace("<?php echo site_url('applicantAuth/login?referrer='.getFullUrl()); ?>");
        <?php endif; ?>
    }
</script>
<div class="m2mj-dialog" id="apply_job_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content w-50">
        <div class="modal-body">
            <div class="modal-header">
                <h5 class="modal-title">Submit Application</h5>
                <button type="button" class="close m2mj-dialog-close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('pipeline/applicantSubmitAjax','id="form_submit_application"'); ?>
                <input type="hidden" value="1" name="job_order_id" id="job_order_id">
                <div class="form-row mb-2">
                    <label for="job_function" class="form-label" required>Message</label>
                    <textarea class="form-control form-control-sm" id="message" name="message" rows="5"></textarea>
                </div>
                <div class="custom-file mb-2">
                    <label for="file_attachment">Please upload your CV.</label>
                    <input type="file" class="form-control-file" id="file_attachment" name="file_attachment">
                </div>
                <div class="modal-footer p-2">
                  <button type="submit" class="btn btn-primary" id="add_pipeline_confirm">Submit</button>
                  <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

