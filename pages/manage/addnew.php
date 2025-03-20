<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/global.php";

$current_page = 'addnew';

$branch_query = "   SELECT *
                    FROM branch ";
$allbranch_result = $conn->query($branch_query);

$department_query = "   SELECT *
                        FROM department ";
$department_result = $conn->query($department_query);

$computer_query = " SELECT ComputerID, ComputerName
                    FROM computer ";
$department_result = $conn->query($computer_query);

$os_query = "   SELECT *
                FROM os ";
$os_result = $conn->query($os_query);

$status_query = "   SELECT *
                    FROM status ";
$allstatus_result = $conn->query($status_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $asset_type = $_POST['asset_type'];
    $values = explode(',', $asset_type);
    $type = $values[0];
    $id = $values[1];

    $asset_sn = $_POST['asset_sn'];
    $status_id = $_POST['status_id'];
    $computer_id = $_POST['computer_id'];
    $os_id = isset($_POST['os_id']) ? $_POST['os_id'] : null;
    $branch_id = $_POST['branch_id'];
    $department_id = $_POST['department_id'];
    $userresp = $_POST['userresp'];
    $userresp_nickname = $_POST['userresp_nickname'];
    $detail = isset($_POST['detail']) ? $_POST['detail'] : null;
    $added_date = $_POST['added_date'];

    $table_pointer = $tables[$id]['table'];
    $sn_pointer = $tables[$id]['short'] . "SN";

    if ($asset_type === 'main') {
        $query = "    INSERT INTO $table_pointer
                    ($sn_pointer, StatusID, OSID, BranchID, DepartmentID, UserResp, UserRespNickname, Detail, AddedDate)
                    VALUES (?,?,?,?,?,?,?,?,?)    ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiiiissss", $asset_sn, $status_id, $osid, $branch_id, $department_id, $userresp, $userresp_nickname, $detail, $added_date);
        $stmt->execute();
    } elseif ($asset_type === 'sub') {
        $query = "    INSERT INTO $table_pointer
                    ($sn_pointer, StatusID, BranchID, DepartmentID, UserResp, UserRespNickname, Detail, AddedDate)
                    VALUES (?,?,?,?,?,?,?,?)    ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiiissss", $asset_sn, $status_id, $branch_id, $department_id, $userresp, $userresp_nickname, $detail, $added_date);
        $stmt->execute();
    } else {
        die("Error: Invalid ID");
    }

    echo "  <script>
                alert('รีเฟรชหน้าเว็บไซต์ 1 ครั้งเพื่อดูการอัพเดต');
                history.go(-2);
            </script>   ";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินทรัพย์ | เพิ่มข้อมูลอุปกรณ์</title>

    <link hasset-typeref="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../../favicon.ico">
    <link rel="stylesheet" href="/dbquery/styles.css">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const assetTypeSelect = document.getElementById('asset-type-options');
            const assetDetails = document.getElementById('asset-details');
            const assetTypeInput = document.getElementById('asset_type_input');
            const mainField = document.getElementById('main-field');
            const subField = document.getElementById('sub-field');

            assetTypeSelect.addEventListener('change', function() {
                const selectedValue = this.value;

                if (!selectedValue) {
                    assetDetails.style.display = 'none';
                    mainField.style.display = 'none';
                    subField.style.display = 'none';
                    return;
                }

                // Extract type from "main,1" or "sub,3"
                const type = selectedValue.split(',')[0];

                assetDetails.style.display = 'block';
                assetTypeInput.value = selectedValue;

                if (type === 'main') {
                    mainField.style.display = 'block';
                    subField.style.display = 'none';
                } else if (type === 'sub') {
                    mainField.style.display = 'none';
                    subField.style.display = 'block';
                } else {
                    mainField.style.display = 'none';
                    subField.style.display = 'none';
                }
            });
        });
    </script>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dbquery/assets/header.php'; ?>

    <div class="container-lg w-100 px-3 my-5 mx-auto">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="my-2">เลือกรูปแบบอุปกรณ์</h5>
            </div>

            <div class="card-body">
                <form id="asset-type-selection">
                    <select id="asset-type-options" name="asset_type" class="form-select" required>
                        <option value="">กรุณาเลือกรูปแบบ</option>
                        <option value="main,1">คอมพิวเตอร์</option>
                        <option value="main,2">โน้ตบุ๊ค</option>
                        <option value="sub,3">มอนิเตอร์</option>
                        <option value="sub,4">คีย์บอร์ด</option>
                        <option value="sub,5">เมาส์</option>
                        <option value="sub,6">เครื่องสำรองไฟ</option>
                        <option value="sub,7">อะแดปเตอร์/สายชาร์จ</option>
                        <option value="sub,8">เราต์เตอร์/Wifi</option>
                        <option value="sub,9">สวิตช์ฮับ</option>
                        <option value="sub,10">แฟลชไดรฟ์</option>
                        <option value="sub,11">ลำโพง</option>
                        <option value="sub,12">iPad & Tablet</option>
                        <option value="sub,13">Printer</option>
                        <option value="sub,14">ฮาร์ดดิสก์</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="card" id="asset-details" style="display: none;">
            <div class="card-header">
                <h5 class="my-2">กรอกข้อมูลรายละเอียด</h5>
            </div>

            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="asset_type" id="asset_type_input" value="">

                    <!-- Main asset fields -->
                    <div id="main-field" style="display: none;">
                        <div class="mb-3">
                            <label for="computer-name" class="form-label">ชื่อเครื่อง</label>
                            <input type="text" class="form-control" id="computer-name" name="computer_name">
                        </div>

                        <div class="mb-3">
                            <label for="computer-specs" class="form-label">Specifications</label>
                            <textarea class="form-control" id="computer-specs" name="computer_specs" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">สถานะ :</label>
                            <select name="status_id" class="form-select" required>
                                <?php while ($status = $allstatus_result->fetch_assoc()) : ?>
                                    <option value="<?php echo $status['StatusID']; ?> ">
                                        <?php echo $status['StatusName']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Sub asset fields -->
                    <div id="sub-field" style="display: none;">
                        <div class="mb-3">
                            <label for="accessory-name" class="form-label">Accessory Name</label>
                            <input type="text" class="form-control" id="accessory-name" name="accessory_name">
                        </div>

                        <div class="mb-3">
                            <label for="accessory-type" class="form-label">Accessory Type</label>
                            <select id="accessory-type" name="accessory_type" class="form-select">
                                <option value="">-- Select Accessory Type --</option>
                                <option value="mouse">Mouse</option>
                                <option value="monitor">Monitor</option>
                                <option value="keyboard">Keyboard</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">สถานะ :</label>
                            <select name="status_id" class="form-select" required>
                                <?php while ($status = $allstatus_result->fetch_assoc()) : ?>
                                    <option value="<?php echo $status['StatusID']; ?> ">
                                        <?php echo $status['StatusName']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
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