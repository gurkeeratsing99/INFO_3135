<?php
$target_dir = "../images/";

// Retrieve POST parameters with appropriate filtering
$product_id = filter_input(INPUT_POST, 'productId', FILTER_DEFAULT);
$file_name = filter_input(INPUT_POST, 'existingImage', FILTER_DEFAULT);
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$product_code = filter_input(INPUT_POST, 'product_code', FILTER_DEFAULT);
$action = filter_input(INPUT_POST, 'action', FILTER_DEFAULT);

// Clean the file name by removing the target directory path
$file_name = str_replace($target_dir, '', $file_name);
$target_file = $target_dir . basename($file_name);

// Flag to indicate if the upload should proceed
$uploadOk = 1;

if (isset($_POST["submitPhotoBtn"])) {

    // Attempt to upload the file
    if ($uploadOk === 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            // Redirect to the index with parameters
            header("Location: index.php?action=$action&product_id=$product_id&category_id=$category_id&product_code=$product_code");
            exit;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
