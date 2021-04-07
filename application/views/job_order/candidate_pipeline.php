<script>
    $(document).ready(function() {
        loadPage(1,<?php echo $rowsPerPage; ?>);
    });
    
    function loadPage(pageNum,rowsPerPage=0){
        $("#pipeline-page .container").html("<div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div>");
        var url = "<?php echo site_url('pipeline/applicantPipelineTable')."?job_order_id=".$job_order_id; ?>&currentPage="+pageNum;
        if(rowsPerPage > 0){
            url += "&rowsPerPage="+rowsPerPage;
        }
        $.get(url , function(data) {
            $("#pipeline-page .container").html(data);
        });
    }
</script>
<div class="col-md-6">
    <section id="content" style="height: 75%;">
        <h5 class="mb-1 text-center">Candidate Pipeline</h5><br/>
            <div id="pipeline-page" class="pipeline-page h-100">
                <div class="container h-100">
                </div>	
            </div>
    </section>
</div>