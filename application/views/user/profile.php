<div id="user-details-page" class="user-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <h5>Profile</h5>
                    <?php if(isset($success_message)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php echo form_open('user/profileUpdate', 'class="profile-form"'); ?>
                        <div class="form-row">
                            <div class="col-md-6 mb-2">
                                <h5 class="mb-3">Username: <?php echo $this->session->userdata(SESS_USERNAME); ?></h5>
                            </div>
                            <div class="col-md-6 mb-2">
                                <h5>Role: <?php echo getRoleDictionary($this->session->userdata(SESS_USER_ROLE)); ?></h5>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" value="<?php echo $user->name; ?>" class="form-control" id="name" name="name" maxLength="255">
                                <?php echo form_error('name'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" value="<?php echo $user->email; ?>" class="form-control" id="email" name="email" maxLength="50">
                                <?php echo form_error('email'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact No.</label>
                                <input type="text" value="<?php echo $user->contact_number; ?>" class="form-control" id="contact_number" name="contact_number" maxLength="50">
                                <?php echo form_error('contact'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Birthday</label>
                                <input type="date" value="<?php echo $user->birthday; ?>" class="form-control" id="birthday" name="birthday" maxLength="50">
                                <?php echo form_error('birthday'); ?>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="name" class="form-label">Address</label>
                            <input type="text" value="<?php echo $user->address; ?>" class="form-control" id="address" name="address" maxLength="50">
                            <?php echo form_error('address'); ?>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?php echo site_url('dashboard/overview') ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>	
</div>