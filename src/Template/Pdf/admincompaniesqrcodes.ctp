<?php

use CodeItNow\BarcodeBundle\Utils\QrCode;
?>

<div class="container">
    <?php foreach ($admincompanies as $company) : ?>
        <div class="row">
            <h2> <?= $company->usercompany->name ?> </h2>
            <?php
            if ($type == 'Entrance') {
                $result =  $protocol . '://' . $domain .  $port . '/companies-user/employeepunchin?Type=' . $type . '&emp_id=' . $user_id . '&company_id=' . $company->usercompany->id . '&code=' . $company->usercompany->entrance_qr_code;
            } elseif ($type == 'Exit') {
                $result =  $protocol . '://' . $domain .  $port . '/companies-user/employeepunchout?Type=' . $type . '&emp_id=' . $user_id . '&company_id=' . $company->usercompany->id . '&code=' . $company->usercompany->exit_qr_code;
            }

            $qrCode = new QrCode();
            $qrCode
                ->setText($result)
                ->setSize(300)
                ->setPadding(10)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setLabel($type)
                ->setLabelFontSize(16)
                ->setImageType(QrCode::IMAGE_TYPE_PNG);
            echo '<img src="data:' . $qrCode->getContentType() . ';base64,' . $qrCode->generate() . '" />';
            ?>
        </div>
        <hr>
    <?php endforeach; ?>


</div>
