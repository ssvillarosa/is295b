<div id="applicant-details-page" class="applicant-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <div class="d-flex">
                        <h5>Search</h5>
                        <div class="help-tip m-1">
                            <p>All fields are listed below. For every field, you can select a condition available for that field. Fill out value field that satisfies the condition. If condition or value is unset the search field will be ignored. Tick "show" item for each field to display that field in the search result.</p>
                        </div>
                    </div>
                    <?php if(isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo site_url('applicant/searchResult') ?>" class="get-form-clear-params">
                        <div class='form-group row  d-flex justify-content-around font-weight-bold'>
                            <label class="col-sm-3 text-center">Field</label>
                            <label class="col-sm-3 text-center">Condition</label>
                            <label class="col-sm-3 text-center">Value</label>
                            <div class="col-sm-1 text-right">
                                <label class="text-center">Show</label>
                            </div>
                        </div>
                        <?php createTextFilter("Last Name") ?>
                        <?php createTextFilter("First Name") ?>
                        <?php createTextFilter("Email") ?>
                        <?php createTextFilter("Primary Phone") ?>
                        <?php createNumberCondition("Active Applicantion") ?>
                        <?php createTextFilter("Secondary Phone") ?>
                        <?php createTextFilter("Work Phone") ?>
                        <?php createTextFilter("Address") ?>
                        <?php createSelectionFilter('Can Relocate',
                                array(
                                    ''=>'Select Value',
                                    APPLICANT_CAN_RELOCATE_TRUE_TEXT => APPLICANT_CAN_RELOCATE_TRUE_TEXT,
                                    APPLICANT_CAN_RELOCATE_FALSE_TEXT => APPLICANT_CAN_RELOCATE_FALSE_TEXT,
                                    )); ?>
                        <?php createTextFilter("Current Employer") ?>
                        <?php createTextFilter("Source") ?>
                        <?php createTextFilter("Best Time to Call") ?>
                        <?php createNumberCondition("Current Pay") ?>
                        <?php createNumberCondition("Desired Pay") ?>
                        <?php createTextFilter("Skills") ?>
                        <div class="text-center mt-4 mb-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="<?php echo site_url('applicant/applicantList') ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>	
</div>