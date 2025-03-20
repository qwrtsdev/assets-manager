<?php
session_start();

// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
require_once "../project/connect.php";

$current_page = 'admin';
$title = 'จัดการระบบ';
require_once 'header.php';

// ฟังก์ชันสำหรับดึงข้อมูลสถานะทั้งหมด
function getStatuses($conn) {
    $sql = "SELECT * FROM stat";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// ฟังก์ชันสำหรับดึงข้อมูลแผนกทั้งหมด
function getDepartments($conn) {
    $sql = "SELECT * FROM department";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// ฟังก์ชันสำหรับดึงข้อมูลสาขาทั้งหมด
function getBranches($conn) {
    $sql = "SELECT * FROM branch";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// ฟังก์ชันสำหรับการเพิ่มข้อมูล
function handleAdd($conn, $type, $data) {
    $sql = "";
    switch($type) {
        case 'computer':
            $sql = "INSERT INTO computer (Com_name, Com_sn, IPaddress, Branch_ID, Department_ID, Stat_ID, ShortNameResp, Detail, DateAdd, UserResp, Os) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'monitor':
            $sql = "INSERT INTO monitor (Monitor_SN, Com_ID, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'mouse':
            $sql = "INSERT INTO mouse (Mouse_SN, Com_ID, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'keyboard':
            $sql = "INSERT INTO keyboard (Key_SN, Com_ID, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'powersup':
            $sql = "INSERT INTO powersup (Power_SN, Com_ID, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'wifi':
            $sql = "INSERT INTO wifi (Wifi_SN, Com_ID, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'printer':
            $sql = "INSERT INTO printer (Printer_SN, Com_ID, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'tablet':
            $sql = "INSERT INTO tablet (Tablet_SN, Com_ID, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'switch':
            $sql = "INSERT INTO switch (Switch_SN, Com_ID, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'flashdrive':
            $sql = "INSERT INTO flashdrive (Flash_SN, Com_ID, Stat_ID, Branch_ID, Department_ID,ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'harddisk':
            $sql = "INSERT INTO harddisk (HDD_SN, Com_ID, Stat_ID, Branch_ID, Department_ID,ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'speaker':
            $sql = "INSERT INTO speaker (Speaker_SN, Com_ID, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'adapter':
            $sql = "INSERT INTO adapter (Adapter_SN, Com_ID, Stat_ID, Branch_ID, Department_ID,ShortNameResp, Detail, DateAdd, UserResp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
        case 'notebook':
            $sql = "INSERT INTO notebook (NB_SN, Stat_ID, Branch_ID, Department_ID, ShortNameResp, Detail, DateAdd, UserResp, OS, IPaddress) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            break;
    }
    
    if ($sql) {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        switch($type) {
            case 'computer':
                $stmt->bind_param("sssiiisssss", $data['name'], $data['sn'], $data['ip'], $data['branch'], $data['department'], $data['status'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp'], $data['Os']);
                break;
            case 'monitor':
                $stmt->bind_param("ssiiissss", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp']);
                break;
            case 'mouse':
                $stmt->bind_param("ssiiissss", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp']);
                break;
            case 'keyboard':
                $stmt->bind_param("ssiiissss", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp']);
                break;
            case 'powersup':
                $stmt->bind_param("ssiiissss", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp']);
                break;
            case 'wifi':
                $stmt->bind_param("ssiiissss", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp']);
                break;
            case 'printer':
                $stmt->bind_param("ssiiissss", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp']);
                break;
            case 'tablet':
                $stmt->bind_param("ssiiissss", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp']);
                break;
            case 'switch':
                $stmt->bind_param("ssiiissss", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp']);
                break;
            case 'flashdrive':
                $stmt->bind_param("siiii", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department']);
                break;
            case 'harddisk':
                $stmt->bind_param("siiii", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department']);
                break;
            case 'speaker':
                $stmt->bind_param("siiisssss", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp']);
                break;
            case 'adapter':
                $stmt->bind_param("siiisi", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['UserResp']);
                break;
            case 'notebook':
                $stmt->bind_param("ssiiisssss", $data['sn'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp'], $data['Os'], $data['ip']);
                break;
        }
        return $stmt->execute();
    }
    return false;
}

// ฟังก์ชันสำหรับการลบข้อมูล
function handleDelete($conn, $type, $id) {
    $sql = "";
    switch($type) {
        case 'computer':
            $sql = "DELETE FROM computer WHERE Com_ID = ?";
            break;
        case 'monitor':
            $sql = "DELETE FROM monitor WHERE Monitor_ID = ?";
            break;
        case 'mouse':
            $sql = "DELETE FROM mouse WHERE Mouse_ID = ?";
            break;
        case 'keyboard':
            $sql = "DELETE FROM keyboard WHERE Key_ID = ?";
            break;
        case 'powersup':
            $sql = "DELETE FROM powersup WHERE Power_ID = ?";
            break;
        case 'wifi':
            $sql = "DELETE FROM wifi WHERE Wifi_ID = ?";
            break;
        case 'printer':
            $sql = "DELETE FROM printer WHERE Printer_ID = ?";
            break;
        case 'tablet':
            $sql = "DELETE FROM tablet WHERE Tablet_ID = ?";
            break;
        case 'switch':
            $sql = "DELETE FROM switch WHERE Switch_ID = ?";
            break;
        case 'flashdrive':
            $sql = "DELETE FROM flashdrive WHERE Flash_ID = ?";
            break;
        case 'harddisk':
            $sql = "DELETE FROM harddisk WHERE HDD_ID = ?";
            break;
        case 'speaker':
            $sql = "DELETE FROM speaker WHERE Speaker_ID = ?";
            break;
        case 'adapter':
            $sql = "DELETE FROM adapter WHERE Adapter_ID = ?";
            break;
        case 'notebook':
            $sql = "DELETE FROM notebook WHERE NB_ID = ?";
            break;
    }
    
    if ($sql) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    return false;
}

// ฟังก์ชันสำหรับการแก้ไขข้อมูล
function handleEdit($conn, $type, $data) {
    $sql = "";
    switch($type) {
        case 'computer':
            $sql = "UPDATE computer SET Com_name = ?, Com_sn = ?, IPaddress = ?, Branch_ID = ?, Department_ID = ?, Stat_ID = ?, Os = ? WHERE Com_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiiiis", $data['name'], $data['sn'], $data['ip'], $data['branch'], $data['department'], $data['status'], $data['Os'], $data['id']);
            break;
        case 'monitor':
            $sql = "UPDATE monitor SET Monitor_SN = ?, Com_ID = ?, Stat_ID = ?, Branch_ID = ?, Department_ID = ? WHERE Monitor_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siiiii", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['id']);
            break;
        case 'switch':
            $sql = "UPDATE switch SET Switch_SN = ?, Com_ID = ?, Stat_ID = ?, Branch_ID = ?, Department_ID = ? WHERE Switch_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siiiii", $data['sn'], $data['com_id'], $data['status'], $data['branch'], $data['department'], $data['id']);
            break;
        case 'notebook':
            $sql = "UPDATE notebook SET NB_SN = ?, Stat_ID = ?, Branch_ID = ?, Department_ID = ?, ShortNameResp = ?, Detail = ?, DateAdd = ?, UserResp = ?, OS = ?, IPaddress = ? WHERE NB_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiiissssss", $data['sn'], $data['status'], $data['branch'], $data['department'], $data['ShortNameResp'], $data['Detail'], $data['DateAdd'], $data['UserResp'], $data['Os'], $data['ip'], $data['id']);
            break;
    }
    
    if ($sql && $stmt->execute()) {
        return true;
    }
    return false;
}

// จัดการการส่งฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $type = $_POST['type'];
    $data = $_POST;
    
    if ($action == 'add') {
        if (handleAdd($conn, $type, $data)) {
            echo "<script>alert('เพิ่มข้อมูลสำเร็จ');</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มข้อมูล');</script>";
        }
    } elseif ($action == 'edit') {
        if (handleEdit($conn, $type, $data)) {
            echo "<script>alert('แก้ไขข้อมูลสำเร็จ');</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการแก้ไขข้อมูล');</script>";
        }
    } elseif ($action == 'delete') {
        if (handleDelete($conn, $type, $data['id'])) {
            echo "<script>alert('ลบข้อมูลสำเร็จ');</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล');</script>";
        }
    }
}

// ดึงข้อมูลที่จำเป็น
$statuses = getStatuses($conn);
$departments = getDepartments($conn);
$branches = getBranches($conn);
$computers = $conn->query("SELECT Com_ID, Com_name FROM computer")->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">จัดการข้อมูลอุปกรณ์</h2>

    <!-- เลือกประเภทอุปกรณ์ -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">เลือกประเภทอุปกรณ์</h5>
        </div>
        <div class="card-body">
            <select id="deviceType" class="form-select" onchange="showForm(this.value)">
                <option value="">เลือกประเภทอุปกรณ์</option>
                <option value="computer">คอมพิวเตอร์</option>
                <option value="notebook">โน้ตบุ๊ค</option>
                <option value="monitor">จอภาพ</option>
                <option value="mouse">เมาส์</option>
                <option value="keyboard">คีย์บอร์ด</option>
                <option value="powersup">เครื่องสำรองไฟ</option>
                <option value="wifi">เครื่องกระจายสัญญาณ/Wifi</option>
                <option value="printer">เครื่องพิมพ์</option>
                <option value="tablet">iPad & Tablet</option>
                <option value="switch">สวิตซ์ฮับ</option>
                <option value="flashdrive">แฟลชไดร์ฟ</option>
                <option value="harddisk">ฮาร์ดดิสก์</option>
                <option value="speaker">ลำโพง</option>
                <option value="adapter">อแดปเตอร์และสายชาร์จ</option>
            </select>
        </div>
    </div>

    <!-- ฟอร์มสำหรับคอมพิวเตอร์ -->
    <div id="computerForm" class="device-form" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">เพิ่มข้อมูลคอมพิวเตอร์</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="type" value="computer">
                    
                    <div class="mb-3">
                        <label class="form-label">สาขา</label>
                        <select name="branch" class="form-select" required>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?php echo $branch['Branch_ID']; ?>">
                                    <?php echo $branch['Branch_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">แผนก</label>
                        <select name="department" class="form-select" required>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?php echo $dept['Department_ID']; ?>">
                                    <?php echo $dept['Department_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ชื่อเครื่อง</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">หมายเลขซีเรียล</label>
                        <input type="text" name="sn" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">IP Address</label>
                        <input type="text" name="ip" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ระบบปฏิบัติการ</label>
                        <input type="text" name="Os" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">สถานะ</label>
                        <select name="status" class="form-select" required>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?php echo $status['Stat_ID']; ?>">
                                    <?php echo $status['Stat_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อเล่น</label>
                        <input type="text" name="ShortNameResp" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">รายละเอียด</label>
                        <textarea name="Detail" class="form-control" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">วันที่เพิ่ม</label>
                        <input type="date" name="DateAdd" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อผู้ใช้งาน</label>
                        <input type="text" name="UserResp" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ฟอร์มสำหรับโน๊ตบุ๊ค -->
    <div id="notebookForm" class="device-form" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">เพิ่มข้อมูลโน๊ตบุ๊ค</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="type" value="notebook">
                    
                    <div class="mb-3">
                        <label class="form-label">สาขา</label>
                        <select name="branch" class="form-select" required>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?php echo $branch['Branch_ID']; ?>">
                                    <?php echo $branch['Branch_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">แผนก</label>
                        <select name="department" class="form-select" required>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?php echo $dept['Department_ID']; ?>">
                                    <?php echo $dept['Department_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ชื่อเครื่อง</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">หมายเลขซีเรียล</label>
                        <input type="text" name="sn" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">IP Address</label>
                        <input type="text" name="ip" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ระบบปฏิบัติการ</label>
                        <input type="text" name="Os" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">สถานะ</label>
                        <select name="status" class="form-select" required>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?php echo $status['Stat_ID']; ?>">
                                    <?php echo $status['Stat_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อเล่น</label>
                        <input type="text" name="ShortNameResp" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">รายละเอียด</label>
                        <textarea name="Detail" class="form-control" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">วันที่เพิ่ม</label>
                        <input type="date" name="DateAdd" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อผู้ใช้งาน</label>
                        <input type="text" name="UserResp" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ฟอร์มสำหรับอุปกรณ์อื่นๆ -->
    <div id="otherDeviceForm" class="device-form" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">เพิ่มข้อมูลอุปกรณ์</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="type" id="otherDeviceType">
                    
                    <div class="mb-3">
                        <label class="form-label">หมายเลขซีเรียล</label>
                        <input type="text" name="sn" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">คอมพิวเตอร์</label>
                        <select name="com_id" class="form-select" required>
                            <?php foreach ($computers as $computer): ?>
                                <option value="<?php echo $computer['Com_ID']; ?>">
                                    <?php echo $computer['Com_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">สถานะ</label>
                        <select name="status" class="form-select" required>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?php echo $status['Stat_ID']; ?>">
                                    <?php echo $status['Stat_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">สาขา</label>
                        <select name="branch" class="form-select" required>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?php echo $branch['Branch_ID']; ?>">
                                    <?php echo $branch['Branch_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">แผนก</label>
                        <select name="department" class="form-select" required>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?php echo $dept['Department_ID']; ?>">
                                    <?php echo $dept['Department_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อเล่น</label>
                        <input type="text" name="ShortNameResp" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">รายละเอียด</label>
                        <textarea name="Detail" class="form-control" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">วันที่เพิ่ม</label>
                        <input type="date" name="DateAdd" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อผู้ใช้งาน</label>
                        <input type="text" name="UserResp" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ฟอร์มสำหรับการแก้ไขข้อมูล -->
    <div id="editDeviceForm" class="device-form" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">แก้ไขข้อมูลอุปกรณ์</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="type" id="editDeviceType">
                    <input type="hidden" name="id" id="editDeviceId">
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อเครื่อง</label>
                        <input type="text" name="name" class="form-control" id="editDeviceName" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">IP Address</label>
                        <input type="text" name="ip" class="form-control" id="editDeviceIp" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">สาขา</label>
                        <select name="branch" class="form-select" id="editDeviceBranch" required>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?php echo $branch['Branch_ID']; ?>">
                                    <?php echo $branch['Branch_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">แผนก</label>
                        <select name="department" class="form-select" id="editDeviceDepartment" required>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?php echo $dept['Department_ID']; ?>">
                                    <?php echo $dept['Department_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">สถานะ</label>
                        <select name="status" class="form-select" id="editDeviceStatus" required>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?php echo $status['Stat_ID']; ?>">
                                    <?php echo $status['Stat_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อเล่น</label>
                        <input type="text" name="ShortNameResp" class="form-control" id="editShortNameResp" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">รายละเอียด</label>
                        <textarea name="Detail" class="form-control" id="editDetail" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">วันที่เพิ่ม</label>
                        <input type="date" name="DateAdd" class="form-control" id="editDateAdd" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อผู้ใช้งาน</label>
                        <input type="text" name="UserResp" class="form-control" id="editUserResp" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showForm(type) {
    // ซ่อนฟอร์มทั้งหมด
    document.querySelectorAll('.device-form').forEach(form => {
        form.style.display = 'none';
    });
    
    // แสดงฟอร์มตามประเภทที่เลือก
    if (type === 'computer') {
        document.getElementById('computerForm').style.display = 'block';
    } else if (type === 'notebook') {
        document.getElementById('notebookForm').style.display = 'block';
    } else if (type !== '') {
        document.getElementById('otherDeviceForm').style.display = 'block';
        document.getElementById('otherDeviceType').value = type;
    }
}
</script>

<?php
$conn->close();
?> 