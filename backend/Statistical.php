<?php
require_once '../db.php';
require_once 'User.php';
require_once 'Category.php';
$db = new DbConnect();
//global $conn;
$conn = $db->getConnect();

if (isset($_POST['key']) && $_POST['key'] == 'monthfromto') {
    statismonth();
}

if (isset($_POST['key']) && $_POST['key'] == 'yearfromto') {
    statisyear();
}

if (isset($_POST['key']) && $_POST['key'] == 'bestseller') {
    showbestseller();
}


function statismonth()
{
    global $conn;
    $fromMonth = $_POST['from_month']; // Giả sử biến 'from_month' chứa tháng từ select box "from"
    $toMonth = $_POST['to_month']; // Giả sử biến 'to_month' chứa tháng từ select box "to"

    // Truy vấn dữ liệu từ cơ sở dữ liệu cho tháng từ
    $queryFrom = "SELECT DAY(CreatedAt) AS Day, SUM(TotalAmount) AS TotalAmount 
          FROM orders 
          WHERE MONTH(CreatedAt) = '$fromMonth' AND Status = 3
          GROUP BY DAY(CreatedAt)";

    $resultFrom = $conn->query($queryFrom);

    // Xử lý dữ liệu trả về từ tháng từ
    $dataFrom = [];
    $lables = range(1, 28);
    while ($row = $resultFrom->fetch_assoc()) {

        $dataFrom[$row['Day']] = $row['TotalAmount'];
    }

    // Truy vấn dữ liệu từ cơ sở dữ liệu cho tháng đến
    $queryTo = "SELECT DAY(CreatedAt) AS Day, SUM(TotalAmount) AS TotalAmount 
          FROM orders 
          WHERE MONTH(CreatedAt) = '$toMonth' AND Status = 3
          GROUP BY DAY(CreatedAt)";

    $resultTo = $conn->query($queryTo);

    // Xử lý dữ liệu trả về từ tháng đến
    $dataTo = [];
    while ($row = $resultTo->fetch_assoc()) {
        $dataTo[$row['Day']] = $row['TotalAmount'];
    }

    // Tính tổng lượng doanh thu của form và to
    $totalFrom = !empty($dataFrom) ? array_sum($dataFrom) : 0;
    $totalTo = !empty($dataTo) ? array_sum($dataTo) : 0;

    // Tính phần trăm tăng trưởng
    $percentageIncrease = $totalTo - $totalFrom;


    // Trả về dữ liệu cho biểu đồ dưới dạng JSON
    $response = [
        'labels' => $lables,
        'monthform' => array_values(array_replace(array_fill_keys($lables, 0), $dataFrom)),
        'monthto' =>  array_values(array_replace(array_fill_keys($lables, 0), $dataTo)),
        'percent' => $percentageIncrease
        // 'monthfrom' => $dataFrom,
        // 'monthto' => $dataTo
    ];

    echo json_encode($response);
}


function statisyear()
{
    global $conn;
    $yearFrom = $_POST['year_from']; // Giả sử biến 'year_from' chứa năm từ select box "from"
    $yearTo = $_POST['year_to']; // Giả sử biến 'year_to' chứa năm từ select box "to"

    // Mảng chứa các nhãn tháng từ 1 đến 12
    $labels = range(1, 12);

    // Truy vấn dữ liệu từ cơ sở dữ liệu cho năm từ
    $queryFrom = "SELECT MONTH(CreatedAt) AS Month, SUM(TotalAmount) AS TotalAmount 
                  FROM orders 
                  WHERE YEAR(CreatedAt) = '$yearFrom' AND Status = 3
                  GROUP BY MONTH(CreatedAt)";

    $resultFrom = $conn->query($queryFrom);

    // Xử lý dữ liệu trả về từ năm từ
    $dataFrom = [];
    while ($row = $resultFrom->fetch_assoc()) {
        $dataFrom[$row['Month']] = $row['TotalAmount'];
    }

    // Truy vấn dữ liệu từ cơ sở dữ liệu cho năm đến
    $queryTo = "SELECT MONTH(CreatedAt) AS Month, SUM(TotalAmount) AS TotalAmount 
                FROM orders 
                WHERE YEAR(CreatedAt) = '$yearTo' AND Status = 3
                GROUP BY MONTH(CreatedAt)";

    $resultTo = $conn->query($queryTo);

    // Xử lý dữ liệu trả về từ năm đến
    $dataTo = [];
    while ($row = $resultTo->fetch_assoc()) {
        $dataTo[$row['Month']] = $row['TotalAmount'];
    }

    // Tính tổng lượng doanh thu của form và to
    $totalFrom = !empty($dataFrom) ? array_sum($dataFrom) : 0;
    $totalTo = !empty($dataTo) ? array_sum($dataTo) : 0;

    // Tính phần trăm tăng trưởng
    $percentageIncrease = $totalTo - $totalFrom;

    // Trả về dữ liệu cho biểu đồ dưới dạng JSON
    $response = [
        'yearfrom' => array_values(array_replace(array_fill_keys($labels, 0), $dataFrom)),
        'yearto' =>  array_values(array_replace(array_fill_keys($labels, 0), $dataTo)),
        'percent' => $percentageIncrease
    ];

    echo json_encode($response);
}

function showbestseller(){
    global $conn;
    $categoryID = $_POST['categoryID'];
    if($categoryID == 0){
        $sql = "SELECT *
        FROM products
        ORDER BY Sale_Quantity DESC
        LIMIT 4";
    }else{
        $sql = "SELECT *
        FROM products
        WHERE CategoryID = $categoryID
        ORDER BY Sale_Quantity DESC
        LIMIT 4";
    }

    $rs = mysqli_query($conn, $sql);
    $html ='';
   if(mysqli_num_rows($rs) >0 ){
    $html = loadbestseller($rs);
   }
    echo $html;
}

function loadbestseller($kq){
    $html='';
    foreach ($kq as $sp) {
        $Name = ($sp['CategoryID'] != 0) ? getCateByID($sp['CategoryID'])['CategoryName'] : "";

        $html .= '<tr>';
        $html .= '<td><img src="' . $sp['Image'] . '" alt="Product 1" class="img-circle img-size-32 mr-2"> ' . $sp['ProductName'] . '</td>';
        $html .= '<td>' . $Name . '</td>';
        $html .= ' <td>' . $sp['Sale_Quantity'] . '</td>';
        $html .= '<td>' . $sp['Quantity'] . '</td>';
        $html .= '</tr>';
    }
    return $html;
}   

function getDistinctYears()
{
    global $conn;

    // Truy vấn SQL để lấy danh sách các năm không trùng lặp từ cột "CreatedAt"
    $query = "SELECT DISTINCT YEAR(CreatedAt) AS Year FROM orders ORDER BY Year DESC";
    $result = $conn->query($query);

    $years = [];

    // Lặp qua kết quả truy vấn và lưu trữ các năm vào mảng
    while ($row = $result->fetch_assoc()) {
        $years[] = $row['Year'];
    }

    return $years;
}
