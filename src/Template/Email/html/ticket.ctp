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
            <th>Selected Task Group Title</th>
            <th>Ticket Start Date</th>
            <th>Ticket Expiry Date</th>
            <th>Price</th>
            <th>Tax</th>
        </tr>

        <tr>
            <th> <?= $updatetask->title ?></th>
            <th><?= $updatetask->description ?></th>

            <?php foreach ($manyObject as $object) : ?>
                    <?php if ($updatetask->id === $object->projecttask_id) : ?>
                        <?php foreach ($taskgroups as $group) : ?>
                            <?php if ($object->taskgroup_id == $group->id) : ?>
                                <th><span> <?= $group->title ?></span></th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <th><?= $updatetask->startdate->i18nFormat('dd/MM/yyyy'); ?></th>
            <th><?= $updatetask->expiration_date->i18nFormat('dd/MM/yyyy'); ?></th>

            <th><?= $updatetask->price ?></th>
            <th><?= $updatetask->tax_percentage ?></th>
        </tr>

    </table>
    <p> alla prossima.</p>
    <p style="text-align:center;">Il team di <b style="text-transform:uppercase">epebook</b> </p>

    <!--<div><button class="btn btn-sucess" style="background-color: green;">Accept</button></div> <br/><br/>
    <div><button class="btn-btn-danger" style="background-color: red">Reject</button></div>--->

</body>

</html>

