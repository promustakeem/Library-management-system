<?php
include 'dbconnect.php';

$membership_id = "";
$start_date = "";
$end_date = "";

// Check if a membership ID is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['load_membership'])) {
    $membership_id = $_POST['membership_id'];

    // Fetch details of the selected membership ID
    if (!empty($membership_id)) {
        $sql = "SELECT start_date, end_date FROM master_list_of_memberships WHERE membership_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $membership_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $start_date = $data['start_date'];
                $end_date = $data['end_date'];
            }
            $stmt->close();
        }
    }
}

// Handle form submission for updating or removing membership
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_membership'])) {
    $membership_id = $_POST['membership_id'];
    if (!empty($membership_id)) {
        if (isset($_POST['membership_remove']) && $_POST['membership_remove'] == "remove") {
            $sql = "UPDATE master_list_of_memberships set status = 'InActive' WHERE membership_id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $membership_id);
                if ($stmt->execute()) {
                    echo "<script>alert('Membership removed successfully!');</script>";
                    $membership_id = $start_date = $end_date = ""; // Reset fields
                } else {
                    echo "<script>alert('Error: " . $stmt->error . "');</script>";
                }
                $stmt->close();
            }
        } else {
            $current_end_date = $_POST['end_date'];
            $extension_period = isset($_POST['membership_ext']) ? $_POST['membership_ext'] : 'six_months';

            $new_end_date = $current_end_date;
            if ($extension_period == "six_months") {
                $new_end_date = date('Y-m-d', strtotime($current_end_date . ' +6 months'));
            } elseif ($extension_period == "one_year") {
                $new_end_date = date('Y-m-d', strtotime($current_end_date . ' +1 year'));
            } elseif ($extension_period == "two_years") {
                $new_end_date = date('Y-m-d', strtotime($current_end_date . ' +2 years'));
            }

            $sql = "UPDATE master_list_of_memberships SET end_date = ?, membership_duration = ? WHERE membership_id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssi", $new_end_date, $extension_period, $membership_id);
                if ($stmt->execute()) {
                    echo "<script>alert('Membership extended successfully!');</script>";

                   $membership_id =  $start_date = $end_date = ""; // Reset fields
                    

                } else {
                    echo "<script>alert('Error: " . $stmt->error . "');</script>";
                }
                $stmt->close();
            }
        }
    } else {
        echo "<script>alert('Please select a valid Membership ID.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Membership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .radio-group {
            margin-bottom: 20px;
        }

        .radio-group label {
            font-weight: normal;
            display: block;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cancel {
            background-color: #6c757d;
        }

        .confirm {
            background-color: #007bff;
        }

        a {
            text-decoration: none;
            color: blue;
            margin-top: 15px;
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        .nav-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .nav-links a {
            margin-right: 10px;
        }
       
        </style>
</head>
<body>
    <?php require 'nav.php'; ?>
    <div class="container mt-4">
        <h2>Update Membership</h2>
        <form method="POST" action="">
            <label for="membership-id">Membership ID</label>
            <select id="membership-id" name="membership_id" class="form-select" onchange="this.form.submit()" required>
                <option value="">Select Membership ID</option>
                <?php
                $sql = "SELECT membership_id FROM master_list_of_memberships";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($membership_id == $row['membership_id']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($row['membership_id']) . "' $selected>" . htmlspecialchars($row['membership_id']) . "</option>";
                    }
                }
                ?>
            </select>
            <input type="hidden" name="load_membership" value="1">

            <label for="start-date">Start Date</label>
            <input type="date" name="start_date" id="start-date" class="form-control" value="<?= htmlspecialchars($start_date) ?>" readonly>

            <label for="end-date">End Date</label>
            <input type="date" name="end_date" id="end-date" class="form-control" value="<?= htmlspecialchars($end_date) ?>" readonly>

            <div class="radio-group mt-3">
                <label>Membership Extension:</label>
                <label><input type="radio" name="membership_ext" value="six_months" checked> Six Months</label>
                <label><input type="radio" name="membership_ext" value="one_year"> One Year</label>
                <label><input type="radio" name="membership_ext" value="two_years"> Two Years</label>
            </div>

            <div class="radio-group mt-3">
                <label><input type="radio" name="membership_remove" value="remove"> Remove Membership</label>
            </div>

            <div class="buttons mt-3">
                <button type="submit" name="update_membership" class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>
</body>
</html>
