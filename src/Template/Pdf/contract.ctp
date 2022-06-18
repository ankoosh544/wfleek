<?php

use Cake\I18n\Number;
use Cake\I18n\Time;


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        /*    tr:nth-child(even) {
            background-color: #dddddd;
        } */

        .aligncenter {
            text-align: center;

        }
    </style>
    <div style="text-align:center"><img style="width: 7em;" src="https://www.epebook.it/images/epebook-logo.png" alt="logo"></div>

</head>

<body>

        <h2 class="aligncenter"> Summary of Signed Contract</h2>
    <h1 class="aligncenter"><?= $contract->title ?></h1>
    <h3><?= $contract->description ?></h3>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">
                    <h3>Members Involved in this project</h3>
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Designation</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($res as $user) : ?>
                            <tr>
                                <td>
                                    <h3 class="table-avatar">
                                        <span><?= $user->firstname ?> <?= $user->lastname ?></span>
                                    </h3>
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
                                    <span>Active</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable" id="contractSummary">
                        <thead>
                            <tr>
                                <th scope="col">TaskTitle</th>
                                <th scope="col">groupTitle</th>
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
                                            <tr>
                                                <td><?= $group->title ?></td>
                                                <?php

                                                $diff = abs(strtotime($task->expiration_date) - strtotime($task->startdate));
                                                $years = floor($diff / (365 * 60 * 60 * 24));
                                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                $totalhrs = $totalhrs + ($days + 1) * 8;

                                                ?>

                                                <td> <?= ($days + 1) * 8 ?> hrs </td>



                                                <td><?= $task->title ?></td>
                                                <td><?= $task->description ?></td>

                                                <td><?= Number::currency($task->price, 'EUR', ['locale' => 'it_IT']); ?></td>
                                                <td><?= Number::toPercentage($task->tax_percentage) ?></td>
                                                <?php

                                                $totalprice = $totalprice + $task->price;

                                                $tax = ($task->tax_percentage / 100) * $task->price;

                                                $totaltax = $totaltax + $tax;
                                                $totalhrs = $totalhrs;
                                                ?>


                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                <?php endforeach; ?>

                            <?php endforeach; ?>


                            <tr>
                                <td colspan="3" style="text-align: end;">
                                    <span>Total Hours = <?= $totalhrs ?></span>
                                </td>

                                <td colspan="2" style="text-align: end;">
                                    <span>Total Price Without Tax = <?= Number::currency($totalprice, 'EUR', ['locale' => 'it_IT']); ?></span>
                                </td>

                                <td>
                                    <span>Total Tax = <?= Number::currency($totaltax, 'EUR', ['locale' => 'it_IT']); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: end;">
                                    <span>Total Price with Tax = <?= Number::currency($totalprice + $totaltax, 'EUR', ['locale' => 'it_IT']);  ?></span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <br>
        <?php if ($contract->creation_date != null) : ?>
            <div> Contract is Created on : <?= $contract->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></div>
        <?php endif; ?>
        <br>
        <?php if($contract->content != null): ?>
        <p>Comments<?= $contract->content ?></p>
        <?php endif; ?>

        <div class="form-group">
            <p>Signature</p>
            <p>Shek Ankoos</p>

            Date: <?= $contract->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
        </div>
    </div>
</body>

</html>
