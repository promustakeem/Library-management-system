<?php
include 'dbconnect.php';

$sql = "SELECT * FROM master_list_of_memberships"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $memberships = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $memberships = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Active Memberships</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .main {
            margin-left: 220px;
            padding: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .buttons {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        button {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <?php require 'nav.php'; ?>

    <div class="main">
        <h2>List of Active Memberships</h2>
        <table>
            <thead>
                <tr>
                    <th>Membership Id</th>
                    <th>Name of Member</th>
                    <th>Contact Number</th>
                    <th>Contact Address</th>
                    <th>Aadhar Card No</th>
                    <th>Start Date of Membership</th>
                    <th>End Date of Membership</th>
                    <th>Status (Active/Inactive)</th>
                    <th>Amount Pending (Fine)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($memberships)) {
                    foreach ($memberships as $membership) {
                        echo "<tr>
                                <td>{$membership['membership_id']}</td>
                                <td>{$membership['member_name']}</td>
                                <td>{$membership['contact_number']}</td>
                                <td>{$membership['contact_address']}</td>
                                <td>{$membership['aadhar_card_no']}</td>
                                <td>{$membership['start_date']}</td>
                                <td>{$membership['end_date']}</td>
                                <td>{$membership['status']}</td>
                                <td>{$membership['amount_pending']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No active memberships found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="buttons">
            <button onclick="history.back()">Back</button>
         
        </div>
    </div>



    <script>
        function confirmAction() {
            alert("Confirm button clicked!");
        }
    </script>
</body>
</html>
