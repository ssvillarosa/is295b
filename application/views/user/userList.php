<script>
    // Redirect user to details view.
    function viewUser(id){
        window.location.href = './view?id='+id;
    }
</script>
<div id="user-page" class="user-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="table_toolbar">
                    <a href="<?php echo site_url('user/add') ?>" class="btn btn-primary">New</a>
                    <button onclick="showDeleteDialog()" class="btn btn-secondary">Delete</button>
                    <a href="<?php echo site_url('user/search') ?>" class="btn btn-success">Search</a>
                </div>
                <div class="table-responsive user-table">
                    <table class="table table-hover" id="user_table">
                        <thead>
                            <tr>
                                <th class="text-left"></th>
                                <th class="text-left">Username</th>
                                <th class="text-left">Role</th>
                                <th class="text-left">Email</th>
                                <th class="text-left">Full Name</th>
                                <th class="text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr id="user-<?php echo $user->id; ?>" class="user-row-item">
                                    <td class="text-left usr-chk">
                                        <input type="checkbox" class="chk" value="<?php echo $user->id; ?>">
                                    </td>
                                    <td class="text-left usr-username" onClick="viewUser(<?php echo $user->id; ?>)">
                                        <?php echo $user->username; ?>
                                    </td>
                                    <td class="text-left" onClick="viewUser(<?php echo $user->id; ?>)">
                                        <?php echo getRoleDictionary($user->role); ?>
                                    </td>
                                    <td class="text-left" onClick="viewUser(<?php echo $user->id; ?>)">
                                        <?php echo $user->email; ?>
                                    </td>
                                    <td class="text-left" onClick="viewUser(<?php echo $user->id; ?>)">
                                        <?php echo $user->name; ?>
                                    </td>
                                    <td class="text-left">
                                        <button type="button"
                                                id="statusUser<?php echo $user->id; ?>"
                                                onclick="toggleUserStatus(<?php echo $user->id; ?>,'<?php echo $user->username; ?>')"
                                                class="btn btn-secondary btn-status-<?php echo $user->status; ?>">
                                            <span><?php echo getStatusDictionary($user->status); ?></span>                                         
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table_footer d-flex justify-content-between align-items-center">
                    <div class="row-per-page">
                        <div class="usr-icon" onclick="$('#user_rows_dropdown').toggle();">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </button> Items per page
                            <div id="user_rows_dropdown" class="dropdown-content dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('user/userList?rowsPerPage=25') ?>">25</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/userList?rowsPerPage=50') ?>">50</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/userList?rowsPerPage=100') ?>">100</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if ($totalPage > 1){
                            $this->view('user/pagination');
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
<?php $this->view('user/toggleStatus'); ?>
<?php $this->view('user/listPageDelete'); ?>