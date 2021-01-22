<script>
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
                    <a href="#" class="btn btn-secondary">Delete</a>
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
                                    <td class="text-left usr-desc" onClick="viewUser(<?php echo $user->id; ?>)">
                                        <?php echo getRoleDictionary($user->role); ?>
                                    </td>
                                    <td class="text-left usr-rank" onClick="viewUser(<?php echo $user->id; ?>)">
                                        <?php echo $user->email; ?>
                                    </td>
                                    <td class="text-left usr-desc" onClick="viewUser(<?php echo $user->id; ?>)">
                                        <?php echo $user->name; ?>
                                    </td>
                                    <td class="text-left usr-rank" onClick="viewUser(<?php echo $user->id; ?>)">
                                        <?php echo form_open('user/update'); ?>
                                            <button type="submit" class="btn btn-secondary btn-status-<?php echo $user->status; ?>">
                                                <span><?php echo getStatusDictionary($user->status); ?></span>                                         
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>	
</div>