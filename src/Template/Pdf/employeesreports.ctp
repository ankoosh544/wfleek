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

    <h2>Employee Reports</h2>

    <table>
        <tr>
            <th>Employee Name</th>
            <th>Employee Type</th>
            <th>Email</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Joining Date</th>
            <th>DOB</th>
            <th>Martial Status</th>
            <th>Gender</th>
            <th>Terminated Date</th>
            <th>Relieving Date</th>
            <th>Salary</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th>Emercency Contact Details</th>
            <th>Experience</th>
        </tr>
        <?php foreach ($companymembers as $companymember) : ?>
            <tr>
                <td><?=$companymember->user->firstname ?> <?= $companymember->user->lastname ?></td>
                <td>Maria Anders</td>
                <td><?= $companymember->user->email ?></td>
                <td><?= $companymember->designation->department->name ?></td>
                <td>
                    <?= $companymember->designation->name ?>
                </td>
                <td><?= $companymember->user->registrationDate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></td>
                <td><?= $companymember->user->birthday->i18nFormat('dd/MM/yyyy ', 'Europe/Rome') ?></td>
                <td>Married</td>
                <td><?= $companymember->user->gender ?></td>
                <td>-</td>
                <td>-</td>
                <td>$20000</td>
                <td>
                    <?= $companymember->user->address ?>
                </td>
                <td><?= $companymember->user->tel ?></td>
                <td>7894561235</td>
                <td>0 years 4 months and 9 days</td>
                <td>
                    <?php if ($companymember->status == 'A') : ?> Active
                        <?php else : ?>InActive
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>


    </table>

</body>

</html>
