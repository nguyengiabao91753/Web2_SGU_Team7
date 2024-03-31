<?php
require_once '../db.php';

if(isset($_POST['add_category'])) {
    addCategory();
} elseif(isset($_POST['update_category'])) {
    updateCategory();
} elseif(isset($_GET['delete_category'])) {
    deleteCategory($_GET['delete_category']);
}

if(isset($_POST['categoryId'])){
    $categoryId = $_POST['categoryId'];
    $rs = getCateByID($categoryId);
    echo $rs;
}

function getAllCategory() {
    global $conn;
    $query = "SELECT * FROM Categories";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $categories = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row; 
        }
        return $categories; 
    } else {
        return array();
    }

}

function getCateByID($ID){
    global $conn;
    $query = "SELECT * FROM Categories WHERE CategoryID = $ID Limit 1";
    $r = mysqli_query($conn, $query);
    $Cate= mysqli_fetch_assoc($r);
    return $Cate;
}


function addCategory() {
    global $conn;
    if(isset($_POST['CategoryName'])) {
        $name = $_POST['CategoryName'];
        $parentID = $_POST['parentID'];
        $sql = "INSERT INTO categories (parentID,CategoryName) VALUES ('$parentID','$name')";
        if($conn->query($sql) === TRUE) {
            $_SESSION['flash_message'] = "Category added successfully!";
            header("Location: ../admin2/index.php?page=pages/Category/list.php");
            exit();
        } else {
            $_SESSION['err'] = "Category added Failed!";
        }
    }else{
        $_SESSION['err'] = "Category added Failed!";
    }
}

function countCate() {
    global $conn;

    $query = "SELECT COUNT(*) FROM categories";
    $Count = mysqli_query($conn, $query);

    return $Count;
}

function updateCategory() {
    global $conn;
    if(isset($_POST['CategoryID']) && isset($_POST['CategoryName'])) {
        $CategoryID = $_POST['CategoryID'];
        $CategoryName = $_POST['CategoryName'];
        $parentID = $_POST['parentID'];
        $sql = "UPDATE Categories SET CategoryName='$CategoryName', parentID = '$parentID' WHERE CategoryID=$CategoryID";
        if($conn->query($sql) === TRUE) {
            $_SESSION['flash_message'] = "Category updated successfully!";
            header("Location: ../admin2/index.php?page=pages/Category/list.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

function deleteCategory( $CategoryID) {
    global $conn;
    if(isset($CategoryID)) {
    
        $sql = "DELETE FROM categories WHERE CategoryID=$CategoryID";
        if($conn->query($sql) === TRUE) {
            $_SESSION['flash_message'] = "Category deleted successfully!";
            header("Location: ../admin2/index.php?page=pages/Category/list.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>