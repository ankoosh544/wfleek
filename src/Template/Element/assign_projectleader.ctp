 <!-- Assign Leader Modal -->
 <div id="assign_leader" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Leader to this project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/project-object/inviteMembers/" id="add" enctype="multipart/form-data">
                            <div class="form-group form-focus select-focus m-b-30">
                                <label for="adduser"><?= __('Add Project Manager') ?> <span class="text-danger">*</span></label>
                                <select id="adduser" class="select2-icon floating" name="adduser">
                                    <option id='' selected disabled>-------</option>
                                    <?php foreach ($companymembers as $companymember) : ?>


                                            <option value=" <?= $companymember->user->id ?>">
                                                <p><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></p><br />
                                                <span class="designation"><?= $companymember->user->email ?></span>
                                            </option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <br />
                            <div class="form-group form-focus select-focus m-b-30">
                                <label for="adddesignation"><?= __('Add Designation') ?><span class="text-danger">*</span></label>
                                <select id="adddesignation" class="select2-icon floating" name="adddesignation">

                                    <option value="Z">Project Manager</option>

                                </select>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                <input type="hidden" name=taskboard value="<?= $projectObject->id ?>">
                                <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Assign Leader Modal -->
