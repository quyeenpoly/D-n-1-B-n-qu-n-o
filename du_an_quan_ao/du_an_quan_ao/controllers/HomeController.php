<?php 

class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDonHang;

    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
        $this->modelDonHang = new DonHang();
    }

    public function home(){
        $listSanPham = $this->modelSanPham->getAllSanPham();
       require_once './views/home.php';
    }
    
   
    public function chiTietSanPham(){
        // hàm này hiện form nhập
        // Lấy ra thông tin của sản phẩm cần sửa đã viết ở model
        $id = $_GET["id"];
        // var_dump($id);die;

        $sanPham = $this->modelSanPham->getDetailSanPham($id);

        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);

        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['category_id']);
        if($sanPham){
          require_once './views/detailSanPham.php';
        }else{
            // var_dump("123");die();
          header("Location: " . BASE_URL);
          exit();
        } 
    }





    public function formLogin(){
      require_once "./views/auth/formLogin.php";
      deleteSessionError();
    }
     public function postLogin(){
      if($_SERVER['REQUEST_METHOD'] == "POST"){
        // Lấy email và pass gửi lên từ form
        $email = $_POST['email'];
        $password = $_POST['password'];
        // var_dump($password);
    
        // Xử lí kiểm tra thông tin đăng nhập
        $user = $this->modelTaiKhoan->checkLogin($email, $password);
    
        if($user == $email){ // TH đăng nhập thành công
          // Lưu thông tin vào session
          $_SESSION["user_client"] = $user;
          header("Location: " . BASE_URL);
          exit();
        }else{
          // Lỗi thì lưu lỗi vào SESSION
          $_SESSION["error"] = $user;
          // var_dump($_SESSION['error']);die();
          $_SESSION["flash"] = true;
          header("Location: " .BASE_URL. "?act=login");
          exit();
    
        }
      }
     }

  public function addGioHang(){
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      if(isset($_SESSION["user_client"])){
        $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION["user_client"]);
         // Lấy dữ liệu của người dùng
        //  var_dump($mail["id"]);die;
         $gioHang = $this->modelGioHang->getGioHangFromUser($mail["id"]);
         if(!$gioHang){
            $gioHangId = $this->modelGioHang->addGioHang($mail["id"]);
            $gioHang = ['id' => $gioHangId];
            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
         }else{
          $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
         }
         
         $san_pham_id = $_POST["san_pham_id"];
         $so_luong = $_POST["so_luong"];
         $checkSanPham = false;
         foreach($chiTietGioHang as $detail){
              if($detail['product_id'] == $san_pham_id){
                $newSoLuong = $detail["so_luong"] + $so_luong;
                $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
                $checkSanPham = true;
                break;
              }
          }
          if(!$checkSanPham){
            $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);

          }
      header("Location:" .BASE_URL.'?act=gio-hang');
   
      }else{
        var_dump("Chưa đăng nhập");die;
      }
 
     
      }
    }
      public function gioHang(){
        if(isset($_SESSION["user_client"])){
          $mail = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION["user_client"]);
           // Lấy dữ liệu của người dùng
          //  var_dump($mail["id"]);die;
           $gioHang = $this->modelGioHang->getGioHangFromUser($mail["id"]);
           if(!$gioHang){
              $gioHangId = $this->modelGioHang->addGioHang($mail["id"]);
              $gioHang = ['id' => $gioHangId];
              $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
           }else{
            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
           }

        require_once './views/gioHang.php';
     
        }else{
          header("Location: " .BASE_URL."?act=login");
        }
      }
    public function thanhToan(){
      if(isset($_SESSION["user_client"])){
        $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION["user_client"]);
         // Lấy dữ liệu của người dùng
        //  var_dump($mail["id"]);die;
         $gioHang = $this->modelGioHang->getGioHangFromUser($user["id"]);
         if(!$gioHang){
            $gioHangId = $this->modelGioHang->addGioHang($user["id"]);
            $gioHang = ['id' => $gioHangId];
            $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
         }else{
          $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
         }

         require_once './views/thanhToan.php';
   
      }else{
        header("Location: " .BASE_URL."?act=login");
      }
      require_once './views/thanhToan.php';

    }
    public function postThanhToan(){
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        // var_dump($_POST);die;
        $ten_nguoi_nhan = $_POST["ten_nguoi_nhan"];
        $email_nguoi_nhan = $_POST["email_nguoi_nhan"];
        $sdt_nguoi_nhan = $_POST["sdt_nguoi_nhan"];
        $dia_chi_nguoi_nhan = $_POST["dia_chi_nguoi_nhan"];
        $ghi_chu = $_POST["ghi_chu"];
        $tong_tien = $_POST["tong_tien"];
        $payment_method_id = $_POST["payment_method_id"]; // phuong_thuc_thanh_toan_id

        $ngay_dat = date('Y-m-d');
        $order_status_id = 1; // trạng thái đơn hàng  = 1 chưa xác nhận

        $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION["user_client"]);
        $user_id = $user['id']; // tai_khoan_id

        $ma_don_hang = "DH-". rand(1000,9999);

        // Thêm thông tin vào db
        $this->modelDonHang->addDonHang($user_id,
        $ten_nguoi_nhan,
        $sdt_nguoi_nhan,
        $email_nguoi_nhan,
        $dia_chi_nguoi_nhan, 
        $ghi_chu,
        $tong_tien, 
        $payment_method_id,
        $ngay_dat,
        $order_status_id,
        $ma_don_hang
      );
      var_dump('Thêm Thành công'); die;
      }
    }
     
  }
