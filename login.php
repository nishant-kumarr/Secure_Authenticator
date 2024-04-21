<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location:./index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Attendance portal </title>
    <!-- Link to the remixicon CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="loginbs.css">
    <link rel="icon" type="image/png" sizes="128x128" href="https://img.icons8.com/stickers/100/test-account.png">

</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    $_SESSION["user"] = "yes";
                    header("Location: ./index.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }
        ?>

        <div class="login__wrapper">
            <div class="login__container">
                <div class="login__title">
                    <h1 style="font-family: Garamond, (serif);">Login</h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-10 col-md-4 col-lg-10">

                        <form action="login.php" method="post" class="login__Form">
                            <div class="form-group">
                                <input type="email" placeholder="Email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Password" name="password" class="form-control" id="loginPassword">
                                <i class="ri-eye-fill icon" onclick="togglePassword('loginPassword')"></i>
                            </div>

                            <div class="form-btn">
                                <input type="submit" value="Login" name="login" class="login__button" class="btn btn-primary">
                            </div>
                        </form>
                        <div class="login__register">
                            <p class="not-registered">Not registered yet ? <a href="registration.php" class="register-link"> Register Here</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword(inputId) {
            var passwordInput = document.getElementById(inputId);
            var icon = document.querySelector('#' + inputId + ' + .icon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove('ri-eye-fill');
                icon.classList.add('ri-eye-off-fill');
            } else {
                passwordInput.type = "password";
                icon.classList.remove('ri-eye-off-fill');
                icon.classList.add('ri-eye-fill');
            }
        }
    </script>
</body>

</html>
