<script>
    $(document).ready(function() {
        applyPillEvents();
        
        $("#form_add_user").submit(function(e){
            e.preventDefault();
            var userId = $("#user_select").val();
            var userName = $("#user_select option:selected").text();
            if(!userId){
                showToast("Error occurred.",3000);
                return;
            }
            if($("#user-" + userId).length != 0) {
                showToast("Already exist.",3000);
                return;
            }
            var userBtn = createPill('user-'+userId,userName,'',true);
            $("#users").prepend(userBtn);
            applyPillEvents();
            hideDialog();
        });
    });
</script>
<div class="m2mj-dialog" id="users_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <form id="form_add_user">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="user_select" class="form-label">Recruiter</label>
                    <select name="user_select" id="user_select" class="custom-select" required>
                        <option value="">Select Recruiter</option>
                        <?php foreach($recruiters as $recruiter): ?>
                            <option value="<?php echo $recruiter->id; ?>">
                                <?php echo $recruiter->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-danger" id="add_user">Add</button>
            </div>
        </form>
    </div>
</div>