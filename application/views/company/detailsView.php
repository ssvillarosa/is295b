<script>
    $(document).ready(function() {
        // Create a post request to delete company/s.
        $("#CompanyDeleteForm").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('company/delete') ?>', 
            $(this).serialize(),
            function(data) {
                hideDialog();
                if(data.trim() === "Success"){
                    showToast("Deleted Successfully.",3000);
                    setTimeout(function(){
                        window.location.replace("<?php echo site_url('company/companyList') ?>");
                    }, 1000);
                    return;
                }
                showToast("Error occurred.",3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
    });
    
    // Displays the dialog to confirm deletion.
    function showDeleteDialog(){
        $("#delete_dialog").fadeIn();
    }
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
                        <div class="d-flex justify-content-between">
                            <div class="text-left">
                                <button type="button" class="btn btn-danger" onclick="showDeleteDialog()">Delete</button>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="<?php echo site_url('company/companyList') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <!--TODO: Add job order list here. --> 
                </section>
            </div>
        </div>
    </div>	
</div>

<div class="m2mj-dialog" id="delete_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('company/delete','id="CompanyDeleteForm"'); ?>        
        <input type="hidden" name="delCompanyIds" id="delCompanyIds" value="<?php echo $company->id; ?>"/>
            <div class="modal-body">
                <strong class="modal-text">Are you sure you want to delete?</strong>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-danger" id="delete_confirm">Delete</button>
            </div>
        </form>
    </div>
</div>