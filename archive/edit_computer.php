<?php
ob_start(); // Start output buffering
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
require_once "../project/connect.php";
require_once 'header.php';
if (isset($_GET['id'])) {
    

    $com_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM computer WHERE Com_ID = ?");
    $stmt->bind_param("s", $com_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $computer = $result->fetch_assoc();
} else {
    // ถ้าไม่มี ID ให้กลับไปที่หน้าหลัก
    header("Location: index.php");
    exit();
}

// ดึงข้อมูลสาขาและแผนก
$branches = $conn->query("SELECT * FROM branch");
$departments = $conn->query("SELECT * FROM department");
// ดึงข้อมูลสถานะ
$statuses = $conn->query("SELECT * FROM stat");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $com_name = $_POST['Com_name'];
    $com_sn = $_POST['Com_sn'];
    $ip_address = $_POST['IPaddress'];
    $branch_id = $_POST['Branch_ID'];
    $department_id = $_POST['Department_ID'];
    $user_resp = $_POST['UserResp'];
    $short_name_resp = $_POST['ShortNameResp'];
    $detail = $_POST['Detail'];
    $os = $_POST['Os'];
    $stat_id = $_POST['stat_id'];

    // อัปเดตข้อมูลในฐานข้อมูล
    $update_stmt = $conn->prepare("UPDATE computer SET Com_name=?, Com_sn=?, IPaddress=?, Branch_ID=?, Department_ID=?, UserResp=?, ShortNameResp=?, Detail=?, Os=?, Stat_ID=? WHERE Com_ID=?");
    $update_stmt->bind_param("sssssssssss", $com_name, $com_sn, $ip_address, $branch_id, $department_id, $user_resp, $short_name_resp, $detail, $os, $stat_id, $com_id);
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
    <title>แก้ไขข้อมูลคอมพิวเตอร์</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>แก้ไขข้อมูลคอมพิวเตอร์</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="Com_name" class="form-label">ชื่อเครื่อง</label>
            <input type="text" class="form-control" id="Com_name" name="Com_name" value="<?php echo htmlspecialchars($computer['Com_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="Com_sn" class="form-label">หมายเลขซีเรียล</label>
            <input type="text" class="form-control" id="Com_sn" name="Com_sn" value="<?php echo htmlspecialchars($computer['Com_sn']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="IPaddress" class="form-label">IP Address</label>
            <input type="text" class="form-control" id="IPaddress" name="IPaddress" value="<?php echo htmlspecialchars($computer['IPaddress']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="Branch_ID" class="form-label">สาขา</label>
            <select class="form-control" id="Branch_ID" name="Branch_ID" required>
                <?php while ($branch = $branches->fetch_assoc()): ?>
                    <option value="<?php echo $branch['Branch_ID']; ?>" <?php echo ($branch['Branch_ID'] == $computer['Branch_ID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($branch['Branch_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Department_ID" class="form-label">แผนก</label>
            <select class="form-control" id="Department_ID" name="Department_ID" required>
                <?php while ($department = $departments->fetch_assoc()): ?>
                    <option value="<?php echo $department['Department_ID']; ?>" <?php echo ($department['Department_ID'] == $computer['Department_ID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($department['Department_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="UserResp" class="form-label">ชื่อผู้ใช้งาน</label>
            <input type="text" class="form-control" id="UserResp" name="UserResp" value="<?php echo htmlspecialchars($computer['UserResp']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="ShortNameResp" class="form-label">ชื่อเล่น</label>
            <input type="text" class="form-control" id="ShortNameResp" name="ShortNameResp" value="<?php echo htmlspecialchars($computer['ShortNameResp']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="Detail" class="form-label">รายละเอียด</label>
            <textarea class="form-control" id="Detail" name="Detail" required><?php echo htmlspecialchars($computer['Detail']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="Os" class="form-label">ระบบปฏิบัติการ</label>
            <input type="text" class="form-control" id="Os" name="Os" value="<?php echo htmlspecialchars($computer['Os']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="stat_id" class="form-label">สถานะ</label>
            <select class="form-control" id="stat_id" name="stat_id" required>
                <?php while ($status = $statuses->fetch_assoc()): ?>
                    <option value="<?php echo $status['Stat_ID']; ?>" <?php echo ($status['Stat_ID'] == $computer['Stat_ID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($status['Stat_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
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