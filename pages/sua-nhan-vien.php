<?php

// create session
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
  // include file
  include('../layouts/header.php');
  include('../layouts/topbar.php');
  include('../layouts/sidebar.php');

  // show data
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $showData = "SELECT nv.id as id, phong_ban_id, chuc_vu_id,  ma_nv, hinh_anh, ten_nv,  gioi_tinh, nv.ngay_tao as ngay_tao, ngay_sinh,  so_cmnd,  tam_tru,   ten_phong_ban, ten_chuc_vu FROM nhanvien nv, phong_ban pb, chuc_vu cv WHERE nv.phong_ban_id = pb.id AND nv.chuc_vu_id = cv.id AND nv.id = $id";
    $result = mysqli_query($conn, $showData);
    $row = mysqli_fetch_array($result);

    // set option active
    $pb_id = $row['phong_ban_id'];
    $ten_pb = $row['ten_phong_ban'];

    $cv_id = $row['chuc_vu_id'];
    $ten_cv = $row['ten_chuc_vu'];



    // set value option another


    $pb = "SELECT id, ten_phong_ban FROM phong_ban WHERE id <> $pb_id";
    $resultPB = mysqli_query($conn, $pb);
    $arrPB = array();
    while ($rowPB = mysqli_fetch_array($resultPB)) {
      $arrPB[] = $rowPB;
    }

    $cv = "SELECT id, ten_chuc_vu FROM chuc_vu WHERE id <> $cv_id";
    $resultCV = mysqli_query($conn, $cv);
    $arrCV = array();
    while ($rowCV = mysqli_fetch_array($resultCV)) {
      $arrCV[] = $rowCV;
    }
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
    $ngaySua = date("Y-m-d H:i:s");

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

        // remove old image
        $oldImage = $row['hinh_anh'];

        // insert data
        $update = " UPDATE nhanvien SET 
                    hinh_anh = '$imageName',
                    ten_nv = '$tenNhanVien',
                    gioi_tinh = '$gioiTinh',
                    ngay_sinh = '$ngaySinh',
                    so_cmnd = '$CMND',
                    tam_tru = '$tamTru',
                    phong_ban_id = '$phongBan',
                    chuc_vu_id = '$chucVu',
                    nguoi_sua_id = '$id_user',
                    ngay_sua = '$ngaySua'
                    WHERE id = $id";
        $result = mysqli_query($conn, $update);
        if ($result) {
          $showMess = true;

          // remove old image
          if ($oldImage != "demo-3x4.jpg") {
            unlink($target_dir . $oldImage);
          }

          // move image
          move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $moveFile);

          $success['success'] = 'Lưu thông tin thành công';
          echo '<script>setTimeout("window.location=\'sua-nhan-vien.php?p=staff&a=list-staff&id=' . $id . '\'",1000);</script>';
        }
      } else {
        $showMess = true;
        // update data
        $update = " UPDATE nhanvien SET 
                    hinh_anh = '$imageName',
                    ten_nv = '$tenNhanVien',
                    gioi_tinh = '$gioiTinh',
                    ngay_sinh = '$ngaySinh',
                    so_cmnd = '$CMND',
                    tam_tru = '$tamTru',
                    phong_ban_id = '$phongBan',
                    chuc_vu_id = '$chucVu',
                    nguoi_sua_id = '$id_user',
                    ngay_sua = '$ngaySua'
                    WHERE id = $id";
        $result = mysqli_query($conn, $update);
        if ($result) {
          $success['success'] = 'Lưu thông tin thành công';
          echo '<script>setTimeout("window.location=\'sua-nhan-vien.php?p=staff&a=list-staff&id=' . $id . '\'",1000);</script>';
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
        Chỉnh sửa nhân viên
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Tổng quan</a></li>
        <li><a href="danh-sach-nhan-vien.php?p=staff&a=list-staff">Nhân viên</a></li>
        <li class="active">Chỉnh sửa thông tin nhân viên</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Chỉnh sửa thông tin nhân viên</h3> &emsp;
              <small>Những ô nhập có dấu <span style="color: red;">*</span> là bắt buộc</small>
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
                      <input type="text" class="form-control" id="exampleInputEmail1" name="maNhanVien" value="<?php echo $row['ma_nv']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label>Tên nhân viên <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên nhân viên" name="tenNhanVien" value="<?php echo $row['ten_nv']; ?>">
                      <small style="color: red;"><?php if (isset($error['tenNhanVien'])) {
                                                    echo "Tên nhân viên không được để trống";
                                                  } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Số CMND <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nhập số CMND" name="CMND" value="<?php echo $row['so_cmnd']; ?>">
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
                        <label>Giới tính <span style="color: red;">*</span>: </label>
                        <select class="form-control" name="gioiTinh">
                          <?php
                          if ($row['gioi_tinh'] == 1) {
                            echo "<option value='1' selected>Nam</option>";
                            echo "<option value='0'>Nữ</option>";
                          } else {
                            echo "<option value='1'>Nam</option>";
                            echo "<option value='0' selected>Nữ</option>";
                          }
                          ?>
                        </select>
                        <small style="color: red;"><?php if (isset($error['gioiTinh'])) {
                                                      echo "Vui lòng chọn giới tính";
                                                    } ?></small>
                      </div>
                      <div class="form-group">
                        <label>Ngày sinh: </label>
                        <input type="date" class="form-control" id="exampleInputEmail1" name="ngaySinh" value="<?php echo $row['ngay_sinh']; ?>">
                      </div>
                      <div class="form-group">
                        <label>Địa chỉ: </label>
                        <textarea class="form-control" name="tamTru"><?php echo $row['tam_tru']; ?></textarea>
                      </div>
                      <div class="form-group">
                        <label>Phòng ban <span style="color: red;">*</span>: </label>
                        <select class="form-control" name="phongBan">
                          <option value="<?php echo $pb_id; ?>"><?php echo $ten_pb; ?></option>
                          <?php
                          foreach ($arrPB as $pb) {
                            echo "<option value='" . $pb['id'] . "'>" . $pb['ten_phong_ban'] . "</option>";
                          }
                          ?>
                        </select>
                        <small style="color: red;"><?php if (isset($error['phongBan'])) {
                                                      echo "Vui lòng chọn phòng ban";
                                                    } ?></small>
                      </div>
                      <div class="form-group">
                        <label>Chức vụ <span style="color: red;">*</span>: </label>
                        <select class="form-control" name="chucVu">
                          <option value="<?php echo $cv_id; ?>"><?php echo $ten_cv; ?></option>
                          <?php
                          foreach ($arrCV as $cv) {
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
                    echo "<button type='submit' class='btn btn-warning' name='save'><i class='fa fa-save'></i> Lưu lại thông tin</button>";
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