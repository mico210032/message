<?php require_once('Connections/user.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_user, $user);
$query_Recordset1 = "SELECT * FROM account";
$Recordset1 = mysql_query($query_Recordset1, $user) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php echo $_POST['acc']; ?>
<?php echo $_POST['password'];
$t=0;
?>

  <?php do { 
 if($_POST['acc']==$row_Recordset1['uacc']&&$_POST['password']==$row_Recordset1['upassword'])
 {
	 echo $u=$row_Recordset1['uname'];
	 setcookie('uid',$row_Recordset1['uacc']);
	 setcookie('user',$row_Recordset1['uname']);
	 header("Location: index.php");
	 $t=1;
	 ?>
<?php	 
 }

 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
 if($t==0)
 {
	 
	setcookie( "user", '登入錯誤');
	header("Location: login.php");
 }
 ?>
 
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
