<?php

use Cake\I18n\Number;
?>
<!DOCTYPE html>
<html>

<head>
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
</head>

<body>
    <table>
        <tr>
            <td>
                <img style="width: 25%;" src="https://www.epebook.it/images/epebook-logo.png" />
            </td>
        </tr>
        <tr>
            <td>
                <h3>Employee Payslip #<?= $employeepayslip->id ?></h3>
                <p><?= $employeepayslip->user->firstname ?> <?= $employeepayslip->user->lastname ?></p>
                <p>Salary Month: <?= $employeepayslip->month ?> ,<?= $employeepayslip->year ?></p>

            </td>
            <td>
                <p><strong><?= $employeepayslip->usercompany->name ?></strong></p>
                <p><?= $employeepayslip->usercompany->address ?>,</p>
                <p><?= $employeepayslip->usercompany->country ?> <?= $employeepayslip->usercompany->state ?>, <?= $employeepayslip->usercompany->postal_code ?></p>

            </td>
        </tr>
    </table>


    <table>
        <tr>
            <th>Earnings</th>
            <th>Deductions</th>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                        Basic Salary
                        </td>
                        <td><?= Number::currency(($employeepayslip->net_salary), 'EUR', ['locale' => 'it_IT']); ?></td>
                    </tr>
                    <tr>
                        <td>House Rent Allowance (H.R.A.)</td>
                        <td><?= $employeepayslip->hra ?></td>
                    </tr>
                    <tr>
                        <td>T D S</td>
                        <td><?= $employeepayslip->tds ?></td>
                    </tr>
                    <tr>
                        <td>
                        PF
                        </td>
                        <td><?= $employeepayslip->pf ?></td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td><?= $employeepayslip->tax ?></td>
                    </tr>
                    <tr>
                        <th>Net Salary</th>
                        <td>$111</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                        Tax Deducted at Source (T.D.S.)
                        </td>
                        <td>$0</td>
                    </tr>
                    <tr>
                        <td>
                        Provident Fund
                        </td>
                        <td>$0</td>
                    </tr>
                    <tr>
                        <td>
                        ESI
                        </td>
                        <td>
                            $0
                        </td>
                    </tr>
                    <tr>
                        <td>Loan</td>
                       <td>$0</td>
                    </tr>
                    <tr>
                        <td>
                        Total Deductions
                        </td>
                        <td>$0</td>
                    </tr>
                </table>
            </td>

        </tr>

    </table>

</body>

</html>
