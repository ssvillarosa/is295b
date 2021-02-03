<div id="user-password-page" class="user-password-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <h5 class="mb-3">Username: <?php echo $this->session->userdata(SESS_USERNAME) ?></h5>
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
                    <?php echo form_open('user/changePassword'); ?> 
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="password" class="form-label required">Current Password</label>
                                <input type="password" value="<?php echo $password; ?>" class="form-control" id="password" name="password" maxLength="255" required>
                                <?php echo form_error('password'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="new_password" class="form-label required">New Password</label>
                                <input type="password" value="<?php echo $new_password; ?>" class="form-control" id="new_password" name="new_password" maxLength="255" required>
                                <?php echo form_error('new_password'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="confirm_password" class="form-label required" required>Confirm Password</label>
                                <input type="password" value="<?php echo $confirm_password; ?>" class="form-control" id="confirm_password" name="confirm_password" maxLength="255" required>
                                <?php echo form_error('confirm_password'); ?>
                            </div>
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