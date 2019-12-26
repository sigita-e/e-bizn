<?php

// Include db_connect file
require "database.php";

// Define variables and initialize with empty values
$name = $description = $price = $stock = "";
$name_err = $description_err = $price_err = $stock_err = $register_err = $success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     //when user clicks Add button
        require "add_product.php";
}

require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="main_container">
    <div class="row">
    <div class="register_form_container col-10 offset-1 col-lg-6 offset-lg-3">
        <div class="light_form">

                <section class="inner_form" id="register_form">
                    <h1>Produkta pievienosana</h1>
                    <br><hr><br>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div <?php echo (!empty($name_err)) ? "has-error" : ""; ?>>
                            <label for="name">Nosaukums<span>*</span></label>
                            <input type="text" name="name" id="name" value="<?= $name ?>">
                            <span class="help-block"><?= $name_err ?></span>
                        </div>

                        <div <?php echo (!empty($description_err)) ? "has-error" : ""; ?>>
                            <label for="description">Apraksts<span>*</span></label>
                            <input type="text" name="description" id="description" value="<?= $description ?>">
                            <span class="help-block"><?= $description_err ?></span>
                        </div>

                        <div <?php echo (!empty($price_err)) ? "has-error" : ""; ?>>
                            <label for="price">Cena<span>*</span></label>
                            <input type="text" name="price" id="price" value="<?= $price ?>">
                            <span class="help-block"><?= $price_err ?></span>
                        </div>

                        <div <?php echo (!empty($stock_err)) ? "has-error" : ""; ?>>
                            <label for="stock">Atlikums<span>*</span></label>
                            <input type="text" name="stock" id="stock" value="<?= $stock ?>">
                            <span class="help-block"><?= $stock_err ?></span>

							<span><?= $register_err ?></span>
                            <span id="success_msg"><?= $success_msg ?></span>
                        </div>
				
                        <br>
                        <button class="btn uppercase btn_blue" name="register">Pievienot</button>
                        <a href="welcome_admin.php" class="btn btn_red uppercase">Atgriezties</a>
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
