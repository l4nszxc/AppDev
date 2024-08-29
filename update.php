<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "henandez_lans1";

    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    $id = "";
    $name = "";
    $description = "";
    $price = "";
    $quantity = "";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Get method: show the data of the client
        if (!isset($_GET["Id"])) {
            header("location: index.php");
            exit;
        }
        $id = $_GET["Id"];

        // Read the row of the selected client
        $sql = "SELECT * FROM products WHERE ID=$id";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();

        if (!$row) {
            header("location: index.php");
            exit;
        }
        $name = $row["Name"];
        $description = $row["Description"];
        $price = $row["Price"];
        $quantity = $row["Quantity"];
    } else {
        // Post method: update the data of the client
        $id = $_POST["Id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["Price"];
        $quantity = $_POST["quantity"];
        
        if (empty($id) || empty($name) || empty($description) || empty($price) || empty($quantity)) {
            $errorMessage = "All the fields are required";
        } else {
            $sql = "UPDATE products SET Name='$name', Description='$description', Price='$price', Quantity='$quantity' WHERE ID=$id";
            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
            } else {
                $successMessage = "Student Updated correctly";
                header("location: index.php");
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Update Student</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="Id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">description</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="description" value="<?php echo $description; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">price</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Price" value="<?php echo $price; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">quantity</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="quantity" value="<?php echo $quantity; ?>">
                </div>
            </div>

            <?php if (!empty($successMessage)): ?>
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-6">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?php echo $successMessage; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <br>
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <br>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
