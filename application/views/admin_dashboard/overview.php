<script>
    $(document).ready(function() {
        loadAssignedToMePage(1);
    });
    
    function loadAssignedToMePage(pageNum,rowsPerPage=0){
        $("#user_pipeline-page #loadAssignedToMeContainer").html("<div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div>");
        var url = "<?php echo site_url('admin_dashboard/getAssignedToMe'); ?>?currentPage="+pageNum;
        if(rowsPerPage > 0){
            url += "&rowsPerPage="+rowsPerPage;
        }
        $.get(url , function(data) {
            $("#user_pipeline-page #loadAssignedToMeContainer").html(data);
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    }
</script>
<div id="user_pipeline-page" class="user_pipeline-page">
    <div class="container">
        <div class="row justify-content-center" id="loadAssignedToMeContainer">
        </div>
    </div>	
</div>
