<?php
session_start(); // Start the session

require '../connection.php';
require '../Layouts/GuestLayout.php';

$errors = array();
$email = $password = '';
$url = '';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Store the admin status in a session variable
            $_SESSION['is_admin'] = $user['isAdmin'];

            if (intval($user['isAdmin']) == 1) {
                $url = "./AdminPanel.php";
            } else {
                $errors['login_failed'] = 'You are not authorized to access this page.';
            }
        } else {
            $errors['login_failed'] = 'Invalid email or password';
        }
    }
}

?>

<form class="bg-white block p-4 w-[400px] rounded-md shadow-md" method="post" action="<?php echo empty($errors) ? $url : ''; ?>">
    <p class="text-xl leading-7 font-semibold text-center text-black">Sign in to your account</p>
    <?php if(isset($errors['login_failed'])): ?>
        <p class="text-red-700"><?=$errors['login_failed']?></p>
    <?php endif; ?>
    <div class="relative">
        <input
                placeholder="email"
                name="email"
                type="email"
                class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                value="<?php echo htmlspecialchars($email); ?>"
        >
        <?php if(isset($errors['email'])): ?>
            <p class="text-red-700"><?=$errors['email']?></p>
        <?php endif; ?>
    </div>
    <div class="relative">
        <input
                placeholder="password"
                name="password"
                type="password"
                class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                value="<?php echo htmlspecialchars($password); ?>"
        >
        <?php if(isset($errors['password'])): ?>
            <p class="text-red-700"><?=$errors['password']?></p>
        <?php endif; ?>
    </div>
    <button class="submit bg-indigo-600 text-white font-medium py-2 px-5 rounded-md w-full uppercase mt-[25px]" type="submit" name="login">
        Sign in
    </button>
</form>