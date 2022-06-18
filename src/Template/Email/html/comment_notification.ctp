<?php

?>
<p>Ciao <?= $touserdata->firstname ?> <?= $touserdata->lastname ?>,</p>
<p><?=$comment->user->firstname?> <?=$comment->user->lastname?> is
<?php if($notificationtype == 'comment') : ?> Commented <?php else: ?> Replied <?php endif; ?> on <?=$task->title?>
</p>

<p><?= __('Saluti') ?></p>
<p style="text-align: center; margin-top: 2em;"><?= __('Il team di WFleek') ?></p>
