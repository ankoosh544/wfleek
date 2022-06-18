<?php

use Cake\I18n\Number;

?>

<div class="page-wrapper">
    <div class="page-content" style="padding: 25px;">

        <div><a class="btn btn-info" href="/project-object/view/<?= $projectObject->id ?>">Back</a></div>
        </br>
        <div class="row">
            <div class="col-lg-10 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="project-title">
                            <form method="post" action="/project-object/summaryUpdates/" enctype="multipart/form-data">
                                <?php if ($projectObject->summary_title != null && $projectObject->summary_description != null) : ?>
                                    <div class="form-group">
                                        <input class="form-control" name="title" id="title" style="text-align: center;font-size:25px; width:100%" contentEditable=true value="<?= $projectObject->summary_title ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="description" id="description" style="text-align: center;width:100%" contentEditable=true value="<?= $projectObject->summary_description ?>">
                                    </div>
                                <?php else : ?>
                                    <div class="form-group">
                                        <input class="form-control" name="title" id="title" contentEditable=true placeholder="Write a Summary Title"">
                                </div>
                                <div class=" form-group">
                                        <textarea class="form-control" name="description" id="description" contentEditable=true placeholder="Write a Summary Description"></textarea>
                                    </div>
                                <?php endif; ?>
                                <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                <?php if ($data2->type == 'Y') : ?>
                                    <button class="btn btn-info" type="submit" style="padding: 0px;">Update</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                        <h2 class="table-avatar">
                                            <a href="profile.html" class="avatar">

                                                <?php if ($projectmember->user->profileFilepath != null && $projectmember->user->profileFilename != null) : ?>
                                                    <img alt="" src="<?= $projectmember->user->profileFilepath ?>/<?= $projectmember->user->profileFilename ?>">
                                                <?php else : ?>
                                                <?php endif; ?>
                                            </a>
                                            <a href="#"><?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?>
                                            </a>
                                        </h2>
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
                                        <div class="dropdown action-label">
                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-dot-circle-o text-purple"></i> Active
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
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
                    <th scope="col">Group Name</th>
                    <th scope="col">Group Tasks</th>
                    <th scope="col">Total Hrs</th>
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

        <?php if ($data2->type == 'Y') : ?>
            <div class="form-group">
                <a class="btn btn-info" data-toggle="modal" data-target="#success_approve" href="#">Send to Customer</a>

                <div class="modal fade" id="success_approve" role="dialog" style="z-index: 999 important!;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>Send to Customer</h3>
                                    <p>Are you sure want to Send to Customer?</p>
                                </div>
                                <div class="modal-btn delete-action">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="/project-object/sendsummary/<?= $projectObject->id ?>" class="btn btn-primary continue-btn">Send</a>
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
            </div>

            <div>
                <a class="btn btn-info" href="/project-object/downloadFile/<?= $projectObject->id ?>">Download file</a>
            </div>
        <?php endif; ?>


    </div>
</div>
</div>


</div>
