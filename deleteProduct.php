<?php

    include 'dbConnection.php';

    $conn = getDatabaseConnection();
    $sql = "DELETE FROM om_product WHERE productId = " . $_GET['productId'];
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    header("Location:admin.php");

?>