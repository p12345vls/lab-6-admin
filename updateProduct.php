<?php 
     include 'dbConnection.php';
     
    if(isset($_GET['productId'])) {
        $product = getProductInfo();
    }
    
       function getProductInfo() {
        
        $conn = getDatabaseConnection();
        
        $sql = "SELECT * 
                FROM om_product
                WHERE productId=".$_GET['productId'];
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $record;
    }
    
     
    function getCategories($catId) {
        
        $conn = getDatabaseConnection();
        
        $sql = "SELECT catId, catName FROM om_category ORDER BY catName";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($records as $record) {
            echo "<option ";
            echo ($record["catId"] == $catId)? "selected": "";
            echo "value= '".$record["catId"] . "'>".$record['catName']."</option>";
        }
        
    }
    
    function updateProduct() {
    
    if (isset($_GET['updateProduct'])) {
        
        $conn = getDatabaseConnection();
        
        $sql = "UPDATE om_product
                SET productName = :productName,
                    productDescription = :productDescription,
                    productImage = :productImage,
                    price = :price,
                    catId = :catId 
                WHERE productId = :productId";
                
        $np = array();
        
        $np[":productName"] = $_GET['productName'];
        $np[":productDescription"] = $_GET['description'];
        $np[":productImage"] = $_GET['productImage'];
        $np[":price"] = $_GET['price'];
        $np[":catId"] = $_GET['catId'];
        $np[":productId"] = $_GET['productId'];
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($np);
        echo "<h2 style='color:green'; padding-left:'10px';>Product has been successfully updated</h2>";
    
    }
    
}
    
    

?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Product </title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    </head>
    <body>

        <div class='container'>
            <div class='well'>

                <h1> Update Product</h1>
                <form method="get">
                    <input type="hidden" name="productId" value="<?=$product['productId']?>"/>
                    <strong> Product name </strong>
                    <input type="text" class="form-control" value="<?=$product['productName']?>" name="productName"><br>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" rows="5" id="description" name="description"><?=$product['productDescription']?></textarea>
                    </div>
                    <strong>Price</strong><input type="text" class="form-control" name="price" value="<?=$product['price']?>" ><br>
                    <strong>Category</strong> <select name="catId" class="form-control" >
                        <option value="">Select One</option>
                        <?php getCategories($product['catId']); ?>
                    </select> <br />
                    <strong>Set Image Url</strong><input type = "text" name = "productImage" class="form-control" value="<?=$product['productImage']?>"><br>
                    <input type="submit" name="updateProduct"  class="btn btn-primary" value="Update Product">
                    <?=updateProduct()?>
                </form>
            </div>
        </div>

    </body>
</html>