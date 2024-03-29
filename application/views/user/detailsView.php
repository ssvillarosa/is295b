<script>
    $(document).ready(function() {
        $.get("<?php echo site_url('job_order/ajaxListPage') ?>"+
                "?display_id=on&display_title=on"+
                "&condition_users=C&value_users=(<?php echo $user->id; ?>)"+
                "&display_status=on",
        function(data) {
            if(data.trim() == "Error"){
                showToast("Error occurred.",3000);
                return;
            }
            $("#userJobOderList").html(data);
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    });
</script>
<div id="user-details-page" class="user-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <h5 class="mb-3">Username: <?php echo $user->username; ?></h5>
                    <?php if(isset($success_message)): ?>
                        <div class="alert alert-success">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($error_message)): ?>
                        <div class="alert alert-danger">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php echo form_open('user/updateDetails'); ?>
                        <input type="hidden" value="<?php echo $user->id; ?>" id="userId" name="userId">
                        <input type="hidden" value="<?php echo $user->username; ?>" id="username" name="username">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="custom-select">
                                    <option value="<?php echo USER_ROLE_ADMIN; ?>" <?php if($user->role===strval(USER_ROLE_ADMIN)) echo "selected"; ?> >Admin</option>
                                    <option value="<?php echo USER_ROLE_RECRUITER; ?>" <?php if($user->role==USER_ROLE_RECRUITER) echo "selected";  ?> >Recruiter</option>
                                </select>
                                <?php echo form_error('role','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="custom-select">
                                    <option value="<?php echo USER_STATUS_ACTIVE; ?>" <?php if($user->status===strval(USER_STATUS_ACTIVE)) echo "selected"; ?> >Active</option>
                                    <option value="<?php echo USER_STATUS_BLOCKED; ?>" <?php if($user->status==USER_STATUS_BLOCKED) echo "selected"; ?>>Blocked</option>
                                </select>
                                <?php echo form_error('status','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" value="<?php echo $user->name; ?>" class="form-control" id="name" name="name" maxLength="255">
                                <?php echo form_error('name','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" value="<?php echo $user->email; ?>" class="form-control" id="email" name="email" maxLength="50">
                                <?php echo form_error('email','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact No.</label>
                                <input type="text" value="<?php echo $user->contact_number; ?>" class="form-control" id="contact_number" name="contact_number" maxLength="50">
                                <?php echo form_error('contact','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Birthday</label>
                                <input type="date" value="<?php echo $user->birthday; ?>" class="form-control" id="birthday" name="birthday" maxLength="50">
                                <?php echo form_error('birthday','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="name" class="form-label">Address</label>
                            <input type="text" value="<?php echo $user->address; ?>" class="form-control" id="address" name="address" maxLength="50">
                            <?php echo form_error('address','<div class="alert alert-danger">','</div>'); ?>
                        </div>
                        <div>
                            <a href="<?php echo site_url('job_order/add') ?>?userIds=<?php echo $user->id; ?>&userNames=<?php echo $user->name; ?>&referrer=<?php echo getFullUrl(); ?>">Add Job Order</a>
                        </div>
                        <!--This is where the ajax takes place.-->
                        <div id="userJobOderList" class="mb-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="loader"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="text-left">
                                <a href="<?php echo site_url('user/log?userId='.$user->id) ?>" class="btn btn-success">View Logs</a>
                                <button type="button" class="btn btn-danger" onclick="showDeleteDialog()">Delete</button>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="<?php echo site_url('user/userList') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>	
</div>

<?php $this->view('user/detailsPageDelete'); ?>