<script>
    $(document).ready(function() {
        $("#add_candidate_dialog .m2mj-dialog-close,#add_candidate_dialog .dialog-background").click(function(){
            $(".m2mj-dialog").fadeOut();
        });
        $("#searchCandidateForm").submit(function(e){
            e.preventDefault();
            var url = "<?php echo site_url('applicant/searchAjax'); ?>?display_id=on&display_last_name=on&display_first_name=on";
            var isValid = false;
            if($("#value_id").val()){
                url += "&condition_id=E&value_id="+$("#value_id").val();
                isValid = true;
            }
            if($("#value_first_name").val()){
                url += "&condition_first_name=C&value_first_name="+$("#value_first_name").val();
                isValid = true;
            }
            if($("#value_last_name").val()){
                url += "&condition_last_name=C&value_last_name="+$("#value_last_name").val();
                isValid = true;
            }
            if($("#value_skills").val()){
                url += "&condition_skills=C&value_skills="+$("#value_skills").val();
                isValid = true;
            }
            if(!isValid){
                return;
            }
            $("#applicant_table tbody").html("<tr><td colspan='5'><div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div></td></tr>");
            $.get(url , function(data) {
                if(data === "Error occured."){
                    showToast("Error occurred.",3000);
                    return;
                }
                result = JSON.parse(data);
                $("#applicant_table tbody").html("");
                result.forEach(function(applicant){
                    var row = "<tr id='applicant-"+applicant.id+"' class='applicant-row-item'>";
                    row += "<td class='text-left'><input type='radio' name='applicant_id' value='"+applicant.id+"' required></td>";
                    row += "<td class='text-left'>"+applicant.id+"</td>";
                    row += "<td class='text-left'>"+applicant.last_name+"</td>";
                    row += "<td class='text-left'>"+applicant.first_name+"</td>";
                    var skills = "";
                    if(applicant.skills){
                        skills = applicant.skills;
                    }
                    row += "<td class='text-left' style='word-wrap:break-word;width:30%'>"+skills+"</td>";
                    row += "</tr>";
                    $("#applicant_table tbody").append(row);
                });
            });
        });
        $("#form_add_candidate_to_pipeline").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('pipeline/add') ?>', 
                $(this).serialize(),
                function(data) {
                    if(data.trim() === "Success"){
                        showToast("Added Successfully.",3000);
                        loadPage(1,<?php echo $rowsPerPage; ?>);
                        hideDialog();
                        return;
                    }
                    showToast(data,3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
    });
</script>
<div class="m2mj-dialog" id="add_candidate_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <div class="modal-body">
            <div class="modal-header">
                <h5 class="modal-title">Add Candidate to Pipeline</h5>
                <button type="button" class="close m2mj-dialog-close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('applicant/searchAjax','id="searchCandidateForm"'); ?>
                <div class="form-row" class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="col-md-1 mb-3">
                        <input type="text" name="value_id" id="value_id" class="form-control" placeholder="ID">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="value_last_name" id="value_last_name" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="value_first_name" id="value_first_name" class="form-control" placeholder="First Name">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="value_skills" id="value_skills" class="form-control" placeholder="Skills">
                    </div>
                    <div class="col-md-1 mb-3">
                        <button id="searchCandidate" type="submit" class="btn btn-success search">Search</button>
                    </div>
                </div>
            </form>
            <?php echo form_open('pipeline/add','id="form_add_candidate_to_pipeline"'); ?>
                <input type="hidden" value="<?php echo $job_order_id; ?>" name="job_order_id" id="job_order_id">
                <div class="table-responsive applicant-table">
                    <table class="table table-hover applicant-pipeline-dialog" id="applicant_table">
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                    <div class="mt-2">
                        <label for="assigned_to" class="form-label">Assigned To:</label>
                        <select name="assigned_to" id="assigned_to" class="custom-select" required>
                            <option value="">Select Assignee</option>
                            <?php foreach($users as $user): ?>
                                <option value="<?php echo $user->id; ?>">
                                    <?php echo $user->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" id="assigned_to" name="assigned_to" 
                           value="<?php echo $this->session->userdata(SESS_USER_ID); ?>">
                <?php endif; ?>
                <div class="modal-footer p-2">
                  <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
                  <button type="submit" class="btn btn-primary" id="add_pipeline_confirm">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

