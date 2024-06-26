<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Responsive Login and Signup Form </title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/login.css">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

</head>
<?php


?>
<script>
    <?php if (isset($_COOKIE['errlogin'])) : ?>
        alert('<?php echo $_COOKIE['errlogin']; ?>');
        <?php
        setcookie("errlogin", "", time() - 1, "/");
        ?>
    <?php endif; ?>
</script>

<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Login</header>
                <form action="../../backend/Login.php" method="post">
                    <div class="field input-field">
                        <input type="email" name="email" placeholder="Email" class="input">
                    </div>

                    <div class="field input-field">
                        <input type="password" name="password" placeholder="Password" class="password">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="form-link">
                        <a href="#" class="forgot-pass">Forgot password?</a>
                    </div>

                    <div class="field button-field">
                        <input type="submit" class="log" name="clientlogin" value="Login">
                    </div>
                </form>

                <div class="form-link">
                    <span>Don't have an account? <a href="signup.php" class=" signup-link">Signup</a></span>
                </div>
            </div>

            <div class="line"></div>

            <!-- <div class="media-options">
                    <a href="#" class="field facebook">
                        <i class='bx bxl-facebook facebook-icon'></i>
                        <span>Login with Facebook</span>
                    </a>
                </div> -->

            <div class="media-options">
                <a href="#" class="field google">
                    <img src="../images/icons/google-logo-6278331_640.png" alt="" class="google-img">
                    <span>Login with Google</span>
                </a>
            </div>

        </div>

        <!-- Signup Form -->

    </section>

    <!-- JavaScript -->
    <script src="../js/login.js"></script>
</body>

</html>