  <!-------------------------------Edit Profile pic Modal-------------------------------------------------------------------->
  <div class="modal" id="editprofile_picture_<?= $authuser->id ?>" tabindex="-1" role="dialog" aria-labelledby="editprofile_picture">
      <div class="modal-dialog" role="dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Update Profile Picture</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <label>Select Image to Upload</label>
                  <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="profilepic" name="images" type="file" />
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateProfilepic(<?= $authuser->id ?>)">Upload Image</button>
              </div>
          </div>
      </div>
  </div>
  <!----------------------------------------------Edit Profile Information----------------------------------------------------------------------------->



