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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO message (msid, message, acc, name) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['msid'], "int"),
                       GetSQLValueString($_POST['message'], "text"),
                       GetSQLValueString($_POST['acc'], "text"),
                       GetSQLValueString($_POST['name'], "text"));

  mysql_select_db($database_user, $user);
  $Result1 = mysql_query($insertSQL, $user) or die(mysql_error());
}

$maxRows_Recordset1 = 5;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_user, $user);
$query_Recordset1 = "SELECT * FROM message";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $user) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

mysql_select_db($database_user, $user);
$query_Recordset2 = "SELECT * FROM account";
$Recordset2 = mysql_query($query_Recordset2, $user) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_user, $user);
$query_Recordset3 = "SELECT * FROM account ORDER BY `uid` DESC";
$Recordset3 = mysql_query($query_Recordset3, $user) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>x留言板</title>
</head>

<body>
<body bgcolor="#A1A1E6">

<?php
	$u = $_COOKIE['user'];

	 if($u==NULL)
	 { ?>
<a href="add.php?id=<?php echo $a ?>" >註冊帳號</a>
        <a href="login.php?id=<?php echo $u ?>" >登入帳號</a>
	
	<?  }
		 if($u!=NULL)
	 {
		 ?> 
	 使用者
	 <?
 		echo $u;
		?>
<a href="logout.php">登出</a>
		<?
	 }

?>
<table border="0" higth="600" width="300"  method="post">
  <tr>
  <td> 
   </td>
  </tr>
  
  <?php do { ?>
      <td>     <?php echo $row_Recordset1['msid']; 
	  $a=$row_Recordset1['message'];
	  ?>
   編輯者<?php echo $row_Recordset1['name']; ?>
   |<a href="anser.php?id=<?php echo $a ?>" >回復</a>
   <br />
	<?php setcookie('mycookie',$row_Recordset1['message']);

	?>

    <?php echo $row_Recordset1['message']; ?></td>
  
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
 <?
 if($u!=NULL)
{	?>
 <table border="0">
   <tr>
     <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
         <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">第一頁</a>
         <?php } // Show if not first page ?></td>
     <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
         <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">上一頁</a>
         <?php } // Show if not first page ?></td>
     <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
         <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">下一頁</a>
         <?php } // Show if not last page ?></td>
     <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
         <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">最後一頁</a>
         <?php } // Show if not last page ?></td>
   </tr>
 </table>
<p>新增留言</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="lift">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Message:</td>
      <td><input type="text" name="message" value="" height="80" size="40" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="hidden" name="acc" value=<? $_COOKIE['uid']; ?> size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="hidden" name="name" value=<? echo $u ?>  /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="留言" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>

 <?php
}?>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
