<div id="user-log-page" class="user-log-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="table_toolbar">
                </div>
                <div class="table-responsive activity-table">
                    <table class="table table-hover" id="activity_table">
                        <thead>
                            <tr>
                                <th class="text-left">Timestamp</th>
                                <th class="text-left">Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activities as $activity): ?>
                                <tr id="activity-<?php echo $activity->id; ?>" class="activity-row-item">
                                    <td class="text-left usr-username">
                                        <?php echo $activity->timestamp; ?>
                                    </td>
                                    <td class="text-left">
                                        <?php echo $activity->activity; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table_footer d-flex justify-content-between align-items-center">
                    <div class="row-per-page">
                        <div class="usr-icon" onclick="$('#number_of_rows_dropdown').toggle();">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </button> Items per page
                            <div id="number_of_rows_dropdown" class="dropdown-content dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('user/log?rowsPerPage=25') ?>">25</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/log?rowsPerPage=50') ?>">50</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/userList?rowsPerPage=100') ?>">100</a>
                            </div>
                        </div>
                    </div>
                    <?php if ($totalPage > 1): ?>
                        <div class="pagination">
                            <nav>
                                <ul class="pagination justify-content-center mb-0 font-weight-bold">
                                    <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo site_url('user/log?currentPage=1'); ?>">&#60;&#60;</a>
                                    </li>
                                    <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                        <a class="page-link" 
                                           href="<?php echo site_url('user/log?currentPage=').($currentPage > 1 ? $currentPage - 1 : 1); ?>"
                                           >&#60;</a>
                                    </li>
                                    <?php for($page=$currentPage-1;$page<$currentPage+2;$page++): ?>
                                        <?php if ($page < 1 || $page > $totalPage){ continue; } ?>
                                        <?php if (strval($currentPage) === strval($page)): ?>                                            
                                            <li class="page-item active">
                                                <a class="page-link" href="#">
                                                    <?php echo $page; ?>
                                                </a>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo site_url("user/log?currentPage=$page") ?>">
                                                    <?php echo $page; ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endfor;?>
                                    <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo site_url('user/log?currentPage=').($currentPage < $totalPage ? $currentPage + 1 : $totalPage); ?>">&#62;</a>
                                    </li>                            
                                    <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                        <a class="page-link" 
                                           href="<?php echo site_url("user/log?currentPage=$totalPage") ?>">&#62;&#62;</a>
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