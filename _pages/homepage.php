<?php
//Zablokování přímé
if (count(get_included_files()) == 1) {
  // require(__DIR__ . '\_parts\secure.php');
  exit("Ne prostě... Já si nepřeju, aby sem někdo chodil.");
} //konec přímého 
?>
<?php
ob_start();

if (isset($_SESSION['uid']) && $_SESSION['uid'] != 0) {
} else {
  header("Location: /login?return=" . urlencode($_SERVER['REQUEST_URI']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 3</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">

  <!-- LIGHT theme switcher -->
  <link rel="stylesheet" href="/_css/rezim.css">

</head>
<?php require('./_parts/rezim_switcher.php'); ?>

<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini <?php echo $_COOKIE['theme']; ?>-mode">
  <div class="wrapper">
    <!-- Navbar -->
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/_parts/navbar.php'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/_parts/sidebar.php'); ?>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard v3</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          asd
        </div>
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <?php require("./_parts/footer.php"); ?>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE -->
  <script src="/dist/js/adminlte.js"></script>

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/8cf785f4c8.js" crossorigin="anonymous"></script>
  
  <!-- LIGHT theme switcher -->
  <script src="/_js/js.cookie.min.js"></script>
  <script src="/_js/rezim.js"></script>

  <?php require($_SERVER['DOCUMENT_ROOT'] . '/_parts/toast.php'); ?>


</body>

</html>