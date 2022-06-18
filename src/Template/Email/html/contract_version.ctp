<?php

use Cake\I18n\Number;


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <div style="text-align:left;">
        <div style="text-align:center"><img style="width: 7em;" src="https://www.epebook.it/images/epebook-logo.png" alt="logo"></div>
        <p> Ciao <?= $user['firstname'] ?>,</p>
        <p> grazie per il vostro interesse.</p>
    </div>
    <div class="container">

            <?php if ($version->creation_date != null) : ?>
                <div>Contract-version Created on :: <?= $version->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?> </div>
            <?php endif; ?>

            <a href="<?= $protocol ?>://<?= $domain ?>:<?= $port ?>/user/verifycontractacceptancy?contract_id=<?= $projectObject->contracts[0]->id ?>&pid=<?= $projectObject->id ?>&userid=<?= $user->id ?>&versionId=<?=$version->id?>">Click to Accept New Version </a>
        <div><?= $content ?></div>
        <p> alla prossima.</p>
        <p style="text-align:center;">Il team di <b style="text-transform:uppercase; width:5em;">epebook</b> </p>




    </div>
</body>

</html>
