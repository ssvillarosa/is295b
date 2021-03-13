<?php $this->load->view('common/unsignedHeader'); ?>
<div id="registration-details-page" class="registration-details-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <section id="content" >
                    <?php if(isset($success_message)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>	
</div>
<?php $this->load->view('common/footer'); ?>