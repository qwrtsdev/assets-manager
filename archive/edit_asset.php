<?php
ob_start(); // Start output buffering
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
require_once "../project/connect.php";
require_once 'header.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $asset_type = $_GET['type'];
    $asset_id = $_GET['id'];

    // Prepare the SQL statement based on the asset type
    switch ($asset_type) {
        case 'computer':
            $stmt = $conn->prepare("SELECT * FROM computer WHERE Com_ID = ?");
            break;
        case 'keyboard':
            $stmt = $conn->prepare("SELECT * FROM keyboard WHERE Key_ID = ?");
            break;
        case 'mouse':
            $stmt = $conn->prepare("SELECT * FROM mouse WHERE Mouse_ID = ?");
            break;
        case 'monitor':
            $stmt = $conn->prepare("SELECT * FROM monitor WHERE Monitor_ID = ?");
            break;
        case 'printer':
            $stmt = $conn->prepare("SELECT * FROM printer WHERE Printer_ID = ?");
            break;
        // Add more cases for other asset types as needed
        default:
            header("Location: index.php");
            exit();
    }

    $stmt->bind_param("s", $asset_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $asset = $result->fetch_assoc();
} else {
    // ถ้าไม่มี type หรือ ID ให้กลับไปที่หน้าหลัก
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    switch ($asset_type) {
        case 'computer':
            $com_name = $_POST['Com_name'];
            $com_sn = $_POST['Com_sn'];
            $ip_address = $_POST['IPaddress'];
            $branch_id = $_POST['Branch_ID'];
            $department_id = $_POST['Department_ID'];
            $stat_id = $_POST['Stat_ID'];

            // อัปเดตข้อมูลในฐานข้อมูล
            $update_stmt = $conn->prepare("UPDATE computer SET Com_name=?, Com_sn=?, IPaddress=?, Branch_ID=?, Department_ID=?, Stat_ID=? WHERE Com_ID=?");
            $update_stmt->bind_param("sssssss", $com_name, $com_sn, $ip_address, $branch_id, $department_id, $stat_id, $asset_id);
            break;

        case 'keyboard':
            $key_sn = $_POST['Key_SN'];
            $branch_id = $_POST['Branch_ID'];
            $department_id = $_POST['Department_ID'];
            $stat_id = $_POST['Stat_ID'];

            // อัปเดตข้อมูลในฐานข้อมูล
            $update_stmt = $conn->prepare("UPDATE keyboard SET Key_SN=?, Branch_ID=?, Department_ID=?, Stat_ID=? WHERE Key_ID=?");
            $update_stmt->bind_param("ssssi", $key_sn, $branch_id, $department_id, $stat_id, $asset_id);
            break;

        case 'mouse':
            $mouse_sn = $_POST['Mouse_SN'];
            $branch_id = $_POST['Branch_ID'];
            $department_id = $_POST['Department_ID'];
            $stat_id = $_POST['Stat_ID'];

            // อัปเดตข้อมูลในฐานข้อมูล
            $update_stmt = $conn->prepare("UPDATE mouse SET Mouse_SN=?, Branch_ID=?, Department_ID=?, Stat_ID=? WHERE Mouse_ID=?");
            $update_stmt->bind_param("ssssi", $mouse_sn, $branch_id, $department_id, $stat_id, $asset_id);
            break;

        case 'monitor':
            $monitor_sn = $_POST['Monitor_SN'];
            $branch_id = $_POST['Branch_ID'];
            $department_id = $_POST['Department_ID'];
            $stat_id = $_POST['Stat_ID'];

            // อัปเดตข้อมูลในฐานข้อมูล
            $update_stmt = $conn->prepare("UPDATE monitor SET Monitor_SN=?, Branch_ID=?, Department_ID=?, Stat_ID=? WHERE Monitor_ID=?");
            $update_stmt->bind_param("ssssi", $monitor_sn, $branch_id, $department_id, $stat_id, $asset_id);
            break;

        case 'printer':
            $printer_sn = $_POST['Printer_SN'];
            $branch_id = $_POST['Branch_ID'];
            $department_id = $_POST['Department_ID'];
            $stat_id = $_POST['Stat_ID'];

            // อัปเดตข้อมูลในฐานข้อมูล
            $update_stmt = $conn->prepare("UPDATE printer SET Printer_SN=?, Branch_ID=?, Department_ID=?, Stat_ID=? WHERE Printer_ID=?");
            $update_stmt->bind_param("ssssi", $printer_sn, $branch_id, $department_id, $stat_id, $asset_id);
            break;

        // Add more cases for other asset types as needed
    }

    $update_stmt->execute();

    // กลับไปที่หน้าหลักหลังจากอัปเดต
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูล <?php echo htmlspecialchars($asset_type); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>แก้ไขข้อมูล <?php echo htmlspecialchars($asset_type); ?></h1>
    <form method="POST" action="">
        <?php if ($asset_type === 'computer'): ?>
            <div class="mb-3">
                <label for="Com_name" class="form-label">ชื่อเครื่อง</label>
                <input type="text" class="form-control" id="Com_name" name="Com_name" value="<?php echo htmlspecialchars($asset['Com_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Com_sn" class="form-label">หมายเลขซีเรียล</label>
                <input type="text" class="form-control" id="Com_sn" name="Com_sn" value="<?php echo htmlspecialchars($asset['Com_sn']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="IPaddress" class="form-label">IP Address</label>
                <input type="text" class="form-control" id="IPaddress" name="IPaddress" value="<?php echo htmlspecialchars($asset['IPaddress']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Branch_ID" class="form-label">สาขา</label>
                <input type="text" class="form-control" id="Branch_ID" name="Branch_ID" value="<?php echo htmlspecialchars($asset['Branch_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Department_ID" class="form-label">แผนก</label>
                <input type="text" class="form-control" id="Department_ID" name="Department_ID" value="<?php echo htmlspecialchars($asset['Department_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Stat_ID" class="form-label">สถานะ</label>
                <input type="text" class="form-control" id="Stat_ID" name="Stat_ID" value="<?php echo htmlspecialchars($asset['Stat_ID']); ?>" required>
            </div>
        <?php elseif ($asset_type === 'keyboard'): ?>
            <div class="mb-3">
                <label for="Key_SN" class="form-label">หมายเลขซีเรียล</label>
                <input type="text" class="form-control" id="Key_SN" name="Key_SN" value="<?php echo htmlspecialchars($asset['Key_SN']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Branch_ID" class="form-label">สาขา</label>
                <input type="text" class="form-control" id="Branch_ID" name="Branch_ID" value="<?php echo htmlspecialchars($asset['Branch_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Department_ID" class="form-label">แผนก</label>
                <input type="text" class="form-control" id="Department_ID" name="Department_ID" value="<?php echo htmlspecialchars($asset['Department_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Stat_ID" class="form-label">สถานะ</label>
                <input type="text" class="form-control" id="Stat_ID" name="Stat_ID" value="<?php echo htmlspecialchars($asset['Stat_ID']); ?>" required>
            </div>
        <?php elseif ($asset_type === 'mouse'): ?>
            <div class="mb-3">
                <label for="Mouse_SN" class="form-label">หมายเลขซีเรียล</label>
                <input type="text" class="form-control" id="Mouse_SN" name="Mouse_SN" value="<?php echo htmlspecialchars($asset['Mouse_SN']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Branch_ID" class="form-label">สาขา</label>
                <input type="text" class="form-control" id="Branch_ID" name="Branch_ID" value="<?php echo htmlspecialchars($asset['Branch_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Department_ID" class="form-label">แผนก</label>
                <input type="text" class="form-control" id="Department_ID" name="Department_ID" value="<?php echo htmlspecialchars($asset['Department_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Stat_ID" class="form-label">สถานะ</label>
                <input type="text" class="form-control" id="Stat_ID" name="Stat_ID" value="<?php echo htmlspecialchars($asset['Stat_ID']); ?>" required>
            </div>
        <?php elseif ($asset_type === 'monitor'): ?>
            <div class="mb-3">
                <label for="Monitor_SN" class="form-label">หมายเลขซีเรียล</label>
                <input type="text" class="form-control" id="Monitor_SN" name="Monitor_SN" value="<?php echo htmlspecialchars($asset['Monitor_SN']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Branch_ID" class="form-label">สาขา</label>
                <input type="text" class="form-control" id="Branch_ID" name="Branch_ID" value="<?php echo htmlspecialchars($asset['Branch_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Department_ID" class="form-label">แผนก</label>
                <input type="text" class="form-control" id="Department_ID" name="Department_ID" value="<?php echo htmlspecialchars($asset['Department_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Stat_ID" class="form-label">สถานะ</label>
                <input type="text" class="form-control" id="Stat_ID" name="Stat_ID" value="<?php echo htmlspecialchars($asset['Stat_ID']); ?>" required>
            </div>
        <?php elseif ($asset_type === 'printer'): ?>
            <div class="mb-3">
                <label for="Printer_SN" class="form-label">หมายเลขซีเรียล</label>
                <input type="text" class="form-control" id="Printer_SN" name="Printer_SN" value="<?php echo htmlspecialchars($asset['Printer_SN']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Branch_ID" class="form-label">สาขา</label>
                <input type="text" class="form-control" id="Branch_ID" name="Branch_ID" value="<?php echo htmlspecialchars($asset['Branch_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Department_ID" class="form-label">แผนก</label>
                <input type="text" class="form-control" id="Department_ID" name="Department_ID" value="<?php echo htmlspecialchars($asset['Department_ID']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Stat_ID" class="form-label">สถานะ</label>
                <input type="text" class="form-control" id="Stat_ID" name="Stat_ID" value="<?php echo htmlspecialchars($asset['Stat_ID']); ?>" required>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?> 