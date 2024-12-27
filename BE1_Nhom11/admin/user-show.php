<?php
include "header.php";
include "sidebar.php";

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_be1";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Lấy ID người dùng từ URL hoặc POST
$user_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);

// Lấy thông tin người dùng
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Kiểm tra xem có dữ liệu trả về không
if ($user === false) {
    echo "Không tìm thấy người dùng.";
    exit; // Dừng script nếu không tìm thấy người dùng
}
?>

<div class="app-main__outer">

    <!-- Main -->
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>
                        User
                        <div class="page-title-subheading">
                            View, create, update, delete and manage.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a href="./user-edit.php" class="nav-link">
                    <span class="btn-icon-wrapper pr-2 opacity-8">
                        <i class="fa fa-edit fa-w-20"></i>
                    </span>
                    <span>Edit</span>
                </a>
            </li>

            <li class="nav-item delete">
                <form action="" method="post">
                    <button class="nav-link btn" type="submit"
                        onclick="return confirm('Do you really want to delete this item?')">
                        <span class="btn-icon-wrapper pr-2 opacity-8">
                            <i class="fa fa-trash fa-w-20"></i>
                        </span>
                        <span>Delete</span>
                    </button>
                </form>
            </li>
        </ul>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body display_data">
                        <div class="position-relative row form-group">
                            <label for="image" class="col-md-3 text-md-right col-form-label">Avatar</label>
                            <div class="col-md-9 col-xl-8">
                                <p>
                                    <img style="height: 200px;" class="rounded-circle" data-toggle="tooltip"
                                        title="Avatar" data-placement="bottom" src="assets/images/_default-user.png"
                                        alt="Avatar">
                                </p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="name" class="col-md-3 text-md-right col-form-label">Name</label>
                            <div class="col-md-9 col-xl-8">
                                <p><?php echo htmlspecialchars($user['fullname']); ?></p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="email" class="col-md-3 text-md-right col-form-label">Email</label>
                            <div class="col-md-9 col-xl-8">
                                <p><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="company_name" class="col-md-3 text-md-right col-form-label">Company Name</label>
                            <div class="col-md-9 col-xl-8">
                                <p><?php echo htmlspecialchars($user['company_name']); ?></p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="country" class="col-md-3 text-md-right col-form-label">Country</label>
                            <div class="col-md-9 col-xl-8">
                                <p><?php echo htmlspecialchars($user['country']); ?></p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="street_address" class="col-md-3 text-md-right col-form-label">Street
                                Address</label>
                            <div class="col-md-9 col-xl-8">
                                <p><?php echo htmlspecialchars($user['street_address']); ?></p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="town_city" class="col-md-3 text-md-right col-form-label">Town City</label>
                            <div class="col-md-9 col-xl-8">
                                <p><?php echo htmlspecialchars($user['town_city']); ?></p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="phone" class="col-md-3 text-md-right col-form-label">Phone</label>
                            <div class="col-md-9 col-xl-8">
                                <p><?php echo htmlspecialchars($user['phone']); ?></p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="level" class="col-md-3 text-md-right col-form-label">Level</label>
                            <div class="col-md-9 col-xl-8">
                                <p><?php echo htmlspecialchars($user['level']); ?></p>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="description" class="col-md-3 text-md-right col-form-label">Description</label>
                            <div class="col-md-9 col-xl-8">
                                <p><?php echo htmlspecialchars($user['description']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main -->

    <?php
    include "footer.php";
    ?>