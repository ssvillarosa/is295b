<script>
    $(document).ready(function() {
        // Add skills to post request.
        $("#addForm").submit(function(e){
            var skillIds = [];
            var skillNames = [];
            var yearsOfExperiences = [];
            var userIds = [];
            var userNames = [];
            $('#skills > button').each(function() {
                var skillId = $(this).attr('id').replace("skill-", "");
                if(skillId != "add_skill"){
                    skillIds.push(skillId);
                    var span = $(this).find('.pill-text');
                    yearsOfExperiences.push(span.text().trim());
                    skillNames.push($(this).find('.pill-button-text').text());
                }
            });
            $('#users > button').each(function() {
                var userId = $(this).attr('id').replace("user-", "");
                if(userId != "add_user"){
                    userIds.push(userId);
                    userNames.push($(this).find('.pill-button-text').text().trim());
                }
            });
            $("#skillIds").val(skillIds);
            $("#skillNames").val(skillNames);
            $("#yearsOfExperiences").val(yearsOfExperiences);
            $("#userIds").val(userIds);
            $("#userNames").val(userNames);
        });
    });
</script>
<div id="job_order_add-page" class="job_order_add-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <h5 class="mb-3">New job order: </h5>
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
                    <?php if(isset($job_order)): ?>
                        <?php echo form_open('job_order/add','id="addForm"'); ?>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" value="<?php echo $job_order->title; ?>" class="form-control" id="title" name="title" maxLength="255" required>
                                    <?php echo form_error('title','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="company_id" class="form-label">Company</label>
                                    <select name="company_id" id="company_id" class="custom-select" required>
                                        <option value="">Select Company</option>
                                        <?php foreach($companies as $company): ?>
                                            <option value="<?php echo $company->id; ?>" <?php if($company->id === $job_order->company_id) echo 'selected'; ?>>
                                                <?php echo $company->name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('company_id','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="min_salary" class="form-label">Min. Salary</label>
                                    <input type="number" value="<?php echo $job_order->min_salary; ?>" class="form-control" id="min_salary" name="min_salary" required>
                                    <?php echo form_error('min_salary','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="max_salary" class="form-label">Max. Salary</label>
                                    <input type="number" value="<?php echo $job_order->max_salary; ?>" class="form-control" id="max_salary" name="max_salary" required>
                                    <?php echo form_error('max_salary','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="employment_type">Employment Type</label>
                                    <select name="employment_type" id="employment_type" class="custom-select" required>
                                        <option value="">Select Employment Type</option>
                                        <option value="<?php echo JOB_ORDER_TYPE_REGULAR; ?>" 
                                            <?php if($job_order->employment_type==JOB_ORDER_TYPE_REGULAR) echo "selected"; ?> >
                                            <?php echo JOB_ORDER_TYPE_REGULAR_TEXT; ?>
                                        </option>
                                        <option value="<?php echo JOB_ORDER_TYPE_CONTRACTUAL; ?>" 
                                            <?php if($job_order->employment_type==JOB_ORDER_TYPE_CONTRACTUAL) echo "selected"; ?>>
                                            <?php echo JOB_ORDER_TYPE_CONTRACTUAL_TEXT; ?>    
                                        </option>
                                    </select>
                                    <?php echo form_error('employment_type','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="custom-select">
                                        <option value="<?php echo JOB_ORDER_STATUS_OPEN; ?>" 
                                            <?php if($job_order->status===JOB_ORDER_STATUS_OPEN) echo "selected"; ?> >
                                            <?php echo JOB_ORDER_STATUS_OPEN_TEXT; ?>
                                        </option>
                                        <option value="<?php echo JOB_ORDER_STATUS_ON_HOLD; ?>" 
                                            <?php if($job_order->status==JOB_ORDER_STATUS_ON_HOLD) echo "selected"; ?>>
                                            <?php echo JOB_ORDER_STATUS_ON_HOLD_TEXT; ?>    
                                        </option>
                                        <option value="<?php echo JOB_ORDER_STATUS_CLOSED; ?>" 
                                            <?php if($job_order->status==JOB_ORDER_STATUS_CLOSED) echo "selected"; ?>>
                                            <?php echo JOB_ORDER_STATUS_CLOSED_TEXT; ?>
                                        </option>
                                    </select>
                                    <?php echo form_error('status','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="job_function" class="form-label" required>Job Function</label>
                                    <textarea class="form-control" id="job_function" name="job_function" rows="3" required><?php echo $job_order->job_function; ?></textarea>
                                    <?php echo form_error('job_function','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="requirement" class="form-label">Requirement</label>
                                    <textarea class="form-control" id="requirement" name="requirement" rows="3" required><?php echo $job_order->requirement; ?></textarea>
                                    <?php echo form_error('requirement','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="requirement" class="form-label">Skills</label>
                                    <div id="skills">
                                        <?php foreach($job_order_skills as $job_order_skill){
                                            echo createPill('skill-'.$job_order_skill->skill_id,
                                                    $job_order_skill->name,
                                                    $job_order_skill->years_of_experience,
                                                    true);
                                        } ?>
                                        <button type="button" id="add_skill" class="btn btn-outline-primary btn-sm" onclick="$('#skills_dialog').fadeIn();">+</button>
                                    </div>
                                    <input type="hidden" name="skillIds" id="skillIds">
                                    <input type="hidden" name="skillNames" id="skillNames">
                                    <input type="hidden" name="yearsOfExperiences" id="yearsOfExperiences">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="users" class="form-label">Recruiters</label>
                                    <div id="users">
                                        <?php foreach($job_order_users as $job_order_user){
                                            echo createPill('user-'.$job_order_user->user_id,
                                                    $job_order_user->name,
                                                    '',
                                                    true);
                                        } ?>
                                        <button type="button" id="add_user" class="btn btn-outline-primary btn-sm" onclick="$('#users_dialog').fadeIn();">+</button>
                                    </div>
                                    <input type="hidden" name="userIds" id="userIds">
                                    <input type="hidden" name="userNames" id="userNames">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" value="<?php echo $job_order->location; ?>" class="form-control" id="location" name="location" maxLength="255">
                                    <?php echo form_error('location','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="slots_available" class="form-label">Slots Available</label>
                                    <input type="number" value="<?php echo $job_order->slots_available; ?>" class="form-control" id="slots_available" name="slots_available" min="1" required>
                                    <?php echo form_error('slots_available','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="priority_level" class="form-label">Priority Level</label>
                                    <input type="number" value="<?php echo $job_order->priority_level; ?>" class="form-control" id="priority_level" name="priority_level" min="1" max="10" required>
                                    <?php echo form_error('priority_level','<div class="alert alert-danger">','</div>'); ?>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="text-left">
                                    <button type="button" class="btn btn-danger" onclick="showDeleteDialog()">Delete</button>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="<?php echo site_url('job_order/jobOrderList') ?>" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>	
</div>

<?php $this->view('job_order/skill'); ?>
<?php $this->view('job_order/user'); ?>