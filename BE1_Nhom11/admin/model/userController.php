<?php
include 'model/User.php';

class UserController
{
    private $userModel;

    public function __construct($conn)
    {
        $this->userModel = new User($conn);
    }

    // Phương thức xóa người dùng
    public function deleteUser($userId)
    {
        if ($this->userModel->delete($userId)) {
            header("Location: users.php?message=deleted");
            exit();
        } else {
            header("Location: users.php?message=error");
            exit();
        }
    }
}
?>