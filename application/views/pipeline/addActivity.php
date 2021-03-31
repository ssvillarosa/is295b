<script>
    $(document).ready(function() {
        $('#status_div').hide();
        $('#activity_notes_div').hide();
        $('#email_details_div').hide();
        $('#send_copy_div').hide();
        $('#assigned_to_div').hide();
        $('#event_div').hide();
    });
</script>
<div id="pipeline-details-page" class="pipeline-details-page">
    <div class="container">
        <div class="row justify-content-center ml-2">
            <div class="col-md-9 update-component">
                <section id="content" >
                    <h5 class="modal-title">Log Activity</h5>
                    <?php echo form_open('pipeline/add','id="form_add_candidate_to_pipeline"'); ?>
                        <input type="hidden" value="<?php echo $pipeline->id; ?>" id="pipelineId" name="pipelineId">
                        <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                            <div class="form-row">
                                <div class="col-md-3 mb-1">
                                    <label for="assigned_to" class="form-label ml-5">Assigned To</label>
                                </div>
                                <div class="col-md-9 mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check_assigned_to" 
                                               onchange="$('#check_assigned_to').is(':checked')?$('#assigned_to_div').show():$('#assigned_to_div').hide();">
                                        <label class="form-check-label" for="check_assigned_to">Change Assignment</label>
                                    </div>
                                    <div id="assigned_to_div">
                                        <select name="user_select" id="user_select" class="custom-select" required>
                                            <option value="">Select User</option>
                                            <?php foreach($recruiters as $recruiter): ?>
                                                <option value="<?php echo $recruiter->id; ?>">
                                                    <?php echo $recruiter->name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-row">
                            <div class="col-md-3 mb-1">
                                <label for="assigned_to" class="form-label ml-5">Status</label>
                            </div>
                            <div class="col-md-9 mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_status" 
                                           onchange="$('#check_status').is(':checked')?$('#status_div').show():$('#status_div').hide();">
                                    <label class="form-check-label" for="check_status">Change Status</label>
                                </div>
                                <div id="status_div">
                                    <select name="status" id="status" class="custom-select">
                                        <option value="">Select Status</option>
                                        <?php foreach(unserialize(PIPELINE_STATUSES) as $status): ?>
                                            <option value="<?php echo $status['value']; ?>">
                                                <?php echo $status['text']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-1">
                                <label for="assigned_to" class="form-label ml-5">Activity</label>
                            </div>
                            <div class="col-md-9 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_notes"
                                           onchange="$('#check_notes').is(':checked')?$('#activity_notes_div').show():$('#activity_notes_div').hide();">
                                    <label class="form-check-label" for="check_notes">Log an Activity</label>
                                </div>
                                <div id="activity_notes_div">
                                    <label for="activity_notes" class="form-label">Activity Notes</label>
                                    <textarea class="form-control" id="activity_notes" name="activity_notes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-1">
                                <label for="assigned_to" class="form-label ml-5">Email</label>
                            </div>
                            <div class="col-md-9 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_email" 
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
                                            <input class="form-control" type="email" id="email_to" name="email_from"
                                                   value="<?php echo SENDER_EMAIL; ?>">
                                        </div>
                                        <div class="col-md-6 mb-1">
                                            <label for="email_to" class="form-label">To</label>
                                            <input class="form-control" type="email" id="email_to" name="email_to"
                                                   value="<?php echo $pipeline->applicant_email; ?>">
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="check_copy"
                                               onchange="$('#check_copy').is(':checked')?$('#send_copy_div').show():$('#send_copy_div').hide();">
                                        <label class="form-check-label" for="check_copy">Send me a copy</label>
                                    </div>
                                    <div class="form-row" id="send_copy_div">
                                        <div class="col-md-6 mb-3">
                                            <label for="email_to" class="form-label">Cc</label>
                                            <input class="form-control" type="email" id="email_to" name="email_cc"
                                                   value="<?php echo $this->session->userdata(SESS_USER_EMAIL); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email_to" class="form-label">Reply To</label>
                                            <input class="form-control" type="email" id="email_to" name="email_reply_to"
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
                                <label for="assigned_to" class="form-label ml-5">Event</label>
                            </div>
                            <div class="col-md-9 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_event"
                                           onchange="$('#check_event').is(':checked')?$('#event_div').show():$('#event_div').hide();">
                                    <label class="form-check-label" for="check_event">Schedule an Event</label>
                                </div>
                                <div id="event_div">
                                    <div class="form-row mb-3">
                                        <label for="event_title" class="form-label col-md-3">Title</label>
                                        <input class="form-control" id="event_title" name="event_title">
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input mt-3" type="radio" name="schedule" value="timed" id="timed_schedule"
                                                onchange="$('#event_time').prop('disabled',false);" checked>
                                        <div>
                                            <input type="datetime-local" class="form-control" id="event_time" name="event_time">
                                        </div>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="schedule" value="all_day" id="all_day_schedule"
                                                onchange="$('#event_time').prop('disabled',true);">
                                        <label class="form-check-label" for="all_day_schedule">All Day/No Specific Time</label>
                                    </div>
                                    <div class="form-row">
                                        <label for="event_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="event_description" name="event_description" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer p-2">
                          <button type="submit" class="btn btn-primary" id="log_activitiy_confirm">Save</button>
                          <button type="button" class="btn btn-secondary m2mj-dialog-close">Back</button>
                        </div>
                    </form>
                </section>
            </div>
            
        </div>
    </div>
</div>