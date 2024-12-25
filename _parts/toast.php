  <!-- sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const toastik = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
      }
    });

    <?php
    //normal toast
    //př: $_SESSION['toast'][] = ['icon' => 'success', 'title' => 'Úspěšně Odhlášeno'];
    if (isset($_SESSION['toast']) && $_SESSION['toast'] != null && $_SESSION['toast'] != '') {
      echo "window.onload = async function(e) {";
      foreach ($_SESSION['toast'] as $datatoast) {
    ?>
        await toastik.fire({
          icon: '<?php echo $datatoast['icon']; ?>', //warning, error, success, info & question
          title: '<?php echo $datatoast['title']; ?>'
        });
      <?php
      }
      echo "}";

      $_SESSION['toast'] = null;
    }


    //big toast
    //př: $_SESSION['toast_big'][] = ['icon' => 'success', 'title' => 'Odhlášeno', 'text' => 'Úspěšně jste se odhlásili'];
    if (isset($_SESSION['toast_big']) && $_SESSION['toast_big'] != null && $_SESSION['toast_big'] != '') {
      echo "window.onload = async function(e) {";
      foreach ($_SESSION['toast_big'] as $datatoast) {
      ?>
        await Swal.fire({
          title: '<?php echo $datatoast['title']; ?>',
          text: '<?php echo $datatoast['text']; ?>',
          icon: '<?php echo $datatoast['icon']; ?>'
        });
    <?php
      }
      echo "}";

      $_SESSION['toast_big'] = null;
    }
    ?>
  </script>