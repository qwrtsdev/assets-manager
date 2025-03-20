<?php
// This file is intentionally left blank.

// Include the database connection file
include 'connect.php';
include 'header.php';

// Query to fetch repair history data with status name, branch, and department
$query = "SELECT rh.*, s.Stat_name, b.Branch_name, d.Department_name 
          FROM repair_history rh 
          JOIN stat s ON rh.Stat_ID = s.Stat_ID 
          JOIN branch b ON rh.Branch_id = b.Branch_ID 
          JOIN department d ON rh.Department_id = d.Department_ID
          ORDER BY rh.repair_id";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

// New query to count repairs by branch and fetch details
$countQuery = "
    SELECT 
        b.Branch_name,
        d.Department_name,
        COUNT(*) as repair_count,
        GROUP_CONCAT(CONCAT('รหัสการซ่อม: ', rh.repair_id, ' (', rh.equipment_type, ')') SEPARATOR '<br>') as repair_details
    FROM repair_history rh
    INNER JOIN branch b ON rh.Branch_id = b.Branch_ID
    INNER JOIN department d ON rh.Department_id = d.Department_ID
    GROUP BY b.Branch_name, d.Department_name
";
$countResult = mysqli_query($conn, $countQuery);

// Check if the count query was successful
if (!$countResult) {
    die('Count query failed: ' . mysqli_error($conn));
}

// Fetch the count results into an associative array
$countData = [];
while ($row = mysqli_fetch_assoc($countResult)) {
    $countData[] = $row;
}
?>

<!-- New summary table for repairs by branch -->
<div class="container mt-5">
    <h2 class="text-center mb-4">สรุปจำนวนการซ่อมตามสาขา <i class="fas fa-tools"></i></h2>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>สาขา <i class="fas fa-building"></i></th>
                <th>แผนก</th>
                <th>จำนวนการซ่อม <i class="fas fa-repair"></i></th>
                <th>รายละเอียดการซ่อม</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($countData as $data): ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['Branch_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($data['Department_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo $data['repair_count'] ?: '-'; ?></td>
                    <td><?php echo $data['repair_details'] ?: '-'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
