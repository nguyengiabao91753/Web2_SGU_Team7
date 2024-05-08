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
        <!-- Signup Form -->

        <div class="form login">
            <div class="form-content">
                <header>Signup</header>
                <form action="../../backend/User.php" method="post">
                    <div class="field input-field">
                        <input type="text" placeholder="FirstName" name="firstname" class="input" required>
                    </div>
                    <div class="field input-field">
                        <input type="text" placeholder="LastName" name="lastname" class="input" required>
                    </div>
                    <div class="field input-field">
                        <input type="email" placeholder="Email" name="email" class="input" required>
                    </div>
                    <div class="field input-field">
                        <input type="number" placeholder="Phone" name="phone" class="input" required>
                    </div>
                    <div class="field input-field">
                        <input type="text" placeholder="Address" name="address" class="input" required>
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Create password" name="password" class="password" required>
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Confirm password" class="password" required>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="field button-field">
                        <input type="submit" class="log" name="clientsignup" value="Sign Up">
                    </div>
                </form>

                <div class="form-link">
                    <span>Already have an account? <a href="login.php" class="login-link">Login</a></span>
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
    </section>

    <!-- JavaScript -->
    <script src="../js/login.js"></script>
</body>

</html>