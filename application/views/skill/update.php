<script>
    $(document).ready(function() {
        // Create a post request to delete job order/s.
        $("#updateSkillForm").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('skill/update') ?>', 
            $(this).serialize(),
            function(data) {
                if(data.trim() === "Success"){
                    showToast("Updated Successfully.",3000);
                    location.reload();
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
    function showUpdateDialog(id,name,category_id){
        $("#update_skill_dialog").fadeIn();
        $("#skill_id").val(id);
        $("#update_cat_id").val(category_id);
        $("#update_skill_name").val(name);
    }
</script>
<div class="m2mj-dialog" id="update_skill_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('skill/update','id="updateSkillForm"'); ?>
            <input type="hidden" name="skill_id" id="skill_id">
            <div class="modal-body">
                <div class="form-row">
                    <label for="title" class="form-label">Name</label>
                    <input type="text" class="form-control" id="update_skill_name" name="update_skill_name" maxLength="255" required>
                    <?php echo form_error('update_skill_name','<div class="alert alert-danger">','</div>'); ?>
                </div>
                <div class="form-row">
                    <label for="update_cat_id" class="form-label">Category</label>
                    <select name="update_cat_id" id="update_cat_id" class="custom-select" required>
                        <option value="">Select Category</option>
                        <?php foreach($skillCategories as $category): ?>
                            <option value="<?php echo $category->id; ?>">
                                <?php echo $category->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo form_error('skill_category','<div class="alert alert-danger">','</div>'); ?>
                </div>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-primary" id="update_confirm">Save</button>
            </div>
        </form>
    </div>
</div>