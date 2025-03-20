<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/global.php";

$equipment_type = isset($_GET['type']) ? $_GET['type'] : null;    // AssetTypeID : com, mouse, keyboard, etc.
$equipment_id = isset($_GET['id']) ? $_GET['id'] : null;          // Asset's Indivdual ID

$tables = [
    2   =>  ['table' => 'notebook', 'column' => 'NotebookID', 'msg' => 'โน๊ตบุ๊ค', 'short' => ''],
    3   =>  ['table' => 'monitor', 'column' => 'MonitorID', 'msg' => 'มอนิเตอร์', 'short' => ''],
    4   =>  ['table' => 'keyboard', 'column' => 'KeyboardID', 'msg' => 'คีย์บอร์ด', 'short' => ''],
    5   =>  ['table' => 'mouse', 'column' => 'MouseID', 'msg' => 'เมาส์', 'short' => ''],
    6   =>  ['table' => 'ups', 'column' => 'UpsID', 'msg' => 'เครื่องสำรองไฟ', 'short' => ''],
    7   =>  ['table' => 'adapter', 'column' => 'AdapterID', 'msg' => 'อะแดปเตอร์', 'short' => ''],
    8   =>  ['table' => 'router', 'column' => 'RouterID', 'msg' => 'เราต์เตอร์', 'short' => ''],
    9   =>  ['table' => 'switchhub', 'column' => 'SwitchHubID', 'msg' => 'สวิตช์ฮับ', 'short' => ''],
    10  =>  ['table' => 'usb', 'column' => 'USBID', 'msg' => 'แฟลชไดรฟ์', 'short' => ''],
    11  =>  ['table' => 'speaker', 'column' => 'SpeakerID', 'msg' => 'ลำโพง', 'short' => ''],
    12  =>  ['table' => 'ipad', 'column' => 'iPadID', 'msg' => 'ไอแพด/แท็บเล็ต', 'short' => ''],
    13  =>  ['table' => 'printer', 'column' => 'PrinterID', 'msg' => 'เครื่องถ่ายเอกสาร', 'short' => ''],
    14  =>  ['table' => 'harddisk', 'column' => 'HarddiskID', 'msg' => 'ฮาร์ดดิสก์', 'short' => ''],
    15  =>  ['table' => 'other', 'column' => 'OtherID', 'msg' => 'อื่นๆ', 'short' => ''],
];

$type_query = " SELECT *
                FROM assettype
                WHERE AssetTypeID = ?   ";
$type_stmt = $conn->prepare($type_query);
$type_stmt->bind_param("i", $equipment_type);
$type_stmt->execute();
$type_result = $type_stmt->get_result();
$assettype = $type_result->fetch_assoc();

$allstatus_query = "    SELECT StatusID, StatusName
                        FROM status s
                        ORDER BY StatusID   ";
$allstatus_result = $conn->query($allstatus_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "    INSERT INTO repair (AssetTypeID, EquipmentID, RepairDate, Problem, 
                Solution, StatusID, Repairer, RepairCost, Note) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)  ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iisssisds",
        $equipment_type,
        $equipment_id,
        $_POST['repair_date'],
        $_POST['problem'],
        $_POST['solution'],
        $_POST['status_id'],
        $_POST['repairer'],
        $_POST['repair_cost'],
        $_POST['note']
    );

    if ($stmt->execute()) {
        if (isset($tables[$equipment_type])) {
            $table = $tables[$equipment_type]['table'];
            $column = $tables[$equipment_type]['column'];

            $update_sql = " UPDATE $table 
                            SET StatusID = ? 
                            WHERE $column = ?   ";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ii", $_POST['status_id'], $equipment_id);
            $update_stmt->execute();
        } else {
            $error = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
        }

        $error = null;
        echo "  <script>
                    history.go(-2);
                </script>   ";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินทรัพย์ | บันทึกการซ่อม</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../../favicon.ico">
    <link rel="stylesheet" href="/dbquery/styles.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dbquery/assets/header.php'; ?>

    <div class="container-lg w-100 px-3 my-5 mx-auto">
        <div class="card">
            <div class="card-body">
                <?php
                if (isset($error)) {
                    echo "<div class='alert alert-danger'>" . $error . "</div>";
                }
                ?>

                <form method="POST" action="">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ประเภทอุปกรณ์ :</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($assettype['AssetTypeName']); ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">รหัสอุปกรณ์ :</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($equipment_id); ?>" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">วันที่ซ่อม :</label>
                            <input type="date" name="repair_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">สถานะการซ่อม :</label>
                            <select name="status_id" class="form-select" required>
                                <?php while ($status = $allstatus_result->fetch_assoc()) : ?>
                                    <option value="<?php echo $status['StatusID']; ?> ">
                                        <?php echo $status['StatusName']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ปัญหาที่พบ :</label>
                        <textarea name="problem" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">วิธีการแก้ไข :</label>
                        <textarea name="solution" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ผู้ซ่อม :</label>
                            <input type="text" name="repairer" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ค่าใช้จ่าย (บาท) :</label>
                            <input type="number" name="repair_cost" class="form-control" step="0.01" min="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">หมายเหตุเพิ่มเติม :</label>
                        <textarea name="note" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>&nbsp;&nbsp;บันทึกข้อมูล
                        </button>

                        <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;ย้อนกลับ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>