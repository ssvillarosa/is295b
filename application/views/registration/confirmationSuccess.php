<?php $this->load->view('common/unsignedHeader'); ?>
<div id="applicant-details-page" class="applicant-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <div class="alert alert-success" role="alert">
                        Your email has been confirmed. Please <a href="<?php echo site_url('applicantAuth/login'); ?>">login</a>.
                    </div>
                </section>
            </div>
        </div>
    </div>	
</div>
<?php $this->load->view('common/footer'); ?>