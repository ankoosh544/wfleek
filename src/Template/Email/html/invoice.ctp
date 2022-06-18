<style>
    body {
        background-color: whitesmoke;
    }


    #invoice {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #invoice td,
    #invoice th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #invoice tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #invoice tr:hover {
        background-color: #ddd;
    }

    #invoice th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>


</style>
</head>

<body>
    <?php

    use Cake\I18n\Number;
    ?>
    <table id="projectDetails">
        <thead>
            <tr style="text-align: center;">
                <th colspan="4"><img style="width: 35%;" src="https://www.epebook.it/images/epebook-logo.png" /></th>
                <th colspan="6">
                    <h1><?= $invoice->client->firstname ?> <?= $invoice->client->lastname ?></h1>
                </th>
            </tr>
        </thead>
    </table><br>


</body>


<?php

?>
<p>Ciao <?= $invoice->client->firstname ?> <?= $invoice->client->lastname ?>,</p>
<p style="padding-left: 1em;"><?= __('Si prega di trovare il Documento di Fattura allegato.') ?></p>

<p><?= __('Saluti') ?></p>
<p style="text-align: center; margin-top: 2em;"><?= __('Il team di WFleek') ?></p>
