 <!-- Delete Taskuser Modal -->
 <div class="modal fade" id="delete_taskuser_<?= $taskuser->user->id ?>" role="dialog" >
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-body">
                 <div class="form-header">
                     <h3>Delete Task User</h3>
                     <p>Are you sure want to Delete this User for this Task?</p>
                 </div>
                 <div class="modal-btn delete-action">
                     <div class="row">
                         <div class="col-6">
                             <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $taskuser->user->id ?>" class="btn btn-primary continue-btn">Delete</a>
                         </div>
                         <div class="col-6">
                             <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- /Delete taskuser Modal -->
