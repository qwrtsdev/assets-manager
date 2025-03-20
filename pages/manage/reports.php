<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dbquery/server/global.php";

$current_page = 'reports';
$search = isset($_GET['search']) ? $_GET['search'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินทรัพย์ | รายงาน</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../../favicon.ico">
    <link rel="stylesheet" href="/dbquery/styles.css">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dbquery/assets/header.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>