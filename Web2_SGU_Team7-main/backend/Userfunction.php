<?php
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

if (isset($_POST['updateUserFunction'])) {
    updateUserFunction();
}
if (isset($_POST['add_level'])) {
    addLevel();
}

if (isset($_POST['getFeatureByLevel'])) {
    $levelId = $_POST['LevelId'];
    $query1 = "SELECT * FROM Userfunctions WHERE LevelId = $levelId";
    $rs = mysqli_query($conn, $query1);
    if (mysqli_num_rows($rs) > 0) {
        $response = array();
        $i = 0;
        while ($result = mysqli_fetch_assoc($rs)) {
            $response['data'][$i] = array(
                'LevelId' => $result['LevelId'],
                'FunctId' => $result['FunctId'],
                'Action' => $result['Action'],
                'Status' => $result['Status']
            );


            $i += 1;
        }
        echo json_encode($response);
    } else {

        echo json_encode(array('error' => 'Level not found'));
    }
}

function getAllLeFe()
{
    global $conn;
    $query = "SELECT * FROM Userfunctions";
    $rs = mysqli_query($conn, $query);
    if (mysqli_num_rows($rs) > 0) {
        $functions = array();
        while ($row = mysqli_fetch_assoc($rs)) {
            $functions[] = $row;
        }
        return $functions;
    } else {
        return array();
    }
}
function getAllFeature()
{
    global $conn;
    $query = "SELECT * FROM Functions";
    $rs = mysqli_query($conn, $query);
    if (mysqli_num_rows($rs) > 0) {
        $functions = array();
        while ($row = mysqli_fetch_assoc($rs)) {
            $functions[] = $row;
        }
        return $functions;
    } else {
        return array();
    }
}

function getAllLevel()
{
    global $conn;
    $query = "SELECT * FROM Levels";
    $rs = mysqli_query($conn, $query);
    if (mysqli_num_rows($rs) > 0) {
        $levels = array();
        while ($row = mysqli_fetch_assoc($rs)) {
            $levels[] = $row;
        }
        return $levels;
    } else {
        return array();
    }
}

function getFeaturebyName($name)
{
    global $conn;
    $user_id = $_COOKIE['user_id'];
    $query = "SELECT u.UserID, u.FirstName, u.LastName, uf.Action
            FROM Users u
            INNER JOIN Levels l ON u.Level = l.LevelId
            INNER JOIN Userfunctions uf ON l.LevelId = uf.LevelId
            INNER JOIN Functions f ON uf.FunctId = f.FunctionId
            WHERE u.UserID = $user_id
            AND f.Name = '$name'
            AND uf.Status = 1; ";
    
    $rs = mysqli_query($conn, $query);
    if (mysqli_num_rows($rs) > 0) {
       return TRUE;
    } else {
        return false;
    }
}
function getFeaturebyAction($name,$action){
    global $conn;
    $user_id = $_COOKIE['user_id'];
    $query = "SELECT u.UserID, u.FirstName, u.LastName, uf.Action
            FROM Users u
            INNER JOIN Levels l ON u.Level = l.LevelId
            INNER JOIN Userfunctions uf ON l.LevelId = uf.LevelId
            INNER JOIN Functions f ON uf.FunctId = f.FunctionId
            WHERE u.UserID = $user_id
            AND f.Name = '$name'
            AND uf.Action = '$action'
            AND uf.Status = 1; ";
    $rs = mysqli_query($conn, $query);
    if (mysqli_num_rows($rs) > 0) {
       return TRUE;
    } else {
        return false;
    }
}

function getLevelbyUserId(){
    global $conn;
    $user_id = $_COOKIE['user_id'];
    $query = "SELECT l.Name
                FROM Users u
                INNER JOIN Levels l ON u.Level = l.LevelId
                WHERE  u.UserID = $user_id";
    $rs = mysqli_query($conn,$query);
    if(mysqli_num_rows($rs)>0){
        $row = mysqli_fetch_assoc($rs);
        return $row['Name'];
    }
}

function addLevel()
{
    global $conn;
    $Name = $_POST['levName'];
    $query1 = "SELECT * FROM levels WHERE Name = '$Name'";
    $rs1 = mysqli_query($conn, $query1);
    if (mysqli_num_rows($rs1) > 0) {
        $_SESSION['err'] = "This Level already exists!";
        header("Location: ../admin2/index.php?page=Feature/modify");
        exit();
    }
    $query = "INSERT INTO Levels (name) VALUES ('$Name')";
    if (mysqli_query($conn, $query) === false) {
        $_SESSION['err'] = "Failed!";
        header("Location: ../admin2/index.php?page=Feature/modify");
        exit();
    }
    $_SESSION['success'] = "Success!";
    header("Location: ../admin2/index.php?page=Feature/modify");
    exit();
}

function updateUserFunction()
{
    global $conn;
    $levelId = $_POST['LevelId'];
    $levfes = getAllLeFe();
    foreach ($levfes as $levfe) {
        if ($levfe['LevelId'] == $levelId) {

            $action = $_POST[$levfe['FunctId'] . '-' . $levfe['Action']];
            $status = (isset($action)) ? 1 : 0;
            $funcId = $levfe['FunctId'];
            $action = $levfe['Action'];
            $Id = $levfe['Id'];
            $query = "UPDATE Userfunctions SET status = $status WHERE Id = $Id";
            if (mysqli_query($conn, $query) == false) {
                setcookie("err","Failed!",time() + (86400 * 30), "/");
                header("Location: ../admin2/index.php?page=Feature/modify");
                exit();
            }
        }
    }

    setcookie("success","Successfully!",time() + (86400 * 30), "/");
    header("Location: ../admin2/index.php?page=Feature/modify");
    exit();
}
