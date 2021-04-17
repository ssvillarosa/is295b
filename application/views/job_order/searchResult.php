<script>
    function viewEntry(id){
        window.location.href = './view?id='+id;
    }
</script>
<div id="entry_serch_result_page" class="entry-search-result-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <?php if(isset($filters) && count($filters)): ?>
                    <div class="alert alert-primary mb-2 p-1">
                        <span class="font-weight-bold">Filters : </span>
                        <?php foreach ($filters as $filter): ?>
                            <span class="badge badge-primary"><?php echo $filter; ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="table_toolbar">
                    <?php if(isset($entries) && count($entries)): ?>
                        <a href="<?php echo site_url($module.'/searchResult').'?'.getQueryParams(); ?>&exportResult=report" class="btn btn-primary">Export</a>
                    <?php endif; ?>
                    <a href="<?php echo site_url($module.'/search') ?>" class="btn btn-success">Search</a>
                </div>
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
                                    <tr id="entry-row-item-<?php echo $entry["id"]; ?>" class="entry-row-item" onClick="viewEntry(<?php echo $entry["id"]; ?>)">
                                        <?php foreach ($shownFields as $field): ?>
                                            <td id="cell-<?php echo $entry["id"]; ?>-<?php echo $field; ?>">
                                                <?php 
                                                    if($field == "skills"){
                                                        $items = explode(", ",$entry[$field]);
                                                        forEach($items as $item){
                                                            $skill = explode("-",$item)[0];
                                                            $yrs = explode("-",$item)[1];
                                                            echo "<script>";
                                                            echo "var skill = createPill(";
                                                            echo "'',";
                                                            echo "'".$skill."',";
                                                            echo "'".$yrs."');";
                                                            echo "$('#cell-".$entry["id"]."-".$field."').append(skill)";
                                                            echo "</script>";
                                                        }
                                                    }else{
                                                        echo strlen($entry[$field]) > 50 ? 
                                                        substr($entry[$field],0,50)."..." : 
                                                        $entry[$field];
                                                    }
                                                ?>
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
                                <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                    <?php echo $rowsPerPage; ?>
                                </button> Items per page
                                <div id="number_of_rows_dropdown" class="dropdown-content dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo $removedRowsPerPage.'&rowsPerPage=25'; ?>">25</a>
                                    <a class="dropdown-item" href="<?php echo $removedRowsPerPage.'&rowsPerPage=50'; ?>">50</a>
                                    <a class="dropdown-item" href="<?php echo $removedRowsPerPage.'&rowsPerPage=100'; ?>">100</a>
                                </div>
                            </div>
                        </div>
                        <?php if ($totalPage > 1): ?>
                            <div class="pagination">
                                <nav>
                                    <ul class="pagination justify-content-center mb-0 font-weight-bold">
                                        <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="<?php echo $removedCurrentPage.'&currentPage=1'; ?>">&#60;&#60;</a>
                                        </li>
                                        <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                            <a class="page-link" 
                                               href="<?php echo $removedCurrentPage.'&currentPage='.($currentPage > 1 ? $currentPage - 1 : 1); ?>">&#60;</a>
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
                                                    <a class="page-link" href="<?php echo $removedCurrentPage."&currentPage=".$page; ?>">
                                                        <?php echo $page; ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endfor;?>
                                        <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="<?php echo $removedCurrentPage.'&currentPage='.($currentPage < $totalPage ? $currentPage + 1 : $totalPage); ?>">&#62;</a>
                                        </li>                            
                                        <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                            <a class="page-link" 
                                               href="<?php echo $removedCurrentPage.'&currentPage='.$totalPage; ?>">&#62;&#62;</a>
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
    </div>	
</div>