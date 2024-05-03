
<?php
require_once '../db.php';
require_once 'User.php';
$db = new DbConnect();
//global $conn;
$conn = $db->getConnect();

if (isset($_GET['lock_account'])) {
    lockUser($_GET['lock_account']);
}
if (isset($_GET['unlock_account'])) {
    lockUser($_GET['unlock_account']);
}

//Xử lý ajax lấy số trang
if (isset($_POST['key']) && $_POST['key'] == 'countcusacc') {
    $rowofPage = $_POST['rowofPage'];
    $total = countUsersacc();
    $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
    echo $page;
}

if (isset($_POST['key']) && $_POST['key'] == 'countempacc') {
    $rowofPage = $_POST['rowofPage'];
    $total = countEmpsacc();
    $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
    echo $page;
}



function getAccountByID($AccountID)
{
    global $conn;
    $query = "SELECT * FROM accounts WHERE AccountID = $AccountID LIMIT 1";
    $rs = mysqli_query($conn, $query);
    $account = mysqli_fetch_assoc($rs);
    return $account;
}
function countUsersacc()
{
    global $conn;
    $query = "SELECT COUNT(*) AS TotalAccounts 
    FROM Accounts
    INNER JOIN Users ON Accounts.AccountID = Users.UserID
    INNER JOIN Levels ON Users.Level = Levels.LevelId
    WHERE Levels.Name == 'User';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $count = (int)$row[0];
    return $count;
}
function countEmpsacc()
{
    global $conn;
    $query = "SELECT COUNT(*) AS TotalAccounts 
    FROM Accounts
    INNER JOIN Users ON Accounts.AccountID = Users.UserID
    INNER JOIN Levels ON Users.Level = Levels.LevelId
    WHERE Levels.Name != 'User';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $count = (int)$row[0];
    return $count;
}


function lockUser($UserID)
{
    global $conn;
    if (isset($UserID)) {

        // Set status = 0 for related accounts
        $sql_accounts = "UPDATE accounts SET Status = 0 WHERE AccountID=$UserID";
        $conn->query($sql_accounts);
        setcookie("success", "Account locked successfully!", time() + (86400 * 30), "/");
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

function unlockUser($UserID)
{
    global $conn;
    if (isset($UserID)) {

        // Set status = 1 for related accounts
        $sql_accounts = "UPDATE accounts SET Status = 1 WHERE AccountID=$UserID";
        $conn->query($sql_accounts);
        setcookie("success", "Account unlocked successfully!", time() + (86400 * 30), "/");
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}



function loadAccountUser($rs)
{
    $html = '';
    while ($row = mysqli_fetch_assoc($rs)) {
        $emp = getCusbyId($row['AccountID']);
        $level = getLevelbyId($emp['Level']);
        if ($level['Name'] == 'User') {


            $userID = $row['AccountID'];
            // Kiểm tra trạng thái của mỗi tài khoản
            if ($row['Status'] == 1) {
                $lockButton = '<a href="../backend/Account.php?lock_account=' . $userID . '" class="btn btn-danger" onclick="return confirm(\'Bạn có muốn khóa tài khoản này không?\')">Lock</a>';
            } else {
                $lockButton = '<a href="../backend/Account.php?unlock_account=' . $userID . '" class="btn btn-success" onclick="return confirm(\'Bạn có muốn mở khóa tài khoản này không?\')">Unlock</a>';
            }

            $html .= "<tr>";
            $html .= "<td>" . $userID . "</td>";
            $html .= "<td>" . $row['Username'] . "</td>";
            $html .= "<td>" . $row['Password'] . "</td>";
            $html .= "<td>";
            if ($row['Status'] == 0) {
                $html .= "<span class='badge badge-secondary'>Locked</span>";
            } elseif ($row['Status'] == 1) {
                $html .= "<span class='badge badge-info'>Active</span>";
            }
            $html .= "</td>";
            $html .= "<td>" . $lockButton . "</td>";
            $html .= "</tr>";
        }
    }
    return $html;
}

function loadAccountEmp($rs)
{
    $html = '';
    while ($row = mysqli_fetch_assoc($rs)) {
        $emp = getCusbyId($row['AccountID']);
        $emp_login = getCusbyId($_COOKIE['user_id']);
        $level = getLevelbyId($emp['Level']);
        if ($level['Name'] != 'User') {


            $userID = $row['AccountID'];
            // Kiểm tra trạng thái của mỗi tài khoản
            $lockButton = '';
            if ($_COOKIE['user_id'] != $row['AccountID'] && $emp['Level'] > $emp_login['Level']) {


                if ($row['Status'] == 1) {
                    $lockButton = '<a href="../backend/Account.php?lock_account=' . $userID . '" class="btn btn-danger" onclick="return confirm(\'Bạn có muốn khóa tài khoản này không?\')">Lock</a>';
                } else {
                    $lockButton = '<a href="../backend/Account.php?unlock_account=' . $userID . '" class="btn btn-success" onclick="return confirm(\'Bạn có muốn mở khóa tài khoản này không?\')">Unlock</a>';
                }
            }
            $html .= "<tr>";
            $html .= "<td>" . $userID . "</td>";
            $html .= "<td>" . $row['Username'] . "</td>";
            $html .= "<td>" . $row['Password'] . "</td>";

            $html .= "<td>";
            if ($row['Status'] == 0) {
                $html .= "<span class='badge badge-secondary'>Locked</span>";
            } elseif ($row['Status'] == 1) {
                $html .= "<span class='badge badge-info'>Active</span>";
            }
            $html .= "</td>";
            $html .= "<td>" . $lockButton . "</td>";
            $html .= "</tr>";
        }
    }
    return $html;
}


function isAccountIDExists($accountID)
{
    global $conn; // Chắc chắn rằng biến $conn đã được khai báo và là kết nối đến cơ sở dữ liệu

    // Truy vấn SQL để kiểm tra xem AccountID đã tồn tại hay chưa
    $query = "SELECT COUNT(*) AS count FROM accounts WHERE AccountID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Lấy giá trị số lượng dòng từ kết quả truy vấn
    $count = $row['count'];

    // Nếu số lượng dòng lớn hơn 0, có nghĩa là AccountID đã tồn tại
    // Nếu không, trả về false
    return $count > 0 ? true : false;
}
