<?php
    
    session_start();

    include 'dbConnection.php';
    
    $conn = getDatabaseConnection("ottermart");
    
    $userName = $_POST['username'];
    $password = sha1($_POST['password']);
    
    //avoid single quotes to prevent injection 
    $sql = "SELECT *
            FROM om_admin
            WHERE username = :username
            AND   password = :password";
            
    $np = array();
    $np[":username"] = $userName;
    $np[":password"] = $password;
            
    $stmt = $conn->prepare($sql);
    $stmt->execute($np);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);//expecting one single record "fetch vs fetchAll"
    
    if (empty($record)) {
        $_SESSION['incorrect'] = true;
        header("Location:index.php");
    } else {
        echo $record['firstName'] . " " .$record['lastName'];
        $_SESSION['incorrect'] = false;
        $_SESSION['adminName'] = $record['firstName'] . " " .$record['lastName'];
        header("Location:admin.php");
    }
    

?>