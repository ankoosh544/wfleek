<?php

use Cake\I18n\Number;

?>

<div class="page-wrapper">

    <div class="page-content" style="padding: 25px;">

            <div><a class="btn btn-info" href="/project-object/view/<?= $projectObject->id ?>">Back</a></div>

        </br>
        <?php if (!empty($projectObject->contracts[0]->versions)) : ?>
            <form method="post" action="/versions-contract/updatetitle/" enctype="multipart/form-data">
                <?php if ($projectObject->contracts[0]->versions[0]->title != null || $projectObject->contracts[0]->versions[0]->description != null) : ?>
                    <div class="form-group">
                        <input class="form-control" name="title" id="title" style="text-align: center;font-size:25px; width:100%" contentEditable=true value="<?= $projectObject->contracts[0]->versions[0]->title ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="description" id="description" style="text-align: center;width:100%" contentEditable=true value="<?=  $projectObject->contracts[0]->versions[0]->description ?>">
                    </div>
                <?php else : ?>
                    <div class="form-group">
                        <input class="form-control" name="title" id="title" contentEditable=true placeholder="Write a Summary Title"">
                                </div>
                                <div class=" form-group">
                        <textarea class="form-control" name="description" id="description" contentEditable=true placeholder="Write a Summary Description"></textarea>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="versionId" value="<?= $projectObject->contracts[0]->versions[0]->id ?>">
                <?php if ($data2->type == 'Y') : ?>
                    <button type="submit" style="padding: 0px;">Update</button>
                <?php endif; ?>
            </form>

        <?php else : ?>
            <form method="post" action="/contracts/updatetitle/" enctype="multipart/form-data">
                <?php if ($projectObject->contracts[0]->title != null || $projectObject->contracts[0]->description != null) : ?>
                    <div class="form-group">
                        <input class="form-control" name="title" id="title" style="text-align: center;font-size:25px; width:100%" contentEditable=true value="<?= $contract->title ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="description" id="description" style="text-align: center;width:100%" contentEditable=true value="<?= $contract->description ?>">
                    </div>
                <?php else : ?>
                    <div class="form-group">
                        <input class="form-control" name="title" id="title" contentEditable=true placeholder="Write a Summary Title"">
                                </div>
                                <div class=" form-group">
                        <textarea class="form-control" name="description" id="description" contentEditable=true placeholder="Write a Summary Description"></textarea>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="contractId" value="<?= $projectObject->contracts[0]->id ?>">
                <?php if ($data2->type == 'Y') : ?>
                    <button type="submit" style="padding: 0px;">Update</button>
                <?php endif; ?>
            </form>

        <?php endif; ?>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Designation</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <h3>Members Involved in this project</h3>
                            <?php foreach ($projectObject->projectmembers as $projectmember) : ?>
                                <tr>
                                    <td>
                                        <h3 class="table-avatar">
                                            <span><?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?></span>
                                        </h3>
                                    </td>

                                    <td>
                                        <?php if ($projectmember->type == 'X') : ?>
                                            <span>Developer</span>
                                        <?php elseif ($projectmember->type == 'Y') : ?>
                                            <span>Admin(Chief)</span>
                                        <?php elseif ($projectmember->type == 'Z') : ?>
                                            <span>Project Manager</span>
                                        <?php elseif ($projectmember->type == 'A') : ?>
                                            <span>Functional Analyst</span>
                                        <?php else : ?>
                                            <span>Customer</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span>Active</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">groupTitle</th>
                    <th scope="col">TaskTitle</th>
                    <th scope="col">Total Hrs</th>
                    <th scope="col">Description of Task</th>
                    <th scope="col">Price</th>
                    <th scope="col">Tax</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projectObject->taskgroups as $taskgroup) : ?>
                    <tr>
                        <td><?= $taskgroup->title ?></td>
                        <td>
                            <table class="table">
                                <thead>
                                    <th scope="col">Task Name</th>
                                    <th scope="col">Total Hrs</th>
                                    <th scope="col">Description of Task</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Tax</t< /thead>
                                        <?php foreach ($taskgroup->projecttasks as $task) : ?>
                                            <tr>
                                                <td><?= $task->title ?></td>
                                                <?php $dteDiff = round((strtotime($task->expiration_date) - strtotime($task->startdate)) / 3600);
                                                ?>
                                                <td> <?= $dteDiff + 24 ?> hrs</td>
                                                <td><?= $task->description ?></td>
                                                <td><?= Number::currency($task->price, 'EUR', ['locale' => 'it_IT']); ?></td>
                                                <td><?= Number::toPercentage($task->tax_percentage) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                            </table>
                        </td>
                        <td><?= $taskgroup->total_workinghrs ?></td>
                        <td><?= $taskgroup->price ?></td>
                        <td><?= $taskgroup->tax_percentage ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: end;">
                        <span>Total Hours = <?= $projectObject->total_workinghours ?></span>
                    </td>

                    <td colspan="2" style="text-align: end;">
                        <span>Total Price Without Tax = <?= Number::currency($projectObject->price, 'EUR', ['locale' => 'it_IT']); ?></span>
                    </td>
                    <?php $projecttax = ($projectObject->tax / 100) * $projectObject->price; ?>
                    <td>
                        <span>Total Tax = <?= Number::currency($projecttax, 'EUR', ['locale' => 'it_IT']); ?></span>
                    </td>
                </tr>

                <tr>
                    <td colspan="5" style="text-align: end;">
                        <span>Total Price with Tax = <?= Number::currency($projectObject->price + $projecttax, 'EUR', ['locale' => 'it_IT']);  ?></span>
                    </td>

                </tr>


            </tbody>

        </table>

        <div>
            <?php if ($data2->type == 'Y') : ?>
                <?php if (!empty($projectObject->contracts[0]->versions[0])) : ?>
                    <form method="post" action="/versions-Contract/createVersion?projectId=<?= $projectObject->id ?>&&contractId=<?= $projectObject->contracts[0]->id ?>" id="add" enctype="multipart/form-data">
                        <textarea type="text" name="content" id="content" style="width: 100%;" rows="15"><?= $projectObject->contracts[0]->versions[0]->content ?></textarea>
                        <br>
                        <div style="text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg">Create New Version</button>
                        </div>
                        <input type="hidden" name="cid" id="cid" value="<?= $projectObject->contracts[0]->versions[0]->contract_id ?>">
                        <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                    </form>
                <?php else : ?>

                    <form method="post" action="/versions-Contract/createVersion/?projectId=<?= $projectObject->id ?>&&contractId=<?= $projectObject->contracts[0]->id ?>" id="add" enctype="multipart/form-data">
                        <textarea type="text" name="content" style="width: 100%;" id="content" rows="10"><?=$projectObject->contracts[0]->content ?></textarea>
                        <br>
                        <div style="text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg">Create New Version</button>
                        </div>
                        <input type="hidden" name="cid" id="cid" value="<?= $projectObject->contracts[0]->id ?>">
                        <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                    </form>

                    <p type="text" name="content" id="content" style="background-color: whitesmoke;" rows="15"><?= $projectObject->contracts[0]->content ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (!empty($projectObject->contracts[0]->versions[0])) : ?>
                <div>
                    <a class="btn btn-info" href="/contracts/downloadFile?contract_id=<?= $projectObject->contracts[0]->versions[0]->contract_id ?>&pid=<?= $projectObject->contracts[0]->versions[0]->project_object_id ?>">Download file</a>
                </div>
                <div style="margin-top: 10px;">
                    <a class="btn btn-info" href="/contracts/sharecontract?contract_id=<?= $projectObject->contracts[0]->versions[0]->contract_id ?>">Share Contract</a>
                </div>
            <?php else : ?>
                <div>
                    <a class="btn btn-info" href="/contracts/downloadFile?contract_id=<?= $projectObject->contracts[0]->id ?>&pid=<?= $projectObject->contracts[0]->project_object_id ?>">Download file</a>
                </div>
                <div style="margin-top: 10px;">
                    <a class="btn btn-info" href="/contracts/sharecontract?contract_id=<?= $projectObject->contracts[0]->id ?>">Share Contract</a>
                </div>
            <?php endif; ?>
        </div>
    </div>


</div>
