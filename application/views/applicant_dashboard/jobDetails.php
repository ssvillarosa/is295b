<div id="jobs_details_page" class="jobs_details_page">
    <div class="container">
        <div class="row justify-content-center ml-2">
            <div class="col-md-9">
                <section id="content" >
                    <?php if(isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                        <?php return; ?>
                    <?php endif; ?>
                </section>
                <div class="form-row">
                    <h5 class="mb-2"><?php echo $job_order->title; ?></h5>
                </div>
                <div class="form-row">
                    <h6>
                        <?php if($job_order->location) :?>
                            <?php echo $job_order->location; ?>
                        <?php endif; ?>
                    </h6>
                </div>
                <div class="form-row mb-2">
                    Php <?php echo $job_order->min_salary; ?> - Php <?php echo $job_order->max_salary; ?>
                </div>
                <div class="form-row mb-4">
                    <?php if($job_order->employment_type==JOB_ORDER_TYPE_REGULAR){
                        echo JOB_ORDER_TYPE_REGULAR_TEXT;
                    }else if($job_order->employment_type==JOB_ORDER_TYPE_CONTRACTUAL){
                        echo JOB_ORDER_TYPE_CONTRACTUAL_TEXT;
                    }?>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-1">
                        <label for="job-function" class="form-label font-weight-bold">Job Function: </label>
                        <div class="job-function"><?php echo $job_order->job_function; ?></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-4">
                        <label for="requirement" class="form-label font-weight-bold">Requirements: </label>
                        <div class="requirement"><?php echo $job_order->requirement; ?></div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary mr-1" 
                            onclick="openApplicationForm(<?php echo $job_order->id; ?>)">Apply</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->view('applicant_dashboard/applyJob');