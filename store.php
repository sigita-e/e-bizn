<?php
// Include db_connect file
require "database.php";

session_start();

	$statement = $pdo->prepare("select * from items");
	$statement->execute();
	$result = $statement->fetchAll();
	//var_dump($result);
	$array_err = "";
	$error_id = 0;

class DeleteAllData
{
    public static function deleteAll($pdo)
    {
        $statement = $pdo->prepare("delete from items;");
        $statement->execute();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

if ( isset ($_GET['delete_all'])  ) {
	DeleteAllData::deleteAll($pdo);
	header("location: store.php");
	}

if ( isset ($_GET['retrieve_all'])  ) {

		$url = '127.0.0.1/api/all_products.php';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $string = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($string);

		//print_r( $data);
		DeleteAllData::deleteAll($pdo);

	foreach ($data as $product) { 
	
		$sql = "INSERT INTO items (id, name, description, price, qtyLeft) VALUES (:id, :name, :description, :price, :qtyLeft)";

		if ($stmt = $pdo->prepare($sql)) {
			$stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
			$stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
			$stmt->bindParam(":description", $param_description, PDO::PARAM_STR);
			$stmt->bindParam(":price", $param_price, PDO::PARAM_STR);
			$stmt->bindParam(":qtyLeft", $param_qtyLeft, PDO::PARAM_STR);

			$param_id = $product->id;
			$param_name = $product->name;
			$param_description = $product->description;
			$param_price = $product->price;
			$param_qtyLeft = $product->stock;

        if ($stmt->execute()) {
			$last_id = $pdo->lastInsertId();
			} 
		}

    // Close statement
    unset($stmt);
	header("location: store.php");
	} //foreach end	


} //retrieve_all end
} //GET end

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if ( isset ($_POST['retrieve'])  ) {

		$url = '127.0.0.1/api/one_product.php?id='.$_POST['id'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);

        $string = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($string);

		if (!empty($data)) {
		
		$sql = 'UPDATE items SET qtyLeft = :qtyLeft WHERE id = '.$_POST['id'];
		
		if ($stmt = $pdo->prepare($sql)) {
			$stmt->bindParam(":qtyLeft", $param_qtyLeft, PDO::PARAM_STR);
			$param_qtyLeft = $data[0]->stock;
			$stmt->execute();
			}

			unset($stmt);
			header("location: store.php");
			$error_id = 0;

		} else { 
			$array_err = "Produkts vairs nav pieejams!"; 
			$error_id = $_POST['id'];
		}

	} //retrieve end

} //POST end

require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="container">
    <div class="row">
        <div class="dark_container col-12">
            <h1>Veikals</h1><br>

            <table class="table table-hover user_table">
                <thead>
                    <tr>
                      
                        <th scope="col">Nosaukums</th>
                        <th scope="col">Apraksts</th>
						<th scope="col">Cena</th>
                        <th scope="col">Atlikums noliktava</th>
						<th scope="col"></th>

                    </tr>
                </thead>
				<tbody>
						<?php foreach ($result as $item) { ?>
                        <tr>       
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['description']; ?></td>
								<td><?php echo $item['price']; ?></td>
								<td><?php echo $item['qtyLeft']; ?>
								<div class="help-block salary_table">
									<?php 
				
										if ($item['id'] == $error_id) {
											echo $array_err;
										}
									?>
									</div></td> 
								<td>
									<input hidden type="text" name="id" value=<?php echo $item['id']; ?>>
								<button type="submit" class="btn btn-danger uppercase" name="retrieve">Atjaunot atlikumu</button></td>
						</form>
                        </tr>
						 <?php }; ?>

                </tbody>
            </table>
			<!--<div class="help-block salary_table"><?= $array_err ?></div></td>-->
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
			<button type="submit" class="btn btn-success uppercase" name="retrieve_all" >Iegut visu</button>
			<button type="submit" class="btn btn-danger uppercase" name="delete_all" >Dzest visu</button>
			<a href="index.php" class="btn btn_logout uppercase">Atgriezties</a>
			</form>
			
    </div>
</main>

					
<!-- javascript versija datu attelosanai

<td id="visi"></td>
<script>
var obj, dbParam, xmlhttp, myObj, x, txt = "";
obj = { "table":"customers", "limit":10 };
dbParam = JSON.stringify(obj);
xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    myObj = JSON.parse(this.responseText);
    for (x in myObj) {
       txt += myObj[x].name;
	   txt += myObj[x].description;
	   txt += myObj[x].price;
	   txt += myObj[x].stock + "<br>";
    }
    document.getElementById("visi").innerHTML = txt;
  }
};
xmlhttp.open("GET", "api/all_products.php?x=" + dbParam, true);
xmlhttp.send();
</script>
-->


<?php
	
require "footer.php";
?>

</body>
</html>