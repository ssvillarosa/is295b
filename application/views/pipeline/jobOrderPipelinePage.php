<?php if(isset($header_on)){
    $this->load->view('common/header');
    $this->load->view('common/nav');
}?>
<script>
    $(document).ready(function() {
        loadPage(1,<?php echo $rowsPerPage; ?>);
    });
    
    function loadPage(pageNum,rowsPerPage=0){
        $("#candidate-pipeline-page .col-md-9").html("<div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div>");
        var url = "<?php echo site_url('pipeline/jobOrderPipelineTable')."?applicant_id=".$applicant_id; ?>&currentPage="+pageNum;
        if(rowsPerPage > 0){
            url += "&rowsPerPage="+rowsPerPage;
        }
        $.get(url , function(data) {
            $("#candidate-pipeline-page .col-md-9").html(data);
        });
    }
</script>
<div id="candidate-pipeline-page" class="candidate-pipeline-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9"></div>
        </div>
    </div>	
</div>

<?php if(isset($header_on)){
    $this->load->view('common/footer');
}?>