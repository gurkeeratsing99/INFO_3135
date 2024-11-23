<?php
header('Pragma: no-cache');
include '../view/header.php';
include '../model/database.php';
include '../model/product_db.php';
include '../model/category_db.php';

// Check if the request method is POST or GET
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT)
        ?? filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT)
        ?? filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS)
        ?? filter_input(INPUT_GET, 'code', FILTER_SANITIZE_SPECIAL_CHARS);

    // Display message only for GET requests
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo "<h2 style='text-align:center;'>Product has been updated...</h2>";
    }
}
//get product info
$product = get_product($product_id);
$product_category = get_category_name($category_id);
$all_categories = get_categories();

//get product existing image
$image_filename = '../images/' . $code . '.png';
$image_alt = 'Image: ' . $code . '.png';

?>

<main>
    <h1>Edit Product</h1>
    <div class="outer_Prod">
        <div class="left_Pord">
            <form action="index.php" method="post" id="edit_product_form" onsubmit="return confirmUpdate();">
                <input type="hidden" name="action" value="edit_product">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">

                <label>Category:</label>
                <select name="category_id" id="categorySelect">
                    <?php foreach ($all_categories as $category) : ?>
                        <option value="<?php echo $category['categoryID']; ?>"
                            <?php echo ($category['categoryID'] == $category_id) ? 'selected' : ''; ?>>
                            <?php echo $category['categoryName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <br>

                <label>Code:</label>
                <input type="text" name="code" value="<?php echo $product['productCode'] ?>" />

                <br>

                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $product['productName'] ?>" />
                <br>

                <label>List Price:</label>
                <input type="text" name="price" value="<?php echo $product['listPrice'] ?>" />
                <br>



                <label>&nbsp;</label>
                <input type="submit" value="Edit Product" />
                <br>

            </form>
        </div>

        <! -- Displaying the existing image -->
            <div class="right_Pord">
                <img class="prod_img" src="<?php echo $image_filename; ?>"
                    alt="<?php echo $image_alt; ?>" />

                <! -- form to upload images -->

                    <form action="upload_image.php" method="post" enctype="multipart/form-data">
                        <label for="file">Update Product Image</label>
                        <input type="file" name="fileToUpload" id="fileToUpload" onclick="uploadShow()">
                        <input type="hidden" name="action" value="edit_product">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                        <input type="hidden" name="product_code" value="<?php echo $code; ?>">
                        <input type="hidden" name="existingImage" value="<?php echo $image_filename; ?>">
                        <input type="hidden" name="productId" value="<?php echo $product_id; ?>">
                        <input type="submit" style="display: none;" value="Upload Image" name="submitPhotoBtn" onclick="return confirmDeletion();">
                    </form>
                    <p class="last_paragraph">
                        <a href="index.php?action=list_products">View Product List</a>
                    </p>
            </div>
    </div>



</main>

<script>
    // Confirmtion before updating the product information
    function confirmUpdate() {

        var categorySelect = document.getElementById('categorySelect');
        var category = categorySelect.options[categorySelect.selectedIndex].text;
        var code = document.getElementsByName('code')[0].value; // Access the first element
        var name = document.getElementsByName('name')[0].value; // Access the first element
        var price = document.getElementsByName('price')[0].value; // Access the first element

        var message = "Are you sure you want to update this product?\n\n" +
            "Category: " + category + "\n" +
            "Code: " + code + "\n" +
            "Name: " + name + "\n" +
            "Price: " + price;

        return confirm(message);
    }

    // Highlighting new image name and showing upload button
    function uploadShow() {
        let uploadBtn = document.getElementsByName('submitPhotoBtn')[0];
        uploadBtn.style.display = "block";


        let uploadBtnTxt = document.getElementById('fileToUpload');
        uploadBtnTxt.style.fontStyle = "italic";
        uploadBtnTxt.style.backgroundColor = "yellow";

    }
    
    // Confirmtion before updating the photo
    function confirmDeletion() {
        return confirm("Are you sure you want to udpate the exisiting photo?");
    }
</script>


<?php include '../view/footer.php'; ?>