<?php
// This is the current theme version you are running.
$themeversion = '1.7.0';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $db_settings['site_title']; ?></title>
<link rel="stylesheet" href="eticket.css" type="text/css">
<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=<?php echo $db_settings['charset']; ?>">
<script language="JavaScript" type="text/javascript">
<!--
function popup() {
window.open ("help.php", "help","location=1,status=1,scrollbars=1,width=400,height=250");
}

//-->
</script>
</head>
<body>
<div class="container">
    <h1><a href="index.php"><img src="images/logo.gif" alt="<?php echo $db_settings['site_title']; ?>" border="0"></a></h1>			
    <div class="nav">
    <ul>
        <li>
        <?php if (isset($login) && ($login != 0) && isset($_SESSION['user']['id'])) {
    echo LANG_USER . ': ' . $_SESSION['user']['id'];
} ?>
		</li>
		<li id="home"><a href="index.php"><img src="images/arrow.gif" border="0" alt="Main"> Main</a></li>
		<?php if (isset($login) && ($login != 0) && isset($_SESSION['user']['type'])) { ?>
		<li><a href="javascript:void(0)" onclick="window.open ('help.php', 'help','location=1,status=1,scrollbars=1,width=400,height=250')"><img src="images/arrow.gif" border="0" alt="Help"> Help</a></li>
		<?php if (!$db_settings['search_disp']) { ?>
		<li><a href="search.php"><img src="images/arrow.gif" border="0" alt="Search"> Search</a></li>
		<?php
    } ?>
		<li><a href="open.php"><img src="images/arrow.gif" border="0" alt="New Ticket"> New Ticket</a></li>
		<li><a href="index.php?a=logout"><img src="images/arrow.gif" border="0" alt="Logout"> Logout</a></li>
		<?php
} ?>
	</ul>
    </div>
    <div class="content">%%BODY%%</div>
    <div class="pre-footer">Support Ticket System</div>	
    <div class="footer"><?php show_copy(); ?></div>
    </div>
    </body>
</html>