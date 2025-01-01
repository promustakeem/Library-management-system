<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Issue Requests</title>
    <style>
    
        /* Main Content */
        .content {
            width: 80%;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4285f4;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Buttons */
        .submit-btn {
            display: block;
            width: 150px;
            margin: 0 auto;
            padding: 10px;
            text-align: center;
            background-color: #4285f4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #306acb;
        }

    </style>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    </head>
<body>
<?php
    require 'nav.php';
    ?>
    

    <!-- Main Content -->
    <div class="content">
        <h2>Issue Requests</h2>
        <table>
            <tr>
                <th>Membership Id</th>
                <th>Name of Book/Movie</th>
                <th>Requested Date</th>
                <th>Request Fulfilled Date</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <!-- Back Button -->
        <a href="#" class="submit-btn" style="text-align: center;">Back</a>

    </div>
</body>
</html>
