

 <!-- Add Group Modal -->
 <div id="add_group" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Group
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/taskgroups/addtaskgroups" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name"><?= __('Group Name') ?><span class="text-danger">*</span></label>
                                    <input type="text" class="form-control btn-mod-input" name="group_title" id="group_title" placeholder="Name" required />
                                </div>


                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon" id="errormessage">
                                        <input class="form-control datetimepicker" name="startdate" id="groupstartdate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Expire Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon" id="errorgroupexpirymessage">
                                        <input class="form-control datetimepicker" name="expirydate" id="groupexpirydate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="price"><?= __('Price') ?><span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="<?= __('Enter Price...') ?> " required>
                                </div>
                                <div class="form-group">
                                    <label for="tax"><?= __('Tax') ?><span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="tax" id="tax" placeholder="<?= __('Enter Tax...') ?> " required>

                                </div>
                                <div class="form-group">
                                    <label for="name"><?= __('Group Description') ?><span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control " name="group_description" id="group_description" placeholder="Description" required /></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <input type="hidden" name="pid" value="<?= $projectObject->id ?>">

                                </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!---/ Add Group Modal--->
