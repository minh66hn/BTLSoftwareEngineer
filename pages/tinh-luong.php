<?php

// create session
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
  // include file
  include('../layouts/header.php');
  include('../layouts/topbar.php');
  include('../layouts/sidebar.php');


  // tao bien mac dinh
  $salaryCode = "ML" . time();

  // show data
  $nv = "SELECT id, ma_nv, ten_nv FROM nhanvien";
  $resultNV = mysqli_query($conn, $nv);
  $arrNV = array();
  while ($rowNV = mysqli_fetch_array($resultNV)) {
    $arrNV[] = $rowNV;
  }

  // thang tinh luong
  $thang = date_create(date("Y-m-d"));
  $thangFormat = date_format($thang, "m/Y");

  // tinh luong nhan vien
  if (isset($_POST['tinhLuong'])) {
    // tao cac gia tri mac dinh
    $showMess = false;
    $error = array();
    $success = array();

    // lay gia tri tren form
    $maNhanVien = $_POST['maNhanVien'];
    $soNgayCong = $_POST['soNgayCong'];
    $moTa = $_POST['moTa'];
    $ngayTinhLuong = $_POST['ngayTinhLuong'];
    $user_id = $row_acc['id'];
    $ngayTao = date("Y-m-d H:i:s");

    // validate
    if (empty($soNgayCong))
      $error['soNgayCong'] = 'error';
    if ($maNhanVien == 'chon')
      $error['maNhanVien'] = 'error';
    if (!empty($soNgayCong) && !is_numeric($soNgayCong))
      $error['kiemTraKieuSo'] = 'error';

    // lay luong ngay cua nhan vien theo chuc vu
    $luongNgay = "SELECT luong_ngay FROM nhanvien nv, chuc_vu cv WHERE nv.chuc_vu_id = cv.id AND nv.id = $maNhanVien";
    $resultLuongNgay = mysqli_query($conn, $luongNgay);
    $rowLuongNgay = mysqli_fetch_array($resultLuongNgay);
    $getLuongNgay = $rowLuongNgay['luong_ngay'];



    // tinh luong co ban
      $luongThang = $soNgayCong * $getLuongNgay;
    if (!$error) {
      // them vao db
      $insert = "INSERT INTO luong(ma_luong, nhanvien_id, luong_thang, ngay_cong, ngay_cham, ghi_chu, nguoi_tao_id, ngay_tao, nguoi_sua_id, ngay_sua) VALUES('$salaryCode', $maNhanVien, $luongThang, $soNgayCong, '$ngayTinhLuong', '$moTa', $user_id, '$ngayTao', $user_id, '$ngayTao')";
      $result = mysqli_query($conn, $insert);

      if ($result) {
        $showMess = true;
        $success['success'] = 'Tính lương thành công';
        echo '<script>setTimeout("window.location=\'bang-luong.php?p=salary&a=salary\'",1000);</script>';
      } else {
        echo "<script>alert('Lõii');</script>";
      }
    }
  }

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tính lương
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Tổng quan</a></li>
        <li><a href="tinh-luong.php?p=salary&a=salary">Tính lương</a></li>
        <li class="active">Tính lương nhân viên</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tính lương nhân viên</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php
              // show error
              if ($row_acc['quyen'] != 1) {
                echo "<div class='alert alert-warning alert-dismissible'>";
                echo "<h4><i class='icon fa fa-ban'></i> Thông báo!</h4>";
                echo "Bạn <b> không có quyền </b> thực hiện chức năng này.";
                echo "</div>";
              }
              ?>

              <?php
              // show error
              if (isset($error2)) {
                if ($showMess == false) {
                  echo "<div class='alert alert-danger alert-dismissible'>";
                  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                  echo "<h4><i class='icon fa fa-ban'></i> Lỗi!</h4>";
                  foreach ($error2 as $err2) {
                    echo $err2 . "<br/>";
                  }
                  echo "</div>";
                }
              }
              ?>
              <?php
              // show success
              if (isset($success)) {
                if ($showMess == true) {
                  echo "<div class='alert alert-success alert-dismissible'>";
                  echo "<h4><i class='icon fa fa-check'></i> Thành công!</h4>";
                  foreach ($success as $suc) {
                    echo $suc . "<br/>";
                  }
                  echo "</div>";
                }
              }
              ?>
              <form action="" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Mã lương: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="maLuong" value="<?php echo $salaryCode; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nhân viên: </label>
                      <select class="form-control" name="maNhanVien" id="idNhanVien">
                        <option value="chon">--- Chọn nhân viên ---</option>
                        <?php
                        foreach ($arrNV as $nv) {
                          echo "<option value='" . $nv['id'] . "'>" . $nv['ma_nv'] . " - " . $nv['ten_nv'] . "</option>";
                        }
                        ?>
                      </select>
                      <small style="color: red;"><?php if (isset($error['maNhanVien'])) {
                                                    echo 'Vui lòng chọn nhân viên';
                                                  } ?></small>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Số ngày công<span style="color: red;">*</span> : </label>
                      <input type="text" class="form-control" placeholder="Nhập số ngày công" name="soNgayCong" value="<?php echo isset($_POST['soNgayCong']) ? $_POST['soNgayCong'] : ''; ?>" id="soNgayCong">
                      <small style="color: red;"><?php if (isset($error['soNgayCong'])) {
                                                    echo 'Số ngày công không được để trống';
                                                  } ?></small>
                      <small style="color: red;"><?php if (isset($error['kiemTraKieuSo'])) {
                                                    echo 'Vui lòng nhập số';
                                                  } ?></small>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Ngày tính lương: </label>
                      <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Nhập số tiền phụ cấp" name="ngayTinhLuong" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Mô tả: </label>
                      <textarea id="editor1" rows="10" cols="80" name="moTa" class="ckeditor">
                      </textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Người tạo: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row_acc['ho']; ?> <?php echo $row_acc['ten']; ?>" name="nguoiTao" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Ngày tạo: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo date('d-m-Y H:i:s'); ?>" name="ngayTao" readonly>
                    </div>
                    <!-- /.form-group -->
                    <?php
                    if ($_SESSION['level'] == 1)
                      echo "<button type='submit' class='btn btn-primary' name='tinhLuong'><i class='fa fa-money'></i> Tính lương nhân viên</button>";
                    ?>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<?php
  // include
  include('../layouts/footer.php');
} else {
  // go to pages login
  header('Location: dang-nhap.php');
}

?>