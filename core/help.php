<?php
include_once ('init.php');
?>
<html>
<head>
<title><?php echo LANG_HELP; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $db_settings['charset']; ?>">
<style type="text/css">
body {
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 12px;
	margin: 5;
	padding: 0;
	color: black;
	background: white;
}
</style>
</head>

<body>
<h1><?php echo LANG_HELP; ?></h1>
<?php echo LANG_HELP_BODY; ?>
<?php echo $help_link; ?>
</body>
</html>
