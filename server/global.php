<?php
$rooturl = "http://localhost/dbquery/"; // for development

$tables = [
    1   =>  ['table' => 'computer', 'column' => 'ComputerID', 'msg' => 'คอมพิวเตอร์', 'short' => 'Computer'],
    2   =>  ['table' => 'notebook', 'column' => 'NotebookID', 'msg' => 'โน๊ตบุ๊ค', 'short' => 'Notebook'],
    3   =>  ['table' => 'monitor', 'column' => 'MonitorID', 'msg' => 'มอนิเตอร์', 'short' => 'Monitor'],
    4   =>  ['table' => 'keyboard', 'column' => 'KeyboardID', 'msg' => 'คีย์บอร์ด', 'short' => 'Keyboard'],
    5   =>  ['table' => 'mouse', 'column' => 'MouseID', 'msg' => 'เมาส์', 'short' => 'Mouse'],
    6   =>  ['table' => 'ups', 'column' => 'UpsID', 'msg' => 'เครื่องสำรองไฟ', 'short' => 'Ups'],
    7   =>  ['table' => 'adapter', 'column' => 'AdapterID', 'msg' => 'อะแดปเตอร์', 'short' => 'Adapter'],
    8   =>  ['table' => 'router', 'column' => 'RouterID', 'msg' => 'เราต์เตอร์', 'short' => 'Router'],
    9   =>  ['table' => 'switchhub', 'column' => 'SwitchHubID', 'msg' => 'สวิตช์ฮับ', 'short' => 'SwitchHub'],
    10  =>  ['table' => 'usb', 'column' => 'USBID', 'msg' => 'แฟลชไดรฟ์', 'short' => 'USB'],
    11  =>  ['table' => 'speaker', 'column' => 'SpeakerID', 'msg' => 'ลำโพง', 'short' => 'Speaker'],
    12  =>  ['table' => 'ipad', 'column' => 'iPadID', 'msg' => 'ไอแพด/แท็บเล็ต', 'short' => 'iPad'],
    13  =>  ['table' => 'printer', 'column' => 'PrinterID', 'msg' => 'เครื่องถ่ายเอกสาร', 'short' => 'Printer'],
    14  =>  ['table' => 'harddisk', 'column' => 'HarddiskID', 'msg' => 'ฮาร์ดดิสก์', 'short' => 'Harddisk'],
    15  =>  ['table' => 'other', 'column' => 'OtherID', 'msg' => 'อื่นๆ', 'short' => 'Other'],
];

$inputtypes = [
    1   =>  ['serial' => 'SN'],
    2   =>  ['id' => 'ID'],
];

function getStatusLabelName($StatusNumber)
{
    $statusLabels = [
        0 => 'เสีย',
        1 => 'ใช้งาน',
        2 => 'ส่งซ่อม',
        3 => 'รออะไหล่',
        4 => 'ซ่อมไม่ได้',
        5 => 'ยกเลิกการซ่อม',
        6 => 'จำหน่าย',
        7 => 'เสร็จสิ้น',
    ];

    return isset($statusLabels[$StatusNumber]) ? $statusLabels[$StatusNumber] : $StatusNumber;
}

function getStatusLabelColor($StatusNumber)
{
    $statusLabels = [
        0 => 'bg-secondary', // เสีย
        1 => 'bg-success',   // ใช้งาน
        2 => 'bg-warning',   // ส่งซ่อม
        3 => 'bg-warning',   // รออะไหล่
        4 => 'bg-danger',    // ซ่อมไม่ได้
        5 => 'bg-danger',    // ยกเลิกการซ่อม
        6 => 'bg-info',      // จำหน่าย
        7 => 'bg-secondary'  // เสร็จสิ้น
    ];

    return isset($statusLabels[$StatusNumber]) ? $statusLabels[$StatusNumber] : 'bg-secondary';
}
