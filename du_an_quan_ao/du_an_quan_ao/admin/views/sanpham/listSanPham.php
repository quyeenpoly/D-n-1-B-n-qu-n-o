<!-- header -->
<?php include "./views/layout/header.php"; 
?>
<!-- end header -->
  <!-- Navbar -->

 <?php include "./views/layout/navbar.php"; ?>

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

<?php include "./views/layout/sidebar.php"; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
       
          <div class="col-sm-6">
            <h1>Quản lý danh sách sản phẩm</h1>
          </div>
          <!-- --------------------------------------------------------------------------------------------- -->
          <!-- THÔNG BÁO XÓA THÀNH CÔNG -->
          <div class="col-sm-6">
          <?php  
            // Kiểm tra và hiển thị thông báo nếu có  
            if (isset($_SESSION['message'])) {  
                echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';  
                // Xóa thông báo khỏi session sau khi hiển thị  
                unset($_SESSION['message']);  
            }  
            ?>
          </div>
          <!-- ---------------------------------------------------------------------------------------------- -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a href="<?= BASE_URL_ADMIN . '?act=form-them-san-pham'?>">
                  <button class="btn btn-success">Thêm sản phẩm</button>
                 
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Giá tiền</th>
                    <th>Số lượng</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($listSanPham as $key=>$sanPham):?>
                        <tr>
                          <td><?= $key+1?></td>
                          <td><?= $sanPham["ten_san_pham"] ?></td>
                          <td>
                            <img src=" <?= BASE_URL . $sanPham["hinh_anh"] ?>" style="width:100px" alt=""
                            onerror="this.onerror=null; this.src='https://png.pngtree.com/png-vector/20190820/ourlarge/pngtree-no-avatar-vector-isolated-on-white-background-png-image_1694546.jpg'"
                            >
                          </td>
                          <td><?= $sanPham["gia_san_pham"] ?></td>
                          <td><?= $sanPham["so_luong"] ?></td>
                          <td><?= $sanPham["ten_danh_muc"] ?></td>
                          <td><?= $sanPham["trang_thai"] == 1 ? "Còn hàng" : "Dừng bán" ?></td>
                        
                         
                          <td>
                            <div class="btn-group">
                                <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id_san_pham=' . $sanPham['id']?>">
                                  <button class="btn btn-primary"><i class="far fa-eye"></i></button>
                                </a>
                                <a href="<?= BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham=' . $sanPham['id']?>">
                                  <button class="btn btn-warning"><i class="fas fa-tools"></i></button>
                                </a>
                                <a href="<?= BASE_URL_ADMIN . '?act=xoa-san-pham&id_san_pham=' . $sanPham['id']?>" onclick="return confirm('Bạn chắc chắn muốn xóa danh mục?')">
                                  <button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </a>
                            </div>
                            
                           
                          </td>
                        </tr>
                    <?php endforeach ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Giá tiền</th>
                    <th>Số lượng</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
<!-- footer -->
 <?php include "./views/layout/footer.php" ?>
<!-- end footer -->
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<!-- Code injected by live-server -->
</body>
</html>