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
    <h2>Summary of the Project </h2>
    <p> Ciao <?= $user->firstname ?> <?= $user->lastname ?>,</p>
    <p> grazie per il vostro interesse.</p>
    <div class="container">
        <div class="row">
            <div>Contract Created on :: <?= $contract->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></div>
            <a href="<?= $protocol ?>://<?= $domain ?>:<?= $port ?>/user/verifycontractacceptancy?contract_id=<?= $contract->id ?>&pid=<?= $projectObject->id ?>&userid=<?= $user->id ?>">Click to Accept Contract</a>
            <div class="form-control"><?= $content ?></div>
            <p> alla prossima.</p>
            <p style="text-align:center;">Il team di <b style="text-transform:uppercase; width:5em;">epebook</b> </p>

        </div>
    </div>
</body>

</html>
