<?php
//Zablokování přímé
if (count(get_included_files()) == 1) {
  // require(__DIR__ . '\_parts\secure.php');
  exit("Ne prostě... Já si nepřeju, aby sem někdo chodil.");
} //konec přímého 
?>

<?php

// Funkce pro generování náhodného tokenu
function generateToken($length = 64)
{
  return bin2hex(random_bytes($length));
}

// Připojení k databázi
require($_SERVER['DOCUMENT_ROOT'] . '/db.php');

// Kontrola, zda je uživatel již přihlášen pomocí session nebo cookies
if (!isset($_SESSION['uid'])) {
  if (isset($_COOKIE['rememberme'])) {
    $token = $_COOKIE['rememberme'];

    // SQL dotaz s kontrolou platnosti tokenu (maximálně 30 dní starý)
    $stmt = $conn->prepare("SELECT * FROM `user_tokens` WHERE `token` = ? AND `created_at` >= NOW() - INTERVAL 30 DAY");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_array(MYSQLI_ASSOC);

      $USERresult = $conn->query("SELECT * FROM `users` WHERE `id` = '" . $row['user_id'] . "';");

      if ($USERresult->num_rows > 0) {
        // output data of each row
        $USERrow = $USERresult->fetch_array(MYSQLI_ASSOC);
        $_SESSION['uid'] = $USERrow['id'];
        $_SESSION['jmeno'] = $USERrow['jmeno'];
        $_SESSION['prijmeni'] = $USERrow['prijmeni'];
        $_SESSION['theme'] = 'light';

        $_SESSION['toast'][] = ['icon' => 'success', 'title' => 'Automaticky přihlášeno'];

        if (isset($_GET['return']) && $_GET['return'] != '') {
          header('Location: ' . $_GET['return']);
        } else {
          header('Location: /');
        }
      } else {
        die("chyba ds6540ads96");
      }
      exit;
    }
  }


  // Zpracování přihlašovacího formuláře
  if (isset($_POST['emailjmeno']) && isset($_POST['password'])) {
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `uzivatel` = ? OR `email` = ?");
    $stmt->bind_param("ss", $_POST['emailjmeno'], $_POST['emailjmeno']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      if (password_verify($_POST['password'], $row['heslo'])) {
        $_SESSION['uid'] = $row['id'];
        $_SESSION['jmeno'] = $row['jmeno'];
        $_SESSION['prijmeni'] = $row['prijmeni'];
        $_SESSION['theme'] = 'light';

        $_SESSION['toast'][] = ['icon' => 'success', 'title' => 'Úspěšně přihlášeno'];

        if (isset($_POST['remember'])) {
          // Generování a uložení tokenu do databáze
          $token = generateToken();
          $stmt = $conn->prepare("INSERT INTO `user_tokens` (`user_id`, `token`) VALUES (?, ?)");
          $stmt->bind_param("is", $row['id'], $token);
          $stmt->execute();

          // Uložení tokenu do cookies
          setcookie('rememberme', $token, time() + (86400 * 30), "/"); // 30 dní
          $_SESSION['toast'][] = ['icon' => 'info', 'title' => 'Nastaveno automatické přihlašování'];
        }

        if (isset($_GET['return']) && $_GET['return'] != '') {
          header('Location: ' . $_GET['return']);
        } else {
          header('Location: /');
        }
        exit;
      } else {
        echo '<h1 style="color:red;">Špatné heslo nebo uživatelské jméno</h1>';
      }
    } else {
      echo '<h1 style="color:red;">Špatné heslo nebo uživatelské jméno</h1>';
    }
  }
} else {
  header("Location: /");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Interní Kalendář</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">

  <!-- LIGHT theme switcher -->
  <link rel="stylesheet" href="/_css/rezim.css">

</head>
<?php require('./_parts/rezim_switcher.php'); ?>

<body class="hold-transition login-page <?php echo $_COOKIE['theme']; ?>-mode">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="/" class="h1"><b>Interní</b>Kalendář</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Pro vstup do systému je nutné se přihlásit</p>

        <form method="post">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="emailjmeno">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Heslo" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">
                  Automaticky přihlašovat po dobu 30 dnů
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>



        <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/dist/js/adminlte.min.js"></script>

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/8cf785f4c8.js" crossorigin="anonymous"></script>

  <!-- LIGHT theme switcher -->
  <script src="/_js/js.cookie.min.js"></script>
  <script src="/_js/rezim.js"></script>


  <?php require($_SERVER['DOCUMENT_ROOT'] . '/_parts/toast.php'); ?>

</body>

</html>