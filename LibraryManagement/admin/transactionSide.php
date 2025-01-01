<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         
        .transactions {
            
    background-color: #f4f4f4;
    border: none;
    padding: 30px;
    width: 300px; /* Adjust the width as needed */
    margin-left: 0; /* Align it to the left of the page */
    margin-top: 20px;

  
}
           
        

        .transactions a {
            display: block;
            margin: 10px 0;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .transactions a:hover {
            text-decoration: underline;
        }
    
    </style>
</head>
<body>
    
<div class="transactions">
        <a href="bookAvailable.php">Is book available?</a>
        <a href="issuebook.php">Issue book?</a>
        <a href="returnBook.php">Return book?</a>
        <a href="payfine.php">Pay Fine?</a>
    </div>
</body>
</html>