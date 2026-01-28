<?php
// public/login.php
require_once '../config/db.php';
require_once '../includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrfToken($_POST['csrf_token']);
    
    $login = trim($_POST['login']); // can be username or email
    $password = $_POST['password'];
    
    if (empty($login) || empty($password)) {
        $error = "Please enter username/email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$login, $login]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    }
}

require_once '../includes/header.php';
?>

<div class="auth-container fade-in">
    <div style="text-align: center; margin-bottom: 2rem;">
        <i class="fa-solid fa-layer-group" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"></i>
        <h2>Welcome Back</h2>
        <p style="color: var(--text-gray);">Enter your details to access the system</p>
    </div>

    <?php if($error): ?>
        <div class="alert" style="color: #fca5a5; background: rgba(239, 68, 68, 0.1); padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid rgba(239, 68, 68, 0.2);">
            <i class="fa-solid fa-triangle-exclamation"></i> <?php echo h($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        
        <div class="form-group">
            <label class="form-label">Username or Email</label>
            <input type="text" name="login" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%;">
            <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
        </button>

        <p style="text-align: center; margin-top: 1.5rem; color: var(--text-gray); font-size: 0.9rem;">
            Don't have an account? <a href="register.php" style="color: var(--primary); text-decoration: none;">Sign up</a>
        </p>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
