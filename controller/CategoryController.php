<?php
require_once 'db.php';

if(isset($_POST['add_category'])) {
    addCategory();
} elseif(isset($_POST['update_category'])) {
    updateCategory();
} elseif(isset($_GET['delete_category'])) {
    deleteCategory();
}

function getAllCategory() {

}

function addCategory() {
    global $conn;
    if(isset($_POST['name'])) {
        $name = $_POST['name'];
        $name = mysqli_query($conn, $name); //tại đây có thể sử dụng mysqli_real_escape_string() để tăng tính bảo mật  khởi  tấn công SQL injection 
        $sql = "INSERT INTO categories (name) VALUES ('$name')";
        if($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Category added successfully!";
            header("Location: index.php?page=pages/Category/list.php");
            exit();
        } else {
            $_SESSION['err'] = "Category added Failed!";
        }
    }
}

function updateCategory() {
    global $conn;
    if(isset($_POST['id']) && isset($_POST['name'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $name = mysqli_query($conn, $name);
        $sql = "UPDATE categories SET name='$name' WHERE id=$id";
        if($conn->query($sql) === TRUE) {
            header("Location:index.php?page=pages/Category/list.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

function deleteCategory() {
    global $conn;
    if(isset($_GET['delete_category'])) {
        $id = $_GET['delete_category'];
        $sql = "UPDATE categories WHERE id=$id";
        if($conn->query($sql) === TRUE) {
            header("Location: index.php?page=pages/Category/list.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>