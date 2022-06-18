 <!-- Assign User Modal -->
 <div id="assign_user" class="modal custom-modal fade" role="dialog">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Assign the user to this project</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form method="post" action="/project-member/invite-members/" enctype="multipart/form-data">
                     <div class="form-group form-focus select-focus m-b-30">
                         <label for="tag"><?= __('Select Department') ?> <span class="text-danger">*</span></label>
                         <select id="company_department" class="select2-icon floating" name="departmentId" onchange="filterdesignations()">
                         <option value="">--Select Department--</option>
                         <?php foreach ($departments as $department) : ?>
                                 <option value="<?= $department->id ?>"><?= $department->name ?></option>
                             <?php endforeach; ?>
                         </select>
                     </div>
                     </br>

                     <div class="form-group form-focus select-focus m-b-30">
                         <label for="adduser"><?= __('Add Designation') ?> <span class="text-danger">*</span></label>
                         <select name="designationId" id="company_designations" class="select2-icon floating" onchange="filteremployees(<?=$userData->choosen_companyId?>)">
                         </select>
                     </div>
                     </br>
                     <div class="form-group form-focus select-focus m-b-30">
                         <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                         <select name="userId" id="company_employees" class="select2-icon floating multiselector" multiple>
                         </select>
                     </div>
                     </br>

                     <div class="submit-section">
                         <input type="hidden" name="projectId" value="<?=$projectObject->id?>">
                         <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /Assign User Modal -->
 <script>
     function filterdesignations() {
         $.ajax({
             url: '/departments/filterdesignations',
             method: 'post',
             dataType: 'json',
             data: {
                 'departmentId': $('#company_department').val(),
             },
             success: function(data) {
                $('#company_designations').empty();
                str = '<option value="">--Select Designation--</option>';
                 if (data != null) {
                     data.forEach(function(designation) {
                         str += ' <option value="' + designation.id + '">' + designation.name + '</option>'
                     });
                     $('#company_designations').html(str);

                 }
             },
             error: function(a, b, c) {
                 console.log(a, b, c);
             }
         })
     }
     function filteremployees(companyId){
         $.ajax({
             url: '/designations/filteremployees',
             method: 'post',
             dataType: 'json',
             data: {
                 'designationId': $('#company_designations').val(),
                 'companyId' : companyId
             },
             success: function(data) {
                 $('#company_employees').empty();

                 if (data != null) {
                     str = '<option value="">--Select Employee--</option>';
                     data.forEach(function(employee) {
                         str += ' <option value="' + employee.user.id + '">' + employee.user.firstname + ' '+employee.user.lastname+'</option>'
                     });
                     $('#company_employees').html(str);
                 }
             },
             error: function(a, b, c) {
                 console.log(a, b, c);
             }
         })
     }
 </script>
