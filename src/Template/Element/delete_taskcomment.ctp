 <!-- Delete Taskuser Modal -->
 <div class="modal fade" id="deletecomment_<?= $ticket->id ?>_<?= $comment->id ?>" role="dialog" >
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
             <div class="modal-body">
                 <div class="form-header">
                     <h3>Delete This Comment</h3>
                     <p>Are you sure want to Delete this Comment ?</p>
                 </div>
                 <div class="modal-btn delete-action">
                     <div class="row">
                         <div class="col-6">
                             <a href="/comments/delete?commentId=<?=$comment->id?>&&ticketid=<?=$ticket->id?>" class="btn btn-primary continue-btn">Delete</a>
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
