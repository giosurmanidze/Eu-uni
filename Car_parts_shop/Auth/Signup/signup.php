<?php
require '../../connection.php';
require '../../Layouts/GuestLayout.php';

$errors = array();
$name = $email = $password = $password_confirmation = '';
$url = '';
if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
    }

    if (empty($password_confirmation)) {
        $errors['password_confirmation'] = 'Password confirmation is required';
    } elseif ($password !== $password_confirmation) {
        $errors['password_confirmation'] = 'Password confirmation does not match';
    }

    // If there are no validation errors, insert the data into the database
    if (empty($errors)) {
        // Insert the data into the database
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        $url = "../../Products/Products.php";
        if (mysqli_query($conn, $sql)) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<form class="bg-white block p-4 w-[400px] rounded-md shadow-md" method="post" action="<?php echo empty($errors) ? $url : ''; ?>">
    <p class="text-xl leading-7 font-semibold text-center text-black">Sign in to your account</p>
    <div class="relative">
        <input
                placeholder="name"
                name="name"
                type="text"
                class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                value="<?=$name?>"
        >
        <?php if(isset($errors['name'])): ?>
            <p class="text-red-700"><?=$errors['name']?></p>
        <?php endif; ?>
    </div>
    <div class="relative">
        <input
                placeholder="email"
                name="email"
                type="email"
                class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                value="<?=$email?>"
        >
        <?php if(isset($errors['email'])): ?>
            <p class="text-red-700"><?=$errors['email']?></p>
        <?php endif; ?>
    </div>
    <div class="relative">
        <input
                value="<?= $password?>"
                class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                placeholder="password"
                name="password"
                type="password"
        />
        <?php if(isset($errors['password'])): ?>
            <p class="text-red-700"><?=$errors['password']?></p>
        <?php endif; ?>
    </div>
    <div class="relative">
        <input
                placeholder="password confirmation"
                name="password_confirmation"
                type="password"
                class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                value="<?=$password_confirmation?>"
        >
        <?php if(isset($errors['password_confirmation'])): ?>
            <p class="text-red-700"><?=$errors['password_confirmation']?></p>
        <?php endif; ?>
    </div>
    <button class="submit bg-indigo-600 text-white font-medium py-2 px-5 rounded-md w-full uppercase mt-[25px]" type="submit" name="send">
        Sign in
    </button>
    <p class="signup-link text-gray-700 text-sm text-center mt-[25px]">
        Are You Registered?
        <a href="../Login/Login.php" class="underline">Sign in</a>
    </p>
</form>

