<?php

// create session
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
  // include file
  include('../layouts/header.php');
  include('../layouts/topbar.php');
  include('../layouts/sidebar.php');

  // create  var default
  $maNhanVien = "MNV" . time();

  // show data


  // ----- Phòng ban
  $phongBan = "SELECT id, ten_phong_ban FROM phong_ban";
  $resultPhongBan = mysqli_query($conn, $phongBan);
  $arrPhongBan = array();
  while ($rowPhongBan = mysqli_fetch_array($resultPhongBan)) {
    $arrPhongBan[] = $rowPhongBan;
  }

  // ----- Chức vụ
  $chucVu = "SELECT id, ten_chuc_vu FROM chuc_vu";
  $resultChucVu = mysqli_query($conn, $chucVu);
  $arrChucVu = array();
  while ($rowChucVu = mysqli_fetch_array($resultChucVu)) {
    $arrChucVu[] = $rowChucVu;
  }

  // chuc nang them nhan vien
  if (isset($_POST['save'])) {
    // tao bien bat loi
    $error = array();
    $success = array();
    $showMess = false;

    // lay du lieu ve
    $tenNhanVien = $_POST['tenNhanVien'];
    $CMND = $_POST['CMND'];
    $gioiTinh = $_POST['gioiTinh'];
    $ngaySinh = $_POST['ngaySinh'];
    $tamTru = $_POST['tamTru'];
    $phongBan = $_POST['phongBan'];
    $chucVu = $_POST['chucVu'];
    $id_user = $row_acc['id'];
    $ngayTao = date("Y-m-d H:i:s");

    // cau hinh o chon anh
    $hinhAnh = $_FILES['hinhAnh']['name'];
    $target_dir = "../uploads/staffs/";
    $target_file = $target_dir . basename($hinhAnh);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // validate
    if (empty($tenNhanVien))
      $error['tenNhanVien'] = 'error';
    if (empty($CMND))
      $error['CMND'] = 'error';
    if ($gioiTinh == 'chon')
      $error['gioiTinh'] = 'error';
    if (empty($tamTru))
      $error['tamTru'] = 'error';
    if ($phongBan == 'chon')
      $error['phongBan'] = 'error';
    if ($chucVu == 'chon')
      $error['chucVu'] = 'error';

    // validate file
    if ($hinhAnh) {
      if ($_FILES['hinhAnh']['size'] > 50000000)
        $error['kichThuocAnh'] = 'error';
      if ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif')
        $error['kieuAnh'] = 'error';
    }

    if (!$error) {
      if ($hinhAnh) {
        $imageName = time() . "." . $imageFileType;
        $moveFile = $target_dir . $imageName;

        // insert data
        $insert = "INSERT INTO nhanvien(ma_nv, hinh_anh, ten_nv, gioi_tinh, ngay_sinh, so_cmnd,  tam_tru, phong_ban_id, chuc_vu_id,  nguoi_tao_id, ngay_tao, nguoi_sua_id, ngay_sua) VALUES('$maNhanVien', '$imageName', '$tenNhanVien',  '$gioiTinh', '$ngaySinh',  '$CMND', '$tamTru', '$phongBan', '$chucVu', '$id_user', '$ngayTao', '$id_user', '$ngayTao')";
        $result = mysqli_query($conn, $insert);
        if ($result) {
          $showMess = true;
          // move image
          move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $moveFile);

          $success['success'] = 'Thêm nhân viên thành công';
          echo '<script>setTimeout("window.location=\'them-nhan-vien.php?p=staff&a=add-staff\'",1000);</script>';
        }
      } else {
        $showMess = true;
        $hinhAnh = "demo-3x4.jpg";
        // insert data
        $insert = "INSERT INTO nhanvien(ma_nv, hinh_anh, ten_nv, gioi_tinh, ngay_sinh, so_cmnd,  tam_tru, phong_ban_id, chuc_vu_id,  nguoi_tao_id, ngay_tao, nguoi_sua_id, ngay_sua) VALUES('$maNhanVien', '$imageName', '$tenNhanVien',  '$gioiTinh', '$ngaySinh',  '$CMND', '$tamTru', '$phongBan', '$chucVu', '$id_user', '$ngayTao', '$id_user', '$ngayTao')";
        $result = mysqli_query($conn, $insert);
        if ($result) {
          $success['success'] = 'Thêm nhân viên thành công';
          echo '<script>setTimeout("window.location=\'them-nhan-vien.php?p=staff&a=add-staff\'",1000);</script>';
        }
      }
    }
  }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Thêm mới nhân viên
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Tổng quan</a></li>
        <li><a href="them-nhan-vien.php?p=staff&a=add-staff">Nhân viên</a></li>
        <li class="active">Thêm mới nhân viên</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Thêm mới nhân viên</h3> &emsp;
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
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Mã nhân viên: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="maNhanVien" value="<?php echo $maNhanVien; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label>Tên nhân viên <span style="color: red;"></span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên nhân viên" name="tenNhanVien" value="<?php echo isset($_POST['tenNhanVien']) ? $_POST['tenNhanVien'] : ''; ?>">
                      <small style="color: red;"><?php if (isset($error['tenNhanVien'])) {
                                                    echo "Tên nhân viên không được để trống";
                                                  } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Số CMND <span style="color: red;"></span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nhập số CMND" name="CMND" value="<?php echo isset($_POST['CMND']) ? $_POST['CMND'] : ''; ?>">
                      <small style="color: red;"><?php if (isset($error['CMND'])) {
                                                    echo "Vui lòng nhập số CMND";
                                                  } ?></small>
                    </div>

                    <!-- /.col -->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Ảnh 3x4 (Nếu có): </label>
                        <input type="file" class="form-control" id="exampleInputEmail1" name="hinhAnh">
                        <small style="color: red;"><?php if (isset($error['kichThuocAnh'])) {
                                                      echo "Kích thước ảnh quá lớn";
                                                    } ?></small>
                        <small style="color: red;"><?php if (isset($error['kieuAnh'])) {
                                                      echo "Chỉ nhận file ảnh dạng: jpg, jpeg, png, gif";
                                                    } ?></small>
                      </div>
                      <div class="form-group">
                        <label>Giới tính <span style="color: red;"></span>: </label>
                        <select class="form-control" name="gioiTinh">
                          <option value="chon">--- Chọn giới tính ---</option>
                          <option value="1">Nam</option>
                          <option value="0">Nữ</option>
                        </select>
                        <small style="color: red;"><?php if (isset($error['gioiTinh'])) {
                                                      echo "Vui lòng chọn giới tính";
                                                    } ?></small>
                      </div>
                      <div class="form-group">
                        <label>Ngày sinh: </label>
                        <input type="date" class="form-control" id="exampleInputEmail1" name="ngaySinh" value="<?php echo date("Y-m-d"); ?>">
                      </div>

                      <div class="form-group">
                        <label>Tạm trú: </label>
                        <textarea class="form-control" name="tamTru"><?php echo isset($_POST['tamTru']) ? $_POST['tamTru'] : ''; ?></textarea>
                      </div>
                      <div class="form-group">
                        <label>Phòng ban <span style="color: red;"></span>: </label>
                        <select class="form-control" name="phongBan">
                          <option value="chon">--- Chọn phòng ban ---</option>
                          <?php
                          foreach ($arrPhongBan as $pb) {
                            echo "<option value='" . $pb['id'] . "'>" . $pb['ten_phong_ban'] . "</option>";
                          }
                          ?>
                        </select>
                        <small style="color: red;"><?php if (isset($error['phongBan'])) {
                                                      echo "Vui lòng chọn phòng ban";
                                                    } ?></small>
                      </div>
                      <div class="form-group">
                        <label>Chức vụ <span style="color: red;"></span>: </label>
                        <select class="form-control" name="chucVu">
                          <option value="chon">--- Chọn chức vụ ---</option>
                          <?php
                          foreach ($arrChucVu as $cv) {
                            echo "<option value='" . $cv['id'] . "'>" . $cv['ten_chuc_vu'] . "</option>";
                          }
                          ?>
                        </select>
                        <small style="color: red;"><?php if (isset($error['chucVu'])) {
                                                      echo "Vui lòng chọn chức vụ";
                                                    } ?></small>
                      </div>

                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                  <?php
                  if ($_SESSION['level'] == 1)
                    echo "<button type='submit' class='btn btn-primary' name='save'><i class='fa fa-plus'></i> Thêm mới nhân viên</button>";
                  ?>
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