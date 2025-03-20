<?php
require_once "../project/connect.php";

$current_page = 'repairs';
$title = 'รายการส่งซ่อม';
require_once 'header.php';

// แสดงข้อความสำเร็จและข้อมูลสาขา/แผนก
if (isset($_GET['success']) && $_GET['success'] === 'repair') {
    $branch = isset($_GET['branch']) ? urldecode($_GET['branch']) : 'N/A';
    $department = isset($_GET['department']) ? urldecode($_GET['department']) : 'N/A';

}

// อัพเดตสถานะการซ่อม
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $repair_id = $_POST['repair_id'];
    $repair_status = $_POST['repair_status'];
    $solution = $_POST['solution'];
    $repairer = $_POST['repairer'];
    $repair_cost = $_POST['repair_cost'];
    $notes = $_POST['notes'];
    
    // กำหนดวันที่ซ่อมเสร็จเมื่อสถานะเป็น "เสร็จสิ้น"
    $completed_date = ($repair_status == 'เสร็จสิ้น') ? date('Y-m-d H:i:s') : null;

    $sql = "UPDATE repair_history SET 
            status = ?,
            solution = ?,
            repairer = ?,
            repair_cost = ?,
            notes = ?,
            completed_date = ?,
            Branch_ID = ?,
            Department_ID = ?
            WHERE repair_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdssii", 
        $repair_status,
        $solution,
        $repairer,
        $repair_cost,
        $notes,
        $completed_date,
        $branch_id,
        $department_id,
        $repair_id
    );

    // Debugging: Check values before executing
    echo "Branch ID: " . $branch_id . "<br>";
    echo "Department ID: " . $department_id . "<br>";

    if ($stmt->execute()) {
        echo "<script>alert('อัพเดตข้อมูลสำเร็จ'); window.location.reload();</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัพเดตข้อมูล');</script>";
    }
}

// เพิ่มการค้นหา
$search = isset($_GET['search']) ? $_GET['search'] : '';

// ดึงข้อมูลสถานะทั้งหมดจากตาราง stat
$sql_status = "SELECT Stat_ID, Stat_Name FROM stat ORDER BY Stat_ID";
$status_result = $conn->query($sql_status);

$sql = "SELECT 
        rh.repair_id,
        rh.equipment_type,
        rh.equipment_id,
        rh.repair_date,
        rh.problem,
        rh.solution,
        rh.repair_cost,
        rh.repairer,
        rh.Stat_ID,
        rh.notes,
        rh.completed_date,
        rh.created_at,
        s.Stat_Name,
        CASE
            WHEN rh.equipment_type = 'computer' THEN c.Branch_ID
            WHEN rh.equipment_type = 'mouse' THEN m.Branch_ID
            WHEN rh.equipment_type = 'keyboard' THEN k.Branch_ID
            WHEN rh.equipment_type = 'monitor' THEN mon.Branch_ID
            WHEN rh.equipment_type = 'powersup' THEN p.Branch_ID
        END as Branch_ID,
        CASE
            WHEN rh.equipment_type = 'computer' THEN c.Department_ID
            WHEN rh.equipment_type = 'mouse' THEN m.Department_ID
            WHEN rh.equipment_type = 'keyboard' THEN k.Department_ID
            WHEN rh.equipment_type = 'monitor' THEN mon.Department_ID
            WHEN rh.equipment_type = 'powersup' THEN p.Department_ID
        END as Department_ID,
        b.Branch_Name,
        d.Department_Name,
        CASE
            WHEN rh.equipment_type = 'computer' THEN c.Com_Name
            ELSE NULL
        END as equipment_name,
        CASE
            WHEN rh.equipment_type = 'computer' THEN c.Com_ID
            WHEN rh.equipment_type = 'mouse' THEN m.Mouse_SN
            WHEN rh.equipment_type = 'keyboard' THEN k.Key_SN
            WHEN rh.equipment_type = 'monitor' THEN mon.Monitor_SN
            WHEN rh.equipment_type = 'powersup' THEN p.Power_SN
        END as serial_number
        FROM repair_history rh
        LEFT JOIN computer c ON rh.equipment_type = 'computer' AND rh.equipment_id = c.Com_ID
        LEFT JOIN mouse m ON rh.equipment_type = 'mouse' AND rh.equipment_id = m.Mouse_ID
        LEFT JOIN keyboard k ON rh.equipment_type = 'keyboard' AND rh.equipment_id = k.Key_ID
        LEFT JOIN monitor mon ON rh.equipment_type = 'monitor' AND rh.equipment_id = mon.Monitor_ID
        LEFT JOIN powersup p ON rh.equipment_type = 'powersup' AND rh.equipment_id = p.Power_ID
        LEFT JOIN stat s ON rh.Stat_ID = s.Stat_ID
        LEFT JOIN branch b ON (CASE
            WHEN rh.equipment_type = 'computer' THEN c.Branch_ID
            WHEN rh.equipment_type = 'mouse' THEN m.Branch_ID
            WHEN rh.equipment_type = 'keyboard' THEN k.Branch_ID
            WHEN rh.equipment_type = 'monitor' THEN mon.Branch_ID
            WHEN rh.equipment_type = 'powersup' THEN p.Branch_ID
        END) = b.Branch_ID
        LEFT JOIN department d ON (CASE
            WHEN rh.equipment_type = 'computer' THEN c.Department_ID
            WHEN rh.equipment_type = 'mouse' THEN m.Department_ID
            WHEN rh.equipment_type = 'keyboard' THEN k.Department_ID
            WHEN rh.equipment_type = 'monitor' THEN mon.Department_ID
            WHEN rh.equipment_type = 'powersup' THEN p.Department_ID
        END) = d.Department_ID
        WHERE rh.equipment_type LIKE ?
        OR s.Stat_Name LIKE ?
        OR rh.repairer LIKE ?
        ORDER BY rh.repair_date DESC";
    
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$searchTerm = "%$search%";
if (!$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm)) {
    die("Binding parameters failed: " . $stmt->error);
}

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();
if ($result === false) {
    die("Getting result set failed: " . $stmt->error);
}
?>

<style>
.table th, .table td {
    vertical-align: middle;
    text-align: center;
}

.table th i, .table td i {
    margin-right: 5px;
    display: inline-block;
    vertical-align: middle;
}

.table th {
    white-space: nowrap;
    width: 150px;
}

.btn-update {
    padding: 0.2rem 0.5rem;
    font-size: 0.75rem;
    line-height: 1.2;
}

.btn-update i {
    font-size: 0.7rem;
    margin-right: 3px;
}

/* สไตล์แบดจ์สถานะ */
.badge {
    font-size: 0.65rem;
    padding: 2px 4px;
    border-radius: 3px;
    font-weight: normal;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000;
}

.badge.bg-info {
    background-color: #17a2b8 !important;
    color: #fff;
}

.badge.bg-secondary {
    background-color: #6c757d !important;
    color: #fff;
}

.badge.bg-primary {
    background-color: #0d6efd !important;
    color: #fff;
}

.badge.bg-success {
    background-color: #198754 !important;
    color: #fff;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
    color: #fff;
}

.badge.bg-dark {
    background-color: #212529 !important;
    color: #fff;
}
</style>

<div class="container">
    <h1><i class="fas fa-tools"></i> รายการส่งซ่อม</h1>

    <!-- ฟอร์มค้นหา -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" class="search-input" 
                   placeholder="ค้นหาด้วย ไอดีอุปกรณ์, ประเภท, สถานะ" 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i> ค้นหา
            </button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th><i class="fas fa-list-ol"></i> ลำดับ</th>
                    <th><i class="fas fa-building"></i> สาขา</th>
                    <th><i class="fas fa-sitemap"></i> แผนก</th>
                    <th><i class="fas fa-desktop"></i> ประเภทอุปกรณ์</th>
                    <th><i class="fas fa-tools"></i> ชื่อเครื่องคอมพิวเตอร์</th>
                    <th><i class="fas fa-barcode"></i> หมายเลขซีเรียล</th>
                    <th><i class="fas fa-exclamation-circle"></i> ปัญหา</th>
                    <th><i class="fas fa-calendar-alt"></i> วันที่แจ้งซ่อม</th>
                    <th><i class="fas fa-info-circle"></i> สถานะ</th>
                    <th><i class="fas fa-wrench"></i> วิธีแก้ไข</th>
                    <th><i class="fas fa-user-cog"></i> ผู้ซ่อม</th>
                    <th><i class="fas fa-money-bill-wave"></i> ค่าใช้จ่าย</th>
                    <th><i class="fas fa-calendar-check"></i> วันที่ซ่อมเสร็จ</th>
                    <th><i class="fas fa-comment-dots"></i> หมายเหตุ</th>
                    <th><i class="fas fa-cogs"></i> การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0):
                    $counter = 1;
                    while($row = $result->fetch_assoc()): 
                ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo htmlspecialchars($row['Branch_Name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Department_Name']); ?></td>
                        <td><?php echo htmlspecialchars($row['equipment_type']); ?></td>
                        <td><?php echo $row['equipment_type'] == 'computer' ? htmlspecialchars($row['equipment_name']) : '-'; ?></td>
                        <td><?php echo htmlspecialchars($row['serial_number']); ?></td>
                        <td><?php echo $row['problem']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['repair_date'])); ?></td>
                        <td>
                            <span class="badge <?php 
                                switch($row['Stat_Name']) {
                                    case 'รอการซ่อม': 
                                        echo 'bg-warning text-dark'; 
                                        break;
                                    case 'กำลังซ่อม': 
                                        echo 'bg-info text-white'; 
                                        break;
                                    case 'รออะไหล่': 
                                        echo 'bg-secondary text-white'; 
                                        break;
                                    case 'ส่งซ่อมภายนอก': 
                                        echo 'bg-primary text-white'; 
                                        break;
                                    case 'เสร็จสิ้น': 
                                        echo 'bg-success text-white'; 
                                        break;
                                    case 'ซ่อมไม่ได้': 
                                        echo 'bg-danger text-white'; 
                                        break;
                                    case 'ยกเลิกการซ่อม': 
                                        echo 'bg-dark text-white'; 
                                        break;
                                    case 'ปกติ': 
                                        echo 'bg-success text-white'; 
                                        break;
                                    default:
                                        echo 'bg-secondary text-white';
                                }
                            ?>">
                                <?php echo $row['Stat_Name']; ?>
                            </span>
                        </td>
                        <td><?php echo $row['solution']; ?></td>
                        <td><?php echo $row['repairer']; ?></td>
                        <td><?php echo number_format($row['repair_cost'], 2); ?> บาท</td>
                        <td><?php echo $row['completed_date'] ? date('d/m/Y', strtotime($row['completed_date'])) : '-'; ?></td>
                        <td><?php echo $row['notes']; ?></td>
                        <td>
                            <a href="repair_form_edit.php?repair_id=<?php echo $row['repair_id']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> แก้ไข
                            </a>
                        </td>
                    </tr>
                <?php 
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="15" class="text-center">ไม่พบข้อมูล</td>
                    </tr>
                <?php 
                endif; 
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add hidden fields in your form to capture Branch_ID and Department_ID -->
<input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>">
<input type="hidden" name="department_id" value="<?php echo $department_id; ?>">

<?php
$conn->close();
?>