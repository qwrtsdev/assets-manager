<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/global.php";

$current_page = 'repair';
$search = isset($_GET['search']) ? $_GET['search'] : null;

$sql = "    SELECT r.*, 
            s.StatusName, 
            a.AssetTypeName, 
            comp.ComputerName,
            COALESCE(
                n.NotebookSN,
                m.MonitorSN,
                k.KeyboardSN,
                mo.MouseSN,
                u.UpsSN,
                ad.AdapterSN,
                ro.RouterSN,
                sh.SwitchHubSN,
                us.USBSN,
                sp.SpeakerSN,
                i.iPadSN,
                pr.PrinterSN,
                hd.HarddiskSN,
                o.OtherSN
            ) AS SN
            FROM repair r
            LEFT JOIN status s ON r.StatusID = s.StatusID
            LEFT JOIN assettype a ON r.AssetTypeID = a.AssetTypeID
            LEFT JOIN notebook n ON (r.EquipmentID = n.NotebookID AND r.AssetTypeID = 2)
            LEFT JOIN monitor m ON (r.EquipmentID = m.MonitorID AND r.AssetTypeID = 3)
            LEFT JOIN keyboard k ON (r.EquipmentID = k.KeyboardID AND r.AssetTypeID = 4)
            LEFT JOIN mouse mo ON (r.EquipmentID = mo.MouseID AND r.AssetTypeID = 5)
            LEFT JOIN ups u ON (r.EquipmentID = u.UpsID AND r.AssetTypeID = 6)
            LEFT JOIN adapter ad ON (r.EquipmentID = ad.AdapterID AND r.AssetTypeID = 7)
            LEFT JOIN router ro ON (r.EquipmentID = ro.RouterID AND r.AssetTypeID = 8)
            LEFT JOIN switchhub sh ON (r.EquipmentID = sh.SwitchHubID AND r.AssetTypeID = 9)
            LEFT JOIN usb us ON (r.EquipmentID = us.USBID AND r.AssetTypeID = 10)
            LEFT JOIN speaker sp ON (r.EquipmentID = sp.SpeakerID AND r.AssetTypeID = 11)
            LEFT JOIN ipad i ON (r.EquipmentID = i.iPadID AND r.AssetTypeID = 12)
            LEFT JOIN printer pr ON (r.EquipmentID = pr.PrinterID AND r.AssetTypeID = 13)
            LEFT JOIN harddisk hd ON (r.EquipmentID = hd.HarddiskID AND r.AssetTypeID = 14)
            LEFT JOIN other o ON (r.EquipmentID = o.OtherID AND r.AssetTypeID = 15)
            LEFT JOIN computer comp ON comp.ComputerID = COALESCE(
            n.ComputerID, m.ComputerID, k.ComputerID, mo.ComputerID, u.ComputerID,
            ad.ComputerID, ro.ComputerID, sh.ComputerID, us.ComputerID, sp.ComputerID,
            i.ComputerID, pr.ComputerID, hd.ComputerID, o.ComputerID
            )
            WHERE r.EquipmentID LIKE ?
            OR s.StatusID LIKE ?
            OR r.Repairer LIKE ?
            OR comp.ComputerName LIKE ?
            OR r.RepairID LIKE ?
            OR a.AssetTypeName LIKE ?
            ORDER BY r.RepairDate DESC  ";
$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param("ssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินทรัพย์ | รายการส่งซ่อม</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../../favicon.ico">
    <link rel="stylesheet" href="/dbquery/styles.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dbquery/assets/header.php'; ?>

    <div class="container-lg w-100 px-3 my-5 mx-auto">
        <h1 class="page-title"><i class="fas fa-tools"></i> รายการส่งซ่อม</h1>

        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="search" class="search-input" placeholder="ค้นหาด้วย ID, ประเภท, ชื่อคอมพิวเตอร์, ผู้ซ่อม, สถานะ" value="<?php echo htmlspecialchars($search); ?>">
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
                        <th><i class="fas fa-desktop"></i>&nbsp;&nbsp;&nbsp;ประเภทอุปกรณ์</th>
                        <th><i class="fas fa-tools"></i>&nbsp;&nbsp;&nbsp;ชื่อเครื่องคอมพิวเตอร์</th>
                        <th><i class="fas fa-barcode"></i>&nbsp;&nbsp;&nbsp;หมายเลขซีเรียล</th>
                        <th><i class="fas fa-exclamation-circle"></i>&nbsp;&nbsp;&nbsp;ปัญหา</th>
                        <th><i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;&nbsp;วันที่แจ้งซ่อม</th>
                        <th><i class="fas fa-info-circle"></i>&nbsp;&nbsp;&nbsp;สถานะ</th>
                        <th><i class="fas fa-wrench"></i>&nbsp;&nbsp;&nbsp;วิธีแก้ไข</th>
                        <th><i class="fas fa-user-cog"></i> ผู้ซ่อม</th>
                        <th><i class="fas fa-money-bill-wave"></i>&nbsp;&nbsp;&nbsp;ค่าใช้จ่าย</th>
                        <th><i class="fas fa-calendar-check"></i>&nbsp;&nbsp;&nbsp;วันที่ซ่อมเสร็จ</th>
                        <th><i class="fas fa-comment-dots"></i>&nbsp;&nbsp;&nbsp;หมายเหตุ</th>
                        <th><i class="fas fa-cogs"></i>&nbsp;&nbsp;&nbsp;การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $counter = 1;

                        while ($row = $result->fetch_assoc()) {
                            $labelClass = getStatusLabelColor($row['StatusID']);

                            echo "<tr>";
                            echo "<td>" . $counter++ . "</td>";
                            echo "<td>" . (isset($row["AssetTypeName"]) ? htmlspecialchars($row["AssetTypeName"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["ComputerName"]) ? htmlspecialchars($row["ComputerName"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["SN"]) ? htmlspecialchars($row["SN"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["Problem"]) ? htmlspecialchars($row["Problem"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["RepairDate"]) ? date('d/m/Y', strtotime($row['RepairDate'])) : '-') . "</td>";
                            echo "<td><span class='badge " . $labelClass . "'>" . htmlspecialchars($row["StatusName"]) . "</span></td>";
                            echo "<td>" . (isset($row["Solution"]) ? htmlspecialchars($row["Solution"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["Repairer"]) ? htmlspecialchars($row["Repairer"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["RepairCost"]) ? htmlspecialchars($row["RepairCost"]) : '-') . "</td>";
                            echo "<td>" . (isset($row["CompleteDate"]) ? date('d/m/Y', strtotime($row['RepairDate'])) : '-') . "</td>";
                            echo "<td>" . (isset($row["Note"]) ? htmlspecialchars($row["Note"]) : '-') . "</td>";
                            echo "  <td>  
                                        <a href='/dbquery/pages/manage/repair-form_edit.php?repair_id=" . $row['RepairID'] . "' class='btn btn-warning btn-sm'>
                                            <i class='fas fa-edit'></i> แก้ไข
                                        </a>
                                    </td>";
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