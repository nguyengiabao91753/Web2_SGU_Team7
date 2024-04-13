<?php

//  session_start();

require_once '../db.php';
require_once 'Userfunction.php';
if (isset($_POST['add_category'])) {
    
    addCategory();
} elseif (isset($_POST['update_category'])) {
    updateCategory();
} elseif (isset($_GET['delete_category'])) {
    
    deleteCategory($_GET['delete_category']);
}
//Xử lý ajax lấy số trang
if (isset($_GET['rowofPage'])) {
    $rowofPage = $_GET['rowofPage'];
    $total = countCate();
    $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
    echo $page;
}

//Xử lý ajax lấy cate bởi id
if (isset($_POST['categoryId'])) {
    $categoryId = $_POST['categoryId'];
    $rs = getCateByID($categoryId);
    echo $rs;
}

//Xử lý ajax đây là search nhá
if (isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];
    $query = "SELECT * FROM categories WHERE CategoryName LIKE '%$searchText%'";
    $result = mysqli_query($conn, $query);
    echo loadCateData($result);
}


function validateCate($parentID, $CategoryName)
{
    global $conn;
    $query = "SELECT * FROM Categories WHERE parentID = '$parentID' AND CategoryName= '$CategoryName'";
    $result = mysqli_query($conn, $query);

    return mysqli_num_rows($result);
}

function getAllCategory()
{
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



function getCateByID($ID)
{
    global $conn;
    $query = "SELECT * FROM Categories WHERE CategoryID = $ID Limit 1";
    $r = mysqli_query($conn, $query);
    $Cate = mysqli_fetch_assoc($r);
    return $Cate;
}


function addCategory()
{
    global $conn;
    if (isset($_POST['CategoryName'])) {
        $name = $_POST['CategoryName'];
        $parentID = $_POST['parentID'];
        if (validateCate($parentID, $name) == 0) {
            $sql = "INSERT INTO categories (parentID,CategoryName) VALUES ('$parentID','$name')";
            if ($conn->query($sql) === TRUE) {
                //setcookie("success","Category added successfully!");
                setcookie("success","Category added successfully!",time() + (86400 * 30), "/");
                //$_SESSION['success'] = "Category updated successfully!";  
                header("Location: ../admin2/index.php?page=Category/list");
                
                exit();
            } else {
                setcookie("err","Category add failed!",time() + (86400 * 30), "/");

                header("Location: ../admin2/index.php?page=Category/list");
                exit();
            }
        } else {
            setcookie("err","This Category already exits!",time() + (86400 * 30), "/");

            header("Location: ../admin2/index.php?page=Category/list");
            exit();
        }
    } else {
        setcookie("err","Category add failed!",time() + (86400 * 30), "/");

        header("Location: ../admin2/index.php?page=Category/list");
        exit();
    }
}

function countCate()
{
    global $conn;

    $query = "SELECT COUNT(*) FROM categories";
    $Count = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($Count);
    $Count = (int)$row[0];
    return $Count;
}

function updateCategory()
{
    global $conn;
    if (isset($_POST['CategoryID']) && isset($_POST['CategoryName'])) {
        $CategoryID = $_POST['CategoryID'];
        $CategoryName = $_POST['CategoryName'];
        $parentID = $_POST['parentID'];
        if (validateCate($parentID, $CategoryName) == 0) {


            $sql = "UPDATE Categories SET CategoryName='$CategoryName', parentID = '$parentID' WHERE CategoryID=$CategoryID";
            if ($conn->query($sql) === TRUE) {
                
                header("Location: ../admin2/index.php?page=Category/list");
                setcookie("success","Category updated successfully!",time() + (86400 * 30), "/");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            setcookie("err","This Category already exits!",time() + (86400 * 30), "/");
            header("Location: ../admin2/index.php?page=Category/list");
            exit();
        }
    }
}

function deleteCategory($CategoryID)
{
    global $conn;
    if (isset($CategoryID)) {
        $validate = "SELECT * FROM categories WHERE parentID = $CategoryID";
        $rs = mysqli_query($conn,$validate);
        if(mysqli_num_rows($rs) >0 ){
            setcookie("err","Delete this category's child first",time() + (86400 * 30), "/");
            header("Location: ../admin2/index.php?page=Category/list");
            exit();
        }

        $sql = "DELETE FROM categories WHERE CategoryID=$CategoryID";
        if ($conn->query($sql) === TRUE) {
            setcookie("success","Category deleted successfully!",time() + (86400 * 30), "/");
            header("Location: ../admin2/index.php?page=Category/list");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

function loadCateData($result)
{
    $html = '';

    while ($category = mysqli_fetch_assoc($result)) {


        $Name = ($category['parentID'] != 0) ? getCateByID($category['parentID'])['CategoryName'] : "";

        $html .= '<tr>';
        $html .= '  <td class="categoryID">' . $category['CategoryID'] . '</td>';
        $html .= '  <td>' . $Name . '</td>';
        $html .= '  <td>' . $category['CategoryName'] . '</td>';
        $html .= '  <td>';
        //$html .= '    <a href="index.php?page=Category/list.php&id=' . $category['CategoryID'] . '">';
        $html .= '      <button type="button" onclick="update(this)" id="updateCate-' . $category['CategoryID'] . '" class="updateCategory btn btn-success">';
        $html .= '        <i class="far fa-edit"></i>';
        $html .= '      </button>';
        //$html .= '    </a>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <a onclick="return confirmDelete()" href="../backend/Category.php?delete_category=' . $category['CategoryID'] . '">';
        $html .= '      <button class="btn btn-danger">';
        $html .= '        <i class="far fa-trash-alt"></i>';
        $html .= '      </button>';
        $html .= '    </a>';
        $html .= '  </td>';
        $html .= '</tr>';
    }

    return $html;
}
