<script>
    // Redirect to details view.
    function viewJobOrder(id){
        window.location.href = '<?php echo site_url('job_order/view') ?>?id='+id;
    }
</script>
<div id="job_order-page" class="job_order-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <div class="table_toolbar">
                    <a href="<?php echo site_url('job_order/add') ?>" class="btn btn-primary">New</a>
                    <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                        <button onclick="showDeleteDialog()" class="btn btn-secondary">Delete</button>
                    <?php endif; ?>
                    <a href="<?php echo site_url('job_order/search') ?>" class="btn btn-success">Search</a>
                </div>
                <div class="table-responsive job_order-table">
                    <table class="table table-hover" id="job_order_table">
                        <thead>
                            <tr>
                                <th class="text-left"></th>
                                <th class="text-left">ID</th>
                                <th class="text-left">Title</th>
                                <th class="text-left">Company</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Priority Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($job_orders as $job_order): ?>
                                <tr id="job_order-<?php echo $job_order->id; ?>" class="job_order-row-item">
                                    <td class="text-left comp-chk">
                                        <input type="checkbox" class="chk" value="<?php echo $job_order->id; ?>">
                                    </td>
                                    <td class="text-left" onClick="viewJobOrder(<?php echo $job_order->id; ?>)">
                                        <?php echo $job_order->id; ?>
                                    </td>
                                    <td class="text-left" onClick="viewJobOrder(<?php echo $job_order->id; ?>)">
                                        <?php echo $job_order->title; ?>
                                    </td>
                                    <td class="text-left" onClick="viewJobOrder(<?php echo $job_order->id; ?>)">
                                        <?php echo $job_order->company; ?>
                                    </td>
                                    <td class="text-center" onClick="viewJobOrder(<?php echo $job_order->id; ?>)">
                                        <?php echo $job_order->status; ?>
                                    </td>
                                    <td class="text-center" onClick="viewJobOrder(<?php echo $job_order->id; ?>)">
                                        <?php echo $job_order->priority_level; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table_footer d-flex justify-content-between align-items-center">
                    <div class="row-per-page">
                        <div class="usr-icon" onclick="$('#job_order_rows_dropdown').toggle();">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </button> Items per page
                            <div id="job_order_rows_dropdown" class="dropdown-content dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('job_order/jobOrderList?rowsPerPage=25') ?>">25</a>
                                <a class="dropdown-item" href="<?php echo site_url('job_order/jobOrderList?rowsPerPage=50') ?>">50</a>
                                <a class="dropdown-item" href="<?php echo site_url('job_order/jobOrderList?rowsPerPage=100') ?>">100</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if ($totalPage > 1){
                            $this->view('job_order/pagination');
                        } 
                    ?>
                    <div class="row-statistics">
                        Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view('job_order/listPageDelete'); ?>
