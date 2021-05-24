<script>
    $(document).ready(function() {
        $("#form_delete_pipeline").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('pipeline/delete') ?>', 
                $(this).serialize(),
                function(data) {
                    if(data.trim() === "Success"){
                        showToast("Deleted Successfully.",3000);
                        setTimeout(function () {
                            window.history.back();
                        }, 1000);
                        return;
                    }
                    showToast(data,3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
    });
</script>
<div class="m2mj-dialog" id="delete_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('pipeline/delete','id="form_delete_pipeline"'); ?>     
            <input type="hidden" value="<?php echo $pipeline->id; ?>" id="delPipelineIds" name="delPipelineIds">
            <div class="modal-body">
                <strong class="modal-text">Are you sure you want to remove this candidate to job order?</strong>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-danger" id="delete_confirm">Delete</button>
            </div>
        </form>
    </div>
</div>