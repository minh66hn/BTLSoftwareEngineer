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

    $showData = "SELECT nv.id as id, ma_nv, hinh_anh, ten_nv, gioi_tinh, nv.ngay_tao as ngay_tao, ngay_sinh,  so_cmnd,  tam_tru, ten_phong_ban, ten_chuc_vu FROM nhanvien nv, phong_ban pb, chuc_vu cv WHERE   nv.phong_ban_id = pb.id AND nv.chuc_vu_id = cv.id AND nv.id = $id";
    $result = mysqli_query($conn, $showData);
    $row = mysqli_fetch_array($result);

    $luong = "SELECT nv.id as idNhanVien, ma_luong, ma_nv, ten_nv, ten_chuc_vu, luong_ngay, luong_thang, ngay_cong, ngay_cham FROM luong l, nhanvien nv, chuc_vu cv WHERE l.nhanvien_id = nv.id AND nv.chuc_vu_id = cv.id AND nv.id = $id";
    $resultLuong = mysqli_query($conn, $luong);
    $arrLuong = array();
    while ($rowLuong = mysqli_fetch_array($resultLuong)) {
      $arrLuong[] = $rowLuong;
    }
  }

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Thông tin nhân viên
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Tổng quan</a></li>
        <li><a href="danh-sach-nhan-vien.php?p=staff&a=list-staff">Danh sách nhân viên</a></li>
        <li class="active">Thông tin nhân viên</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Mã nhân viên: <?php echo $row['ma_nv']; ?></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-lg-2">
                  <img src="../uploads/staffs/<?php echo $row['hinh_anh']; ?>" width="100%">
                </div>
                <div class="col-lg-5 col-sm-5 col-md-6 col-xs-12">
                  <p class="box-title">Tên nhân viên: <b><?php echo $row['ten_nv']; ?></b></p>
                  <p class="box-title">Giới tính:
                    <?php if ($row['gioi_tinh'] == 1) {
                      echo "Nam";
                    } else {
                      echo "Nữ";
                    } ?>
                  </p>
                  <p class="box-title">Ngày sinh:
                    <b><?php $date = date_create($row['ngay_sinh']);
                        echo date_format($date, 'd-m-Y'); ?></b>
                  </p>
                  <p class="box-title">Số CMND:
                    <b> <?php echo $row['so_cmnd']; ?> </b>
                  </p>
                </div>
                <!-- col-5 -->
                <div class="col-lg-5 col-sm-5 col-md-6 col-xs-12">
                  <p class="box-title">Địa chỉ:
                    <?php echo $row['tam_tru']; ?>
                  </p>
                  <p class="box-title">Phòng ban:
                    <b><?php echo $row['ten_phong_ban']; ?></b>
                  </p>
                  <p class="box-title">Chức vụ:
                    <b><?php echo $row['ten_chuc_vu']; ?></b>
                  </p>
                </div>
                <!-- col-5 -->
              </div>
              <!-- row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Bảng lương nhân viên</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Mã lương</th>
                      <th>Lương ngày</th>
                      <th>Ngày công</th>
                      <th>Lương tháng</th>
                      <th>Ngày chấm</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $count = 1;
                    foreach ($arrLuong as $luong) {
                    ?>
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $luong['ma_luong']; ?></td>
                        <td><?php echo number_format($luong['luong_ngay']) . "vnđ"; ?></td>
                        <td><?php echo $luong['ngay_cong']; ?></td>
                        <td><?php echo number_format($luong['luong_thang']) . "vnđ"; ?></td>
                        <td class="text-center">
                          <?php echo date_format(date_create($luong['ngay_cham']), "d-m-Y"); ?>
                        </td>
                      </tr>
                    <?php
                      $count++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
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