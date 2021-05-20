<script>
    $(document).ready(function() {
        $('#rating_div').hide();
        $('#status_div').hide();
        $('#activity_notes_div').hide();
        $('#email_details_div').hide();
        $('#send_copy_div').hide();
        $('#assigned_to_div').hide();
        $('#event_div').hide();
        $('#file_upload_div').hide();
        
        $("#form_add_activity").submit(function(e){
            e.preventDefault();
            showLoading();
            $.ajax({
                url:'<?php echo site_url('activity/add') ?>', 
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    hideLoading();
                    if(data.trim() === "Success"){
                        showToast("Activity Added Successfully.",3000);
                        setTimeout(function () {
                            location.reload(true);
                        }, 1000);
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
        
        $("#form_add_activity .star-rating").mouseenter(function(){
            var yellowCount = $(this).attr("id").replace("star-","");
            updateStarsColor(yellowCount);
        });
        
        $("#form_add_activity .star-rating").mouseleave(function(){
            var defaultScore = $("#rateScore").val();
            updateStarsColor(defaultScore);
        });
    });
    
    function starhover(score){
        $("#rateScore").val(score);
        updateStarsColor(score);
    }
    
    function updateStarsColor(yellowCount){
        for(ctr=1;ctr<=<?php echo MAX_RATING?>;ctr++){
            if(yellowCount >= ctr){
                $("#star-"+ctr).removeClass("black-star");
                $("#star-"+ctr).addClass("yellow-star");
            }else{
                $("#star-"+ctr).removeClass("yellow-star");
                $("#star-"+ctr).addClass("black-star");
            }
        }
    }
</script>
<div id="add_activity_page" class="add-activity-page">
    <section id="content" >
        <h5 class="modal-title mb-3">Log Activity</h5>
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
            <?php return; ?>
        <?php endif; ?>
        <?php echo form_open_multipart('activity/add','id="form_add_activity"'); ?>
            <input type="hidden" value="<?php echo $pipeline->id; ?>" id="pipelineId" name="pipelineId">
            <div class="form-row">
                <div class="col-md-3 mb-1">
                    <label class="form-label ml-4">Rating</label>
                </div>
                <div class="col-md-9 mb-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_rating" name="check_rating" 
                               onchange="$('#check_rating').is(':checked')?$('#rating_div').show():$('#rating_div').hide();">
                        <label class="form-check-label" for="check_rating">Update Rating</label>
                    </div>
                    <div id="rating_div" class="m-3">
                        <input type="hidden" id="rateScore" name="rateScore" value="<?php echo $pipeline->rating; ?>">
                        <?php for($ctr=0;$ctr<MAX_RATING;$ctr++) {
                            if(intval($pipeline->rating) > $ctr){
                                echo "<button type='button' class='star-rating yellow-star' id='star-".($ctr+1)."' onclick='starhover(".($ctr+1).")'/>";
                            }else{
                                echo "<button type='button' class='star-rating black-star' id='star-".($ctr+1)."' onclick='starhover(".($ctr+1).")'/>";
                            }
                        } ?>
                    </div>
                </div>
            </div>
            <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                <div class="form-row">
                    <div class="col-md-3 mb-1">
                        <label for="assigned_to" class="form-label ml-4">Assign To</label>
                    </div>
                    <div class="col-md-9 mb-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_assigned_to" name="check_assigned_to"
                                   onchange="$('#check_assigned_to').is(':checked')?$('#assigned_to_div').show():$('#assigned_to_div').hide();">
                            <label class="form-check-label" for="check_assigned_to">Change Assignment</label>
                        </div>
                        <div id="assigned_to_div">
                            <select name="user_select" id="user_select" class="custom-select">
                                <option value="">Select User</option>
                                <?php foreach($users as $user): ?>
                                    <?php if($user->id == $pipeline->assigned_to): ?>
                                        <?php continue; ?>
                                    <?php endif; ?>
                                    <option value="<?php echo $user->id; ?>">
                                        <?php echo $user->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-row">
                <div class="col-md-3 mb-1">
                    <label for="assigned_to" class="form-label ml-4">Status</label>
                </div>
                <div class="col-md-9 mb-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_status" name="check_status" 
                               onchange="$('#check_status').is(':checked')?$('#status_div').show():$('#status_div').hide();">
                        <label class="form-check-label" for="check_status">Change Status</label>
                    </div>
                    <div id="status_div">
                        <select name="status" id="status" class="custom-select">
                            <option value="">Select Status</option>
                            <?php foreach($pipeline_statuses as $ps): ?>
                                <?php if($pipeline->status_id == $ps->id): ?>
                                    <?php continue; ?>
                                <?php endif; ?>
                                <option value="<?php echo $ps->id; ?>">
                                    <?php echo $ps->status; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-1">
                    <label for="assigned_to" class="form-label ml-4">Notes</label>
                </div>
                <div class="col-md-9 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_notes" name="check_notes"
                               onchange="$('#check_notes').is(':checked')?$('#activity_notes_div').show():$('#activity_notes_div').hide();">
                        <label class="form-check-label" for="check_notes">Add Note</label>
                    </div>
                    <div id="activity_notes_div">
                        <label for="activity_notes" class="form-label">Activity Notes</label>
                        <textarea class="form-control" id="activity_notes" name="activity_notes" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-1">
                    <label for="assigned_to" class="form-label ml-4">Email</label>
                </div>
                <div class="col-md-9 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_email" name="check_email" 
                               onchange="$('#check_email').is(':checked')?$('#email_details_div').show():$('#email_details_div').hide();">
                        <label class="form-check-label" for="check_email">Send an E-mail</label>
                    </div>
                    <div id="email_details_div">
                        <div class="form-row">
                            <label for="email_to" class="form-label">Subject</label>
                            <input class="form-control" type="text" id="email_subject" name="email_subject"
                                   value="JOB POSTING FOR <?php echo strtoupper($pipeline->title); ?> (ID: <?php echo $pipeline->job_order_id; ?>)">
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="email_to" class="form-label">From</label>
                                <input class="form-control" type="email" id="email_from" name="email_from"
                                       value="<?php echo SENDER_EMAIL; ?>">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="email_to" class="form-label">To</label>
                                <input class="form-control" type="email" id="email_to" name="email_to"
                                       value="<?php echo $pipeline->applicant_email; ?>">
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_copy" name="check_copy"
                                   onchange="$('#check_copy').is(':checked')?$('#send_copy_div').show():$('#send_copy_div').hide();">
                            <label class="form-check-label" for="check_copy">Send me a copy</label>
                        </div>
                        <div class="form-row" id="send_copy_div">
                            <div class="col-md-6 mb-3">
                                <label for="email_to" class="form-label">Cc</label>
                                <input class="form-control" type="email" id="email_cc" name="email_cc"
                                       value="<?php echo $this->session->userdata(SESS_USER_EMAIL); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email_to" class="form-label">Reply To</label>
                                <input class="form-control" type="email" id="email_reply_to" name="email_reply_to"
                                       value="<?php echo $pipeline->user_email; ?>">
                            </div>
                        </div>
                        <label for="email_message" class="form-label">Message</label>
                        <textarea class="form-control" id="email_message" name="email_message" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-1">
                    <label for="assigned_to" class="form-label ml-4">Event</label>
                </div>
                <div class="col-md-9 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_event" name="check_event"
                               onchange="$('#check_event').is(':checked')?$('#event_div').show():$('#event_div').hide();">
                        <label class="form-check-label" for="check_event">Schedule an Event</label>
                    </div>
                    <div id="event_div">
                        <div class="form-row mb-2">
                            <label for="event_title" class="form-label col-md-3">Title</label>
                            <input class="form-control" id="event_title" name="event_title">
                        </div>
                        <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                            <div class="form-row mb-2">
                                <label for="event_assigned_to" class="form-label col-md-3">Assign to:</label>
                                <select name="event_assigned_to" id="event_assigned_to" class="custom-select">
                                    <option value="">Select User</option>
                                    <?php foreach($users as $user): ?>
                                        <?php if($user->id == $pipeline->assigned_to 
                                                || $user->id == $this->session->userdata(SESS_USER_ID)): ?>
                                            <option value="<?php echo $user->id; ?>">
                                                <?php echo $user->name; ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_public" id="is_public">
                            <label class="form-check-label" for="is_public">Public Event</label>
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
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-1">
                    <label class="form-label ml-4">File</label>
                </div>
                <div class="col-md-9 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_upload" name="check_upload"
                               onchange="$('#check_upload').is(':checked')?$('#file_upload_div').show():$('#file_upload_div').hide();">
                        <label class="form-check-label" for="check_upload">Upload File</label>
                    </div>
                    <div id="file_upload_div" class="mt-3">
                        <input type="file" class="form-control-file" id="file_attachment" name="file_attachment">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary mr-1" id="log_activitiy_confirm">Save</button>
              <button type="button" class="btn btn-secondary m2mj-dialog-close" onclick="$('#add_activity_page').slideUp();">Cancel</button>
            </div>
        </form>
    </section>
</div>