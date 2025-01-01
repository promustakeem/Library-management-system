<?php
 include 'dbconnect.php';
 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | HOME</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../CSS/main.css"> -->
  </head>
  <body>
 <?php require '../admin/nav.php' ?>

<div class="container my-5">
    <h1 class="text-center">Admin Home Page - Product Details</h1>

    <?php
    // Fetch data from the table `master_list_of_books`
    $sql = "SELECT serial_no, book_name, author_name, category, status, cost, procurement_date, quantity FROM master_list_of_books where quantity >0";
    $result = $conn->query($sql);
    ?>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Code No From</th>
                <th>Code No To</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . sprintf("%s(%06d)", substr($row['category'], 0, 2), $row['serial_no']) . "</td>";
                    echo "<td>" . sprintf("%s(%06d)", substr($row['category'], 0, 2), $row['serial_no'] + $row['quantity'] - 1) . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
