<?php

?>
<div>
	<p style="margin-bottom: 0;"><?= __('Ciao {0},', $firstname) ?></p>,
	<p style="margin-top: 0; margin-bottom: 0;"><?= __('ti ringraziamo per esserti registrato su WFleek!') ?></p>
	<p style="margin-top: 0;"><?= __('Ti chiediamo gentilmente di cliccare sul link sottostante per verificare il tuo account.') ?></p>
	<p><a href="<?= $link ?>"><?= $link ?></a></p>
	<p><?= __('Ti auguriamo una buona giornata.') ?></p>
	<p style="margin-top: 1em; text-align: center;"><?= __('Il team di WFleek') ?></p>
</div>