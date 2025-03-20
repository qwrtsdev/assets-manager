<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/global.php";

$repair_id = isset($_GET['repair_id']) ? $_GET['repair_id'] : null;

$allstatus_query = "    SELECT StatusID, StatusName
                        FROM status
                        ORDER BY StatusID   ";
$allstatus_result = $conn->query($allstatus_query);

$sql = "    SELECT r.*, a.AssetTypeName
            FROM repair r
            JOIN assettype a ON r.AssetTypeID = a.AssetTypeID
            WHERE RepairID = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $repair_id);
$stmt->execute();
$result = $stmt->get_result();
$repair = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status_id = $_POST['status_id'];
    $problem = $_POST['problem'];
    $solution = $_POST['solution'];
    $repairer = $_POST['repairer'];
    $repair_cost = $_POST['repair_cost'];
    $completed_date = !empty($_POST['completed_date']) ? $_POST['completed_date'] : null;
    $notes = $_POST['notes'];

    $sql = "    UPDATE repair SET 
                StatusID = ?,
                Problem = ?,
                Solution = ?,
                Repairer = ?,
                RepairCost = ?,
                Note = ?,
                CompleteDate = ?
                WHERE RepairID = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssdssi",
        $status_id,
        $problem,
        $solution,
        $repairer,
        $repair_cost,
        $notes,
        $completed_date,
        $repair_id
    );

    if ($stmt->execute()) {
        if (!isset($tables[$repair['AssetTypeID']])) {
            die("Error: Invalid AssetTypeID");
        }

        $table_pointer = $tables[$repair['AssetTypeID']]['table'];
        $id_pointer = $tables[$repair['AssetTypeID']]['column'];

        $update_sql = " UPDATE $table_pointer 
                        SET StatusID = ? 
                        WHERE $id_pointer = ?   ";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("is", $status_id, $repair['EquipmentID']);
        $update_stmt->execute();

        $error = null;
        echo "  <script>
                    alert('รีเฟรชหน้าเว็บไซต์ 1 ครั้งเพื่อดูการอัพเดต');
                    history.go(-2);
                </script>   ";
        exit();
    } else {
        $error = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินทรัพย์ | แก้ไขข้อมูลการซ่อม</title>

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
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($repair['AssetTypeName']); ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">รหัสอุปกรณ์ :</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($repair['EquipmentID']); ?>" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">สถานะการซ่อม :</label>
                        <select name="status_id" class="form-select" required>
                            <?php while ($status = $allstatus_result->fetch_assoc()) : ?>
                                <option value="<?php echo $status['StatusID']; ?> ">
                                    <?php echo $status['StatusName']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ปัญหาที่พบ :</label>
                        <textarea name="problem" class="form-control" rows="3"><?php echo $repair['Problem']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">วิธีการแก้ไข :</label>
                        <textarea name="solution" class="form-control" rows="3"><?php echo $repair['Solution']; ?></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ผู้ซ่อม :</label>
                            <input type="text" name="repairer" class="form-control" value="<?php echo $repair['Repairer']; ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ค่าใช้จ่าย (บาท) :</label>
                            <input type="number" name="repair_cost" class="form-control" step="0.01" min="0" value="<?php echo $repair['RepairCost']; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">วันที่ซ่อม :</label>
                            <input type="date" name="repair_date" class="form-control" value="<?php echo $repair['RepairDate'] ? date('Y-m-d', strtotime($repair['RepairDate'])) : date('Y-m-d'); ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">วันที่ซ่อมเสร็จ :</label>
                            <input type="date" name="completed_date" class="form-control" value="<?php echo $repair['CompleteDate'] ? date('Y-m-d', strtotime($repair['CompleteDate'])) : date('Y-m-d'); ?>">
                            <small class="text-muted">*เลือกวันที่ที่ซ่อมเสร็จ</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">หมายเหตุเพิ่มเติม :</label>
                        <textarea name="notes" class="form-control" rows="2"><?php echo $repair['Note']; ?></textarea>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>