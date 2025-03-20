<?php
require_once "../project/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $com_id = $_POST["com_id"];
    $status_id = $_POST["status_id"];

    $sql = "UPDATE computer SET Stat_ID = ? WHERE Com_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status_id, $com_id);

    if ($stmt->execute()) {
        header("Location: index.php"); // กลับไปที่หน้าหลัก
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
