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
<?php $t=0; ?>
<?php echo $_POST['upassword'];?>
  <?php do { 
 if($_POST['uacc']==$row_Recordset1['uacc']||$_POST['upassword']==$row_Recordset1['upassword'])
 {
	 echo $u=$row_Recordset1['uname'];
	 setcookie('again','已經註冊過了');
	 header("Location: add.php");
	 $t=1;
	 ?>
<?php	 
 } 
 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<?  if($t==0)
{  
  $insertSQL = sprintf("INSERT INTO account (`uid`, uacc, upassword, uname, utime) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['uid'], "int"),
                       GetSQLValueString($_POST['uacc'], "text"),
                       GetSQLValueString($_POST['upassword'], "text"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['utime'], "date"));

  mysql_select_db($database_user, $user);
  $Result1 = mysql_query($insertSQL, $user) or die(mysql_error());
  
setcookie( "again", "", time()-3600);
header("Location: index.php");

}?>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
