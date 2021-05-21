<script>
    $(document).ready(function() {
        $("#add_job_order_dialog .m2mj-dialog-close,#add_job_order_dialog .dialog-background").click(function(){
            $(".m2mj-dialog").fadeOut();
        });
        $("#searchJobOrderForm").submit(function(e){
            e.preventDefault();
            var url = "<?php echo site_url('job_order/searchAjax'); ?>?display_id=on&display_title=on";
            var isValid = false;
            if($("#value_id").val()){
                url += "&condition_id=E&value_id="+$("#value_id").val();
                isValid = true;
            }
            if($("#value_title").val()){
                url += "&condition_title=C&value_title="+$("#value_title").val();
                isValid = true;
            }
            if($("#value_skills").val()){
                url += "&condition_skills=C&value_skills="+$("#value_skills").val();
                isValid = true;
            }
            if(!isValid){
                return;
            }
            $("#job_order_table tbody").html("<tr><td colspan='5'><div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div></td></tr>");
            $.get(url , function(data) {
                if(data === "Error occured."){
                    showToast("Error occurred.",3000);
                    return;
                }
                result = JSON.parse(data);
                $("#job_order_table tbody").html("");
                result.forEach(function(job_order){
                    var row = "<tr id='job_order-"+job_order.id+"' class='job_order-row-item'>";
                    row += "<td class='text-left'><input type='radio' name='job_order_id' value='"+job_order.id+"' required></td>";
                    row += "<td class='text-left'>"+job_order.id+"</td>";
                    row += "<td class='text-left'>"+job_order.title+"</td>";
                    var skills = "";
                    if(job_order.skills){
                        skills = job_order.skills;
                    }
                    row += "<td class='text-left' style='word-wrap:break-word;width:50%'>"+skills+"</td>";
                    row += "</tr>";
                    $("#job_order_table tbody").append(row);
                });
            });
        });
        $("#form_add_job_order_to_pipeline").submit(function(e){
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
<div class="m2mj-dialog" id="add_job_order_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <div class="modal-body">
            <div class="modal-header">
                <h5 class="modal-title">Add Candidate to Pipeline</h5>
                <button type="button" class="close m2mj-dialog-close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('job_order/searchAjax','id="searchJobOrderForm"'); ?>
                <div class="form-row" class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="col-md-1 mb-3">
                        <input type="text" name="value_id" id="value_id" class="form-control" placeholder="ID">
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" name="value_title" id="value_title" class="form-control" placeholder="Job Order Title">
                    </div>
                    <div class="col-md-4 mb-3">
                        <input type="text" name="value_skills" id="value_skills" class="form-control" placeholder="Skills">
                    </div>
                    <div class="col-md-1 mb-3">
                        <button id="searchCandidate" type="submit" class="btn btn-success search">Search</button>
                    </div>
                </div>
            </form>
            <?php echo form_open('pipeline/add','id="form_add_job_order_to_pipeline"'); ?>
                <input type="hidden" value="<?php echo $applicant_id; ?>" name="applicant_id" id="applicant_id">
                <div class="table-responsive job_order-table">
                    <table class="table table-hover job_order-pipeline-dialog" id="job_order_table">
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

