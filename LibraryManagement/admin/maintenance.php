<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeping - Card Style</title>
    <style>
       
      

        /* Card Container */
        .container {
            display: flex;
            
            align-items: center;
            margin-top: 40px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        /* Card Title */
        .card-header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            background-color: #f8f8f8;
        }

        /* Table Content */
        .card-content {
            padding: 10px 20px;
            width: 500px;
        }

        .card-content .row1 {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        /* .card-content .row:last-child {
            border-bottom: none;
        } */

        .card-content a {
            color: #007BFF;
            text-decoration: none;
            margin-left: 10px;
        }

        .card-content a:hover {
            text-decoration: underline;
        }

         h2{
            text-align: center;
         }
        
    </style>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    </head>
<body>
<?php
    require 'nav.php';
    ?>

    

    
          <h2>Housekeeping</h2>
        
            </div>
            <!-- Card Content -->
            <div class="card-content">
                <div class="row1">
                    <div>Membership</div>
                    <div>
                        <a href="addMemberShip.php">Add</a>
                        <a href="updateMemberShip.php">Update</a>
                    </div>
                </div>
                <div class="row1">
                    <div>Books/Movies</div>
                    <div>
                        <a href="addBook.php">Add</a>
                        <a href="updateBook.php">Update</a>
                    </div>
                </div>
                <div class="row1">
                    <div>User Management</div>
                    <div>
                        <a href="userManagement.php">Manage Users</a>
                       
                    </div>
                </div>
            </div>

        

</body>
</html>
