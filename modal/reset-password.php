<?php
// session_start();
include_once('includes/session.php');


if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    header("Location: password-reset.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <?php
    if (isset($_SESSION['message'])) {
        echo '<p>' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }
    ?>
    <form action="reset-password-action.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <label for="new-password">Enter your new password:</label>
        <input type="password" name="new-password" required>
        <button type="submit" name="reset-password-submit">Reset Password</button>
    </form>
</body>
</html>
