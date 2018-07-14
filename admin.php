<?php
session_start();

if (!isset($_SESSION['adminName'])) {
    header("Location:login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            #first {
                height: 800px;
                overflow: auto;
            }
            .container input{
                margin-right:20px;
            }

        </style>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    </head>

    <title>Admin Main Page</title>

    <body class='container'>
        <div  class="text-center">
            <h1>Admin Main Page</h1>
            <h4>Welcome Administrator <i><?= $_SESSION['adminName'] ?></i></h4><hr>
        </div>
        <div id="first" class='container'>

            <?php

            function displayAllProducts() {
                include "dbConnection.php";
                $conn = getDatabaseConnection("ottermart");

                $sql = "SELECT * FROM om_product ORDER BY productId";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $records;
            }

            $records = displayAllProducts();
            echo "<div class='container' >";

            echo "<div class='span2' >";
            echo "<form action='addProduct.php'>";
            echo "<input type='submit' class='btn btn-success' id='beginning' name='addProduct' value='Add Product'/>";
            echo "<input type='submit' style='float:right;'
              class='btn btn-warning' id='beginning' name='logOut' value='  Log Out  '/>";
            echo "</form>";

            echo "</div>";

            echo "<table class='table table-hover'>";
            echo "<thead>
            <tr>
               <th scope = 'col'>ID</th>
               <th scope = 'col'>Name</th>
               <th scope = 'col'>Description</th>
               <th scope = 'col'>Price</th>
               <th scope = 'col'>Udate</th>
               <th scope = 'col'>Remove</th>
            </tr>
          </thead>";
            echo "</tbody>";

            foreach ($records as $record) {
                echo "<tr>";
                echo "<td>" . $record['productId'] . "</td>";
                echo "<td>" . $record['productName'] . "</td>";
                echo "<td>" . $record['productDescription'] . "</td>";
                echo "<td>" . "$" . $record['price'] . "</td>";
                echo "<td><a class='btn btn-primary' href='updateProduct.php?productId=" . $record['productId'] . "'>Update</a></td>";

                echo '<form action="deleteProduct.php" method="get" onsubmit="return confirmDelete()">';
                echo "<input type='hidden' name='productId' value=" . $record['productId'] . ">";
                echo "<td><input type='submit' class='btn btn-danger' name='deleteProduct' value='Remove'></td>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            ?>

            <script>
                function confirmDelete() {
                    return confirm("Are you sure you want to delete the product?");
                }
            </script>

            <?php if ($_SESSION['prodAdded'] != '') {
                $_SESSION['prodAdded'] .= ": Has been succesfully added";
            } ?>
            <p id="last" style="padding-left: 30px; color:magenta;">
            <?= $_SESSION['prodAdded']; ?>
            </p>

        </div>
    </body>

    <?php
    
    if ($_SESSION['prodAdded'] != '') {
        echo"<script>
        var height = 0;
        $('div').each(function (i, value) {
            height += parseInt($(this).height());
        });

        height += '';

        $('div').animate({scrollTop: height});
    </script>";
    }

    $_SESSION['prodAdded'] = '';
    ?>

</html>

