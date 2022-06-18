  <!-- Delete Member  ProjectManager Modal -->
  <div class="modal fade" id="delete_approve_<?= $projectObject->id ?>_<?= $client->memberId ?>" role="dialog" style="z-index: 999 important!;">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-body">
                  <div class="form-header">
                      <h3>Delete Project Member</h3>
                      <p>Are you sure want to Delete the Project Member ?</p>
                  </div>
                  <div class="modal-btn delete-action">
                      <div class="row">
                          <div class="col-6">
                              <a href="/project-object/deleteProjectusers?memberId=<?= $client->memberId ?>&pid=<?= $projectObject->id ?>" class="btn btn-primary continue-btn">Delete</a>
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
  <!-- /Delete ProjectManager Modal -->
