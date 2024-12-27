<?php
// Start output buffering to avoid "headers already sent" error
ob_start();

include "header.php";
include "sidebar.php";

// Database connection
$host = 'localhost';
$dbname = 'db_be1';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Retrieve category details if an ID is provided
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $query = "SELECT category_id, name, total_products FROM product_categories WHERE category_id = :category_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no category is found, redirect or show an error message
    if (!$category) {
        echo "Category not found.";
        exit;
    }
}

// Handle form submission to update category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $total_products = $_POST['total_products'];

    $updateQuery = "UPDATE product_categories SET name = :name, total_products = :total_products WHERE category_id = :category_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
    $updateStmt->bindParam(':total_products', $total_products, PDO::PARAM_INT);
    $updateStmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        echo "Category updated successfully!";
        header('Location: category.php'); // Redirect to category list page
        exit;
    } else {
        echo "Error updating category.";
    }
}
?>

<!-- Your HTML content here -->

<?php
// End output buffering and send the output to the browser
ob_end_flush();
?>


<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-edit icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>
                        Edit Category
                        <div class="page-title-subheading">
                            Modify the category details.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Category Form -->
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo htmlspecialchars($category['name']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="total_products">Total Products</label>
                                <input type="number" class="form-control" id="total_products" name="total_products"
                                    value="<?php echo htmlspecialchars($category['total_products']); ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php include "footer.php"; ?>