<script>
    $(document).ready(function() {
        // Create a post request to toggle user status.
        $("#statusForm").submit(function(e){
            e.preventDefault();
            var api = '<?php echo site_url('user') ?>/'+$("#action").val();
            $.post(api, 
            $(this).serialize(),
            function(data) {
                hideDialog();
                if(data.trim() === "Error"){
                    showToast("Error occurred.",3000);
                    return;
                }
                var rowButton = "#statusUser"+$("#userId").val(); 
                var done;
                var newStatus;
                if($("#action").val() === "activate"){
                    done = "activated";
                    newStatus = "Active";
                    $(rowButton).removeClass('btn-status-1');
                    $(rowButton).addClass('btn-status-0');
                }else{
                    done = "blocked";
                    newStatus = "Blocked";
                    $(rowButton).removeClass('btn-status-0');
                    $(rowButton).addClass('btn-status-1');
                }
                var message = "User "+$("#username").val()
                        +" successfully "+done+".";
                $(rowButton+" span").text(newStatus);
                showToast(message,3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
    });
    
    // Redirect user to details view.
    function viewUser(id){
        window.location.href = './view?id='+id;
    }
    
    // Displays the dialog to toggle user status.
    function toggleUserStatus(userId,username){
        var action;
        var status = $("#statusUser"+userId+" span").text() != "Active";
        $("#userId").val(userId);
        if(status){
            action = "activate";
            $("#modal-action").addClass("btn-warning");
            $("#modal-action").removeClass("btn-danger");
        }else{
            action = "block";
            $("#modal-action").addClass("btn-danger");
            $("#modal-action").removeClass("btn-warning");
        }        
        var message = "Do you want to "+action+" "+username+"?";
        $("#modal-action").html(action);
        $("#action").val(action);
        $("#username").val(username);
        $(".modal-text").html(message);
        $("#status_dialog").fadeIn();
    }
</script>
<div id="user-page" class="user-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="table_toolbar">
                    <a href="<?php echo site_url('user/add') ?>" class="btn btn-primary">New</a>
                    <button onclick="showDeleteDialog()" class="btn btn-secondary">Delete</button>
                </div>
                <div class="table-responsive user-table">
                    <table class="table table-hover">
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
                                        <input type="checkbox" class="chk" name="vehicle1" value="<?php echo $user->id; ?>">
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
                            <a class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </a> Items per page
                            <div id="user_rows_dropdown" class="dropdown-content dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('user/userList?rowsPerPage=25') ?>">25</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/userList?rowsPerPage=50') ?>">50</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/userList?rowsPerPage=100') ?>">100</a>
                            </div>
                        </div>
                    </div>
                    <?php if ($totalPage > 1): ?>
                        <div class="pagination">
                            <nav>
                                <ul class="pagination justify-content-center mb-0 font-weight-bold">
                                    <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo site_url('user/userList?currentPage=1'); ?>">&#60;&#60;</a>
                                    </li>
                                    <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                        <a class="page-link" 
                                           href="<?php echo site_url('user/userList?currentPage=').($currentPage > 1 ? $currentPage - 1 : 1); ?>"
                                           >&#60;</a>
                                    </li>
                                    <?php for($page=$currentPage-1;$page<$currentPage+2;$page++): ?>
                                        <?php if ($page < 1 || $page > $totalPage){ continue; } ?>
                                        <li class="page-item <?php echo strval($currentPage) === strval($page) ? 'active' : ''; ?>">
                                            <a class="page-link" href="<?php echo site_url("user/userList?currentPage=$page") ?>">
                                                <?php echo $page; ?>
                                            </a>
                                        </li>
                                    <?php endfor;?>
                                    <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo site_url('user/userList?currentPage=').($currentPage < $totalPage ? $currentPage + 1 : $totalPage); ?>">&#62;</a>
                                    </li>                            
                                    <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                        <a class="page-link" 
                                           href="<?php echo site_url("user/userList?currentPage=$totalPage") ?>">&#62;&#62;</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                    <div class="row-statistics">
                        Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>

<div class="m2mj-dialog" id="status_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('user/block','id="statusForm"'); ?>
            <input type="hidden" name="userId" id="userId"/>
            <input type="hidden" name="username" id="username"/>
            <input type="hidden" name="action" id="action"/>
            <div class="modal-body">
                <strong class="modal-text"></strong>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-primary" id="modal-action">Save</button>
            </div>
        </form>
    </div>
</div>