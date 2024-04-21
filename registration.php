<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Attendance portal </title>
    <link rel="icon" type="image/png" sizes="128x128" href="https://img.icons8.com/stickers/100/test-account.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        /* Centering the form */
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        
        /* Fullscreen background image */
        body {
            background-image: url("./login-bg.png");
            background-size: cover;
            background-position: center;
        }

        /* Styles for the form */
        .login__Form {
            max-width: 470px;
            width: 100%;
            padding: 15px 70px;
            background-color: transparent;
            border: 1px solid white;
            border-radius: 5px;
            box-shadow: 0 0 30px rgba(0, 0, 0,0.3);
            backdrop-filter: blur(3px);
            border-radius: 5%;
        }

        .login__title {
            text-align: center;
            margin-top : 20px;
            margin-bottom: 20px;
            color: white;
            font-family: "Garamond (serif)";
        }

        .login__inputs {
            margin-bottom: 20px;
            align-items:center;
        }

        .form-group {
            position: relative;
            margin-bottom: 10px;
        }

        .form-control {
            padding-right: 40px;
            background-color: transparent;
            color: white;
            border: 1px solid white;
            border-radius: 100px;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .form-control::placeholder {
            color: white;
        }

        .form-control:hover::placeholder {
            color: orange;
        }

        .form-control:focus + .icon {
            color: orange;
        }

        .form-control + .icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: white;
        }

        .login__button {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: white;
            color: black;
            font-size: 16px;
            border-radius: 100px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login__button:hover {
            background-color: wheat;
        }

        .login__register {
            text-align: center;
            margin-top: -142px;
            color: yellow;
            position: relative;
            z-index : 1;
        }

        .login__register p {
            margin: 0;

        }

        .login__register a {
            color: white;
            text-decoration: none;
        }
        .login__register a:hover {
            color: white;
            text-decoration: underline;
        }
        .not-registered-glow {
            text-shadow: 2px 1px #008080; /* Add your desired shadow properties here */
        }


    </style>
</head>
<body>
    <!-- Body content -->
    <div class="container">
        <form action="registration.php" class="login__Form" method="post">
            <h1 class="login__title">Register</h1>
            <?php
            // Include database connection
            require_once "database.php";

            // Check if the submit button is clicked
            if (isset($_POST["submit"])) {
                $fullName = $_POST["fullname"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $passwordRepeat = $_POST["repeat_password"];
                $adminKeyInput = $_POST["admin_key"]; // Retrieve admin key input

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $errors = array();

                // Check if all fields are filled
                if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat) OR empty($adminKeyInput)) {
                    array_push($errors, "All fields are required");
                }

                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }

                // Check password length
                if (strlen($password) < 8) {
                    array_push($errors, "Password must be at least 8 characters long");
                }

                // Confirm password match
                if ($password !== $passwordRepeat) {
                    array_push($errors, "Password does not match");
                }

                // Verify admin key
                if (!password_verify($adminKeyInput, $adminKey)) {
                    array_push($errors, "Invalid Admin key");
                }

                // Check if there are any errors
                if (count($errors) > 0) {
                    foreach ($errors as  $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    // Insert user data into the database
                    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>You are registered successfully.</div>";
                    } else {
                        die("Something went wrong");
                    }
                }
            }
            ?>
            <div class="login__inputs">
                <div class="form-group">
                    <input type="text" class="form-control" name="fullname" placeholder=" Full Name" required>
                </div>

                <div class="form-group">
                    <div style="position:relative;">
                        <input type="email" class="form-control" name="email" placeholder="Email" style="padding-right: 40px;" required>
                        <i class="ri-mail-fill icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required id="registerPassword1">
                    <i class="ri-eye-fill password-toggle icon" onclick="togglePassword('registerPassword1')"></i>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="repeat_password" placeholder="Confirm Password" required id="registerPassword2">
                    <i class="ri-eye-fill password-toggle icon" onclick="togglePassword('registerPassword2')"></i>
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" name="admin_key" id="adminKeyInput" placeholder="Authentication Key" required>
                    <i class="ri-eye-fill password-toggle icon" onclick="togglePassword('adminKeyInput')"></i>
                </div>
                <br>

                <div class="form-btn">
                    <input type="submit" class="login__button" value="Register" name="submit">
                </div>

            </div>
        </form>
    </div>
    <div class="login__register"><p>Already Registered ? <a href="login.php">Login Here</a></p></div>

    <script>
        function togglePassword(inputId) {
            var passwordInput = document.getElementById(inputId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    

        function adjustRegisterPosition() {
            var registerDiv = document.querySelector('.login__register');
            var alertDiv = document.querySelector('.login__Form .alert');

            if (alertDiv && registerDiv) {
                var alertHeight = alertDiv.offsetHeight;
                registerDiv.style.marginTop = '-43px'; // Adjust the value as needed

                if (alertHeight > 0) {
                    registerDiv.classList.add('not-registered-glow'); // Apply the shadow class
                } 
                
                else {
                    registerDiv.classList.remove('not-registered-glow'); // Remove the shadow class
                }
            }
        }

        // Call the function when the page loads and whenever the window is resized
        window.addEventListener('load', adjustRegisterPosition);
        window.addEventListener('resize', adjustRegisterPosition);
    </script>
</body>
</html>
