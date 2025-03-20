<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/global.php";

$current_page = 'notebook';
$search = isset($_GET['search']) ? $_GET['search'] : null;

$sql = "    SELECT n.*, s.StatusID as StatusNumber, s.StatusName
            FROM notebook n
            JOIN status s ON n.StatusID = s.StatusID
            WHERE n.NotebookID LIKE ? 
            OR n.NotebookSN LIKE ?  ";
$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินทรัพย์ | โน้ตบุ๊ค</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../../favicon.ico">
    <link rel="stylesheet" href="/dbquery/styles.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dbquery/assets/header.php'; ?>

    <div class="container-lg w-100 px-3 my-5 mx-auto">
        <h1 class="page-title"><i class="fas fa-laptop"></i> ข้อมูลโน้ตบุ๊ค</h1>

        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="search" class="search-input" placeholder="ค้นหาด้วย ID หรือ Serial Number" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </form>
        </div>

        <div class="table-responsive mx-auto">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th><i class="fas fa-list-ol"></i>&nbsp;&nbsp;&nbsp;ลำดับ</th>
                        <th><i class="fas fa-barcode"></i>&nbsp;&nbsp;&nbsp;หมายเลขซีเรียล</th>
                        <th><i class="fas fa-desktop"></i>&nbsp;&nbsp;&nbsp;รหัสคอมพิวเตอร์</th>
                        <th><i class="fa-solid fa-code-branch"></i>&nbsp;&nbsp;&nbsp;สาขา</th>
                        <th><i class="fa-solid fa-building"></i>&nbsp;&nbsp;&nbsp;แผนก</th>
                        <th><i class="fas fa-info-circle"></i>&nbsp;&nbsp;&nbsp;สถานะ</th>
                        <th><i class="fa-solid fa-user"></i>&nbsp;&nbsp;&nbsp;ชื่อผู้ใช้งาน</th>
                        <th><i class="fa-solid fa-user"></i></i>&nbsp;&nbsp;&nbsp;ชื่อเล่น</th>
                        <th><i class="fa-solid fa-note-sticky"></i>&nbsp;&nbsp;&nbsp;รายละเอียด</th>
                        <th><i class="fa-solid fa-calendar-days"></i>&nbsp;&nbsp;&nbsp;วันที่เพิ่ม</th>
                        <th><i class="fas fa-cogs"></i>&nbsp;&nbsp;&nbsp;การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $counter = 1;

                        while ($row = $result->fetch_assoc()) {
                            $labelClass = getStatusLabelColor($row['StatusNumber']);

                            echo "<tr>";
                            echo "<td>" . $counter++ . "</td>";
                            echo "<td>" . htmlspecialchars($row["NotebookSN"]) . "</td>";
                            echo "<td>" . (isset($row["ComputerID"]) ? htmlspecialchars($row["ComputerID"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["BranchID"]) ? htmlspecialchars($row["BranchID"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["DepartmentID"]) ? htmlspecialchars($row["DepartmentID"]) : '-') . "</td>";
                            echo "<td><span class='badge " . $labelClass . "'>" . htmlspecialchars($row["StatusName"]) . "</span></td>";
                            echo "<td>" . (isset($row["UserResp"]) ? htmlspecialchars($row["UserResp"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["UserRespNickname"]) ? htmlspecialchars($row["UserRespNickname"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["Detail"]) ? htmlspecialchars($row["Detail"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["AddedDate"]) ? htmlspecialchars($row["AddedDate"]) : '-') . "</td>";
                            echo "<td>" .
                                "<a href='/dbquery/pages/manage/repair-form.php?type=2&id=" . htmlspecialchars($row["NotebookID"]) . "' class='btn btn-warning btn-sm'>
                                    <i class='fas fa-tools'></i> บันทึกการซ่อม
                                </a>
                                <a href='/dbquery/pages/manage/assets-edit.php?type=2&id=" . htmlspecialchars($row["NotebookID"]) . "' class='btn btn-info btn-sm'>
                                    <i class='fas fa-pencil'></i> แก้ไข
                                </a>"
                                . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>ไม่มีข้อมูล</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>