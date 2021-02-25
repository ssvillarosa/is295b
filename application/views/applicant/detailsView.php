<div id="applicant-details-page" class="applicant-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <h5 class="mb-3">Applicant details: </h5>
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
                    <?php echo form_open('applicant/update'); ?>
                        <input type="hidden" value="<?php echo $applicant->id; ?>" id="applicantId" name="applicantId">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" value="<?php echo $applicant->last_name; ?>" class="form-control" id="last_name" name="last_name" maxLength="255" required>
                                <?php echo form_error('last_name','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" value="<?php echo $applicant->first_name; ?>" class="form-control" id="first_name" name="first_name" maxLength="255" required>
                                <?php echo form_error('first_name','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" value="<?php echo $applicant->email; ?>" class="form-control" id="email" name="email" maxLength="255">
                                <?php echo form_error('contact_person','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="primary_phone" class="form-label">Primary Phone</label>
                                <input type="text" value="<?php echo $applicant->primary_phone; ?>" class="form-control" id="primary_phone" name="primary_phone" maxLength="255">
                                <?php echo form_error('primary_phone','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="secondary_phone" class="form-label">Secondary Phone</label>
                                <input type="text" value="<?php echo $applicant->secondary_phone; ?>" class="form-control" id="secondary_phone" name="secondary_phone" maxLength="255">
                                <?php echo form_error('secondary_phone','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="work_phone" class="form-label">Work Phone</label>
                                <input type="text" value="<?php echo $applicant->work_phone; ?>" class="form-control" id="work_phone" name="work_phone" maxLength="255">
                                <?php echo form_error('work_phone','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" value="<?php echo $applicant->address; ?>" class="form-control" id="address" name="address" maxLength="255">
                                <?php echo form_error('address','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="best_time_to_call" class="form-label">Best Time to Call</label>
                                <input type="text" value="<?php echo $applicant->best_time_to_call; ?>" class="form-control" id="best_time_to_call" name="best_time_to_call" maxLength="255">
                                <?php echo form_error('best_time_to_call','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="source" class="form-label">Source</label>
                                <input type="text" value="<?php echo $applicant->source; ?>" class="form-control" id="source" name="source" maxLength="255">
                                <?php echo form_error('source','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="current_employer" class="form-label">Current Employer</label>
                                <input type="text" value="<?php echo $applicant->current_employer; ?>" class="form-control" id="current_employer" name="current_employer" maxLength="255">
                                <?php echo form_error('current_employer','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="can_relocate" class="form-label">Can Relocate</label>
                                <input type="text" value="<?php echo $applicant->can_relocate; ?>" class="form-control" id="can_relocate" name="can_relocate" maxLength="255">
                                <?php echo form_error('can_relocate','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="current_pay" class="form-label">Current Pay</label>
                                <input type="number" value="<?php echo $applicant->current_pay; ?>" class="form-control" id="current_pay" name="current_pay" maxLength="255">
                                <?php echo form_error('current_pay','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="desired_pay" class="form-label">Desired Pay</label>
                                <input type="number" value="<?php echo $applicant->desired_pay; ?>" class="form-control" id="desired_pay" name="desired_pay" maxLength="255">
                                <?php echo form_error('desired_pay','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="skills" class="form-label">Skills</label>
                                <div id="skills">
                                    <?php foreach($applicant_skills as $applicant_skill){
                                        echo createPill('skill-'.$applicant_skill->skill_id,
                                                $applicant_skill->name,
                                                $applicant_skill->years_of_experience,
                                                true);
                                    } ?>
                                    <button type="button" id="add_skill" class="btn btn-outline-primary btn-sm" onclick="$('#skills_dialog').fadeIn();">+</button>
                                </div>
                                <input type="hidden" name="skillIds" id="skillIds">
                                <input type="hidden" name="skillNames" id="skillNames">
                                <input type="hidden" name="yearsOfExperiences" id="yearsOfExperiences">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="text-left">
                                <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                                    <button type="button" class="btn btn-danger" onclick="showDeleteDialog()">Delete</button>
                                <?php endif; ?>
                            </div>
                            <div class="text-right">
                                <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                <?php endif; ?>
                                <a href="<?php echo site_url('applicant/applicantList') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>	
</div>