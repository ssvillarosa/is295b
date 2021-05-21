<div id="applicant-submissions-page" class="applicant-submissions-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 main-content d-flex flex-column">
                <?php if(isset($filters) && count($filters)): ?>
                    <div class="alert alert-primary mb-2 p-1">
                        <span class="font-weight-bold">Filters : </span>
                        <?php foreach ($filters as $filter): ?>
                            <span class="badge badge-primary"><?php echo $filter; ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex card-container">
                    <?php foreach($applied_jobs as $index=>$applied_job) :?>
                        <div class="card mb-2 mr-2">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <?php echo $applied_job->status; ?>
                                </h5>
                                <h5><?php echo $applied_job->title; ?></h5>
                                <h6 class="card-subtitle mb-2">
                                    <?php if($applied_job->location) :?>
                                        <?php echo $applied_job->location; ?>
                                    <?php endif; ?>
                                </h6>
                                <div class="mt-auto">
                                    <a href="<?php echo site_url('applicant_dashboard/viewJob').'?id='.$applied_job->id; ?>" 
                                       class="card-link btn btn-primary">View Job Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
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