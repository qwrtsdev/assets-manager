$sql = "SELECT x.*, s.Stat_name as status, d.Department_name, b.Branch_name
        FROM x_table x
        JOIN stat s ON x.Stat_ID = s.Stat_ID
        JOIN department d ON x.Department_ID = d.Department_ID
        JOIN branch b ON x.Branch_ID = b.Branch_ID
        WHERE x.ID LIKE ? 
        OR x.SN LIKE ? 
        OR x.Com_ID LIKE ?"; 

<thead>
    <tr>
        <th><i class="fas fa-list-ol"></i> ลำดับ</th>
        <th><i class="fas fa-barcode"></i> หมายเลขซีเรียล</th>
        <th><i class="fas fa-desktop"></i> รหัสคอมพิวเตอร์</th>
        <th><i class="fas fa-building"></i> สาขา</th>
        <th><i class="fas fa-users"></i> แผนก</th>
        <th><i class="fas fa-info-circle"></i> สถานะ</th>
        <th><i class="fas fa-cogs"></i> การดำเนินการ</th>
    </tr>
</thead> 

<td><?php echo $counter++; ?></td>
<td><?php echo htmlspecialchars($row["SN"]); ?></td>
<td><?php echo htmlspecialchars($row["Com_ID"]); ?></td>
<td><?php echo htmlspecialchars($row["Branch_name"]); ?></td>
<td><?php echo htmlspecialchars($row["Department_name"]); ?></td>
<td>
    <?php 
    $status = $row['status'];
    $badge_class = match($status) {
        'เสร็จสิ้น' => 'bg-secondary',
        'ปกติ' => 'bg-success',
        'รอการซ่อม' => 'bg-warning',
        'กำลังซ่อม' => 'bg-info',
        'รออะไหล่' => 'bg-secondary',
        'ส่งซ่อมภายนอก' => 'bg-primary',
        'ซ่อมไม่ได้' => 'bg-danger',
        default => 'bg-secondary'
    };
    echo $status === 'เสร็จสิ้น' ? "<span class='badge $badge_class'>เสร็จสิ้น</span>" : "<span class='badge $badge_class'>$status</span>";
    ?>
</td>
<td>
    <a href="repair_form.php?type=x&id=<?php echo urlencode($row["ID"]); ?>" 
       class="btn btn-warning btn-sm">
        <i class="fas fa-tools"></i> บันทึกการซ่อม
    </a>
</td> 