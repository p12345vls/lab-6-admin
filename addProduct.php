<?php
    
    if(isset($_GET['logOut'])){
        session_start();
        session_destroy();
        header('Location:login.php');
        
    } else {
        
session_start();
include 'dbConnection.php';
function getCategories() {
   

    $conn = getDatabaseConnection("ottermart");

    $sql = "Select catId, catName FROM om_category ORDER BY catName";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($records as $record) {
        echo "<option value='" . $record["catId"] . "'>" . $record['catName'] . "</option>";
    }
    
    if(isset($_GET['submitProduct'])) {
        $productName = $_GET['productName'];
        $productDescription = $_GET['description'];
        $productImage = $_GET['productImage'];
        $productPrice = $_GET['price'];
        $catId = $_GET['catId'];
        
        $sql = "INSERT INTO om_product
                (productName, productDescription, productImage, price, catId)
                VALUES (:productName, :productDescription,:productImage,:price,:catId)";
                
                $nameParameters = array();
                $nameParameters[':productName'] = $productName;
                $nameParameters[':productDescription'] = $productDescription;
                $nameParameters[':productImage'] = $productImage;
                $nameParameters[':price'] = $productPrice;
                $nameParameters[':catId'] = $catId;
                $conn = getDatabaseConnection("ottermart");
                //fetch or fetch all are used in select statement
                $stmt = $conn->prepare($sql);
                $stmt->execute($nameParameters);
                $_SESSION['prodAdded']=$_GET['productName'];;
                header('Location:admin.php');
    }
}
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Add a product </title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    </head>
    <body>

        <div class='container'>
            <div class='well'>

                <h1> Add a product</h1>
                <form >
                    <strong> Product name </strong> <input type="text" class="form-control" name="productName"><br>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                    </div>
                    <strong>Price</strong><input type="text" class="form-control" name="price"><br>
                    <strong>Category</strong> <select name="catId" class="form-control" >
                        <option value="">Select One</option>
                        <?php getCategories(); ?>
                    </select> <br />
                    <strong>Set Image Url</strong><input type = "text" name = "productImage" class="form-control"><br>
                  <input type="submit" name="submitProduct"  class="btn btn-primary" value="Add Product">

                </form>
            </div>
        </div>
    </body>
</html>