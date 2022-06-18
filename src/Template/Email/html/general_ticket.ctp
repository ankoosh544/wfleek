<?php

use Cake\I18n\Number;


?>

<!DOCTYPE html>
<html>

<head>
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

    <h2>Ticket Details</h2>

    <table>
        <tr>
            <th>Title of the Ticket</th>
            <th>Title Description</th>
            <th>Ticket Start Date</th>
        </tr>

        <tr>
            <th> <?= $task->title ?></th>
            <th><?= $task->description ?></th>


            <th>
                <?php if ($task->startdate != null) : ?>
                    <?= $task->startdate->i18nFormat('dd/MM/yyyy'); ?>
                <?php endif; ?>
            </th>
            <th>
                <?php if ($task->expiration_date != null) : ?>
                    <?= $task->expiration_date->i18nFormat('dd/MM/yyyy'); ?>
                <?php endif; ?>
            </th>
        </tr>

    </table>
    <p> alla prossima.</p>
    <p style="text-align:center;">Il team di <b style="text-transform:uppercase">epebook</b> </p>

</body>

</html>
