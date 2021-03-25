<script>
    $(document).ready(function() {
        $("#add_candidate_dialog .m2mj-dialog-close,#add_candidate_dialog .dialog-background").click(function(){
            $(".m2mj-dialog").fadeOut();
        });
        $("#searchCandidate").click(function(){
            $("#applicant_table tbody").html("<tr><td colspan='5'><div class='d-flex justify-content-center align-items-center'><div class='loader'></div></div></td></tr>");
            var url = "<?php echo site_url('applicant/searchAjax'); ?>?display_id=on&display_last_name=on&display_first_name=on";
            if($("#value_id").val()){
                url += "&condition_id=E&value_id="+$("#value_id").val();
            }
            if($("#value_first_name").val()){
                url += "&condition_first_name=SW&value_first_name="+$("#value_first_name").val();
            }
            if($("#value_first_name").val()){
                url += "&condition_last_name=SW&value_last_name="+$("#value_last_name").val();
            }
            $.get(url , function(data) {
                if(data === "Error occured."){
                    showToast("Error occurred.",3000);
                    return;
                }
                result = JSON.parse(data);
                $("#applicant_table tbody").html("");
                result.forEach(function(applicant){
                    var row = "<tr id='applicant-"+applicant.id+"' class='applicant-row-item'>";
                    row += "<td class='text-left'><input type='checkbox' class='chk' value='"+applicant.id+"'></td>";
                    row += "<td class='text-left'>"+applicant.id+"</td>";
                    row += "<td class='text-left'>"+applicant.last_name+"</td>";
                    row += "<td class='text-left'>"+applicant.first_name+"</td>";
                    var skills = "";
                    if(applicant.skills){
                        skills = applicant.skills;
                    }
                    row += "<td class='text-left' style='word-wrap:break-word;width:30%'>"+skills+"</td>";
                    row += "</tr>";
                    console.log(applicant);
                    $("#applicant_table tbody").append(row);
                });
            });
        });
    });
</script>
<div class="m2mj-dialog" id="add_candidate_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <form id="form_add_candidate">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="category_select" class="form-label">Add Candidate to Pipeline</label>
                </div>
                <div class="form-row mb-3" class="col-md-12">
                    <div class="col-md-1 mb-3">
                        <input type="text" name="value_id" id="value_id" class="form-control" placeholder="ID">
                    </div>
                    <div class="col-md-5 mb-3">
                        <input type="text" name="value_first_name" id="value_first_name" class="form-control" placeholder="First Name">
                    </div>
                    <div class="col-md-5 mb-3">
                        <input type="text" name="value_last_name" id="value_last_name" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="col-md-1 mb-3">
                        <button id="searchCandidate" type="button" class="btn btn-success search">Search</button>
                    </div>
                </div>
                
                <div class="table-responsive applicant-table">
                    <table class="table table-hover" id="applicant_table">
                        <thead>
                            <tr>
                                <th class="text-left"></th>
                                <th class="text-center">ID</th>
                                <th class="text-left">Last Name</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Skills</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                
                <div class="mb-3">
                    <label for="candidate_status" class="form-label">Status</label>
                    <input type="number" name="candidate_status" id="candidate_status" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-danger" id="add_candidate">Add</button>
            </div>
        </form>
    </div>
</div>

