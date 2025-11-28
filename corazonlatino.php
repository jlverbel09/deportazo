<?php
if (isset($_GET['public'])) {
  $public = 1;
} else {
  $public = 0;
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>🏐CORAZÓN LATINO🏐</title>
  <link rel="icon" href="https://georkingweb.com/deportazo/dist/assets/img/logo2.png" type="image/x-icon">
  <meta name="theme-color" content="#AE0909">

  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <meta property="og:title" content="DEPORTAZO 1.0">
  <meta property="og:description" content="Esta es una plataforma interactiva para el registro de campenonatos, visitantes y deportistas interesados en formar parte de la comundad deportiva en Madrid - España. Fomentando el deporte de tu mano en nuestra app">
  <meta property="og:image" content="https://georkingweb.com/deportazo/dist/assets/img/logo2.png">
  <meta property="og:url" content="https://georkingweb.com/deportazo">
  <meta property="og:type" content="website">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</head>

<body style="margin: 0; padding:0;position:fixed; width:100%">

  <!-- <script>
    window.location.href = './dist/pages/login.php'
  </script> -->

  <iframe src="./dist/pages/index?public=<?=$public?>" id="ventana" padding="0" frameborder="0" margin="0" width="100%"></iframe>

  <script>
    var height = $(window).height()
    /* console.log(height); */

    $('#ventana').height(height + 'px')
    $('#ventana').css({
      'background-color': '#fff'
    })
  </script>
</body>

</html>