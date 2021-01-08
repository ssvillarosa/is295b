<div id="user-page" class="user-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="table_toolbar">
                    <a href="#" class="btn btn-primary">New</a>
                    <a href="#" class="btn btn-secondary">Delete</a>
                </div>
                <div class="table-responsive user-table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-left"></th>
                                <th class="text-left">Username</th>
                                <th class="text-left">Password</th>
                                <th class="text-left">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr id="user-<?php echo $user->id; ?>" class="user-row-item" onClick="">
                                    <td class="text-left usr-chk">
                                        <input type="checkbox" class="chk" name="vehicle1" value="<?php echo $user->id; ?>">
                                    </td>
                                    <td class="text-left usr-name"><?php echo $user->username; ?></td>
                                    <td class="text-left usr-desc"><?php echo $user->password; ?></td>
                                    <td class="text-left usr-rank"><?php echo $user->role; ?></td
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>	
</div>