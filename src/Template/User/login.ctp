<?php
$this->assign('title', __('Accedi'));
?>
<div class="container">
    <div class="account-logo">
        <a href="/"><img src="/assets/img/logo.png" alt="Logo di WFleek"></a>
    </div>
    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title"><?= __('Accedi a WFleek') ?></h3>
            <p class="account-subtitle"><?= __('Entra nel tuo account') ?></p>
            <form method="post" action="/user/login">
                <div class="form-group">
                    <label><?= __('Il tuo indirizzo e-mail') ?><span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="email" placeholder="example@gmail.com" required  />
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label><?= __('La tua password') ?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-auto">
                            <a tabindex="1" class="text-muted" href="/user/forgot-password">
                                <?= __('Hai dimenticato la password?') ?>
                            </a>
                        </div>
                    </div>
                    <input tabindex="0" class="form-control" type="password" name="password" placeholder="Password" required />
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit"><?= __('Accedi') ?></button>
                </div>
            </form>

            <div class="account-footer">
                <p><?= __('Non hai ancora un account?') ?> <a href="/registrations/register"><?= __('Clicca qui per crearne uno') ?></a>.</p>
                </br>
                <p><?= __("Registrata, Non hai ricevuto l'email di verifica ? ") ?> <a href="/registrations/verifymail"><?= __('Clicca qui ') ?></a>.</p>
            </div>

        </div>
    </div>
</div>


