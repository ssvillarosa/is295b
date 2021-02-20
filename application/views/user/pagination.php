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
                <?php if (strval($currentPage) === strval($page)): ?>                                            
                    <li class="page-item active">
                        <a class="page-link" href="#">
                            <?php echo $page; ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo site_url("user/userList?currentPage=$page") ?>">
                            <?php echo $page; ?>
                        </a>
                    </li>
                <?php endif; ?>
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