<?php
require_once "../project/connect.php";

// รับค่า parameter จาก URL

$equipment_type = isset($_GET['type']) ? $_GET['type'] : '';
$equipment_id = isset($_GET['id']) ? $_GET['id'] : '';
$return_page = isset($_GET['return']) ? $_GET['return'] : 'repairs.php';

// ดึงข้อมูลสถานะทั้งหมด
$sql_status = "SELECT Stat_ID, Stat_Name FROM stat ORDER BY Stat_ID";
$status_result = $conn->query($sql_status);

// After fetching status data
$equipment_id_column = ($equipment_type === 'computer') ? 'Com_ID' : 
                       ($equipment_type === 'notebook' ? 'NB_ID' : 
                       ($equipment_type === 'keyboard' ? 'Key_ID' : 
                       ($equipment_type === 'harddisk' ? 'HDD_ID' : 
                       ($equipment_type === 'flashdrive' ? 'Flash_ID' : 
                       ($equipment_type === 'adapter' ? 'Adapter_ID' :
                       ($equipment_type === 'powersup' ? 'Power_ID' :
                       ($equipment_type === 'speaker' ? 'Speaker_ID' :
                       ($equipment_type === 'printer' ? 'Printer_ID' :
                       ($equipment_type === 'mouse' ? 'Mouse_ID' :
                       ($equipment_type === 'monitor' ? 'Monitor_ID' :
                       ($equipment_type === 'wifi' ? 'Wifi_ID' :
                       ($equipment_type === 'tablet' ? 'Tablet_ID' :
                       ($equipment_type === 'switch' ? 'Switch_ID' : "{$equipment_type}_ID")))))))))))));

$sql_branch_department = "
    SELECT b.Branch_ID, b.Branch_name, d.Department_ID, d.Department_name 
    FROM $equipment_type e 
    JOIN branch b ON e.Branch_ID = b.Branch_ID 
    JOIN department d ON e.Department_ID = d.Department_ID 
    WHERE e.$equipment_id_column = ?";
$stmt_branch_department = $conn->prepare($sql_branch_department);

if ($stmt_branch_department === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt_branch_department->bind_param("s", $equipment_id);
$stmt_branch_department->execute();
$result_branch_department = $stmt_branch_department->get_result();

if ($result_branch_department === false) {
    die("Error executing query: " . $stmt_branch_department->error);
}

$branch_department = $result_branch_department->fetch_assoc();

$department_name = $branch_department['Department_name']; // Default to 'N/A' if not found

// ถ้ามีการ submit ฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO repair_history (equipment_type, equipment_id, repair_date, problem, 
            solution, Stat_ID, repairer, repair_cost, notes, Branch_ID, Department_ID) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssissdss",
        $_POST['equipment_type'],
        $_POST['equipment_id'],
        $_POST['repair_date'],
        $_POST['problem'],
        $_POST['solution'],
        $_POST['stat_id'],
        $_POST['repairer'],
        $_POST['repair_cost'],
        $_POST['notes'],
        $_POST['branch_id'],
        $_POST['department_id']   
    );

    if ($stmt->execute()) {
        // อัพเดทสถานะอุปกรณ์ในตารางหลัก
        $update_sql = "";
        switch($_POST['equipment_type']) {
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
            $update_stmt->bind_param("is", $_POST['stat_id'], $_POST['equipment_id']);
            $update_stmt->execute();
        }

        // กลับไปหน้าที่เรียกมา
        header("Location: " . $_POST['return_page'] . "?success=repair&branch=" . urlencode($branch_department['Branch_name']) . "&department=" . urlencode($department_name));
        exit();
    } else {
        $error = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกการซ่อม</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-light">
<?php require_once "../project/header.php"; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-tools"></i> บันทึกการซ่อม</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <input type="hidden" name="equipment_type" value="<?php echo htmlspecialchars($equipment_type); ?>">
                            <input type="hidden" name="equipment_id" value="<?php echo htmlspecialchars($equipment_id); ?>">
                            <input type="hidden" name="return_page" value="<?php echo htmlspecialchars($return_page); ?>">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">ประเภทอุปกรณ์:</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($equipment_type); ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">รหัสอุปกรณ์:</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($equipment_id); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">สาขา:</label>
                                    <input type="hidden" name="branch_id" value="<?php echo htmlspecialchars($branch_department['Branch_ID']); ?>">
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($branch_department['Branch_name']); ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">แผนก:</label>
                                    <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($branch_department['Department_ID']); ?>">
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($branch_department['Department_name']); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">วันที่ซ่อม:</label>
                                    <input type="date" name="repair_date" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">สถานะการซ่อม:</label>
                                    <select name="stat_id" class="form-select" required>
                                        <?php while($status = $status_result->fetch_assoc()): ?>
                                        <option value="<?php echo $status['Stat_ID']; ?>">
                                            <?php echo $status['Stat_Name']; ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ปัญหาที่พบ:</label>
                                <textarea name="problem" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">วิธีการแก้ไข:</label>
                                <textarea name="solution" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">ผู้ซ่อม:</label>
                                    <input type="text" name="repairer" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ค่าใช้จ่าย (บาท):</label>
                                    <input type="number" name="repair_cost" class="form-control" step="0.01" min="0">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">หมายเหตุเพิ่มเติม:</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> บันทึกข้อมูล
                                </button>
                                <a href="<?php echo htmlspecialchars($return_page); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> ย้อนกลับ
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>