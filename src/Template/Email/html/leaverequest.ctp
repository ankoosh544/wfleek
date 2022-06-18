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

    <h2>Leave Request Data</h2>

    <table>
        <tr>
            <th>Employee Name</th>
            <th>Employee ID</th>
            <th>Leave Reason</th>
            <th>Leave form Date</th>
            <th>Leave To Date</th>
            <th>Total number of Days</th>
        </tr>

        <tr>
            <th><?= $leaveuseremail->firstname ?> <?= $leaveuseremail->lastname ?></th>
            <th><?= $leaveuseremail->id ?></th>
            <th><?= $leave->leavereason ?></th>
            <th><?= $leave->fromdate->i18nFormat('dd/MM/yyyy'); ?></th>
            <th><?= $leave->todate->i18nFormat('dd/MM/yyyy'); ?></th>
            <?php $difference = date_diff($leave->fromdate, $leave->todate) ?>
            <th><?= $difference->format("%a days");  ?></th>
        </tr>

    </table>

    <!--<div><button class="btn btn-sucess" style="background-color: green;">Accept</button></div> <br/><br/>
    <div><button class="btn-btn-danger" style="background-color: red">Reject</button></div>--->

</body>

</html>
