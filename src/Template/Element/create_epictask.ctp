 <!-- Add Task Modal -->

 <div id="create_epictask_modal" class="modal custom-modal fade" role="dialog">
     <div class="modal-dialog  modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title"> Create Epic Task</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body">
                 <form method="post" action="/projecttasks/create_epictask/">
                     <div class="modal-body">
                         <div class="form-group form-focus select-focus">
                             <label for="addtasktsgrouptype"><?= __('Select the Task Group') ?><span class="text-danger">*</span></label><span class="text-success" style="display: none;text-align:end; margin-left:200px" id="successAddtask">Updated Sucessfully</span>
                             <select id="addtasktsgrouptype" class="select floating" name="tsgrouptype">
                                 <?php foreach ($projectObject->taskgroups as $group) : ?>
                                     <option value="<?= $group->id ?>"><?= $group->title ?></option>
                                 <?php endforeach; ?>
                             </select>
                         </div>
                         </br>
                         <div class="form-group">
                             <label>Epic Task Name <span class="text-danger">*</span></label>
                             <input name="epic_name" class="form-control" type="text">
                         </div>

                         <div class="form-group">
                             <label for="startdate"><?= __('Start Date') ?></label>
                             <div class="cal-icon">
                                 <input type="text" name="epic_startdate" id="add_epic_taskstartdate" class="datetimepicker form-control" placeholder="dd/mm/yyyy" />
                             </div>
                             <span class="text-danger" id="epic_errorstartdateMsg"></span>
                         </div>
                         <div class="form-group">
                             <label for="expirydate"><?= __('Expire Date') ?></label>
                             <div class="cal-icon">
                                 <input type="text" name="epic_expirydate" id="add_epic_taskexpirydate" class="form-control datetimepicker" placeholder="dd/mm/yyyy" />
                             </div>
                             <span class="text-danger" id="epic_errorexpirydateMsg"></span>
                         </div>
                         <div class="form-group">
                             <label for="price"><?= __('Price') ?></label>
                             <input type="number" class="form-control" name="epic_price" id="price" placeholder="<?= __('Enter Price...') ?>">
                         </div>
                         <div class="form-group">
                             <label for="tax"><?= __('Tax') ?></label>
                             <input type="number" class="form-control" name="epic_tax" id="tax" placeholder="<?= __('Enter Tax...') ?>">
                         </div>

                         <div class="form-group form-focus select-focus">
                             <label for="tasks"><?= __('Add Tasks to Epic Task') ?><span class="text-danger">*</span></label>
                             <select id="tasks" class="select floating" name="epic_tasks[]" multiple>
                                 <?php foreach ($epictasks as $singletask) : ?>
                                     <option value="<?= $singletask->id ?>"><?= $singletask->title ?></option>
                                 <?php endforeach; ?>
                             </select>
                         </div>
                         </br>

                         <div class="form-group"><span>Priority:</span>
                             <select class="select2-icon floating" name="epic_task_prority">
                                 <option>Select Priority</option>
                                 <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                 <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                 <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                             </select>
                         </div>
                         </br>
                         <div class="form-group">
                             <label>Epic Task Description <span class="text-danger">*</span></label>
                             <textarea name="epic_description" class="form-control summernote btn-mod-input height10" type="text"></textarea>
                         </div>


                         <div class="text-center">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                             <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('create task') ?></button>
                             <input type="hidden" name="epic_pid" value="<?= $projectObject->id ?>">
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /Add Task Modal---->

 <!-- /Add Task Modal---->
 <script>
     //taskstartdate
     $('#add_epic_taskstartdate').on('dp.change', function(ev) {
         var ts = $('#add_epic_taskstartdate').val();
         var gid = $('#addtasktsgrouptype').val()
         $.ajax({
             url: '/projecttasks/checkstartdate',
             method: 'post',
             dataType: 'json',
             data: {
                 'groupid': gid,
             },
             success: function(data) {
                 var error = "";
                 var splittedDate = ts.split("/");
                 var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                 if (new Date(dateToString) > new Date()) {
                     if (((new Date(data.startdate)) <= (new Date(dateToString))) && ((new Date(data.expirydate)) >= (new Date(dateToString)))) {
                         console.log('Valid Date');
                     } else {
                         error = "Invalid Date";
                     }
                 } else {
                     error = "Invalid Date Start Date should be greaterthan today date";
                 }
                 $('#epic_errorstartdateMsg').html(error);
             },
             error: function() {}
         });

     });

     // task ExpiryDate
     $('#add_epic_taskexpirydate').on('dp.change', function(ev) {
         var str = $('#add_epic_taskstartdate').val()
         var exp = $('#add_epic_taskexpirydate').val()
         $.ajax({
             url: '/projecttasks/checkexpirydate',
             method: 'post',
             dataType: 'json',
             data: {
                 'groupid': $('#addtasktsgrouptype').val(),

             },
             success: function(data) {
                 var error = "";
                 var splittedstartDate = str.split("/");
                 var splittedexpiryDate = exp.split("/");
                 var startdateToString = splittedstartDate[2] + "-" + splittedstartDate[1] + "-" + splittedstartDate[0];
                 var expirydateToString = splittedexpiryDate[2] + "-" + splittedexpiryDate[1] + "-" + splittedexpiryDate[0];
                 if (new Date(expirydateToString) > new Date(startdateToString)) {
                     if (((new Date(data.startdate)) <= (new Date(expirydateToString))) && ((new Date(data.expirydate)) >= (new Date(expirydateToString)))) {} else {
                         error = 'ExpiryDate Invalid';
                     }
                 } else {
                     error = 'ExpiryDate not Lessthan StartDate';
                 }
                 $('#epic_errorexpirydateMsg').html(error);
             },
             error: function() {}
         });
     });
 </script>
