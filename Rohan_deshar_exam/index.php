<?php require 'db.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Fitness Membership Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
$member_name = $email = $plan_type = $duration_months = "";
$member_nameErr = $emailErr = $plan_typeErr = $duration_monthsErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    if (empty($_POST["member_name"])) {
        $member_nameErr = "Name is required";
        $valid = false;
    } else {
        $member_name = test_input($_POST["member_name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $member_name)) {
            $member_nameErr = "Only letters and white space allowed";
            $valid = false;
        }
    }
  
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $valid = false;
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $valid = false;
        }
    }

    if (empty($_POST["plan_type"])) {
        $plan_typeErr = "Plan type is required";
        $valid = false;
    } else {
        $plan_type = test_input($_POST["plan_type"]);
    }

    if (empty($_POST["duration_months"])) {
        $duration_monthsErr = "Duration is required";
        $valid = false;
    } else {
        $duration_months = test_input($_POST["duration_months"]);
    }

    if ($valid) {
        try {
            $stmt = $conn->prepare("INSERT INTO Gymmembers (member_name, email, plan_type, duration_months) VALUES (:member_name, :email, :plan_type, :duration_months)");
            $stmt->bindParam(':member_name', $member_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':plan_type', $plan_type);
            $stmt->bindParam(':duration_months', $duration_months);
            $stmt->execute();
            
            echo "<script>alert('Membership created successfully');</script>";
            $member_name = $email = $plan_type = $duration_months = "";
        } catch(PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div class="container">
    <div class="top-bar">
        <h2>Elite Fitness Membership</h2>
        <a href="dashboard.php" class="link-button">View Dashboard</a>
    </div>
    <p><span class="error">* required field</span></p>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        Member Name: 
        <input type="text" name="member_name" value="<?php echo $member_name;?>">
        <span class="error">* <?php echo $member_nameErr;?></span>
        
        E-mail: 
        <input type="text" name="email" value="<?php echo $email;?>">
        <span class="error">* <?php echo $emailErr;?></span>
        
        Plan Type: 
        <input type="text" name="plan_type" value="<?php echo $plan_type;?>">
        <span class="error">* <?php echo $plan_typeErr;?></span>
        
        Duration (Months): 
        <input type="number" name="duration_months" value="<?php echo $duration_months;?>">
        <span class="error">* <?php echo $duration_monthsErr;?></span>
        
        <input type="submit" name="submit" value="Submit">  
    </form>
</div>

</body>
</html>