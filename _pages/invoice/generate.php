<?php
ob_start();
session_start();

require($_SERVER['DOCUMENT_ROOT'] . '/db.php');


$result = $conn->query("SELECT * FROM `RFP_invoice` WHERE `id` = '" . $_GET['id'] . "';");

if ($result->num_rows > 0) {
  $row = $result->fetch_array(MYSQLI_ASSOC);


  // URL ke stažení JSON dat
  $url = "https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/" . $row["dodavatel_ico"];

  // Inicializace cURL
  $ch = curl_init();

  // Nastavení cURL
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Zakázání ověřování SSL certifikátu (použijte pouze v případě, že to je nezbytné)

  // Stáhnutí obsahu
  $response = curl_exec($ch);

  // Kontrola, zda nastala chyba
  if (curl_errno($ch)) {
    echo "Chyba při načítání dat: " . curl_error($ch);
    curl_close($ch);
    exit;
  }

  // Zavření cURL
  curl_close($ch);

  // Dekódování JSON dat
  $data_dodavatel = json_decode($response, true);

  // Kontrola, zda JSON dekódování proběhlo úspěšně
  if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Chyba při dekódování JSON: " . json_last_error_msg();
    exit;
  }

  // URL ke stažení JSON dat
  $url = "https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/" . $row["odberatel_ico"];

  // Inicializace cURL
  $ch = curl_init();

  // Nastavení cURL
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Zakázání ověřování SSL certifikátu (použijte pouze v případě, že to je nezbytné)

  // Stáhnutí obsahu
  $response = curl_exec($ch);

  // Kontrola, zda nastala chyba
  if (curl_errno($ch)) {
    echo "Chyba při načítání dat: " . curl_error($ch);
    curl_close($ch);
    exit;
  }

  // Zavření cURL
  curl_close($ch);

  // Dekódování JSON dat
  $data_odberatel = json_decode($response, true);

  // Kontrola, zda JSON dekódování proběhlo úspěšně
  if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Chyba při dekódování JSON: " . json_last_error_msg();
    exit;
  }


?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <!-- http://api.paylibo.com/paylibo/generator/czech/image?accountNumber=2902382748&bankCode=2010&amount=13900.00&currency=CZK&vs=202407006&ks=2&message=Uhrazení%20faktury -->

  <body>
    <div class="page">
      <div class="margin-header">
        <div class="flex-header">
          <div class="header-left">
            <img src="./logo.png" class="logo">
          </div>
          <div class="header-right">
            <b style="font-size: 24px;">FAKTURA č. 202407006</b><br>
            <b style="font-size: 21px; color:#9598AA;">Evidenční č. 006</b>
          </div>
        </div>

        <div class="flex-contacts">
          <div class="contact-dodavatel">
            <h2 class="text-color-main text-bold m0">DODAVATEL</h2>
            <p><b><?php echo $data_dodavatel['obchodniJmeno']; ?></b></p>
            <p class="text-f-14">
              <?php echo $data_dodavatel['sidlo']['nazevUlice'] . ' ' . $data_dodavatel['sidlo']['cisloDomovni'] . ', ' . $data_dodavatel['sidlo']['nazevCastiObce']; ?><br>
              <?php echo $data_dodavatel['sidlo']['psc'] . ' ' . $data_dodavatel['sidlo']['nazevObce']; ?><br>
              <?php echo $data_dodavatel['sidlo']['nazevStatu']; ?>
            </p>
            <p class="m0 text-f-14">
              <b>IČO</b><span class="space"><?php echo $data_dodavatel['icoId']; ?></span><br>
              <b>NEPLÁTCE DPH</b>
            </p>
          </div>
          <div class="contact-odberatel">
            <h2 class="text-color-main text-bold m0">ODBĚRATEL</h2>
            <p><b>Tomáš Janovský</b></p>
            <p class="text-f-14">
              Durychova 1388/12, Nový Hradec Králové<br>
              50012 Hradec Králové<br>
              Česká republika
            </p>
            <p class="m0 text-f-14">
              <b>IČO</b><span class="space">73661287<span class="space"></span><b class="space">DIČ</b><span class="space">CZ8209133680</span><br>
            </p>
          </div>
        </div>
        <div class="flex-contacts-details">
          <div class="contact-dodavatel">
            <p class="text-color-main mb0">Kontaktní údaje</p>
            <p class="m0 text-f-14">
              www.runforplanet.cz<br>
              +420733488345<span class="space">info@filmypodpevnosti.cz</span></p>
          </div>
          <div class="contact-odberatel">
            <p class="text-color-main mb0">Kontaktní údaje</p>
            <p class="m0 text-f-14">+420777552626</p>
          </div>
        </div>
      </div>

      <div class="flex-pay">
        <div class="pay-left">
          <div class="pay-left-creditals">
            <div style="padding-bottom: 13px;">
              <b class="text-f-16">Platební údaje</b>
            </div>
            <div style="margin: auto;">
              <table class="text-f-14" style="width: 100%; border-spacing:0;">
                <tbody>
                  <tr>
                    <td>Číslo účtu</td>
                    <td><b>2902382748/2010</b></td>
                    <td>Forma úhrady</td>
                    <td><b>Převodem</b></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td>Variabilní symbol</td>
                    <td><b>202407006</b></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td>Konstantní symbol</td>
                    <td><b>2</b></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="pay-left-qr">
            <img src="./qr_sample.png" width="120px" height="120px">
          </div>
        </div>
        <div class="pay-right text-f-14">
          <p>
            Datum vystavení<br>
            <b>17. 08. 2024</b>
          </p>
          <p>
            Datum splatnosti<br>
            <b>31. 08. 2024</b>
          </p>
        </div>
      </div>

      <div class="margin-shoplist">
        <table class="shoplist">
          <tr>
            <th>Počet</th>
            <th style="width: 60%;">Popis</th>
            <th>Jedn. cena</th>
            <th>Celkem</th>
          </tr>

          <tr>
            <td>1 ks</td>
            <td>Zajištění promítání</td>
            <td>5500,00</td>
            <td>5500,00</td>
          </tr>
          <tr>
            <td>1 ks</td>
            <td>Licence filmu</td>
            <td>8400,00</td>
            <td>8400,00</td>
          </tr>
        </table>
      </div>

      <div class="pay-price text-f-21">
        <div class="margin-pay-price">
          <table>
            <tbody>
              <tr>
                <td>Celkem k úhradě</td>
                <td>13900,00 Kč</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="footer text-f-14">
        Stránka 1 z 1
      </div>
    </div>

    <style>
      :root {
        --odsazeni: 30px;
        --color-main: #1E8393;
      }

      * {
        -webkit-print-color-adjust: exact !important;
        /*Chrome, Safari */
        color-adjust: exact !important;
        /*Firefox*/
        font-family: Arial, Helvetica, sans-serif;
      }

      body {
        margin: 0;
      }

      .page {
        height: 100%;
        width: 100%;
        background-color: white;
        margin: auto;
      }

      .margin-header {
        margin-top: var(--odsazeni);
        margin-left: var(--odsazeni);
        margin-right: var(--odsazeni);
      }

      .flex-header {
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: flex-start;
      }

      .header-right {
        text-align: right;
      }

      .logo {
        height: 100px;
      }

      .flex-contacts,
      .flex-contacts-details {
        width: 100%;
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: flex-start;
      }

      .contact-dodavatel,
      .contact-odberatel {
        width: 49%;
      }

      .flex-pay {
        width: 100%;
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: flex-start;
        padding-top: 40px;
      }

      .pay-left {
        width: 80%;
        height: 130px;
        background-color: var(--color-main);
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: flex-start;
      }

      .pay-right {
        margin: auto;
        padding-right: var(--odsazeni);
      }

      .pay-left-creditals {
        width: 100%;
        color: #fff;
        padding: 5px;
        padding-left: var(--odsazeni);
      }

      .pay-left-qr {
        padding: 5px;

      }

      .pay-left-qr img {

        border-radius: 15px;
      }

      .margin-shoplist {
        margin-left: var(--odsazeni);
        margin-right: var(--odsazeni);
        padding-top: 50px;
        padding-bottom: 50px;
      }

      .shoplist tr:nth-child(even) {
        background-color: #F8F8F8;
      }

      .shoplist {
        border-collapse: collapse;
        width: 100%;
        text-align: left;
      }

      .pay-price {
        margin: auto;
        margin-right: 0;
        width: 45%;
        height: 50px;
        background-color: var(--color-main);
        color: #fff;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
      }

      .margin-pay-price {
        margin-right: var(--odsazeni);
        height: 100%;
      }

      .pay-price table {
        width: 100%;
        height: 100%;
        font-weight: bolder;
        padding-left: 10px;
      }

      .footer {
        position: fixed;
        bottom: 20px;
        width: 100%;
        text-align: center;
      }

      .text-bold {
        font-weight: bold;
      }

      .text-color-main {
        color: var(--color-main);
      }

      .text-f-14 {
        font-size: 14px
      }

      .text-f-16 {
        font-size: 16px
      }

      .text-f-21 {
        font-size: 21px
      }

      .space {
        padding-left: 5px;
      }

      .m0 {
        margin: 0;
      }

      .mb0 {
        margin-bottom: 0;
      }
    </style>

  </body>

  </html>

<?php


} else {
  echo "0 results";
}
