<?php
session_start();
session_destroy();
$_SESSION=array();
unset($_SESSION['ok']);
unset($_SESSION['checkup']);
echo '<script>window.location.href = "../"</script>'; exit();
/*�������������� ����� ������ ������, ����� ������ ������ �� �����,
����� ����� ������������� ������ ����� ��� ��������, ���� �� �����
������ �������*/
?>