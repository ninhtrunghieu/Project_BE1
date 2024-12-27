<?php
include "header.php";  // Bao gồm header của trang
require 'config.php';  // Bao gồm kết nối cơ sở dữ liệu

// Tạo kết nối MySQLi
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, PORT);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Kiểm tra xem từ khóa tìm kiếm có tồn tại không
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Xây dựng truy vấn SQL tìm kiếm sản phẩm theo từ khóa
$sql = "SELECT product_id, name, description, price, image_url FROM products WHERE name LIKE ?";

// Chuẩn bị truy vấn
$stmt = $conn->prepare($sql);
$searchTermLike = "%" . $searchTerm . "%";  // Thêm dấu '%' để tìm kiếm tương đối
$stmt->bind_param("s", $searchTermLike);
$stmt->execute();
$result = $stmt->get_result();

?>

<section class="lattest-product-area pb-40 category-list">
    <div class="row">
        <?php
        // Hiển thị các sản phẩm tìm thấy
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-6 col-lg-4'>";
                echo "  <div class='card text-center card-product'>";
                echo "    <div class='card-product__img'>";
                echo "      <img class='card-img' src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                echo "    </div>";
                echo "    <div class='card-body'>";
                echo "      <h4 class='card-product__title'><a href='#'>" . htmlspecialchars($row['name']) . "</a></h4>";
                echo "      <p>" . htmlspecialchars($row['description']) . "</p>";
                echo "      <p class='card-product__price'>$" . number_format($row['price'], 2) . "</p>";
                echo "    </div>";
                echo "  </div>";
                echo "</div>";
            }
        } else {
            echo "<p>Không tìm thấy sản phẩm nào với từ khóa '{$searchTerm}'.</p>";
        }
        ?>
    </div>
</section>

<?php
// Đóng kết nối
$conn->close();
?>
