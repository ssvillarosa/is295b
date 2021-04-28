<script>
    $(document).ready(function() {
        // Create a post request to delete job order/s.
        $("#addCategoryForm").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('skill/addCategory') ?>', 
            $(this).serialize(),
            function(data) {
                if(data.trim() === "Success"){
                    showToast("Added Successfully.",3000);
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                    hideDialog();
                    return;
                }
                showToast(data,3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
    });
    
    // Displays the dialog to confirm deletion.
    function showAddCategoryDialog(){
        $("#add_category_dialog").fadeIn();
    }
</script>
<div class="m2mj-dialog" id="add_category_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('skill/addCategory','id="addCategoryForm"'); ?>  
            <div class="modal-body">
                <div class="form-row">
                    <label for="title" class="form-label">Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" maxLength="255" required>
                    <?php echo form_error('category_name','<div class="alert alert-danger">','</div>'); ?>
                </div>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-primary" id="add_category_confirm">Add</button>
            </div>
        </form>
    </div>
</div>