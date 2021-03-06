<script>
    $(document).ready(function() {
        // Add skills to post request.
        $("#updateRegistrationForm").submit(function(e){
            var skillIds = [];
            var skillNames = [];
            var yearsOfExperiences = [];
            $('#skills > button').each(function() {
                var skillId = $(this).attr('id').replace("skill-", "");
                if(skillId != "add_skill"){
                    skillIds.push(skillId);
                    var span = $(this).find('.pill-text');
                    yearsOfExperiences.push(span.text().trim());
                    skillNames.push($(this).find('.pill-button-text').text());
                }
            });
            $("#skillIds").val(skillIds);
            $("#skillNames").val(skillNames);
            $("#yearsOfExperiences").val(yearsOfExperiences);
        });
    });
</script>
<div id="registration-details-page" class="registration-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
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
                    <?php echo form_open('registration/update','id="updateRegistrationForm"'); ?>
                        <input type="hidden" value="<?php echo $registration->id; ?>" id="registrationId" name="registrationId">
                        <h5 class="mb-1 section-head">Personal Information: </h5>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" value="<?php echo $registration->last_name; ?>" class="form-control form-control-sm" id="last_name" name="last_name" maxLength="255" required>
                                <?php echo form_error('last_name','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" value="<?php echo $registration->first_name; ?>" class="form-control form-control-sm" id="first_name" name="first_name" maxLength="255" required>
                                <?php echo form_error('first_name','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Birthday</label>
                                <input type="date" value="<?php echo $registration->birthday; ?>" class="form-control form-control-sm" id="birthday" name="birthday" maxLength="50">
                                <?php echo form_error('birthday','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role">Civil Status</label>
                                <select id="civil_status" name="civil_status" class="custom-select custom-select-sm">
                                    <option value="">Select Civil Status</option>
                                    <option value="<?php echo APPLICANT_CIVIL_STATUS_SINGLE; ?>" <?php if($registration->civil_status===strval(APPLICANT_CIVIL_STATUS_SINGLE)) echo "selected"; ?> ><?php echo APPLICANT_CIVIL_STATUS_SINGLE_TEXT; ?></option>
                                    <option value="<?php echo APPLICANT_CIVIL_STATUS_MARRIED; ?>" <?php if($registration->civil_status===strval(APPLICANT_CIVIL_STATUS_MARRIED)) echo "selected"; ?> ><?php echo APPLICANT_CIVIL_STATUS_MARRIED_TEXT; ?></option>
                                    <option value="<?php echo APPLICANT_CIVIL_STATUS_WIDOWED; ?>" <?php if($registration->civil_status===strval(APPLICANT_CIVIL_STATUS_WIDOWED)) echo "selected"; ?> ><?php echo APPLICANT_CIVIL_STATUS_WIDOWED_TEXT; ?></option>
                                </select>
                                <?php echo form_error('civil_status','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <h5 class="mb-1 section-head">Contact Information: </h5>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" value="<?php echo $registration->email; ?>" class="form-control form-control-sm" id="email" name="email" maxLength="255">
                                <?php echo form_error('email','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="primary_phone" class="form-label">Primary Phone</label>
                                <input type="text" value="<?php echo $registration->primary_phone; ?>" class="form-control form-control-sm" id="primary_phone" name="primary_phone" maxLength="255">
                                <?php echo form_error('primary_phone','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="secondary_phone" class="form-label">Secondary Phone</label>
                                <input type="text" value="<?php echo $registration->secondary_phone; ?>" class="form-control form-control-sm" id="secondary_phone" name="secondary_phone" maxLength="255">
                                <?php echo form_error('secondary_phone','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="work_phone" class="form-label">Work Phone</label>
                                <input type="text" value="<?php echo $registration->work_phone; ?>" class="form-control form-control-sm" id="work_phone" name="work_phone" maxLength="255">
                                <?php echo form_error('work_phone','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-1">
                                <label for="best_time_to_call" class="form-label">Best Time to Call</label>
                                <input type="text" value="<?php echo $registration->best_time_to_call; ?>" class="form-control form-control-sm" id="best_time_to_call" name="best_time_to_call" maxLength="255">
                                <?php echo form_error('best_time_to_call','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-1">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" value="<?php echo $registration->address; ?>" class="form-control form-control-sm" id="address" name="address" maxLength="255">
                                <?php echo form_error('address','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="custom-control custom-checkbox mr-sm-2  mb-2">
                                <input type="checkbox" class="custom-control-input" id="can_relocate" name="can_relocate" value="1"
                                       <?php if($registration->can_relocate != "0") echo "checked"; ?>>
                                <label class="custom-control-label" for="can_relocate">Can relocate</label>
                                <?php echo form_error('can_relocate','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <h5 class="mb-1 section-head">Employment Information: </h5>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="current_employer" class="form-label">Current Employer</label>
                                <input type="text" value="<?php echo $registration->current_employer; ?>" class="form-control form-control-sm" id="current_employer" name="current_employer" maxLength="255">
                                <?php echo form_error('current_employer','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="source" class="form-label">Source</label>
                                <input type="text" value="<?php echo $registration->source; ?>" class="form-control form-control-sm" id="source" name="source" maxLength="255">
                                <?php echo form_error('source','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="current_pay" class="form-label">Current Pay</label>
                                <input type="number" value="<?php if($registration->current_pay != "0") echo $registration->current_pay; ?>" class="form-control form-control-sm" id="current_pay" name="current_pay" maxLength="255">
                                <?php echo form_error('current_pay','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="desired_pay" class="form-label">Desired Pay</label>
                                <input type="number" value="<?php if($registration->desired_pay != "0") echo $registration->desired_pay; ?>" class="form-control form-control-sm" id="desired_pay" name="desired_pay" maxLength="255">
                                <?php echo form_error('desired_pay','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-1">
                                <label for="skills" class="form-label">Skills</label>
                                <div id="skills">
                                    <?php foreach($registration_skills as $registration_skill){
                                        echo createPill('skill-'.$registration_skill->skill_id,
                                                $registration_skill->name,
                                                $registration_skill->years_of_experience,
                                                true);
                                    } ?>
                                    <button type="button" id="add_skill" class="btn btn-outline-primary btn-sm" onclick="$('#skills_dialog').fadeIn();">+</button>
                                </div>
                                <input type="hidden" name="skillIds" id="skillIds">
                                <input type="hidden" name="skillNames" id="skillNames">
                                <input type="hidden" name="yearsOfExperiences" id="yearsOfExperiences">
                                <?php echo form_error('skillIds','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="objectives" class="form-label">Objectives</label>
                                <textarea class="form-control form-control-sm" id="objectives" name="objectives" rows="3"><?php echo $registration->objectives; ?></textarea>
                                <?php echo form_error('objectives','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="objectives" class="form-label">Educational Background</label>
                                <textarea class="form-control form-control-sm" id="educational_background" name="educational_background" rows="3"><?php echo $registration->educational_background; ?></textarea>
                                <?php echo form_error('educational_background','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="objectives" class="form-label">Professional Experience</label>
                                <textarea class="form-control form-control-sm" id="professional_experience" name="professional_experience" rows="3"><?php echo $registration->professional_experience; ?></textarea>
                                <?php echo form_error('professional_experience','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="objectives" class="form-label">Seminars and Trainings</label>
                                <textarea class="form-control form-control-sm" id="seminars_and_trainings" name="seminars_and_trainings" rows="3"><?php echo $registration->seminars_and_trainings; ?></textarea>
                                <?php echo form_error('seminars_and_trainings','<div class="alert alert-danger">','</div>'); ?>
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
                                    <button type="submit" class="btn btn-primary">Approve</button>
                                <?php endif; ?>
                                <a href="<?php echo site_url('registration/registrationList') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>	
</div>

<?php $this->view('common/skillDialog'); ?>
<?php $this->view('registration/detailsPageDelete'); ?>