<script>
    $(document).ready(function() {
        loadAssignedToMePage(1);
        loadUnassignedPage(1);
        loadJoAssignedToMePage(1);
        loadEventsPage(1);
        loadPublicEventsPage(1);
    });
    
    function loadAssignedToMePage(pageNum,rowsPerPage=0,orderBy,order){
        $("#admin-dashboard-page #loadAssignedToMeContainer").html("<div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div>");
        var url = "<?php echo site_url('admin_dashboard/getAssignedToMe'); ?>?currentPage="+pageNum;
        if(rowsPerPage > 0){
            url += "&rowsPerPage="+rowsPerPage;
        }
        if(orderBy){
            url += "&orderBy="+orderBy+"&order="+order;
        }
        $.get(url , function(data) {
            if(data=="Error"){
                showToast("Error occurred.",3000);
            }
            $("#admin-dashboard-page #loadAssignedToMeContainer").html(data);
            applyCollapsible("#admin-dashboard-page #loadAssignedToMeContainer");
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    }
    
    function loadUnassignedPage(pageNum,rowsPerPage=0,orderBy,order){
        $("#admin-dashboard-page #loadUnassignedContainer").html("<div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div>");
        var url = "<?php echo site_url('admin_dashboard/getUnassigned'); ?>?currentPage="+pageNum;
        if(rowsPerPage > 0){
            url += "&rowsPerPage="+rowsPerPage;
        }
        if(orderBy){
            url += "&orderBy="+orderBy+"&order="+order;
        }
        $.get(url , function(data) {
            if(data=="Error"){
                showToast("Error occurred.",3000);
            }
            $("#admin-dashboard-page #loadUnassignedContainer").html(data);
            applyCollapsible("#admin-dashboard-page #loadUnassignedContainer");
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    }
    
    function loadJoAssignedToMePage(pageNum,rowsPerPage=0,orderBy,order){
        $("#admin-dashboard-page #loadJoAssignedToMeContainer").html("<div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div>");
        var url = "<?php echo site_url('admin_dashboard/getJoAssignedToMe'); ?>?currentPage="+pageNum;
        if(rowsPerPage > 0){
            url += "&rowsPerPage="+rowsPerPage;
        }
        if(orderBy){
            url += "&orderBy="+orderBy+"&order="+order;
        }
        $.get(url , function(data) {
            if(data=="Error"){
                showToast("Error occurred.",3000);
            }
            $("#admin-dashboard-page #loadJoAssignedToMeContainer").html(data);
            applyCollapsible("#admin-dashboard-page #loadJoAssignedToMeContainer");
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    }
    
    function loadEventsPage(pageNum,rowsPerPage=0,orderBy,order){
        $("#admin-dashboard-page #loadEventsContainer").html("<div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div>");
        var url = "<?php echo site_url('admin_dashboard/getEvents'); ?>?currentPage="+pageNum;
        if(rowsPerPage > 0){
            url += "&rowsPerPage="+rowsPerPage;
        }
        if(orderBy){
            url += "&orderBy="+orderBy+"&order="+order;
        }
        $.get(url , function(data) {
            if(data=="Error"){
                showToast("Error occurred.",3000);
            }
            $("#admin-dashboard-page #loadEventsContainer").html(data);
            applyCollapsible("#admin-dashboard-page #loadEventsContainer");
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    }
    
    function loadPublicEventsPage(pageNum,rowsPerPage=0,orderBy,order){
        $("#admin-dashboard-page #loadPublicEventsContainer").html("<div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div>");
        var url = "<?php echo site_url('admin_dashboard/getPublicEvents'); ?>?currentPage="+pageNum;
        if(rowsPerPage > 0){
            url += "&rowsPerPage="+rowsPerPage;
        }
        if(orderBy){
            url += "&orderBy="+orderBy+"&order="+order;
        }
        $.get(url , function(data) {
            if(data=="Error"){
                showToast("Error occurred.",3000);
            }
            $("#admin-dashboard-page #loadPublicEventsContainer").html(data);
            applyCollapsible("#admin-dashboard-page #loadPublicEventsContainer");
        }).fail(function() {
            showToast("Error occurred.",3000);
        });
    }
    
    function applyCollapsible(container){
        $(container+" .table_toolbar").click(function(){
            $(this).next(".table-responsive").slideToggle(function(){
                if($(this).is(':visible')){
                    $(container+" .table_toolbar div").removeClass("arrow-down")
                    $(container+" .table_toolbar div").addClass("arrow-up")
                    return;
                }
                $(container+" .table_toolbar div").removeClass("arrow-up")
                $(container+" .table_toolbar div").addClass("arrow-down")
            });
            $(this).next(".table-responsive").next(".table_footer").slideToggle();
        });
    }
</script>
<div id="admin-dashboard-page" class="admin-dashboard-page">
    <div class="container">
        <div class="row justify-content-center mb-3" id="loadAssignedToMeContainer">
        </div>
        <div class="row justify-content-center mb-3" id="loadUnassignedContainer">
        </div>
        <div class="row justify-content-center mb-3" id="loadJoAssignedToMeContainer">
        </div>
        <div class="row justify-content-center mb-3" id="loadEventsContainer">
        </div>
        <div class="row justify-content-center mb-3" id="loadPublicEventsContainer">
        </div>
    </div>	
</div>
