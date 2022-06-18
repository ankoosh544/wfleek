<?php
$this->assign('title', __('Invia link di verifica'));
?>
<div class="account-content">
    <div class="container">
        <div class="account-box">
            <div class="account-wrapper">
                <h3 class="account-title"><?= __('Invia link di verifica') ?></h3>
                <p class="account-subtitle"><?= __('Compila i campi sottostanti') ?></p>

                <!-- Account Form -->
                <form action="/registrations/sendverificationlink" method="post">
                    <div class="form-group">
                        <label><?= __('Il tuo indirizzo e-mail') ?></label>
                        <input class="form-control" type="text" id="email" name="email" required />
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary account-btn" type="submit"><?= __('Spedire') ?></button>
                    </div>
                </form>
                <!-- <div class="account-footer">
                    <p><?= __('Ricordi la tua password?') ?> <a href="/user/login"><?= __('Clicca qui per accedere') ?></a>.</p>
                </div> -->
                <!-- /Account Form -->

            </div>
        </div>
    </div>
</div>


