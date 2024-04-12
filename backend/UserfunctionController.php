<?php
require_once '../db.php';

if (isset($_POST['updateUserFunction'])) {
    updateUserFunction();
}
if(isset($_POST['add_level'])){
    addLevel();
}

if (isset($_POST['getFeatureByLevel'])) {
    $levelId = $_POST['LevelId'];
    $query1 = "SELECT * FROM Userfunctions WHERE LevelId = $levelId";
    $rs = mysqli_query($conn, $query1);
    if (mysqli_num_rows($rs) > 0) {
        $response = array();
        $i =0;
        while ($result = mysqli_fetch_assoc($rs)) {
            $response['data'][$i] = array(
                'LevelId' => $result['LevelId'],
                'FunctId' => $result['FunctId'],
                'Status' => $result['Status']
            );


            $i+=1;
            
        }
        echo json_encode($response);
    }else {
       
        echo json_encode(array('error' => 'Level not found'));
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

function addLevel(){
    global $conn;
    $Name = $_POST['levName'];
    $query1 = "SELECT * FROM levels WHERE Name = '$Name'";
    $rs1 = mysqli_query($conn, $query1);
    if(mysqli_num_rows($rs1) >0){
        $_SESSION['err'] = "This Level already exists!";
        header("Location: ../admin2/index.php?page=pages/Feature/modify");
        exit();
    }
    $query = "INSERT INTO levels (Name) VALUES ('$Name')";
    if(mysqli_query($conn,$query) == false){
        $_SESSION['err'] = "Failed!";
        header("Location: ../admin2/index.php?page=pages/Feature/modify");
        exit();
    }
    $_SESSION['success'] = "Success!";
    header("Location: ../admin2/index.php?page=pages/Feature/modify");
    exit();
    

}

function updateUserFunction()
{
    global $conn;
    $levelId = $_POST['LevelId'];
    $funcs = getAllFeature();
    foreach ($funcs as $func) {
        $status = (isset($_POST[$func['FunctionId']])) ? 1 : 0;
        $funcId = $func['FunctionId'];
        $query = "UPDATE Userfunctions SET status = $status WHERE  LevelId = $levelId  AND FunctId = $funcId";
        if (mysqli_query($conn, $query) == false) {
            $_SESSION['err'] = "Failed!";
            header("Location: ../admin2/index.php?page=pages/Feature/modify");
            exit();
        }
    }

    $_SESSION['success'] = "Success!";
    header("Location: ../admin2/index.php?page=pages/Feature/modify");
    exit();
}
