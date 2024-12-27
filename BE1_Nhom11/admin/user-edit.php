<?php
include "header.php";
include "sidebar.php";

// Kết nối cơ sở dữ liệu
$host = 'localhost';
$db = 'db_be1';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy user_id (giả định từ URL hoặc session)
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Truy vấn để lấy thông tin người dùng
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Gán dữ liệu mặc định nếu không tìm thấy user
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = [
        'image' => '_default-user.png',
        'name' => 'Unknown User',
        'email' => '',
        'password' => ''
    ];
}
?>

<div class="app-main__outer">
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

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <form method="post" enctype="multipart/form-data">
                                <div class="position-relative row form-group">
                                    <label for="image" class="col-md-3 text-md-right col-form-label">Avatar</label>
                                    <div class="col-md-9 col-xl-8">
                                        <?php
                                        // Đường dẫn ảnh của người dùng
                                        $imagePath = 'assets/images/' . htmlspecialchars($user['image'] ?? '_default-user.png');

                                        // Kiểm tra xem ảnh có tồn tại không
                                        if (!file_exists($imagePath)) {
                                            $imagePath = 'assets/images/_default-user.png'; // Sử dụng ảnh mặc định nếu không tồn tại
                                        }
                                        ?>

                                        <img style="height: 200px; cursor: pointer;" class="thumbnail rounded-circle"
                                            data-toggle="tooltip" title="Click to change the image"
                                            data-placement="bottom" src="<?php echo $imagePath; ?>" alt="Avatar">

                                        <input name="image" type="file" onchange="changeImg(this)"
                                            class="image form-control-file" style="display: none;">
                                        <input type="hidden" name="image_old"
                                            value="<?php echo htmlspecialchars($user['image'] ?? '_default-user.png'); ?>">
                                        <small class="form-text text-muted">Click on the image to change
                                            (required)</small>
                                    </div>
                                </div>
                            </form>



                            <div class="position-relative row form-group">
                                <label for="name" class="col-md-3 text-md-right col-form-label">Name</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="name" id="name" placeholder="Name" type="text"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="email" class="col-md-3 text-md-right col-form-label">Email</label>
                                <div class="col-md-9 col-xl-8">
                                    <input required name="email" id="email" placeholder="Email" type="email"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="password" class="col-md-3 text-md-right col-form-label">Password</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="password" id="password" placeholder="Password" type="password"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="password_confirmation" class="col-md-3 text-md-right col-form-label">Confirm
                                    Password</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="password_confirmation" id="password_confirmation"
                                        placeholder="Confirm Password" type="password" class="form-control">
                                </div>
                            </div>
                            <div class="position-relative row form-group">
                                <label for="company_name" class="col-md-3 text-md-right col-form-label">Company
                                    Name</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="company_name" id="company_name" placeholder="Company Name" type="text"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($user['company_name'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="country" class="col-md-3 text-md-right col-form-label">Country</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="country" id="country" placeholder="Country" type="text"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($user['country'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="street_address" class="col-md-3 text-md-right col-form-label">Street
                                    Address</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="street_address" id="street_address" placeholder="Street Address"
                                        type="text" class="form-control"
                                        value="<?php echo htmlspecialchars($user['street_address'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="town_city" class="col-md-3 text-md-right col-form-label">Town/City</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="town_city" id="town_city" placeholder="Town/City" type="text"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($user['town_city'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="phone" class="col-md-3 text-md-right col-form-label">Phone</label>
                                <div class="col-md-9 col-xl-8">
                                    <input name="phone" id="phone" placeholder="Phone" type="text" class="form-control"
                                        value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="level" class="col-md-3 text-md-right col-form-label">Level</label>
                                <div class="col-md-9 col-xl-8">
                                    <select name="level" id="level" class="form-control">
                                        <option value="" disabled>-- Level --</option>
                                        <option value="beginner" <?php echo (isset($user['level']) && $user['level'] === 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                                        <option value="intermediate" <?php echo (isset($user['level']) && $user['level'] === 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                        <option value="expert" <?php echo (isset($user['level']) && $user['level'] === 'expert') ? 'selected' : ''; ?>>Expert</option>
                                    </select>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="description"
                                    class="col-md-3 text-md-right col-form-label">Description</label>
                                <div class="col-md-9 col-xl-8">
                                    <textarea name="description" id="description" placeholder="Description"
                                        class="form-control"><?php echo htmlspecialchars($user['description'] ?? ''); ?></textarea>
                                </div>
                            </div>

                            <div class="position-relative row form-group mb-1">
                                <div class="col-md-9 col-xl-8 offset-md-2">
                                    <a href="#" class="border-0 btn btn-outline-danger mr-1">
                                        <span class="btn-icon-wrapper pr-1 opacity-8">
                                            <i class="fa fa-times fa-w-20"></i>
                                        </span>
                                        <span>Cancel</span>
                                    </a>

                                    <button type="submit" class="btn-shadow btn-hover-shine btn btn-primary">
                                        <span class="btn-icon-wrapper pr-2 opacity-8">
                                            <i class="fa fa-download fa-w-20"></i>
                                        </span>
                                        <span>Save</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>