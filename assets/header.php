<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสินทรัพย์</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-dark maintheme">
            <div class="container">
                <a class="navbar-brand" href="<?php echo $rooturl; ?>index.php">
                    <i class="fas fa-desktop"></i>&nbsp;&nbsp;ระบบจัดการครุภัณฑ์
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="mainComputerDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-desktop"></i> คอมพิวเตอร์หลัก
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item <?php echo $current_page === 'index' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>index.php">
                                    <span class="moving-text"><i class="fas fa-desktop"></i></span> <span class="moving-text">คอมพิวเตอร์</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'notebook' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/maincom/notebook.php">
                                    <span class="moving-text"><i class="fas fa-laptop"></i></span> <span class="moving-text">โน้ตบุ๊ค</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'monitor' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/maincom/monitor.php">
                                    <span class="moving-text"><i class="fas fa-tv"></i></span> <span class="moving-text">จอภาพ</span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="peripheralDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-plug"></i> ต่อพ่วง
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item <?php echo $current_page === 'mouse' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/connector/mouse.php">
                                    <span class="moving-text"><i class="fas fa-mouse"></i></span> <span class="moving-text">เมาส์</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'keyboard' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/connector/keyboard.php">
                                    <span class="moving-text"><i class="fas fa-keyboard"></i></span> <span class="moving-text">คีย์บอร์ด</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'printer' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/connector/printer.php">
                                    <span class="moving-text"><i class="fas fa-print"></i></span> <span class="moving-text">เครื่องพิมพ์</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'speaker' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/connector/speaker.php">
                                    <span class="moving-text"><i class="fas fa-volume-up"></i></span> <span class="moving-text">ลำโพง</span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="networkDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-network-wired"></i> เครือข่าย
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item <?php echo $current_page === 'router' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/network/router.php">
                                    <span class="moving-text"><i class="fas fa-wifi"></i></span> <span class="moving-text">เครื่องกระจายสัญญาณ/Wifi</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'switch' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/network/switch.php">
                                    <span class="moving-text"><i class="fas fa-network-wired"></i></span> <span class="moving-text">สวิตซ์ฮับ</span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="storageDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-hdd"></i> จัดเก็บข้อมูล
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item <?php echo $current_page === 'harddisk' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/storage/harddisk.php">
                                    <span class="moving-text"><i class="fas fa-hdd"></i></span> <span class="moving-text">ฮาร์ดดิสก์</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'flashdrive' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/storage/flashdrive.php">
                                    <span class="moving-text"><i class="fa-solid fa-link"></i></span> <span class="moving-text">แฟลชไดร์ฟ</span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accessoryDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-puzzle-piece"></i> อุปกรณ์เสริม
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item <?php echo $current_page === 'powersup' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/accessory/powersup.php">
                                    <span class="moving-text"><i class="fas fa-plug"></i></span> <span class="moving-text">เครื่องสำรองไฟ</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'tablet' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/accessory/tablet.php">
                                    <span class="moving-text"><i class="fas fa-tablet-alt"></i></span> <span class="moving-text">iPad & Tablet</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'adapter' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/accessory/adapter.php">
                                    <span class="moving-text"><i class="fas fa-charging-station"></i></span> <span class="moving-text">อแดปเตอร์และสายชาร์จ</span>
                                </a>
                            </div>
                        </li>

                        <!-- <li class="nav-item">
                            <a class="nav-link <?php // echo $current_page === 'repairs' ? 'active' : ''; 
                                                ?>" href="<?php // echo $rooturl; 
                                                            ?>pages/manage/repair-list.php">
                                <i class="fas fa-tools"></i> ซ่อมบำรุง
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php // echo $current_page === 'repairs' ? 'active' : ''; 
                                                ?>" href="<?php // echo $rooturl; 
                                                            ?>pages/manage/addnew.php">
                                <i class="fa-solid fa-plus"></i> เพิ่มข้อมูล
                            </a>
                        </li> -->
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-cog"></i> ผู้ดูแล
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- <a class="dropdown-item <?php // echo $current_page === 'admin' ? 'active' : ''; 
                                                                ?>" href="<?php // echo $rooturl; 
                                                                            ?>pages/manage/admin.php">
                                    <span class="moving-text"><i class="fas fa-cogs"></i></span> <span class="moving-text">จัดการระบบ</span>
                                </a> -->
                                <a class="dropdown-item <?php echo $current_page === 'addnew' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/manage/addnew.php">
                                    <span class="moving-text"><i class="fa-solid fa-plus"></i></span> <span class="moving-text">เพิ่มข้อมูล</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'repair' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/manage/repair-list.php">
                                    <span class="moving-text"><i class="fas fa-tools"></i></span> <span class="moving-text">ซ่อมบำรุง</span>
                                </a>
                                <a class="dropdown-item <?php echo $current_page === 'reports' ? 'active' : ''; ?>" href="<?php echo $rooturl; ?>pages/manage/reports.php">
                                    <span class="moving-text"><i class="fa-solid fa-chart-simple"></i></span> <span class="moving-text">รายงาน</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>