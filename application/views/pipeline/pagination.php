<div class="pagination">
    <nav>
        <ul class="pagination justify-content-center mb-0 font-weight-bold">
            <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                <button class="page-link" onclick="loadPage(1);">&#60;&#60;</button>
            </li>
            <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                <button class="page-link" 
                    onclick="loadPage(<?php echo ($currentPage > 1 ? $currentPage - 1 : 1) ?>);"
                   >&#60;</button>
            </li>
            <?php for($page=$currentPage-1;$page<$currentPage+2;$page++): ?>
                <?php if ($page < 1 || $page > $totalPage){ continue; } ?>
                <?php if (strval($currentPage) === strval($page)): ?>                                            
                    <li class="page-item active">
                        <button class="page-link" href="#">
                            <?php echo $page; ?>
                        </button>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <button class="page-link" onclick="loadPage(<?php echo $page; ?>);">
                            <?php echo $page; ?>
                        </button>
                    </li>
                <?php endif; ?>
            <?php endfor;?>
            <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                <button class="page-link" 
                    onclick="loadPage(<?php echo ($currentPage < $totalPage ? $currentPage + 1 : $totalPage); ?>);">&#62;</button>
            </li>                            
            <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                <button class="page-link"
                   onclick="loadPage(<?php echo $totalPage ?>);">&#62;&#62;</button>
            </li>
        </ul>
    </nav>
</div>