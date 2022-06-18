<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VersionsContract $versionsContract
 */
?>
<?php

use Cake\I18n\Number;

?>

<div class="page-wrapper">

    <div class="page-content" style="padding: 25px;">
        <div>
            <input name="title" id="title" style="text-align: center;font-size:25px; width:100%" value="<?= $version->title ?>">
        </div>
        <br>
        <div>
            <textarea name="description" id="description" style="width:100%"><?= $version->description ?></textarea>
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
                            <?php foreach ($res as $user) : ?>
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <?php if ($user->profileFilepath != null && $user->profileFilename != null) : ?>
                                                <a href="/user/view/<?= $user->id ?>" class="avatar"><img alt="" src="<?= $user->profileFilepath ?>/<?= $user->profileFilename ?>"></a>

                                            <?php else : ?>
                                                <a href="/user/view/<?= $user->id ?>" class="avatar"><img alt="" src="/assets/img/profiles/avatar-09.jpg"></a>
                                            <?php endif; ?>

                                            <a href="#"><?= $user->firstname ?> <?= $user->lastname ?>
                                            </a>
                                        </h2>
                                    </td>
                                    <td>
                                        <?php foreach ($projectMember as $member) : ?>
                                            <?php if ($user->id == $member->memberId) : ?>
                                                <?php if ($member->type == 'X') : ?>
                                                    <span>Developer</span>
                                                <?php elseif ($member->type == 'Y') : ?>
                                                    <span>Admin(Chief)</span>
                                                <?php elseif ($member->type == 'Z') : ?>
                                                    <span>Project Manager</span>
                                                <?php else : ?>
                                                    <span>Customer</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
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
                    <th scope="col">groupTitle</th>
                    <th scope="col">TaskTitle</th>
                    <th scope="col">Total Hrs</th>
                    <th scope="col">Description of Task</th>
                    <th scope="col">Price</th>
                    <th scope="col">Tax</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $totalprice = 0;
                $totaltax = 0;
                $totalhrs = 0;

                ?>
                <?php foreach ($manyObject as $object) : ?>

                    <?php foreach ($groupoftask as $group) : ?>

                        <?php foreach ($projecttask as $task) : ?>
                            <?php if ($object->taskgroup_id == $group->id && $object->projecttask_id == $task->id) : ?>
                                <?php if ($task->isDeleted == false) : ?>

                                    <tr>
                                        <td><?= $group->title ?></td>
                                        <td> <a href="/project-object/taskboard/<?= $projectObject->id ?>" class="btn btn-success"><?= $task->title ?></a></td>

                                        <?php

                                        $diff = abs(strtotime($task->expiration_date) - strtotime($task->startdate));
                                        $years = floor($diff / (365 * 60 * 60 * 24));
                                        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                        $totalhrs = $totalhrs + ($days + 1) * 8;
                                        ?>
                                        <td> <?= ($days + 1) * 8 ?> hrs</td>
                                        <td><?= $task->description ?></td>

                                        <td><?= Number::currency($task->price, 'EUR', ['locale' => 'it_IT']); ?></td>
                                        <td><?= Number::toPercentage($task->tax_percentage) ?></td>
                                        <?php

                                        $totalprice = $totalprice + $task->price;
                                        $tax = $task->price / $task->tax_percentage;
                                        $totaltax = $totaltax + $tax;
                                        $totalhrs = $totalhrs + 24;

                                        ?>


                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    <?php endforeach; ?>

                <?php endforeach; ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <h6>Total Hours =</h6> <?= $totalhrs ?>
                    </td>
                    <td></td>
                    <td>
                        <h6>Total Price Without Tax =</h6><?= Number::currency($totalprice, 'EUR', ['locale' => 'it_IT']); ?>
                    </td>
                    <td></td>
                    <td>
                        <h6>Total Tax =</h6><?= Number::currency($totaltax, 'EUR', ['locale' => 'it_IT']); ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align: center;">
                        <h6>Total Price with Tax =</h6>
                    </td>
                    <td><?= Number::currency($totalprice + $totaltax, 'EUR', ['locale' => 'it_IT']);  ?></td>
                </tr>


            </tbody>
        </table>

        <div>

            <?php if (!empty($version)) : ?>
                <?php if ($data2->type == 'Y') : ?>
                    <form method="post" action="/versionscontract/createVersion/" id="add" enctype="multipart/form-data">
                        <textarea type="text" name="content" id="content" style="width: 100%;" rows="15"><?= $version->content ?></textarea>
                        <br>
                        <div style="text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg">Create New Version</button>
                        </div>
                        <input type="hidden" name="cid" id="cid" value="<?= $version->contract_id ?>">
                        <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                    </form>
                <?php endif; ?>
            <?php else : ?>
                <p type="text" name="content" id="content" style="background-color: whitesmoke;" rows="15"><?= $contract->content ?></p>
            <?php endif; ?>


            <?php if (!empty($version)) : ?>
                <div>
                    <a class="btn btn-info" href="/contracts/downloadFile?contract_id=<?= $version->contract_id ?>&pid=<?= $version->project_object_id ?>">Download file</a>
                </div>
                <div style="margin-top: 10px;">
                    <a class="btn btn-info" href="/contracts/sharecontract?contract_id=<?= $version->contract_id ?>">Share Contract</a>
                </div>
            <?php else : ?>
                <div>
                    <a class="btn btn-info" href="/contracts/downloadFile?contract_id=<?= $version->contract_id ?>&pid=<?= $version->project_object_id ?>">Download file</a>
                </div>
                <div style="margin-top: 10px;">
                    <a class="btn btn-info" href="/contracts/sharecontract?contract_id=<?= $version->contract_id ?>">Share Contract</a>
                </div>
            <?php endif; ?>
        </div>
    </div>


</div>
