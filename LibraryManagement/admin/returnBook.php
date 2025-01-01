<?php
include 'dbconnect.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_name = $_POST['book_name'];
    $serial_no = $_POST['serial_no'];
    $return_date = $_POST['return_date'];
   $membership_id = $_POST['membership_id'];
    // Check if mandatory fields are filled
    if (empty($book_name) || empty($serial_no) || empty($return_date)) {
        $message = "Error: Please ensure all mandatory fields are filled.";
    } else {
        // Update the quantity in master_list_of_books table
        $update_query = "UPDATE master_list_of_books SET quantity = quantity + 1 WHERE serial_no = '$serial_no'";

        if (mysqli_query($conn, $update_query)) {
            // Delete the row from the list_of_issuebooks table after returning the book
            $delete_query = "DELETE FROM list_of_issuebooks WHERE serial_no = '$serial_no' AND membership_id = '$membership_id'";

            if (mysqli_query($conn, $delete_query)) {
                // Redirect with all necessary fields
                $params = http_build_query([
                    'bookName' => $book_name,
                    'author' => $_POST['author'],
                    'serialNo' => $serial_no,
                    'membership_id' => $_POST['membership_id'],
                    'issueDate' => $_POST['issue_date'],
                    'returnDate' => $_POST['return_date'],
                    'remarks' => $_POST['remarks'] ?? ''
                ]);
                header("Location: payfine.php?$params");
                exit();
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

// Fetch available books from the database
$query = "SELECT book_name, author_name, serial_no, issue_date, return_date FROM list_of_issuebooks";
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
    <title>Return Book Form</title>
    <style>
        /* Sidebar Styling */
        .content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
            width: 60%;
            margin-left: 270px;
        }

        .top-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            border: 1px solid black;
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            display: flex;
            align-items: center;
        }

        .form-group label {
            width: 150px;
            font-weight: bold;
        }

        .form-group input, 
        .form-group select, 
        .form-group textarea {
            flex: 1;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group textarea {
            resize: none;
            height: 50px;
        }

        .form-group span {
            margin-left: 10px;
            color: gray;
            font-size: 12px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php require 'nav.php'; ?>
    <!-- Content Section -->
    <div class="content">
        <!-- Page Title -->
        <h2>Return Book</h2>

        <?php if (isset($message)) { echo "<p style='color: red;'>$message</p>"; } ?>

        <!-- Form Section -->
        <form id="returnForm" method="post" action="">
            <!-- Book Name -->
            <div class="form-group">
                <label for="bookName">Enter Book Name</label>
                <select id="bookName" name="book_name" required onchange="getBookDetails()">
                    <option value="">Select Book</option>
                    <?php while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['book_name'] . "' data-author='" . $row['author_name'] . 
                             "' data-serial='" . $row['serial_no'] . "' data-issue='" . $row['issue_date'] . 
                             "' data-return='" . $row['return_date'] . "'>" . $row['book_name'] . "</option>";
                    } ?>
                </select>
            </div>

            <!-- Author -->
            <div class="form-group">
                <label for="author">Enter Author</label>
                <input type="text" id="author" name="author" readonly placeholder="Enter Author">
            </div>

            <!-- Serial Number -->
            <div class="form-group">
                <label for="serialNo">Serial No</label>
                <input type="text" id="serialNo" name="serial_no" readonly required placeholder="Enter serial no">

                <span style="color: red;">Mandatory</span>
            </div>

            <div class="form-group">
                <label for="membership-id">Membership Id</label>
                <input type="text" id="membersip_id" name="membership_id">
            </div>

            <!-- Issue Date -->
            <div class="form-group">
                <label for="issueDate">Issue Date</label>
                <input type="date" id="issueDate" name="issue_date" readonly>
            </div>

            <!-- Return Date -->
            <div class="form-group">
                <label for="returnDate">Return Date</label>
                <input type="date" id="returnDate" name="return_date" required>
            </div>

            <!-- Remarks -->
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea id="remarks" name="remarks" placeholder="Optional"></textarea>
                <span>Non Mandatory</span>
            </div>

            <!-- Buttons -->
            <div class="buttons">
                <button type="reset" onclick="history.back()">Cancel</button>
                <button type="submit">Confirm</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function getBookDetails() {
            var bookName = document.getElementById('bookName').value;
            var selectedOption = document.querySelector('#bookName option[value="' + bookName + '"]');

            if (selectedOption) {
                document.getElementById('author').value = selectedOption.getAttribute('data-author');
                document.getElementById('serialNo').value = selectedOption.getAttribute('data-serial');
                document.getElementById('issueDate').value = selectedOption.getAttribute('data-issue');
                document.getElementById('returnDate').value = selectedOption.getAttribute('data-return');
            }
        }
    </script>
</body>
</html>
