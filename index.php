<?php
require 'connection.php';

if(isset($_REQUEST['myForm'])){
  $name = $_POST['name'];
  $category = $_POST['cate'];
  $price = $_POST['price'];
  $desc = $_POST['message'];
  $image_file = $_FILES['image']['name'];
  $type = $_FILES['image']['type'];
  $size = $_FILES['image']['size'];
  $temp = $_FILES['image']['tmp_name'];
  $path = "upload/$image_file";
  
  // Validate the inputs
  if(empty($name)){
    $errorMsg = "Please enter the product name.";
  } elseif(!in_array($type, ['image/jpeg', 'image/png', 'image/gif', 'image/avif'])){
    $errorMsg = "Please select a valid image file (JPEG, PNG, GIF, AVIF).";
  } elseif ($size > 5000000) { // Example: Limit file size to 5MB
    $errorMsg = "File size should not exceed 5MB.";
  } else {
    if (!file_exists($path)) {
      move_uploaded_file($temp, $path); // Move uploaded file to the directory
    } else {
      $errorMsg = "File already exists, choose another one.";
    }
  }

  try {
    // If there's no error, insert into the database
    if (!isset($errorMsg)) {
      // Use prepared statements to prevent SQL injection
      $stmt = $db->prepare("INSERT INTO albums (name, category, price, image, description) VALUES (:name, :category, :price, :image, :description)");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':category', $category);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':image', $image_file);
      $stmt->bindParam(':description', $desc);
      $stmt->execute();
      
      echo "<script>alert('Data Inserted Successfully!');</script>";
    } else {
      echo "<script>alert('$errorMsg');</script>";
    }
  } catch (PDOException $e) {
    $errorMsg = $e->getMessage();
    echo "<script>alert('$errorMsg');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Admin panel</title>
    <style>
        /* Container padding */
           /* Container padding */
           .container {
            padding: 0 15px;
        }

        /* Navbar styles */
        .navbar {
            background: linear-gradient(to right, #007bff, #4da6ff);
        }

        /* Button Styles */
        .btn-custom-green {
            background: linear-gradient(to right, #4caf50, #66bb6a);
            color: white;
            font-size: 18px;
        }

        .btn-custom-red {
            background: linear-gradient(to right, #f44336, #ef5350);
            color: white;
            font-size: 18px;
        }

        .btn-custom-blue {
            background: linear-gradient(to right, #007bff, #4da6ff);
            color: white;
            font-size: 18px;
        }

        /* Modal styles */
        .modal-header {
            background: linear-gradient(to right, #007bff, #4da6ff);
            color: white;
        }

        /* List Styles */
        .product-list {
            list-style: none; /* Remove default list style */
            padding: 0; /* Remove padding */
            margin: 0; /* Remove margin */
        }

        .product-item {
            display: flex;
            align-items: center; /* Center items vertically */
            border: 1px solid #ddd; /* Border around each item */
            border-radius: 10px; /* Rounded corners */
            padding: 15px; /* Padding inside the item */
            margin-bottom: 15px; /* Space between items */
            background-color: #f8f9fa; /* Light grey background */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
        }

        .product-image {
            max-width: 100px; /* Set max width for images */
            margin-right: 20px; /* Space between image and text */
            border-radius: 8px; /* Round image corners */
        }

        .product-details {
            flex-grow: 1; /* Take up available space */
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 0; /* Remove margin */
        }

        .product-text {
            margin: 5px 0; /* Space between text elements */
        }

        /* Responsive adjustment */
        @media (max-width: 768px) {
            .product-item {
                flex-direction: column; /* Stack items on smaller screens */
                align-items: flex-start; /* Align items to the start */
            }

            .product-image {
                max-width: 100%; /* Full width on small screens */
                margin-bottom: 10px; /* Space below the image */
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./display.php">View Products</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
    <h1 class="text-center my-4">Products Details</h1>
    </div>
    <div class="container">
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
   Add Product
  </button> -->
  <button type="button" class="btn btn-custom-blue" data-bs-toggle="modal" data-bs-target="#myModal">Add Product</button>
        <button type="button" class="btn btn-custom-green">Manage Orders</button>
        <button type="button" class="btn btn-custom-red">View Reports</button>
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Products detail</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Form content inside the modal -->
          <form method="POST" enctype="multipart/form-data" id="myForm">
            <div class="mb-3">
              <label for="name" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="cate" class="form-label">Category</label>
              <input type="text" class="form-control" id="cate" name="cate" required>
            </div>
            <div class="mb-3">
              <label for="price" class="form-label">Price</label>
              <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image" required accept=".jpg,.jpeg,.png,.gif,.avif">
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Description</label>
              <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="myForm" form="myForm">Submit</button>
        </div>
      </div>
    </div>
  </div>
    </div>



<!--list of add products-->
<div class="row">
            <div class="col-12">
                <h2 class="text-center my-4">Product List</h2>
                <ul class="product-list">
                    <?php
                    // Fetch products from the database
                    $stmt = $db->prepare("SELECT * FROM albums");
                    $stmt->execute();
                    $products = $stmt->fetchAll();

                    foreach ($products as $product) {
                    ?>
                        <li class="product-item">
                            <img src="upload/<?= $product['image']; ?>" alt="<?= $product['name']; ?>" class="product-image">
                            <div class="product-details">
                                <h5 class="product-title"><?= $product['name']; ?></h5>
                                <p class="product-text"><strong>Category:</strong> <?= $product['category']; ?></p>
                                <p class="product-text"><strong>Price:</strong> $<?= $product['price']; ?></p>
                                <p class="product-text"><strong>Description:</strong> <?= $product['description']; ?></p>
                                <button class="btn btn-custom-red">Edit</button>
                                <button class="btn btn-custom-red">Delete</button>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>








    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>