<?php if(isset($header_on)){
    $this->load->view('common/header');
    $this->load->view('common/nav');
}?>
<script>
    $(document).ready(function() {
        loadPage(1,<?php echo $rowsPerPage; ?>);
    });
    
    function loadPage(pageNum,rowsPerPage=0){
        $("#pipeline-page .col-md-9").html("<div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div>");
        var url = "<?php echo site_url('pipeline/applicantPipelineTable')."?job_order_id=".$job_order_id ?>&currentPage="+pageNum;
        if(rowsPerPage > 0){
            url += "&rowsPerPage="+rowsPerPage;
        }
        $.get(url , function(data) {
            $("#pipeline-page .col-md-9").html(data);
        });
    }
</script>
<div id="pipeline-page" class="pipeline-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9"></div>
        </div>
    </div>	
</div>

<?php if(isset($header_on)){
    $this->load->view('common/footer');
}?>