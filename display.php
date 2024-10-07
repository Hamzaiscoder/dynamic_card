<?php 
require 'connection.php';
$statement = "SELECT * FROM albums";
$result = $db->query($statement);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Images</title>
    <style>
        /* Body and background */
        body {
            background: linear-gradient(to bottom, #e6f7ff, #ffffff); /* Light blue to white gradient */
            color: #333;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #007bff; /* Blue color for navbar */
        }
        .navbar-brand, .nav-link {
            color: white !important; /* White text for navbar items */
            font-weight: 500;
            font-size: 20px;
        }
        .nav-link:hover {
            text-decoration: underline; /* Underline effect on hover */
        }

        /* Container padding */
        .container {
            padding: 0 15px;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden; /* Prevent image overflow */
            background-color: #ffffff; /* White background for cards */
        }

        /* Card hover effect */
        .card:hover {
            transform: translateY(-10px); /* Slight lift on hover */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
        }

        /* Image Styling */
        .card img {
            width: 100%; /* Full width */
            height: 200px; /* Fixed height */
            object-fit: cover; /* Ensures image is well-fitted */
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        /* Card body padding */
        .card-body {
            padding: 20px;
        }

        /* Card title styling */
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Card text styling */
        .card-text {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        /* Price styling */
        .card-text strong {
            color: #343a40; /* Darker text for labels */
        }

        /* Responsive adjustment */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">WebCreation2.0</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <h1 class="text-center mb-4">Products Catalog</h1>
        <!-- Row for cards -->
        <div class="row">
            <?php foreach ($result as $row) { ?>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                    <div class="card card-custom-height">
                        <img src="upload/<?php echo $row['image'] ?>" class="card-img-top" alt="<?php echo $row['name']?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']?></h5>
                            <p class="card-text"><strong>Category:</strong> <?php echo $row['category']?></p>
                            <p class="card-text"><strong>Price:</strong><?php echo $row['price']?></p>
                            <p class="card-text"><?php echo $row['description']?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
