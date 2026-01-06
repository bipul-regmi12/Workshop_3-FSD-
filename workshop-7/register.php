<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO students (student_id, name, password) VALUES (?, ?, ?)");

    if ($stmt->execute([$student_id, $name, $hashed_password])) {
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #f5f5f5;
            border: 3px solid #ff0000;
            padding: 40px;
            width: 400px;
            text-align: left;
        }

        h2 {
            text-align: center;
            color: #000000;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 32px;
            letter-spacing: -1px;
            text-transform: uppercase;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #000000;
            font-weight: 500;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #000000;
            background-color: #ffffff;
            color: #000000;
            font-family: Helvetica, Arial, sans-serif;
            font-size: 16px;
        }

        input:focus {
            outline: none;
            border-color: #ff0000;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #ff0000;
            color: #ffffff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-family: Helvetica, Arial, sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #cc0000;
        }

        p {
            text-align: left;
            margin-top: 20px;
            color: #000000;
            font-size: 14px;
        }

        a {
            color: #ff0000;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST">
            <label>Student ID:</label>
            <input type="text" name="student_id" required><br>
            <label>Name:</label>
            <input type="text" name="name" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>

</html>