<?php
ob_start(); // Start output buffering
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
require_once "../project/connect.php";
require_once 'header.php';

if (isset($_GET['id'])) {
    $mouse_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM mouse WHERE Mouse_ID = ?");
    $stmt->bind_param("i", $mouse_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $mouse = $result->fetch_assoc();
} else {
    // ถ้าไม่มี ID ให้กลับไปที่หน้าหลัก
    header("Location: mouse.php");
    exit();
}

// ดึงข้อมูลสาขาและแผนก
$branches = $conn->query("SELECT * FROM branch");
$departments = $conn->query("SELECT * FROM department");
// ดึงข้อมูลสถานะ
$statuses = $conn->query("SELECT * FROM stat");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $mouse_sn = $_POST['mouse_sn'];
    $com_id = $_POST['com_id'];
    $stat_id = $_POST['stat_id'];
    $branch_id = $_POST['Branch_ID'];
    $department_id = $_POST['Department_ID'];
    $user_resp = $_POST['user_resp'];
    $short_name_resp = $_POST['short_name_resp'];
    $detail = $_POST['detail'];
    $date_add = $_POST['date_add'];

    // อัปเดตข้อมูลในฐานข้อมูล
    $update_stmt = $conn->prepare("UPDATE mouse SET 
                Mouse_SN=?, 
                Com_ID=?, 
                Stat_ID=?, 
                Branch_ID=?, 
                Department_ID=?, 
                UserResp=?, 
                ShortNameResp=?, 
                Detail=?, 
                DateAdd=? 
            WHERE Mouse_ID=?");
    $update_stmt->bind_param("ssssssssss", $mouse_sn, $com_id, $stat_id, $branch_id, $department_id, $user_resp, $short_name_resp, $detail, $date_add, $mouse_id);
    $update_stmt->execute();

    // กลับไปที่หน้าหลักหลังจากอัปเดต
    header("Location: mouse.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลเมาส์</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>แก้ไขข้อมูลเมาส์</h1>
    <form method="POST" action="">
        <input type="hidden" name="mouse_id" value="<?php echo htmlspecialchars($mouse['Mouse_ID']); ?>">
        <div class="mb-3">
            <label for="mouse_sn" class="form-label">หมายเลขซีเรียล:</label>
            <input type="text" class="form-control" id="mouse_sn" name="mouse_sn" 
                   value="<?php echo htmlspecialchars($mouse['Mouse_SN']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="com_id" class="form-label">รหัสคอมพิวเตอร์:</label>
            <input type="text" class="form-control" id="com_id" name="com_id" 
                   value="<?php echo htmlspecialchars($mouse['Com_ID']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="stat_id" class="form-label">สถานะ</label>
            <select class="form-control" id="stat_id" name="stat_id" required>
                <?php while ($status = $statuses->fetch_assoc()): ?>
                    <option value="<?php echo $status['Stat_ID']; ?>" <?php echo ($status['Stat_ID'] == $mouse['Stat_ID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($status['Stat_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Branch_ID" class="form-label">สาขา</label>
            <select class="form-control" id="Branch_ID" name="Branch_ID" required>
                <?php while ($branch = $branches->fetch_assoc()): ?>
                    <option value="<?php echo $branch['Branch_ID']; ?>" <?php echo ($branch['Branch_ID'] == $mouse['Branch_ID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($branch['Branch_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Department_ID" class="form-label">แผนก</label>
            <select class="form-control" id="Department_ID" name="Department_ID" required>
                <?php while ($department = $departments->fetch_assoc()): ?>
                    <option value="<?php echo $department['Department_ID']; ?>" <?php echo ($department['Department_ID'] == $mouse['Department_ID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($department['Department_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="user_resp" class="form-label">ชื่อผู้ใช้งาน:</label>
            <input type="text" class="form-control" id="user_resp" name="user_resp" 
                   value="<?php echo htmlspecialchars($mouse['UserResp']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="short_name_resp" class="form-label">ชื่อเล่น:</label>
            <input type="text" class="form-control" id="short_name_resp" name="short_name_resp" 
                   value="<?php echo htmlspecialchars($mouse['ShortNameResp']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="detail" class="form-label">รายละเอียด:</label>
            <textarea class="form-control" id="detail" name="detail" required><?php echo htmlspecialchars($mouse['Detail']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="date_add" class="form-label">วันที่เพิ่ม:</label>
            <input type="date" class="form-control" id="date_add" name="date_add" 
                   value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($mouse['DateAdd']))); ?>" required>
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