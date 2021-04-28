<script>
    $(document).ready(function() {
        // Create a post request to delete job order/s.
        $("#addSkillForm").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('skill/add') ?>', 
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
    function showAddDialog(){
        $("#add_skill_dialog").fadeIn();
        $("#skillId").val('');
    }
</script>
<div class="m2mj-dialog" id="add_skill_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('skill/add','id="addSkillForm"'); ?>  
            <div class="modal-body">
                <div class="form-row">
                    <label for="title" class="form-label">Name</label>
                    <input type="text" class="form-control" id="skill_name" name="skill_name" maxLength="255" required>
                    <?php echo form_error('skill_name','<div class="alert alert-danger">','</div>'); ?>
                </div>
                <div class="form-row">
                    <label for="skill_category" class="form-label">Category</label>
                    <select name="skill_category_id" id="skill_category_id" class="custom-select" required>
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
              <button type="submit" class="btn btn-primary" id="add_confirm">Add</button>
            </div>
        </form>
    </div>
</div>