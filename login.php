<?php
//Login process

// Check if email is empty
if (empty(trim($_POST["email"]))) {
    $lg_email_err = 'Lūdzu ievadiet epastu!';
} else {
    $email = trim($_POST["email"]);
}

// Check if password is empty
if (empty(trim($_POST["password"]))) {
    $lg_password_err = "Lūdzu ievadiet paroli!";
} else {
    $password = trim($_POST["password"]);
}

// Validate credentials
if (empty($lg_email_err) && empty($lg_password_err)) {
    // Prepare a select statement
    $sql = "SELECT email, password, role, id FROM users WHERE email = :email";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $param_email = trim($_POST["email"]);

        if ($stmt->execute()) {
            // Check if email exists, if yes then verify password
            if ($stmt->rowCount() == 1) {
                if ($row = $stmt->fetch()) {
                    $hashed_password = $row["password"];
                    if (password_verify($password, $hashed_password)) {
                        /* Password is correct, so start a new session and
                        save email to the session */
                        session_start();
                        $id = $row["id"];
                        $_SESSION["email"] = $email;
                        $_SESSION["id"] = $id;

                        // redirect to correct page based on user role
                        $role = $row["role"];
                        if($role == 'admin') {
                            header("location: welcome_admin.php");
                        } //else citas lomas var pievienot

                    } else {
                        // Display an error message if password is not valid
                        $lg_password_err = "Ievadītā parole nav pareiza!";
                    }
                }
            } else {
                // Display an error message if email doesn't exist
                $lg_email_err = "Konts ar šādu epasta adresi nav atrasts!";
            }
        } else {
            $register_err =  "Kaut kas nogāja greizi. Lūdzu mēģiniet vēlreiz!";
        }
    }

    // Close statement
    unset($stmt);
}

// Close connection
unset($pdo);

?>

