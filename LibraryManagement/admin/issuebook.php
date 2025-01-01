<?php
include '../admin/dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $serial_no = $_POST['serial_no'];
    $issue_date = $_POST['issue_date'];
    $return_date = $_POST['return_date'];
    $remarks = $_POST['remarks'];
    $membership_id = $_POST['membership_id'];

    $insert_query = "INSERT INTO list_of_issuebooks(book_name, author_name, serial_no, issue_date, return_date, membership_id, remarks) 
                     VALUES ('$book_name', '$author', '$serial_no', '$issue_date', '$return_date','$membership_id', '$remarks')";

    $update_query = "UPDATE master_list_of_books 
                     SET quantity = quantity - 1, issueDate = '$issue_date', returnDate = '$return_date' 
                     WHERE serial_no = '$serial_no'";

    if (mysqli_query($conn, $update_query) && mysqli_query($conn, $insert_query)) {
        $message = "Book issued successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

$query = "SELECT book_name, author_name, serial_no 
          FROM master_list_of_books 
          WHERE quantity > 0";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Issue Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            border: 2px solid black;
            padding: 10px;
            margin: 20px auto;
            width: 80%;
        }
        input, textarea, select {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .buttons {
            text-align: center;
            margin-top: 10px;
        }
        .btn {
            background-color: #3399FF;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #287BDB;
        }
    </style>
</head>
<body>
<?php require '../admin/nav.php'; ?>

<div class="container">
    <div class="title">Book Issue</div>
    <?php if (isset($message)) { echo "<p style='color: green;'>$message</p>"; } ?>
    <form id="bookIssueForm" action="" method="post">
        <table class="table">
            <tr>
                <td>Enter Book Name</td>
                <td>
                    <select name="book_name" id="bookName" required onchange="getBookDetails()">
                        <option value="">Select Book</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['book_name'] . "' data-author='" . $row['author_name'] . "' data-serial='" . $row['serial_no'] . "'>" . $row['book_name'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Enter Author</td>
                <td><input type="text" name="author" id="author" placeholder="Enter Author Name" required readonly></td>
            </tr>
            <tr>
                <td>Serial Number</td>
                <td><input type="text" name="serial_no" placeholder="Serial Number" required readonly></td>
            </tr>
            <tr>
                <td>Membership Id</td>
                <td><input type="text" name="membership_id" placeholder="Membership ID" required></td>
            </tr>
            <tr>
                <td>Issue Date</td>
                <td><input type="date" name="issue_date" required></td>
            </tr>
            <tr>
                <td>Return Date</td>
                <td><input type="date" name="return_date" required></td>
            </tr>
            <tr>
                <td>Remarks</td>
                <td><textarea name="remarks" placeholder="Optional"></textarea></td>
            </tr>
        </table>
        <div class="buttons">
            <a href="transaction.php"><button type="reset" class="btn">Cancel</button></a>
            <button type="submit" class="btn">Confirm</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const issueDateInput = document.querySelector('input[name="issue_date"]');
        const returnDateInput = document.querySelector('input[name="return_date"]');
        const bookNameSelect = document.getElementById('bookName');
        
        const today = new Date().toISOString().split('T')[0];
        issueDateInput.min = today;

        issueDateInput.addEventListener('change', function () {
            const issueDate = new Date(this.value);
            if (!isNaN(issueDate)) {
                const returnDate = new Date(issueDate);
                returnDate.setDate(returnDate.getDate() + 15);
                returnDateInput.value = returnDate.toISOString().split('T')[0];
                returnDateInput.max = returnDate.toISOString().split('T')[0];
            }
        });

        returnDateInput.addEventListener('change', function () {
            const issueDate = new Date(issueDateInput.value);
            const returnDate = new Date(this.value);

            if (returnDate > issueDate) {
                const maxDate = new Date(issueDate);
                maxDate.setDate(maxDate.getDate() + 15);

                if (returnDate > maxDate) {
                    alert("Return date cannot be more than 15 days after the issue date.");
                    this.value = maxDate.toISOString().split('T')[0];
                }
            } else {
                alert("Return date cannot be earlier than the issue date.");
                this.value = issueDate.toISOString().split('T')[0];
            }
        });

        bookNameSelect.addEventListener('change', getBookDetails);

        document.getElementById('bookIssueForm').addEventListener('submit', function (e) {
            const bookName = bookNameSelect.value;
            const issueDate = issueDateInput.value;

            if (!bookName || !issueDate) {
                e.preventDefault();
                alert("Please ensure all required fields are filled correctly.");
            }
        });
    });

    function getBookDetails() {
        const selectedOption = document.querySelector('#bookName option:checked');
        
        if (selectedOption) {
            const author = selectedOption.getAttribute('data-author');
            const serial = selectedOption.getAttribute('data-serial');

            document.getElementById('author').value = author;
            document.querySelector('input[name="serial_no"]').value = serial;
        }
    }
</script>

</body>
</html>
