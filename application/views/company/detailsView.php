<script>
    $(document).ready(function() {
        $.get("<?php echo site_url('job_order/ajaxListPage') ?>"+
                "?display_id=on&display_title=on"+
                "&condition_company=E&value_company=<?php echo $company->name; ?>"+
                "&display_status=on",
        function(data) {
            if(data.trim() == "Error"){
                showToast("Error occurred.",3000);
                return;
            }
            $("#companyJobOderList").html(data);
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    });
</script>
<div id="company-details-page" class="company-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <h5 class="mb-3">Company details: </h5>
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
                    <?php echo form_open('company/update'); ?>
                        <input type="hidden" value="<?php echo $company->id; ?>" id="companyId" name="companyId">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" value="<?php echo $company->name; ?>" class="form-control" id="name" name="name" maxLength="255" required>
                                <?php echo form_error('name','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact_person" class="form-label">Contact Person</label>
                                <input type="text" value="<?php echo $company->contact_person; ?>" class="form-control" id="contact_person" name="contact_person" maxLength="255">
                                <?php echo form_error('contact_person','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="primary_phone" class="form-label">Primary Phone</label>
                                <input type="text" value="<?php echo $company->primary_phone; ?>" class="form-control" id="primary_phone" name="primary_phone" maxLength="255">
                                <?php echo form_error('primary_phone','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="secondary_phone" class="form-label">Secondary Phone</label>
                                <input type="text" value="<?php echo $company->secondary_phone; ?>" class="form-control" id="secondary_phone" name="secondary_phone" maxLength="50">
                                <?php echo form_error('secondary_phone','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="industry" class="form-label">Industry</label>
                                <input type="text" value="<?php echo $company->industry; ?>" class="form-control" id="industry" name="industry" maxLength="50">
                                <?php echo form_error('industry','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="text" value="<?php echo $company->website; ?>" class="form-control" id="website" name="website" maxLength="50">
                                <?php echo form_error('website','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" value="<?php echo $company->address; ?>" class="form-control" id="address" name="address" maxLength="50">
                                <?php echo form_error('address','<div class="alert alert-danger">','</div>'); ?>
                            </div>
                        </div>
                        <!--This is where the ajax takes place.-->
                        <div id="companyJobOderList" class="mb-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="loader"></div>
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
                                <a href="<?php echo site_url('company/companyList') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>	
</div>

<?php $this->view('company/detailsPageDelete'); ?>