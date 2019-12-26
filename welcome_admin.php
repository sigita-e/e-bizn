<?php

session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    header("location: index.php");
    exit;
}

$user_email = $_SESSION["email"];
$user_id = $_SESSION["id"];

class Products
{
    //create Products object when reading data from database
    public $id;
    public $name;
    public $description;
    public $price;
    public $stock;

}

class ReadData
{
    //function to read data from Products table
    public static function readProductsTable($pdo)
    {
        $statement = $pdo->prepare("select * from products");
        $statement->execute();

        $products = $statement->fetchAll(PDO::FETCH_CLASS, "Products");
        return $products;
    }
}

class DeleteData
{
    public static function deleteProduct($pdo, $product_id)
    {
        $statement = $pdo->prepare("delete from products where id =:product_id;");
        $statement->bindParam(":product_id", $product_id, PDO::PARAM_STR);
        $statement->execute();
    }
}

class EditData
{
    public static function editPriceStock($pdo, $newPrice, $id, $newStock)
    {
        $statement = $pdo->prepare("UPDATE products SET price = round('$newPrice',2) , stock = '$newStock' WHERE id = '$id'");
        $statement->bindParam($id, $newPrice, $newStock, PDO::PARAM_STR);
        $statement->execute();

	}
}

require "database.php";

$products = ReadData::readProductsTable($pdo);

$price_err = "";
$stock_err = "";
$error_id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {



if ( isset ($_POST['delete'])  ) {
	DeleteData::deleteProduct($pdo, $_POST["product_id"]);
    header("location: welcome_admin.php");
}


	if ( isset ($_POST['newPrice']) || isset ($_POST['newStock']) ) {


	$newPrice = $_POST['newPrice'];
	$id = $_POST['product_id'];
	$newStock = $_POST['newStock'];
	

		if ( ($newPrice <= 0) || ($newStock < 0) || (ctype_digit($newStock) == null) ) {

			if ($newPrice <= 0 ) {
				$price_err = "Ludzu ievadi derigu cenu!";
				$error_id = $id;
			}

			if ($newStock < 0 || (ctype_digit($newStock) == null) ) {
				$stock_err = "Ludzu ievadi derigu skaitu!";
				$error_id = $id;
			}
		}
		else
		{
			EditData::editPriceStock($pdo, $newPrice, $id, $newStock);
			header("location: welcome_admin.php");
			$price_err = "";
			$stock_err = "";
			$error_id = 0;
		}	

	}


}


require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="container">
    <div class="row">
        <div class="dark_container col-12">

            <a href="logout.php" class="btn btn_logout uppercase" id="signout">Iziet</a>
            <h1>Noliktava</h1><br>

            <table class="table table-hover user_table">
                <thead>
                    <tr>
                      
                        <th scope="col">Nosaukums</th>
                        <th scope="col">Apraksts</th>
						<th scope="col">Cena</th>
                        <th scope="col">Atlikums</th>
						<th scope="col"></th>
						<th scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($products as $product) { ?>
                        <tr>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      
                                <td><?= $product->name ?></td>
                                <td><?= $product->description ?></td>

								<td><input type="text" name="newPrice" value="<?= $product->price ?>">
									<div class="help-block salary_table">
									<?php 
				
										if ($product->id == $error_id) {
											echo $price_err;
										}
									?>
									</div> 
									<input hidden type="text" name="product_id" value=<?= $product->id ?>>

                                <td><input type="text" name="newStock" value="<?= $product->stock ?>">
									<div class="help-block salary_table">
									<?php 
										if ($product->id == $error_id) {
											echo $stock_err;
										} 
										?>
									</div> 

									<td><button type="submit" class="btn btn-danger uppercase" value="calculate">Labot</button></td>
									<td><button type="submit" class="btn btn-danger uppercase" name="delete" id="delete">Dzest</button></td>
								
                                
								</form>
                        </tr>
						 <?php }; ?>
                </tbody>
            </table>

			<!--<div class="help-block salary_table"><?= $price_err ?></div></td>
			<div class="help-block salary_table"><?= $stock_err ?></div>-->

            <a href="add_form.php" class="btn btn-success uppercase">Pievienot</a>
                   
        </div>
    </div>
</main>

<?php
require "footer.php";
?>

</body>
</html>