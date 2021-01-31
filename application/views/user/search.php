<div id="user-details-page" class="user-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <?php if(isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo site_url('user/searchResult') ?>" class="get-form-clear-params">
                        <div class='form-group row  d-flex justify-content-around font-weight-bold'>
                            <label class="col-sm-3 text-center">Field</label>
                            <label class="col-sm-3 text-center">Condition</label>
                            <label class="col-sm-3 text-center">Value</label>
                            <div class="col-sm-1 text-right">
                                <label class="text-center">Show</label>
                            </div>
                        </div>
                        <?php createTextFilter("Username") ?>
                        <?php createSelectionFilter('Role',
                                array(
                                    ''=>'Select Role',
                                    USER_ROLE_ADMIN =>'Admin',
                                    USER_ROLE_RECRUITER =>'Recruiter'
                                    )); ?>
                        <?php createSelectionFilter('Status',
                                array(
                                    ''=>'Select Status',
                                    USER_STATUS_ACTIVE =>'Active',
                                    USER_STATUS_BLOCKED =>'Blocked'
                                    )); ?>
                        <?php createTextFilter("Name") ?>
                        <?php createTextFilter("Email") ?>
                        <?php createTextFilter("Contact Number") ?>
                        <?php createDateCondition("Birthday") ?>
                        <?php createTextFilter("Address") ?>
                        <div class="text-center mt-4 mb-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="<?php echo site_url('user/userList') ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>	
</div>