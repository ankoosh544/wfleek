<?php if (!empty($alltasks)) : ?>
    <div id="assign_alltaskuser_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
    <?php elseif (!empty($pendingtasks)) : ?>
        <div id="assign_pendingtaskuser_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
        <?php elseif (!empty($completedtasks)) : ?>
            <div id="assign_completedtaskuser_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
            <?php else : ?>
                <div id="assign_taskuser_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                <?php endif; ?>
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign the user to task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group form-focus select-focus m-b-30">
                                <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                                <select id="alltaskassignuser" class="select2-icon floating" name="adduser" multiple>
                                    <?php foreach ($companymembers as $companymember) : ?>
                                        <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?>
                                            <?php if ($companymember->member_role == 'Y') : ?>
                                                <span class="message-content">Administrator</span>
                                            <?php elseif ($companymember->member_role == 'X') : ?>
                                                <span class="message-content">Developer</span>
                                            <?php elseif ($companymember->member_role == 'Z') : ?>
                                                <span class="message-content">ProjectManager</span>
                                            <?php elseif ($companymember->member_role == 'H') : ?>
                                                <span class="message-content">HR</span>
                                            <?php elseif ($companymember->member_role == 'W') : ?>
                                                <span class="message-content">Co-Ordinator</span>
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="submit-section">
                                <a class="btn btn-success" onclick="select2function(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>
                            </div>

                        </div>
                    </div>
                    <br />
                </div>
                </div>
