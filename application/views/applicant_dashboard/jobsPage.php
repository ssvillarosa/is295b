<div id="applicant-jobs-page" class="applicant-jobs-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3 text-white side-bar">
                <form action="<?php echo site_url('applicant_dashboard/searchJobResult') ?>">
                    <div class="form-row my-2">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" 
                               value="<?php if(isset($title)) echo html_escape($title); ?>" 
                               id="title" name="title" placeholder="Title">
                    </div>
                    <div class="form-row my-2">
                        <label for="title">Company</label>
                        <input type="text" class="form-control" 
                               value="<?php if(isset($company)) echo html_escape($company); ?>"
                               id="company" name="company" placeholder="Company">
                    </div>
                    <div class="form-row my-2">
                        <label>Salary</label>
                    </div>
                    <div class="form-row my-2">
                        <div class="col">
                            <input type="text" class="form-control" 
                                   value="<?php if(isset($min_salary)) echo html_escape($min_salary); ?>"
                                   id="min-salary" name="min_salary" placeholder="Min. Salary">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" 
                                   value="<?php if(isset($max_salary)) echo html_escape($max_salary); ?>"
                                   id="max-salary" name="max_salary" placeholder="Max. Salary">
                        </div>
                    </div>
                    <div class="form-row my-2">
                        <label for="employment_type">Employment Type</label>
                        <select name="employment_type" id="employment_type" class="custom-select">
                            <option value="">--</option>
                            <option value="<?php echo JOB_ORDER_TYPE_REGULAR_TEXT; ?>" 
                                <?php if(isset($employment_type)) echo $employment_type==JOB_ORDER_TYPE_REGULAR_TEXT? "selected":""; ?>>
                                <?php echo JOB_ORDER_TYPE_REGULAR_TEXT; ?>
                            </option>
                            <option value="<?php echo JOB_ORDER_TYPE_CONTRACTUAL_TEXT; ?>"
                                <?php if(isset($employment_type)) echo $employment_type==JOB_ORDER_TYPE_CONTRACTUAL_TEXT? "selected":""; ?>>
                                <?php echo JOB_ORDER_TYPE_CONTRACTUAL_TEXT; ?>    
                            </option>
                        </select>
                    </div>
                    <div class="form-row my-2">
                        <label for="title">Location</label>
                        <input type="text" class="form-control" 
                               value="<?php if(isset($location)) echo html_escape($location); ?>"
                               id="location" name="location" placeholder="Location">
                    </div>
                    <div class="form-row mt-3 mb-2">
                        <button type="submit" class="btn btn-primary ml-auto">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-md-9 pl-2 main-content d-flex flex-column">
                <?php if(isset($filters) && count($filters)): ?>
                    <div class="alert alert-primary mb-2 p-1">
                        <span class="font-weight-bold">Filters : </span>
                        <?php foreach ($filters as $filter): ?>
                            <span class="badge badge-primary"><?php echo $filter; ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php foreach($job_orders as $index=>$job_order) :?>
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $job_order->title; ?></h5>
                        <h6 class="card-subtitle mb-2">
                            <?php echo $job_order->company; ?>
                            <?php if($job_order->location) :?>
                                <span class="text-muted"> - <?php echo $job_order->location; ?></span>
                            <?php endif; ?>
                        </h6>
                        <p>
                            Php <?php echo $job_order->min_salary.'- Php '.$job_order->max_salary; ?>
                        </p>
                        <p class="card-text">
                            <?php echo strlen($job_order->job_function) > 300 ? 
                                substr($job_order->job_function,0,300)."..." : 
                                $job_order->job_function; ?>
                        </p>
                        <div class="d-flex justify-content-end">
                            <a href="<?php echo site_url('applicant_dashboard/viewJob').'?id='.$job_order->id; ?>" 
                               class="card-link btn btn-primary">View Details</a>
                            <button type="button" class="btn btn-secondary ml-1" 
                                    onclick="openApplicationForm(<?php echo $job_order->id; ?>)">Apply</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="table_footer d-flex justify-content-between align-items-center mt-auto">
                    <div class="row-per-page">
                        <div class="usr-icon" onclick="$('#applicant_rows_dropdown').toggle();">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </button> Items per page
                            <div id="applicant_rows_dropdown" class="dropdown-content dropdown-menu">
                                <?php if(isset($fullUrl)): ?>
                                    <a class="dropdown-item" href="<?php echo $fullUrl.'&rowsPerPage=5'; ?>">5</a>
                                    <a class="dropdown-item" href="<?php echo $fullUrl.'&rowsPerPage=10'; ?>">10</a>
                                    <a class="dropdown-item" href="<?php echo $fullUrl.'&rowsPerPage=25'; ?>">25</a>
                                <?php else: ?>
                                    <a class="dropdown-item" href="<?php echo site_url('applicant_dashboard/jobs?rowsPerPage=5') ?>">5</a>
                                    <a class="dropdown-item" href="<?php echo site_url('applicant_dashboard/jobs?rowsPerPage=10') ?>">10</a>
                                    <a class="dropdown-item" href="<?php echo site_url('applicant_dashboard/jobs?rowsPerPage=25') ?>">25</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if ($totalPage > 1){
                            if(isset($fullUrl)){
                                $this->view('applicant_dashboard/searchPagination');
                            }else{
                                $this->view('applicant_dashboard/pagination');
                            }
                        } 
                    ?>
                    <?php if($totalCount) : ?>
                        <div class="row-statistics">
                            Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->view('applicant_dashboard/applyJob');