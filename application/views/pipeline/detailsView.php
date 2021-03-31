<div id="pipeline-details-page" class="pipeline-details-page">
    <div class="container">
        <div class="row justify-content-center ml-2">
            <div class="col-md-9 update-component">
                <section id="content" >
                    <h5 class="mb-3">Pipeline Details</h5>
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
                    <div class="form-row">
                        <div class="col-md-6 mb-1">
                            <label for="title" class="form-label">Rating: <?php echo $pipeline->rating; ?></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-1">
                            <label for="title" class="form-label">Job Order ID: <?php echo $pipeline->job_order_id; ?></label>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="title" class="form-label">Candidate ID: <?php echo $pipeline->applicant_id; ?></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-1">
                            <label for="title" class="form-label">Job Order Title: <?php echo $pipeline->title; ?></label>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="title" class="form-label">Candidate Full Name: <?php echo $pipeline->first_name.' '.$pipeline->last_name; ?></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-1">
                            <label for="title" class="form-label">Assigned To: <?php echo $pipeline->name; ?></label>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label for="title" class="form-label">Status: <?php echo $pipeline->status; ?></label>
                        </div>
                    </div>
                    <?php if($this->session->userdata(SESS_USER_ROLE)== USER_ROLE_ADMIN ||
                            $this->session->userdata(SESS_USER_ID) == $pipeline->assigned_to): ?>
                        <div class="d-flex justify-content-between">
                            <div class="text-right">
                                <a href="<?php echo site_url('pipeline/addActivity').'?id='.$pipeline->id; ?>" class="btn btn-primary">Log Activity</a>
                                <button type="button" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</div>