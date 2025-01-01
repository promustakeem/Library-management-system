<?php
require 'dbconnect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $role = isset($_POST['admin']) ? 'admin' : 'user';
    $status = isset($_POST['status']) ? 1 : 0;

    if ($userType == 'new') {
        $password = $_POST['password'];
        $sql = "INSERT INTO users (username, password, role, status) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $username, $password, $role, $status);
            if ($stmt->execute()) {
                echo "<script>alert('New user added successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing the query for new user.');</script>";
        }
    } elseif ($userType == 'existing') {
        $sql = "UPDATE users SET role = ?, status = ? WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sis", $role, $status, $username);
            if ($stmt->execute()) {
                echo "<script>alert('User updated successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing the query for updating user.');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="radio"] {
            margin-right: 5px;
        }
        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .buttons .cancel {
            background-color: #d9534f;
            color: white;
        }
        .buttons .confirm {
            background-color: #5cb85c;
            color: white;
        }
        .buttons button:hover {
            opacity: 0.9;
        }
    </style>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    </head>
<body>
<?php
    require 'nav.php';
    ?>
    <div class="container">
        <h1>User Management</h1>
        <form method="POST">
            <div class="form-group">
                <label>
                    <input type="radio" name="userType" value="new" id="newUserRadio" checked> New User
                </label>
                <label>
                    <input type="radio" name="userType" value="existing" id="existingUserRadio"> Existing User
                </label>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" required>
            </div>
            <div class="form-group" id="passwordGroup">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="status"> Active
                </label>
                <label>
                    <input type="checkbox" name="admin"> Admin
                </label>
            </div>
            <div class="buttons">
                <button type="button" class="cancel">Cancel</button>
                <button type="submit" class="confirm">Confirm</button>
            </div>
        </form>
    </div>
    <script>
        const newUserRadio = document.getElementById('newUserRadio');
        const existingUserRadio = document.getElementById('existingUserRadio');
        const passwordGroup = document.getElementById('passwordGroup');

        function togglePasswordField() {
            if (newUserRadio.checked) {
                passwordGroup.style.display = 'block';
            } else {
                passwordGroup.style.display = 'none';
            }
        }

        newUserRadio.addEventListener('change', togglePasswordField);
        existingUserRadio.addEventListener('change', togglePasswordField);

        togglePasswordField();
    </script>
</body>
</html>
