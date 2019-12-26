<?php

// Include db_connect file
require "database.php";

// Define variables and initialize with empty values
$password = $email = "";
$login_err = $lg_email_err = $lg_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //when user clicks Login button
        require "login.php";
}

require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="main_container">
    <div class="row">
        <div class="form_container col-10 offset-1 col-lg-6 offset-lg-3">

            <div class="light_form">
                <section class="inner_form" id="login_form">
                    <h1>Autorizacija</h1>

                    <br>
                    <hr>
                    <br>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div <?php echo (!empty($lg_email_err)) ? "has-error" : ""; ?>>
                            <label for="email">Epasts<span>*</span><span class="icon"><img src="images/icon1.png"></span></label>
                            <input type="email" name="email" id="email" value="<?= $email ?>">
                            <span class="help-block"><?= $lg_email_err ?></span>
                        </div>
                        <div <?php echo (!empty($lg_password_err)) ? "has-error" : ""; ?>>
                            <label for="password">Parole<span>*</span><span class="icon"><img src="images/icon2.png"></span></label>
                            <input type="password" name="password" id="password"><br>
                            <span class="help-block"><?= $lg_password_err ?></span>
                            <span><?= $login_err ?></span>
                        </div>
                        <br>
                        <button class="btn uppercase btn_blue" name="login">Ienakt</button>
						<a href="store.php" class="btn btn-success uppercase">Uz veikalu</a>

                    </form>
                </section>

            </div>
        </div>
    </div>
</main>

<?php
require "footer.php";
?>

</body>
</html>


