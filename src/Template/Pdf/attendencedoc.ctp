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

    <h2 class="aligncenter"> Company Employees Attendence</h2>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date </th>
                            <th>Punch In</th>
                            <th>Punch Out</th>
                            <th>Production</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendances as $key => $attendance) : ?>
                            <tr id="myrow_<?= $key ?>">
                                <td>1</td>
                                <td><?=$attendance->user->firstname?> <?=$attendance->lastname?></td>
                                <td>
                                    <?php if ($attendance->start_time != null) : ?>
                                        <?= $attendance->start_time->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                    <?php endif; ?>

                                </td>
                                <td>
                                    <?php if ($attendance->start_time != null) : ?>
                                        <?= $attendance->start_time->i18nFormat('HH:mm:ss', 'Europe/Rome'); ?></td>
                            <?php endif; ?>
                            <td>
                                <?php if ($attendance->end_time != null) : ?>
                                    <?= $attendance->end_time->i18nFormat('HH:mm:ss', 'Europe/Rome'); ?>
                                <?php endif; ?>
                            </td>


                            <?php
                            if ($attendance->end_time != null) {
                                $diff = strtotime($attendance->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                                $hours = round($diff / (60 * 60), 2);
                            } else {
                                $hours = 0;
                            }
                            ?>
                            <td><?= $hours ?> hrs</td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
