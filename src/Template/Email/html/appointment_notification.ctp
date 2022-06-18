<?php if ($notification->type == 'request') : ?>
    <p>Ciao <?= $appointment->candidate->firstname ?> <?= $appointment->companymember->lastname ?>,</p>
    <p><?= $appointment->candidate->lastname ?><?= $appointment->companymember->firstname ?> is
        Requested <?= $notification->action_title ?> on <?= $appointment->datetime ?>
    </p>
<?php else : ?>
    <p>Ciao <?= $appointment->candidate->lastname ?><?= $appointment->companymember->firstname ?>,</p>
    <p><?= $appointment->candidate->firstname ?> <?= $appointment->companymember->lastname ?> is
        Updated <?= $notification->action_title ?> on <?= $appointment->datetime ?>
    </p>
<?php endif; ?>

<p><?= __('Saluti') ?></p>
<p style="text-align: center; margin-top: 2em;"><?= __('Il team di WFleek') ?></p>
