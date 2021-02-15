<div id="job-order-details-page" class="job-order-details-page">
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
                    <form action="<?php echo site_url('job_order/searchResult') ?>" class="get-form-clear-params">
                        <div class='form-group row  d-flex justify-content-around font-weight-bold'>
                            <label class="col-sm-3 text-center">Field</label>
                            <label class="col-sm-3 text-center">Condition</label>
                            <label class="col-sm-3 text-center">Value</label>
                            <div class="col-sm-1 text-right">
                                <label class="text-center">Show</label>
                            </div>
                        </div>
                        <?php createNumberCondition("ID") ?>
                        <?php createTextFilter("Title") ?>
                        <?php createTextFilter("Company") ?>
                        <?php createSelectionFilter('Status',
                                array(
                                    ''=>'Select Status',
                                    JOB_ORDER_STATUS_OPEN =>JOB_ORDER_STATUS_OPEN_TEXT,
                                    JOB_ORDER_STATUS_ON_HOLD =>JOB_ORDER_STATUS_ON_HOLD_TEXT,
                                    JOB_ORDER_STATUS_CLOSED => JOB_ORDER_STATUS_CLOSED_TEXT,
                                    )); ?>
                        <?php createSelectionFilter('Employent Type',
                                array(
                                    ''=>'Select Type',
                                    JOB_ORDER_TYPE_REGULAR =>JOB_ORDER_TYPE_REGULAR_TEXT,
                                    JOB_ORDER_TYPE_CONTRACTUAL =>JOB_ORDER_TYPE_CONTRACTUAL_TEXT
                                    )); ?>
                        <?php createTextFilter("Job Function") ?>
                        <?php createTextFilter("Requirement") ?>
                        <?php createNumberCondition("Min Salary") ?>
                        <?php createNumberCondition("Max Salary") ?>
                        <?php createTextFilter("Location") ?>
                        <?php createNumberCondition("Slots Available") ?>
                        <?php createNumberCondition("Priority Level") ?>
                        <?php createTextFilter("Skills") ?>
                        <div class="text-center mt-4 mb-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="<?php echo site_url('job_order/jobOrderList') ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>	
</div>