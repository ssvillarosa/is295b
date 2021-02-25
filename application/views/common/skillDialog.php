<script>
    $(document).ready(function() {
        applyPillEvents();
        $("#category_select").change(function(){
            var categoryId = $("#category_select").val();
            $.get('<?php echo site_url('skill/getSkillsByCategory') ?>?skillCategoyId='+categoryId,
            function(data) {
                if(data.trim() === "Error"){
                    showToast("Error occurred.",3000);
                }
                var skills = $.parseJSON(data);
                $("#skill_select").html("");
                $("#skill_select").append("<option value=''>Select Skill</option>");
                skills.forEach(function(skill){
                   var option = "<option value='"+skill.id+"'>"
                           +skill.name+"</option>";
                   $("#skill_select").append(option);
                });
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
        
        $("#form_add_skill").submit(function(e){
            e.preventDefault();
            var categoryId = $("#category_select").val();
            var skillId = $("#skill_select").val();
            var skillName = $("#skill_select option:selected").text();
            var yrsOfExp = $("#text_yrs_of_exp").val();
            if(!categoryId || !skillId || !yrsOfExp || yrsOfExp < 1){
                showToast("Error occurred.",3000);
                return;
            }
            if($("#skill-" + skillId).length != 0) {
                showToast("Already exist.",3000);
                return;
            }
            var skillBtn = createPill('skill-'+skillId,skillName,yrsOfExp,true);
            $("#skills").prepend(skillBtn);
            applyPillEvents();
            hideDialog();
        });
    });
</script>
<div class="m2mj-dialog" id="skills_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <form id="form_add_skill">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="category_select" class="form-label">Category</label>
                    <select name="category_select" id="category_select" class="custom-select" required>
                        <option value="">Select Category</option>
                        <?php foreach($skillCategories as $skillCategory): ?>
                            <option value="<?php echo $skillCategory->id; ?>">
                                <?php echo $skillCategory->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="skill_select" class="form-label">Skill</label>
                    <select name="skill_select" id="skill_select" class="custom-select" required>
                        <option value="">Select Skill</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="text_yrs_of_exp" class="form-label">Years of experience</label>
                    <input type="number" name="text_yrs_of_exp" id="text_yrs_of_exp" class="form-control" value="1" min="1" required>
                </div>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-danger" id="add_skill">Add</button>
            </div>
        </form>
    </div>
</div>