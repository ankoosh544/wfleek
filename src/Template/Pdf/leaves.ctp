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

    <h2>Leaves Report</h2>

    <table>
        <tr>
            <th>Employee</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Department</th>
            <th>Leave Type</th>
            <th>No.of Days</th>
            <th>Remaining Leave</th>
            <th>Total Leaves</th>
            <th>Total Leave Taken</th>
            <th>Leave Carry Forward</th>

        </tr>
        <?php foreach ($leaves as $leave) : ?>
            <tr>
                <td><?= $leave->user->firstname ?> <?= $leave->user->lastname ?></td>
                <td><?= $leave->fromdate->i18nFormat('dd/MM/yyyy ', 'Europe/Rome') ?></td>
                <td><?= $leave->todate->i18nFormat('dd/MM/yyyy ', 'Europe/Rome') ?></td>
                <?php foreach ($companymembers as $companymember) : ?>
                    <?php if ($companymember->user_id == $leave->user_id) : ?>
                        <td><?= $companymember->designation->name ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>

                <td>
                    <?php if ($leave->leavetype == 'M') : ?> Medical Leave
                    <?php elseif ($leave->leavetype == 'C') : ?> Casual Leave
                    <?php else : ?>
                        Loss of Pay Leave
                    <?php endif; ?>
                </td>
                <?php
                $diff = abs(strtotime($leave->todate) - strtotime($leave->fromdate));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $totalannualleaves = 12;
                $remaing = $totalannualleaves - $days;

                ?>

                <td class="text-center"><span class="btn btn-danger btn-sm"><?= $days ?></span></td>
                <td class="text-center"><span class="btn btn-warning btn-sm"><b><?= $remaing ?></b></span></td>
                <td class="text-center"><span class="btn btn-success btn-sm"><b><?= $totalannualleaves ?></b></span></td>
                <td class="text-center"><?= $days ?></td>
                <td class="text-center">00</td>
            </tr>
        <?php endforeach; ?>

    </table>

</body>

</html>
