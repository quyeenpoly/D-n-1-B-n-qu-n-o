<?php 

// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/AdminDanhMucController.php';
require_once './controllers/AdminSanPhamController.php';

// Require toàn bộ file Models
require_once './models/AdminDanhMuc.php';
require_once './models/AdminSanPham.php';
// Route
$act = $_GET['act'] ?? '/';


match ($act) {
    // route
    'danh-muc' => (new AdminDanhMucController())->danhSachDanhMuc(),
    'form-them-danh-muc' => (new AdminDanhMucController())->formAddDanhMuc(), //Phương thức hiển thị form
    'them-danh-muc' => (new AdminDanhMucController())->postAddDanhMuc(), //Xử lí nhận và post vào CSDL

   
    'form-sua-danh-muc' => (new AdminDanhMucController())->formEditDanhMuc(), //Phương thức hiển thị form sửa
    'sua-danh-muc' => (new AdminDanhMucController())->postEditDanhMuc(), //Xử lí nhận và cập nhật vào CSDL 
    'xoa-danh-muc' => (new AdminDanhMucController())->deleteDanhMuc(), //Xử lí nhận và cập nhật vào CSDL 

   
   
};