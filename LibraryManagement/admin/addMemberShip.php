<?php
include 'dbconnect.php';  // Ensure dbconnect.php connects to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $member_name = $_POST['member_name'];
    
    $contact_number = $_POST['contact_number'];
    $contact_address = $_POST['contact_address'];
    $aadhar_card_no = $_POST['aadhar_card_no'];
    $start_date = $_POST['start_date'];
    $membership_duration = $_POST['membership_duration'];

    // Calculate end date based on membership duration
    $end_date = null;
    if ($membership_duration == "6 months") {
        $end_date = date('Y-m-d', strtotime($start_date . ' +6 months'));
    } elseif ($membership_duration == "1 year") {
        $end_date = date('Y-m-d', strtotime($start_date . ' +1 year'));
    } elseif ($membership_duration == "2 years") {
        $end_date = date('Y-m-d', strtotime($start_date . ' +2 years'));
    }

    // Validate the inputs (for simplicity, we just check for empty values here)
    if (!empty($member_name) && !empty($contact_number) && !empty($contact_address) && !empty($aadhar_card_no) && !empty($start_date)) {
        
        // Prepare SQL statement
        $sql = "INSERT INTO master_list_of_memberships (member_name, contact_number, contact_address, aadhar_card_no, start_date, end_date, membership_duration) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepare statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("sssssss", $member_name, $contact_number, $contact_address, $aadhar_card_no, $start_date, $end_date, $membership_duration);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Membership added successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            // Close the statement
            $stmt->close();
        }
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Membership</title>
    <style>
        .container1 {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
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

    </style>
    <script>
        function updateEndDate() {
            const startDate = document.getElementById('start_date').value;
            const duration = document.querySelector('input[name="membership_duration"]:checked').value;
            let endDate = '';

            if (startDate) {
                const start = new Date(startDate);
                if (duration === '6 months') {
                    start.setMonth(start.getMonth() + 6);
                } else if (duration === '1 year') {
                    start.setFullYear(start.getFullYear() + 1);
                } else if (duration === '2 years') {
                    start.setFullYear(start.getFullYear() + 2);
                }

                endDate = start.toISOString().split('T')[0];
            }

            document.getElementById('end_date').value = endDate;
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('start_date').addEventListener('change', updateEndDate);
            document.querySelectorAll('input[name="membership_duration"]').forEach(radio => {
                radio.addEventListener('change', updateEndDate);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
    require 'nav.php';
    ?>
    <div class="container1">
        <h2>Add Membership</h2>
        <form method="POST">
            <label for="member_name">First Name</label>
            <input type="text" name="member_name" id="member_name" required>

            
            <label for="contact_number">Contact Number</label>
            <input type="text" name="contact_number" id="contact_number" required>

            <label for="contact_address">Address</label>
            <input type="text" name="contact_address" id="contact_address" required>

            <label for="aadhar_card_no">Aadhar Card No</label>
            <input type="text" name="aadhar_card_no" id="aadhar_card_no" required>

            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" required>

            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" readonly>

            <div class="radio-group">
                <label>Membership Duration:</label>
                <label><input type="radio" name="membership_duration" value="6 months" checked> 6 Months</label>
                <label><input type="radio" name="membership_duration" value="1 year"> 1 Year</label>
                <label><input type="radio" name="membership_duration" value="2 years"> 2 Years</label>
            </div>

            <div class="buttons">
                <button type="reset" class="cancel">Cancel</button>
                <button type="submit" class="confirm">Confirm</button>
            </div>
        </form>
    </div>
</body>
</html>
