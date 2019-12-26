<?php

//Registration process, inserts info into the database

// Validate name
if (empty(trim($_POST["name"]))) {
    $name_err = "Lūdzu ievadiet nosaukumu!";
} else {
    $sql = "SELECT name FROM products WHERE name = :name";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":name", $param_email, PDO::PARAM_STR);
        $param_email = trim($_POST["name"]);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $name_err = "Šāds produkts jau eksistē!";
            } else {
                $name = trim($_POST["name"]);
            }
        } else {
            $register_err =  "Kaut kas nogāja greizi ar nosaukumu. Lūdzu mēģiniet atkal nedaudz vēlāk!";
        }
    }
    unset($stmt);
}

// Validate description
if (empty(trim($_POST["description"]))) {
    $description_err = "Lūdzu ievadiet aprakstu!";
} else {
    $description = trim($_POST["description"]);
}

// Validate price
if (empty(trim($_POST["price"])) || is_numeric(trim($_POST["price"])) == null ) {
    $price_err = "Lūdzu ievadiet korektu cenu!";
} else {
    $price = trim($_POST["price"]);
}

// Validate stock
if (empty(trim($_POST["stock"])) || ctype_digit(trim($_POST["stock"])) == null) {
    $stock_err = "Lūdzu ievadiet korektu atlikumu!";
} else {
    $stock = trim($_POST["stock"]);
}


if ( !empty($name_err) || !empty($description_err) || !empty($price_err) || !empty($stock_err) ) {
    $register_err = "Pievienošana nebija veiksmīga. Lūdzu mēģiniet atkal!";
}

// Check input errors before inserting in database
if ( empty($name_err) && empty($description_err) &&  empty($price_err) &&  empty($stock_err) ) {

    // Prepare an insert statement
    $sql = "INSERT INTO products (name, description, price, stock) VALUES (:name, :description, :price, :stock)";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $param_description, PDO::PARAM_STR);
        $stmt->bindParam(":price", $param_price, PDO::PARAM_STR);
        $stmt->bindParam(":stock", $param_stock, PDO::PARAM_STR);

        $param_name = $name;
        $param_description = $description;
        $param_price = round( $price, 2);
        $param_stock = $stock;

        if ($stmt->execute()) {
            $success_msg = "Produkta pievienošana veiksmīga!";	
			$last_id = $pdo->lastInsertId();
        } else {
            $register_err = "Kaut kas nogāja greizi. Lūdzu mēģiniet atkal nedaudz vēlāk!";
        }
    }

    // Close statement
    unset($stmt);


}

// Close connection
unset($pdo);
