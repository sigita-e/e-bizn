<?php 
session_start();
		try{
			include '../database.php';
			$method_name=$_SERVER["REQUEST_METHOD"];

			if($_SERVER["REQUEST_METHOD"] == 'GET')
			{


				$objectArray = array();
				$sql = 'SELECT * FROM products';
				$result = $pdo->query($sql);
					
				if ($result->rowCount() > 0) {
					foreach ($result as $row) {
						$object = new stdClass();
						$object->id = $row["id"];
						$object->name = $row["name"];
						$object->description = $row["description"];
						$object->price = $row["price"];
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