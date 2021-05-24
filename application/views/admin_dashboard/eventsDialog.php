<script>
    function viewPipelineDetails(){
        let id = $("#eventId").val();
        window.location.href = '<?php echo site_url('activity/activityListByPipeline') ?>?pipelineId='+id;
    }
    
    $(document).ready(function() {
        $("#event_dialog .m2mj-dialog-close, #event_dialog .dialog-background,#delete_event_dialog .m2mj-dialog-close, #delete_event_dialog .dialog-background").click(function(){
            $(".m2mj-dialog").fadeOut();
        });
        // Create a post request to update event.
        $("#form_event_dialog").submit(function(e){
            e.preventDefault();
            showLoading();
            $.post('<?php echo site_url('activity/updateEvent') ?>', 
            $(this).serialize(),
            function(data) {
                hideLoading();
                if(data.trim() === "Success"){
                    hideDialog();
                    showToast("Updated Successfully.",3000);
                    location.reload();
                    return;
                }
                showToast("Error occurred.",3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
        // Create a post request to update event.
        $("#pipeline_delete").click(function(e){
            $(".m2mj-dialog").fadeOut();
            $("#delete_event_dialog").fadeIn();
        });
        // Create a post request to update event.
        $("#delete_event_confirm").click(function(e){
            e.preventDefault();
            showLoading();
            $.post('<?php echo site_url('activity/deleteEvent') ?>', 
            $("#form_event_dialog").serialize(),
            function(data) {
                hideLoading();
                if(data.trim() === "Success"){
                    hideDialog();
                    showToast("Updated Successfully.",3000);
                    location.reload();
                    return;
                }
                showToast("Error occurred.",3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
    });
</script>
<div class="m2mj-dialog" id="event_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('event/update','id="form_event_dialog"'); ?>     
            <input type="hidden" id="eventId" name="eventId">
            <div class="modal-body">
                <div class="form-row mb-2">
                    <label for="event_title" class="form-label col-md-3">Title</label>
                    <input class="form-control" id="event_title" name="event_title">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="public" id="public" value="1">
                    <label class="form-check-label" for="public">Public Event</label>
                </div>
                <div class="form-row mb-2">
                    <label class="form-check-label" for="event_time">Date/Time</label>
                    <input type="datetime-local" class="form-control" id="event_time" name="event_time">
                </div>
                <div class="form-row">
                    <label for="event_description" class="form-label">Description</label>
                    <textarea class="form-control" id="event_description" name="event_description" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer p-2 justify-content-between">
                <div class="left">
                    <button type="button" class="btn btn-success" id="pipeline_view" onclick="viewPipelineDetails()">
                        View Pipeline
                    </button>
                    <button type="button" class="btn btn-danger" id="pipeline_delete">Delete</button>
                </div>
                <div class="right">
                    <button type="submit" class="btn btn-primary" id="pipeline_save">Save</button>
                    <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="m2mj-dialog" id="delete_event_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('pipeline/delete','id="form_delete_pipeline"'); ?>     
            <div class="modal-body">
                <strong class="modal-text">Are you sure you want to delete event?</strong>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-danger" id="delete_event_confirm">Delete</button>
            </div>
        </form>
    </div>
</div>