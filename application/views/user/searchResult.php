<div id="user_serch_result_page" class="user-search-result-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="table_toolbar">
                    <a href="<?php echo site_url('user/add') ?>" class="btn btn-primary">New</a>
                    <button onclick="showDeleteDialog()" class="btn btn-secondary">Delete</button>
                    <a href="<?php echo site_url('user/search') ?>" class="btn btn-success">Search</a>
                </div>
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($users) && count($users)>0): ?> 
                    <div class="table-responsive user-search-result-table">
                        <table class="table table-hover" id="user_search_result_table">
                            <thead>
                                <tr>
                                    <?php foreach ($columnHeaders as $header): ?>
                                        <th class="text-left"><?php echo $header ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr class="user-row-item">
                                        <?php foreach ($shownFields as $field): ?>
                                            <td>
                                                <?php 
                                                switch($field){
                                                    case "status":
                                                        echo getStatusDictionary($user[$field]);
                                                        break;
                                                    case "role":
                                                        echo getRoleDictionary($user[$field]);
                                                        break;
                                                    default:
                                                        echo $user[$field];
                                                        break;
                                                }
                                                ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>             
            </div>
        </div>
    </div>	
</div>