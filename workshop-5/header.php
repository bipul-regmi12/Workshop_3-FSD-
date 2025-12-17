<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Portfolio Manager</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #f0f2f5;
            color: #333;
            max-width: 900px;
            margin: 0 auto;
            line-height: 1.6;
            text-align: center;
        }

        nav {
            background: #2c3e50;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        nav a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
            font-weight: 600;
        }

        nav a:hover {
            background-color: #34495e;
            text-decoration: none;
            color: #fff;
        }

        h1,
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: 300;
            text-align: center;
        }

        form {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #eee;
            text-align: center;
        }

        label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
            color: #555;
            text-align: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px 0;
            display: inline-block;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.1s;
        }

        button:hover {
            background-color: #43a047;
        }

        button:active {
            transform: translateY(1px);
        }

        ul {
            list-style-type: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        li {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
        }

        li:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Message Styles */
        .message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        hr {
            border: 0;
            height: 1px;
            background: #e0e0e0;
            margin: 40px 0;
        }

        footer {
            text-align: center;
            font-size: 0.9em;
            color: #888;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="add_student.php">Add Student Info</a>
        <a href="upload.php">Upload Portfolio</a>
        <a href="students.php">View Students</a>
    </nav>
    <hr>