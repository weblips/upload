<?php
session_start();
session_destroy();
$_SESSION=array();
unset($_SESSION['ok']);
unset($_SESSION['checkup']);
echo '<script>window.location.href = "../"</script>'; exit();
/*принудительный сброс сессии админа, после сброса пароля на папку,
иначе будет запрашиваться пароль после его удаления, пока не будет
закрыт браузер*/
?>