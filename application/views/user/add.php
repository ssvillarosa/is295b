<script>
    $( document ).ready(function() {
        $("#copy_message").hide()
    });
    function generatePassword(){
        var pass = Math.random().toString(36).slice(-8);
        $("#password").val(pass);
        $("#confirm_password").val(pass);
        copyToClipboard(pass);
        $("#copy_message").show().delay(5000).fadeOut(400);
    }
    function copyToClipboard(text) {
        var temp = document.createElement("textarea");
        document.body.appendChild(temp);
        temp.value = text;
        temp.select();
        document.execCommand("copy");
        document.body.removeChild(temp);
    }
</script>
<div id="user-details-page" class="user-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <h5 class="mb-3">New user:</h5>
                    <?php if(isset($success_message)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php echo form_open('user/add'); ?>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label required">Username</label>
                                <input type="text" value="<?php echo $user->username; ?>" class="form-control" id="username" name="username" maxLength="255" required>
                                <?php echo form_error('username'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-1">
                                <label for="password" class="form-label required">Password</label>
                                <input type="password" value="<?php echo $user->password; ?>" class="form-control" id="password" name="password" maxLength="255" required>
                                <?php echo form_error('password'); ?>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label for="confirm_password" class="form-label required" required>Confirm Password</label>
                                <input type="password" value="<?php echo $user->confirm_password; ?>" class="form-control" id="confirm_password" name="confirm_password" maxLength="255" required>
                                <?php echo form_error('confirm_password'); ?>
                            </div>
                        </div>
                        <div class="form-row align-items-center">
                            <div class="col-md-2 mb-3">
                                <button class="btn btn-outline-secondary" type="button" onclick="generatePassword()">Generate</button>
                            </div>
                            <div class="col-md-5 mb-3">
                                <span id="copy_message" class="bg-warning text-dark font-weight-bold">Copied to your clipboard!</span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="required">Role</label>
                                <select name="role" id="role" class="custom-select" required>
                                    <option value="">SELECT ROLE</option>
                                    <option value="<?php echo USER_ROLE_ADMIN; ?>" <?php if($user->role===strval(USER_ROLE_ADMIN)) echo "selected"; ?> >Admin</option>
                                    <option value="<?php echo USER_ROLE_RECRUITER; ?>" <?php if($user->role==USER_ROLE_RECRUITER) echo "selected";  ?> >Recruiter</option>
                                </select>
                                <?php echo form_error('role'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="required">Status</label>
                                <select name="status" id="status" class="custom-select">
                                    <option value="<?php echo USER_STATUS_ACTIVE; ?>" <?php if($user->status==USER_STATUS_ACTIVE) echo "selected"; ?> >Active</option>
                                    <option value="<?php echo USER_STATUS_BLOCKED; ?>" <?php if($user->status==USER_STATUS_BLOCKED) echo "selected"; ?>>Blocked</option>
                                </select>
                                <?php echo form_error('status'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label required">Full Name</label>
                                <input type="text" value="<?php echo $user->name; ?>" class="form-control" id="name" name="name" maxLength="255" required>
                                <?php echo form_error('name'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label required">Email</label>
                                <input type="email" value="<?php echo $user->email; ?>" class="form-control" id="email" name="email" maxLength="50" required>
                                <?php echo form_error('email'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact No.</label>
                                <input type="text" value="<?php echo $user->contact_number; ?>" class="form-control" id="contact" name="contact" maxLength="50">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" value="<?php echo $user->birthday; ?>" class="form-control" id="birthday" name="birthday">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" value="<?php echo $user->address; ?>" class="form-control" id="address" name="address" maxLength="255">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?php echo site_url('user/userList') ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>	
</div>