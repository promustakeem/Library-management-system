<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Reports</title>
    <style>
        

        /* Container styling */
        .containerwq {
            width: 500px;
            margin-top: 20px;
            
            padding: 10px;
    
        }

      

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Report List styling */
        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: black;
        }

        a:hover {
            text-decoration: underline;
        }

        

        
    </style>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    <?php
    require 'nav.php';
    ?>
    <h2>Available Reports</h2>
    <div class="containerwq">
        
        <!-- Available Reports -->
        
        <ul>
            <li><a href="masterListOfBooks.php">Master List of Books</a></li>
            <li><a href="masterListOfMovies.php">Master List of Movies</a></li>
            <li><a href="masterListOfmembership.php">Master List of Memberships</a></li>
            <li><a href="activeIssue.php">Active Issues</a></li>
            <li><a href="overDueReturns.php">Overdue Returns</a></li>
            <!-- <li><a href="issueRequest.php">Pending Issue Requests</a></li> -->
        </ul>

        <!-- Log Out Section -->
        
    </div>
</body>
</html>
f