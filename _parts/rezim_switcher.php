<?php
//Zablokování přímé
if (count(get_included_files()) == 1) {
  require($_SERVER['DOCUMENT_ROOT'] . '\_parts\secure.php');
  exit("Ne prostě... Já si nepřeju, aby sem někdo chodil.");
} //konec přímého 
?>

<label id="fgztD_switch" class="fgztD_switch">
  <input type="checkbox" onchange="nastavittema()" id="fgztD_slider" <?php
                                                                      if (isset($_COOKIE['theme']) != null) {
                                                                        if ($_COOKIE['theme'] == 'light') {
                                                                          echo 'checked';
                                                                        }
                                                                      }
                                                                      ?>>
  <span class="fgztD_slider fgztD_round"></span>
</label>
