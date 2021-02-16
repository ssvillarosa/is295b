<script>
    function viewEntry(id){
        window.location.href = '<?php echo site_url($module.'/view') ?>/?id='+id;
    }
    function loadAjaxPage(url){
        $.get(url,
        function(page) {
            if(page.trim() == "Error"){
                showToast("Error occurred.",3000);
                return;
            }
            $("#<?php echo $ajaxContainer ?>").html(page);
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    }
</script>
<div id="entry_serch_result_page_ajax" class="entry_serch_result_page_ajax">
    <div class="w-100">
        <div class="table_toolbar"><p class="h5 mb-0 text-light align-middle"><?php if(isset($toolbar_text)){ echo$toolbar_text; } ?></p></div>
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($entries) && count($entries)>0): ?> 
            <div class="table-responsive entry-search-result-table">
                <table class="table table-hover" id="entry_search_result_table">
                    <thead>
                        <tr>
                            <?php foreach ($columnHeaders as $header): ?>
                                <th class="text-left"><?php echo $header ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entries as $entry): ?>
                            <tr class="entry-row-item" onClick="viewEntry(<?php echo $entry["id"]; ?>)">
                                <?php foreach ($shownFields as $field): ?>
                                    <td>
                                        <?php echo $entry[$field]; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="table_footer d-flex justify-content-between align-items-center">
                <div class="row-per-page">
                    <div class="usr-icon" onclick="$('#number_of_rows_dropdown').toggle();">
                        <button class="btn btn-secondary dropdown-toggle btn-sm" type="button">
                            <?php echo $rowsPerPage; ?>
                        </button> Items per page
                        <div id="number_of_rows_dropdown" class="dropdown-content dropdown-menu">
                            <buton class="dropdown-item btn" type="button" onclick="loadAjaxPage('<?php echo $removedRowsPerPage.'&rowsPerPage=25'; ?>')">25</buton>
                            <buton class="dropdown-item btn" type="button" onclick="loadAjaxPage('<?php echo $removedRowsPerPage.'&rowsPerPage=50'; ?>')">50</buton>
                            <buton class="dropdown-item btn" type="button" onclick="loadAjaxPage('<?php echo $removedRowsPerPage.'&rowsPerPage=100'; ?>')">100</buton>
                        </div>
                    </div>
                </div>
                <?php if ($totalPage > 1): ?>
                    <div class="pagination">
                        <nav>
                            <ul class="pagination justify-content-center mb-0 font-weight-bold">
                                <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                    <buton class="page-link" type="button" onclick="loadAjaxPage('<?php echo $removedCurrentPage.'&currentPage=1'; ?>')">&#60;&#60;</buton>
                                </li>
                                <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                    <buton class="page-link" type="button" onclick="loadAjaxPage('<?php echo $removedCurrentPage.'&currentPage='.($currentPage > 1 ? $currentPage - 1 : 1); ?>')">&#60;</buton>
                                </li>
                                <?php for($page=$currentPage-1;$page<$currentPage+2;$page++): ?>
                                    <?php if ($page < 1 || $page > $totalPage){ continue; } ?>
                                    <?php if (strval($currentPage) === strval($page)): ?>                                            
                                        <li class="page-item active">
                                            <buton class="page-link" href="#">
                                                <?php echo $page; ?>
                                            </buton>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <buton class="page-link" type="button" onclick="loadAjaxPage('<?php echo $removedCurrentPage."&currentPage=".$page; ?>')">
                                                <?php echo $page; ?>
                                            </buton>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor;?>
                                <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                    <buton class="page-link" type="button" onclick="loadAjaxPage('<?php echo $removedCurrentPage.'&currentPage='.($currentPage < $totalPage ? $currentPage + 1 : $totalPage); ?>')">&#62;</buton>
                                </li>                            
                                <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                    <buton class="page-link" type="button" onclick="loadAjaxPage('<?php echo $removedCurrentPage.'&currentPage='.$totalPage; ?>')">&#62;&#62;</buton>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
                <div class="row-statistics">
                    Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>