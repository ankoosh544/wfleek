<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->layout = 'layout_for_dashboard';

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">

<header class="row">
    <div class="header-image"><?= $this->Html->image('cake.logo.svg') ?></div>
    <div class="header-title">
        <h1>Benvenuto ad Agora Test. Scegli un ruolo: </h1>
    </div>
</header>

<div class="row">
    <div class="columns large-2">
        <?php
            echo $this->Form->button('Azienda', array(
                'type' => 'button',
                'onclick' => 'location.href=\'/homepage?role=company\';',
            ));
        ?>
    </div>
    <div class="columns large-2">
        <?php
            echo $this->Form->button('Studente', array(
                'type' => 'button',
                'onclick' => 'location.href=\'/homepage?role=student\';',
            ));
        ?>
    </div>
    <div class="columns large-3">
        <?php
            echo $this->Form->button('Università', array(
                'type' => 'button',
                'onclick' => 'location.href=\'/homepage?role=university\';',
            ));
        ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $.ajax({
                url: 'http://193.206.172.30/user-friendship/get-pending-friendships',
                data: {

                },
                method: 'POST',
                dataType: 'jsonp',
                statusCode: {
                    403: function(xhr){
                        //location.href="/user/login?redirect=/user/profile";
                    }
                },
                success: function(data, textStatus, jqXHR){
                    console.log(data);
                },

                error: function(jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });

    </script>
    </div>
    <div class="columns large-3">
        <?php
            echo $this->Form->postButton('Notaio', ['controller' => 'Pages', 'action' => 'display', 'homepage'])
        ?>
    </div>
    <div class="columns large-2">
        <?php
            echo $this->Form->postButton('Notaio', ['controller' => 'Pages', 'action' => 'displayPars', 'notary', 'homepage'])
        ?>
    </div>


    </div>

</div>

</body>
</html>
