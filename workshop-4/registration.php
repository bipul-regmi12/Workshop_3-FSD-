<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>User Registration</h1>

        <?php
        $errors = [];
        $success = false;
        $formData = ['name' => '', 'email' => '', 'password' => '', 'confirm_password' => ''];

        // Set timezone to avoid warnings in default XAMPP installations
        date_default_timezone_set('UTC');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize input
            $formData['name'] = trim($_POST['name'] ?? '');
            $formData['email'] = trim($_POST['email'] ?? '');
            $formData['password'] = $_POST['password'] ?? '';
            $formData['confirm_password'] = $_POST['confirm_password'] ?? '';

            // Validation
            if (empty($formData['name'])) {
                $errors['name'] = "Name is required";
            }

            if (empty($formData['email'])) {
                $errors['email'] = "Email is required";
            } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Please enter a valid email address";
            }

            if (empty($formData['password'])) {
                $errors['password'] = "Password is required";
            } elseif (strlen($formData['password']) < 8) {
                $errors['password'] = "Password must be at least 8 characters long";
            } elseif (!preg_match('/[A-Z]/', $formData['password'])) {
                $errors['password'] = "Password must contain at least one uppercase letter";
            } elseif (!preg_match('/[0-9]/', $formData['password'])) {
                $errors['password'] = "Password must contain at least one number";
            } elseif (!preg_match('/[!@#$%^&*]/', $formData['password'])) {
                $errors['password'] = "Password must contain at least one special character (!@#$%^&*)";
            }

            if (empty($formData['confirm_password'])) {
                $errors['confirm_password'] = "Please confirm your password";
            } elseif ($formData['password'] !== $formData['confirm_password']) {
                $errors['confirm_password'] = "Passwords do not match";
            }

            // Process registration if no errors
            if (empty($errors)) {
                $usersFile = __DIR__ . '/users.json';
                try {
                    // Check permissions explicitly
                    if (!is_writable(dirname($usersFile))) {
                        throw new Exception("Directory not writable. Check permissions for " . __DIR__);
                    }

                    // Read existing users
                    if (file_exists($usersFile)) {
                        $jsonContent = file_get_contents($usersFile);
                        $users = json_decode($jsonContent, true);
                        if (!is_array($users))
                            $users = [];
                    } else {
                        $users = [];
                    }

                    // Check if email exists
                    $emailExists = false;
                    foreach ($users as $user) {
                        if ($user['email'] === $formData['email']) {
                            $emailExists = true;
                            break;
                        }
                    }

                    if ($emailExists) {
                        $errors['email'] = "This email is already registered";
                    } else {
                        // Create new user
                        $newUser = [
                            'name' => $formData['name'],
                            'email' => $formData['email'],
                            'password' => password_hash($formData['password'], PASSWORD_DEFAULT),
                            'registered_at' => date('Y-m-d H:i:s')
                        ];

                        $users[] = $newUser;

                        $jsonData = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

                        // Ensure we capture the specific error
                        $saved = @file_put_contents($usersFile, $jsonData);

                        if ($saved !== false) {
                            $success = true;
                            $formData = ['name' => '', 'email' => '', 'password' => '', 'confirm_password' => ''];
                        } else {
                            $lastError = error_get_last();
                            $errors['file'] = "Error saving user data: " . ($lastError['message'] ?? 'Permission denied or disk full');
                        }
                    }
                } catch (Exception $e) {
                    $errors['file'] = "An error occurred: " . $e->getMessage();
                }
            }
        }
        ?>

        <?php if ($success): ?>
            <div class="success">
                <strong>Success!</strong> Your registration was successful. Welcome aboard!
            </div>
        <?php endif; ?>

        <?php if (!empty($errors) && isset($errors['file'])): ?>
            <div class="error-alert">
                <strong>Error:</strong> <?php echo htmlspecialchars($errors['file']); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Full Name <span style="color: red;">*</span></label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($formData['name']); ?>"
                    placeholder="Enter your full name">
                <?php if (isset($errors['name'])): ?>
                    <div class="error-message"><?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email Address <span style="color: red;">*</span></label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($formData['email']); ?>"
                    placeholder="Enter your email address">
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password <span style="color: red;">*</span></label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
                <small>
                    Password must contain: 8+ characters, 1 uppercase letter, 1 number, 1 special character (!@#$%^&*)
                </small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password <span style="color: red;">*</span></label>
                <input type="password" id="confirm_password" name="confirm_password"
                    placeholder="Confirm your password">
                <?php if (isset($errors['confirm_password'])): ?>
                    <div class="error-message"><?php echo $errors['confirm_password']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>