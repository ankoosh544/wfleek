 <!-- Change Background Image Modal -->
 <div class="modal custom-modal fade" id="background_image_<?= $group->id ?>" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="post" action="/groups/updatebackgroundimg" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Update Background Image</h3>
                            </div>

                            <div class=" form-group">
                                <label for="image"> Image</label>
                                <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" name="background_image" type="file" />

                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button style="width: 100%;" type="submit" class="btn btn-primary continue-btn">Update</button>

                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                            <input type="hidden" name="group_id" value="<?= $group->id ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Change Background Image Modal ---->


<script>
    function changebackgroundimage(group_id) {
        $('#background_image_' + group_id).modal('show');

    }
</script>
