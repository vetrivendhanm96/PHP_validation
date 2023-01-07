<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // validation for all
    function validate($str)
    {
        return trim(htmlspecialchars($str));
    }

    if (empty($_POST['name'])) {
        $nameError = 'You should fill name!';
    } else {
        $name = validate($_POST['name']);
        if (!preg_match('/^[a-zA-Z0-9\s]{1, 32}$/', $name)) {
            $nameError = 'Name field can contain alphanumeric only!';
        }
    }

    if (empty($_POST['email'])) {
        $emailError = 'Please enter your email!';
    } else {
        $email = validate($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Invalid Email';
        }
    }

    // ternary operator -- condition ? true : false
    $desc = !empty($_POST['desc']) ? validate($_POST['desc']) : "";


    if (empty($_POST['gender'])) {
        $genderError = 'Kindly choose your gender!';
    } else {
        $gender = $_POST['gender'];
    }

    // remember validation
    $remember = !empty($_POST['remember']) ? !filter_var($_POST['remember'], FILTER_VALIDATE_BOOLEAN) : "";

    if (empty($nameError) && empty($emailError) && empty($genderError)) {
        // valid form data
        echo "Your form has been submitted successfully";
        echo "<br>
            Name: $name;
            Email: $email;
            Description: $desc;
            Gender: $gender;
        ";
        exit();
    }
}

?>

<html>

<head>
    <title> User Input Forms </title>
    <style type="text/css">
        .error {
            color: red;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- isset() -->
    <form method="POST" action="">

        Name: <input type="text" name="name" value="<?php if (isset($name)) echo $name; ?>">
        <span class="error"><?php if (isset($nameError)) echo $nameError; ?></span><br>

        Email: <input type="text" name="email" value="<?php if (isset($email)) echo $email; ?>">
        <span class="error"><?php if (isset($emailError)) echo $emailError; ?></span><br>

        Password: <input type="password" name="password" value="<?php if (isset($password)) echo $password; ?>">
        <span class="error"><?php if (isset($passwordError)) echo $passwordError; ?></span><br>
        Description:
        <textarea name="desc"><?php if (isset($desc)) $desc; ?></textarea><br>

        Gender:
        Male:
        <input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender === 'male') echo "checked"; ?>><br>

        Female:
        <input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender === 'female') echo "checked"; ?>><br>

        <span class="error"><?php if (isset($genderError)) echo $genderError; ?></span><br>

        Remember Me <span style="color:red">*</span>:
        <input type="checkbox" name="remember" required><br>
        <input type="submit" name="submit">
    </form>
</body>

</html>