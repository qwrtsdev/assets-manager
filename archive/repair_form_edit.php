<?php
require_once "../project/connect.php";

$current_page = 'repairs';
$title = 'แก้ไขข้อมูลการซ่อม';
require_once 'header.php';

// รับค่า repair_id จาก URL
$repair_id = isset($_GET['repair_id']) ? $_GET['repair_id'] : '';

// ดึงข้อมูลการซ่อมที่ต้องการแก้ไข
$sql = "SELECT rh.*, s.Stat_Name 
        FROM repair_history rh 
        LEFT JOIN stat s ON rh.Stat_ID = s.Stat_ID 
        WHERE repair_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $repair_id);
$stmt->execute();
$result = $stmt->get_result();
$repair = $result->fetch_assoc();

// ถ้าไม่พบข้อมูล ให้กลับไปหน้า repairs.php
if (!$repair) {
    echo "<script>
            alert('ไม่พบข้อมูลการซ่อม');
            window.location.href = 'repairs.php';
          </script>";
    exit();
}

// ดึงข้อมูลสถานะทั้งหมด
$sql_status = "SELECT Stat_ID, Stat_Name FROM stat ORDER BY Stat_ID";
$status_result = $conn->query($sql_status);

// เมื่อมีการส่งฟอร์มแก้ไข
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stat_id = $_POST['stat_id'];
    $solution = $_POST['solution'];
    $repairer = $_POST['repairer'];
    $repair_cost = $_POST['repair_cost'];
    $notes = $_POST['notes'];
    
    // รับค่าวันที่ซ่อมเสร็จจากฟอร์ม
    $completed_date = !empty($_POST['completed_date']) ? $_POST['completed_date'] : null;

    $sql = "UPDATE repair_history SET 
            Stat_ID = ?,
            solution = ?,
            repairer = ?,
            repair_cost = ?,
            notes = ?,
            completed_date = ?
            WHERE repair_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdssi", 
        $stat_id,
        $solution,
        $repairer,
        $repair_cost,
        $notes,
        $completed_date,
        $repair_id
    );

    if ($stmt->execute()) {
        // อัพเดทสถานะอุปกรณ์ในตารางหลัก
        $update_sql = "";
        switch($repair['equipment_type']) {
            case 'computer':
                $update_sql = "UPDATE computer SET Stat_ID = ? WHERE Com_ID = ?";
                break;
            case 'mouse':
                $update_sql = "UPDATE mouse SET Stat_ID = ? WHERE Mouse_ID = ?";
                break;
            case 'keyboard':
                $update_sql = "UPDATE keyboard SET Stat_ID = ? WHERE Key_ID = ?";
                break;
            case 'monitor':
                $update_sql = "UPDATE monitor SET Stat_ID = ? WHERE Monitor_ID = ?";
                break;
            case 'powersup':
                $update_sql = "UPDATE powersup SET Stat_ID = ? WHERE Power_ID = ?";
                break;
        }
        
        if ($update_sql) {
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("is", $stat_id, $repair['equipment_id']);
            $update_stmt->execute();
        }

        echo "<script>
                alert('บันทึกข้อมูลสำเร็จ');
                window.location.href = 'repairs.php';
              </script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');</script>";
    }
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-edit"></i> แก้ไขข้อมูลการซ่อม #<?php echo $repair_id; ?></h3>
        </div>
        <div class="card-body">
            <form method="POST" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ประเภทอุปกรณ์:</label>
                        <input type="text" class="form-control" value="<?php echo $repair['equipment_type']; ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">รหัสอุปกรณ์:</label>
                        <input type="text" class="form-control" value="<?php echo $repair['equipment_id']; ?>" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">ปัญหาที่พบ:</label>
                    <textarea class="form-control" readonly rows="2"><?php echo $repair['problem']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">สถานะการซ่อม: <span class="text-danger">*</span></label>
                    <select name="stat_id" class="form-select" required>
                        <option value="" disabled>เลือกสถานะ</option>
                        <?php while($status = $status_result->fetch_assoc()): ?>
                        <option value="<?php echo $status['Stat_ID']; ?>" <?php echo $repair['Stat_ID'] == $status['Stat_ID'] ? 'selected' : ''; ?>>
                            <?php echo $status['Stat_Name']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">วิธีการแก้ไข:</label>
                    <textarea name="solution" class="form-control" rows="3"><?php echo $repair['solution']; ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ผู้ซ่อม:</label>
                        <input type="text" name="repairer" class="form-control" value="<?php echo $repair['repairer']; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ค่าใช้จ่าย (บาท):</label>
                        <input type="number" name="repair_cost" class="form-control" value="<?php echo $repair['repair_cost']; ?>" step="0.01">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">วันที่ซ่อมเสร็จ:</label>
                        <input type="date" name="completed_date" class="form-control" 
                               value="<?php echo $repair['completed_date'] ? date('Y-m-d', strtotime($repair['completed_date'])) : date('Y-m-d'); ?>">
                        <small class="text-muted">*เลือกวันที่ที่ซ่อมเสร็จ</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">หมายเหตุ:</label>
                    <textarea name="notes" class="form-control" rows="2"><?php echo $repair['notes']; ?></textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> บันทึกข้อมูล
                    </button>
                    <a href="repairs.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> ยกเลิก
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$conn->close();
?>