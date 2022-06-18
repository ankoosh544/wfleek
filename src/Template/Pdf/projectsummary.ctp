<?php

use Cake\I18n\Number;


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

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    <div style="text-align:center"><img style="width: 7em;" src="https://www.epebook.it/images/epebook-logo.png" alt="logo"></div>
</head>

<body>

    <h2 style="text-align: center;">Summary of the Project </h2>

    <div class="row">
        <div class="col-md-12">
            <h3>Members Involved in this project</h3>
            </br>
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">

                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Designation</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
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
    </br>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Tasks Information</h3>
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
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
                </div>
            </div>
        </div>

        <p>Customer Signature</p>

        <h4> alla prossima.</h4>
        <p style="text-align:center;">Il team di <b style="text-transform:uppercase; width:5em;">epebook</b> </p>

    </div>
</body>

</html>
