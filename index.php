<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/global.php";

$current_page = 'index';
$search = isset($_GET['search']) ? $_GET['search'] : null;

$sql = "    SELECT c.ComputerID, c.ComputerName, IPAddress, b.BranchName, d.DepartmentName, 
            m.MouseSN, o.OSName, c.ComputerSN, c.UserResp, c.UserRespNickname, c.Detail, c.AddedDate,
            c.StatusID AS ComputerStatus,
            m.StatusID AS MouseStatus, 
            mt.MonitorSN, mt.StatusID AS MonitorStatus, 
            kb.KeyboardSN, kb.StatusID AS KeyboardStatus, 
            up.UpsSN, up.StatusID AS UpsStatus
            FROM computer c
            LEFT JOIN branch b ON c.BranchID = b.BranchID
            LEFT JOIN department d ON c.DepartmentID = d.DepartmentID
            LEFT JOIN mouse m ON c.ComputerID = m.ComputerID
            LEFT JOIN monitor mt ON c.ComputerID = mt.ComputerID
            LEFT JOIN keyboard kb ON c.ComputerID = kb.ComputerID
            LEFT JOIN ups up ON c.ComputerID = up.ComputerID
            LEFT JOIN os o ON c.OSID = o.OSID
            WHERE c.ComputerID LIKE ? 
            OR c.ComputerName LIKE ?
            ORDER BY c.ComputerID ASC   ";

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
    <title>ระบบจัดการสินทรัพย์</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dbquery/assets/header.php'; ?>

    <div class="container-lg w-100 px-3 my-5 mx-auto">
        <h1 class="page-title"><i class="fa-solid fa-computer"></i> ข้อมูลคอมพิวเตอร์</h1>

        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="search" class="search-input" placeholder="ค้นหาด้วย ชื่อคอมพิวเตอร์" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </form>
        </div>

        <div class="table-responsive mx-auto">
            <table class="table table-bordered text-center" style="width: 100%;">
                <thead>
                    <tr>
                        <th><i class="fas fa-list-ol"></i>&nbsp;&nbsp;&nbsp;ลำดับ</th>
                        <th><i class="fa-solid fa-computer"></i>&nbsp;&nbsp;&nbsp;ชื่อคอมพิวเตอร์</th>
                        <!-- ------------------------- -->
                        <th><i class="fas fa-barcode"></i>&nbsp;&nbsp;&nbsp;หมายเลขซีเรียล</th>
                        <!-- ------------------------- -->
                        <th><i class="fa-solid fa-globe"></i>&nbsp;&nbsp;&nbsp;ที่อยู่ IP</th>
                        <th><i class="fa-solid fa-code-branch"></i>&nbsp;&nbsp;&nbsp;สาขา</th>
                        <th><i class="fa-solid fa-building"></i>&nbsp;&nbsp;&nbsp;แผนก</th>
                        <!-- ------------------------- -->
                        <th><i class="fas fa-info-circle"></i>&nbsp;&nbsp;&nbsp;สถานะ</th>
                        <th><i class="fa-solid fa-user"></i>&nbsp;&nbsp;&nbsp;ชื่อผู้ใช้งาน</th>
                        <th><i class="fa-solid fa-user"></i></i>&nbsp;&nbsp;&nbsp;ชื่อเล่น</th>
                        <th><i class="fa-solid fa-note-sticky"></i>&nbsp;&nbsp;&nbsp;รายละเอียด</th>
                        <th><i class="fa-solid fa-calendar-days"></i>&nbsp;&nbsp;&nbsp;วันที่เพิ่ม</th>
                        <th><i class="fa-brands fa-windows"></i>&nbsp;&nbsp;&nbsp;ระบบปฎิบัติการ</th>
                        <!-- ------------------------- -->
                        <th><i class="fa-solid fa-hashtag"></i>&nbsp;&nbsp;&nbsp;SN เมาส์</th>
                        <th><i class="fa-solid fa-question"></i>&nbsp;&nbsp;&nbsp;สถานะเมาส์</th>
                        <th><i class="fa-solid fa-hashtag"></i>&nbsp;&nbsp;&nbsp;SN มอนิเตอร์</th>
                        <th><i class="fa-solid fa-question"></i>&nbsp;&nbsp;&nbsp;สถานะมอนิเตอร์</th>
                        <th><i class="fa-solid fa-hashtag"></i>&nbsp;&nbsp;&nbsp;SN คีย์บอร์ด</th>
                        <th><i class="fa-solid fa-question"></i>&nbsp;&nbsp;&nbsp;สถานะคีย์บอร์ด</th>
                        <th><i class="fa-solid fa-hashtag"></i>&nbsp;&nbsp;&nbsp;SN พาวเวอร์ฯ</th>
                        <th><i class="fa-solid fa-question"></i>&nbsp;&nbsp;&nbsp;สถานะพาวเวอร์ฯ</th>
                        <th><i class="fas fa-cogs"></i>&nbsp;&nbsp;&nbsp;การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $previousComputerId = null;
                    $previousRow = null;
                    $currentCount = 1;
                    $groupClass = "group-odd";

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $isDuplicate = ($previousComputerId !== null && $previousComputerId === $row['ComputerName']);

                            if (!$isDuplicate) {
                                $groupClass = ($groupClass === "group-odd") ? "group-even" : "group-odd";
                                $currentCount = $count++;
                                echo "<tr class='$groupClass'><td>" . $currentCount . "</td>";
                            } else {
                                echo "<tr class='$groupClass'><td></td>";
                            }

                            echo "<td>" . ($isDuplicate && $row['ComputerName'] == $previousRow['ComputerName'] ? '' : $row['ComputerName']) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['ComputerSN'] == $previousRow['ComputerSN'] ? '' : $row['ComputerSN']) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['IPAddress'] == $previousRow['IPAddress'] ? '' : $row['IPAddress']) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['BranchName'] == $previousRow['BranchName'] ? '' : $row['BranchName']) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['DepartmentName'] == $previousRow['DepartmentName'] ? '' : $row['DepartmentName']) . "</td>";
                            echo "<td>" . ($isDuplicate && getStatusLabelName($row['ComputerStatus']) == getStatusLabelName($previousRow['ComputerStatus']) ? '' : getStatusLabelName($row['ComputerStatus'])) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['UserResp'] == $previousRow['UserResp'] ? '' : $row['UserResp']) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['UserRespNickname'] == $previousRow['UserRespNickname'] ? '' : $row['UserRespNickname']) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['Detail'] == $previousRow['Detail'] ? '' : $row['Detail']) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['AddedDate'] == $previousRow['AddedDate'] ? '' : $row['AddedDate']) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['OSName'] == $previousRow['OSName'] ? '' : $row['OSName']) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['MouseSN'] == $previousRow['MouseSN'] ? '' : $row['MouseSN']) . "</td>";
                            echo "<td>" . ($isDuplicate && getStatusLabelName($row['MouseStatus']) == getStatusLabelName($previousRow['MouseStatus']) ? '' : getStatusLabelName($row['MouseStatus'])) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['MonitorSN'] == $previousRow['MonitorSN'] ? '' : $row['MonitorSN']) . "</td>";
                            echo "<td>" . ($isDuplicate && getStatusLabelName($row['MonitorStatus']) == getStatusLabelName($previousRow['MonitorStatus']) ? '' : getStatusLabelName($row['MonitorStatus'])) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['KeyboardSN'] == $previousRow['KeyboardSN'] ? '' : $row['KeyboardSN']) . "</td>";
                            echo "<td>" . ($isDuplicate && getStatusLabelName($row['KeyboardStatus']) == getStatusLabelName($previousRow['KeyboardStatus']) ? '' : getStatusLabelName($row['KeyboardStatus'])) . "</td>";
                            echo "<td>" . ($isDuplicate && $row['UpsSN'] == $previousRow['UpsSN'] ? '' : $row['UpsSN']) . "</td>";
                            echo "<td>" . ($isDuplicate && getStatusLabelName($row['UpsStatus']) == getStatusLabelName($previousRow['UpsStatus']) ? '' : getStatusLabelName($row['UpsStatus'])) . "</td>";
                            echo "<td>" . ($isDuplicate ? '' :
                                "<a href='/dbquery/pages/manage/repair-form.php?type=1&id=" . htmlspecialchars($row["ComputerID"]) . "' class='btn btn-warning btn-sm'>
                                                <i class='fas fa-tools'></i> บันทึกการซ่อม
                                            </a>
                                            <a href='/dbquery/pages/manage/assets-edit.php?type=1&id=" . htmlspecialchars($row["ComputerID"]) . "' class='btn btn-info btn-sm'>
                                                <i class='fas fa-pencil'></i> แก้ไข
                                            </a>")
                                . "</td>";

                            $previousComputerId = $row['ComputerName'];
                            $previousRow = $row;
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>ไม่มีข้อมูล</td></tr>";
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