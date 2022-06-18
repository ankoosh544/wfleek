 <!-- Add Task Modal -->
 <div id="add_task_modal" class="modal custom-modal fade" role="dialog">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Add Task</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body">
                 <form method="post" action="/projecttasks/addtask" id="addtask" enctype="multipart/form-data" novalidate>
                     <div class="modal-body">

                         <div class="row">
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label>Task Name <span class="text-danger">*</span></label>
                                     <input name="name" class="form-control" type="text">
                                 </div>
                             </div>

                             <div class="col-sm-6">
                                 <div class="form-group form-focus select-focus">
                                     <label for="addtasktsgrouptype"><?= __('Select the Task Group') ?><span class="text-danger">*</span></label><span class="text-success" style="display: none;text-align:end; margin-left:200px" id="successAddtask">Updated Sucessfully</span>
                                     <select id="addtasktsgrouptype" class="select floating" name="tsgrouptype">
                                         <option value="">--Select Task Group--</option>
                                         <?php foreach ($projectObject->taskgroups as $group) : ?>
                                             <option value="<?= $group->id ?>"><?= $group->title ?></option>
                                         <?php endforeach; ?>
                                     </select>
                                 </div>
                             </div>
                         </div>
                         </br>



                         <div class="row">
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="startdate"><?= __('Start Date') ?></label>
                                     <div class="cal-icon">
                                         <input type="text" name="startdate" id="addtaskstartdate" class="datetimepicker form-control" placeholder="dd/mm/yyyy" />
                                     </div>
                                     <span class="text-danger" id="errorstartdateMsg"></span>
                                 </div>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="expirydate"><?= __('Expire Date') ?></label>
                                     <div class="cal-icon">
                                         <input type="text" name="expirydate" id="addtaskexpirydate" class="form-control datetimepicker" placeholder="dd/mm/yyyy" />
                                     </div>
                                     <span class="text-danger" id="errorexpirydateMsg"></span>
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="price"><?= __('Price') ?></label>
                                     <input type="number" class="form-control" name="price" id="price" placeholder="<?= __('Enter Price...') ?>">
                                 </div>
                             </div>
                             <div class="col-sm-6">
                                 <div class="form-group">
                                     <label for="tax"><?= __('Tax') ?></label>
                                     <input type="number" class="form-control" name="tax" id="tax" placeholder="<?= __('Enter Tax...') ?>">
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-sm-6">
                                 <div class="form-group form-focus select-focus"><span>Priority:</span>
                                     <select class="select2-icon floating" name="task_prority">
                                         <option>Select Priority</option>
                                         <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                         <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                         <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                     </select>
                                 </div>
                             </div>

                             <div class="col-sm-6">
                                 <div class="form-group form-focus select-focus">
                                     <label for="epic"><?= __('Link to  Epic Task') ?><span class="text-danger">*</span></label>
                                     <select id="epic" class="select floating" name="epic_task">
                                         <?php foreach ($epictasks as $epictask) : ?>
                                             <option value="<?= $epictask->id ?>"><?= $epictask->title ?></option>
                                         <?php endforeach; ?>
                                     </select>
                                 </div>
                             </div>

                         </div>
                                         </br>
                         <div class="row">
                             <div class="col-sm-6">
                                 <label>Assign to Employee <span class="text-danger">*</span></label>
                                 <select name="taskassignees[]" class="select floating" required multiple>
                                     <option id='' disabled>-Select A Member-</option>
                                     <?php foreach ($companymembers as $companymember) : ?>
                                         <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <div class="col-sm-6">
                                 <label>Add Followers <span class="text-danger">*</span></label>
                                 <select name="followers[]" class="select floating" required multiple>
                                     <option id='' disabled>-Select member as Follower-</option>
                                     <?php foreach ($companymembers as $companymember) : ?>
                                         <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                         </div>
                         </br>
                         <div class="row">
                             <div class="col-sm-12">
                                 <div class="form-group">
                                     <label> Task Description <span class="text-danger">*</span></label>
                                     <textarea name="description" class="form-control  btn-mod-input height10" type="text"></textarea>
                                 </div>
                             </div>
                         </div>
                         </br>
                         <div class="row">
                             <div class="col-sm-12">
                                 <div class="form-group">
                                     <label>Upload Files</label>
                                     <?= $this->Form->control('taskfiles.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                     <!--  <input class="form-control" type="file" name="ticketfiles" multiple> -->
                                 </div>
                             </div>
                         </div>
                         <div class="text-center">
                             <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                             <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('create task') ?></button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /Add Task Modal---->
 <script>
     var values;

     //taskstartdate
     $('#addtaskstartdate').on('dp.change', function(ev) {
         var ts = $('#addtaskstartdate').val();
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
                 var taskstartdate = moment(dateToString).format("YYYY-MM-DD");
                 var todaydate = moment().format("YYYY-MM-DD");

                 if (taskstartdate >= todaydate) {
                     if ((moment(data.startdate).format("YYYY-MM-DD") <= taskstartdate) && (moment(data.expirydate).format("YYYY-MM-DD") > taskstartdate)) {
                         console.log('Valid Date');
                     } else {
                         error = "Invalid Date";
                     }
                 } else {
                     error = "Invalid Date Start Date should be greaterthan today date";
                 }
                 $('#errorstartdateMsg').html(error);
             },
             error: function() {}
         });

     });

     // task ExpiryDate
     $('#addtaskexpirydate').on('dp.change', function(ev) {
         var str = $('#addtaskstartdate').val()
         var exp = $('#addtaskexpirydate').val()
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
                 $('#errorexpirydateMsg').html(error);
             },
             error: function() {}
         });
     });
 </script>
