<?php
include 'dbconnect.php'; // Database connection

// Retrieve data from query parameters
$bookName = $_GET['bookName'] ?? '';
$author = $_GET['author'] ?? '';
$serialNo = $_GET['serialNo'] ?? '';
$membershipId = $_GET['membership_id'] ?? '';
$issueDate = $_GET['issueDate'] ?? '';
$returnDate = $_GET['returnDate'] ?? '';
$remarks = $_GET['remarks'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $bookName = $_POST['bookName'];
    $author = $_POST['author'];
    $serialNo = $_POST['serialNo'];
    $membershipId = $_POST['membershipId'];
    $issueDate = $_POST['issueDate'];
    $returnDate = $_POST['returnDate'];
    $actualReturnDate = $_POST['actualReturnDate'];
    $fineCalculated = $_POST['fineCalculated'];
    $finePaid = isset($_POST['finePaid']) ? 1 : 0; // Checkbox value
    $remarks = $_POST['remarks'];

    // Insert into the database if the fine is not paid
    if (!$finePaid) {
        $query = "INSERT INTO overduereturns (SerialNoBook, NameOfBook, NameOfAuthor, MembershipID, DateOfIssue, DateOfReturn, TotalFine) 
                  VALUES ('$serialNo', '$bookName', '$author', '$membershipId', '$issueDate', '$returnDate', '$fineCalculated')";
         $update = "UPDATE master_list_of_memberships set amount_pending = amount_pending +'$fineCalculated' where membership_id = '$membershipId'";
         mysqli_query($conn, $update);
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data inserted successfully!');</script>";
            echo "<script>window.location.href='transaction.php';</script>";
        } else {
            echo "<script>alert('Error inserting data: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Fine</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .content {
            flex: 1;
            padding: 20px;
            width: 60%;
            margin-left: 270px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 10px;
            border: 1px solid black;
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: none;
            height: 50px;
        }

        input[type="checkbox"] {
            margin-top: 5px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        button {
            width: 120px;
            padding: 10px;
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #4b98ff;
        }

        button:hover {
            background-color: #367cd5;
        }
    </style>
</head>
<body>
    <?php require 'nav.php'; ?>

    <div class="content">
        <h2>Pay Fine</h2>
        <form method="POST" action="">
            <div class="form-container">
                <label for="bookName">Book Name</label>
                <input type="text" id="bookName" name="bookName" value="<?= htmlspecialchars($bookName) ?>" required>

                <label for="author">Author</label>
                <input type="text" id="author" name="author" value="<?= htmlspecialchars($author) ?>" required>

                <label for="serialNo">Serial No</label>
                <input type="text" id="serialNo" name="serialNo" value="<?= htmlspecialchars($serialNo) ?>" required>

                <label for="membershipId">Membership ID</label>
                <input type="text" id="membershipId" name="membershipId" value="<?= htmlspecialchars($membershipId) ?>" required>

                <label for="issueDate">Issue Date</label>
                <input type="date" id="issueDate" name="issueDate" value="<?= htmlspecialchars($issueDate) ?>" required>

                <label for="returnDate">Return Date</label>
                <input type="date" id="returnDate" name="returnDate" value="<?= htmlspecialchars($returnDate) ?>" required>

                <label for="actualReturnDate">Actual Return Date</label>
                <input type="date" id="actualReturnDate" name="actualReturnDate" value="Date">

                <label for="fineCalculated">Fine Calculated</label>
                <input type="text" id="fineCalculated" name="fineCalculated" value="0.0">

                <label for="finePaid">Fine Paid</label>
                <div>
                    <input type="checkbox" id="finePaid" name="finePaid">
                </div>

                <label for="remarks">Remarks</label>
                <textarea id="remarks" name="remarks"><?= htmlspecialchars($remarks) ?></textarea>
            </div>

            <div class="buttons">
                <button type="reset" onclick="history.back()">Cancel</button>
                <button type="submit">Confirm</button>
            </div>
        </form>
    </div>
</body>
</html>
