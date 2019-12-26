<?php 
include '../database.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	echo 'nav';
}

		try{
			
			$method_name=$_SERVER["REQUEST_METHOD"];

			if($_SERVER["REQUEST_METHOD"] == 'POST')
			{
			
				$objectArray = array();
				$sql = 'SELECT id, stock FROM products where id = '.$id;
				$result = $pdo->query($sql);
					
				if ($result->rowCount() > 0) {
					foreach ($result as $row) {
						$object = new stdClass();
						//$object->id = $row["id"];
						$object->stock = $row["stock"];
						$objectArray[] = $object;
					}
				}
 

				//$data=array("status"=>"1","message"=>"success","result"=>$objectArray);
						
				echo json_encode($objectArray);
				
				}
			
		}
		catch(Exception $e) {
			 echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
?>