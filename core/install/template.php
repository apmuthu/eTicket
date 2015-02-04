<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>	
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>eTicket Installer</title>
	<style type="text/css" media="screen">


		/* Default Style */
		BODY {
			font-family: Verdana, Arial;
			font-size: 14px;
			color: #000000;
			background: #FFFFFF;
		}
		P {
			padding: 3px;
			padding-left: 10px;
			line-height: 18px;
		}
		BLOCKQUOTE {
			margin: 10px 20px 0px 20px;
			padding: 10px;
			border: 1px solid #8d8d8d;
			background-color: #f5f5f5;
		}
		LI {
			margin-top: 4px;
		}
		UL LI UL LI {
			margin-top: 2px;
		}
		A, A:active, A:link, A:visited {
			color: #EFB55C;
			text-decoration: none;
		}
		A:hover {
			color: #5577a5;
			text-decoration: underline;
		}
		/* Place Holder Style */
		#Container {
			width: 780px;
			margin-left: auto;
			margin-right: auto; 
		}
		#Content {
			background-color: #fafafa;
			border: 1px solid #F8981D;
			padding: 10px;
			margin-top: -13px;
		}
		/* Title Style */
		#Title,H1 {
			font-family: Verdana, Arial;
			font-size: 22px;
			font-weight: bold;
			color: #F8981D;
			border-bottom: 1px solid #F8981D;
			margin-bottom: 10px;
		}
		.SubTitle,H2 {
			font-family: Verdana, Arial;
			font-size: 18px;
			font-weight: bold;
			color: #EFB55C;
		}
		.SubSubTitle,H3 {
			font-family: Verdana, Arial;
			font-size: 14px;
			font-weight: bold;
			color: #F3C378;
		}
		/* Tabs */
		UL#Tabs {
			font-family: Verdana, Arial;
			font-size: 12px;
			font-weight: bold;
			list-style-type: none;
			padding-bottom: 28px;
			border-bottom: 1px solid #F8981D;
			margin-bottom: 12px;
			z-index: 1;
		}
		#Tabs LI.Tab {
			float: right;
			height: 25px;
			background-color: #F3C378;
			margin: 2px 0px 0px 5px;
			border: 1px solid #F8981D;
		}
		#Tabs LI.Tab A {
			float: left;
			display: block;
			color: #666666;
			text-decoration: none;
			padding: 5px;
		}
		#Tabs LI.Tab A:hover {
			background-color: #EFB55C;
			border-bottom: 1px solid #EFB55C;
		}
		/* Selected Tab */
		#Tabs LI.SelectedTab {
			float: right;
			height: 25px;
			background-color: #fafafa;
			margin: 2px 0px 0px 5px;
			border-top: 1px solid #F8981D;
			border-right: 1px solid #F8981D;
			border-bottom: 1px solid #fafafa;
			border-left: 1px solid #F8981D;
		}
		#Tabs LI.SelectedTab A {
			float: left;
			display: block;
			color: #666666;
			text-decoration: none;
			padding: 5px;
			cursor: default;
		}
		/* Footer */
		#Footer {
			text-align: center;
		}
	</style>
</head>

<body>
<!-- Container Start -->
<div id="Container">

	<!-- Title Start -->
	<h1>eTicket</h1>
	<!-- Title End -->

	<!-- Tabs Start -->
	<ul id="Tabs">
		<li id="FourTab" class="Tab"><a href="../readme.html" title="Readme">Readme</a></li>
		<?php $class = 'Tab';
if (preg_match('/install.php$/', $_SERVER['PHP_SELF'])) {
    $class = 'SelectedTab';
} ?>
		<li id="TwoTab" class="<?php echo $class; ?>"><a href="install.php" title="Install">Install</a></li>
		<?php $class = 'Tab';
if (preg_match('/index.php$/', $_SERVER['PHP_SELF'])) {
    $class = 'SelectedTab';
} ?>
		<li id="OneTab" class="<?php echo $class; ?>"><a href="index.php" title="Welcome">Welcome</a></li>
	</ul>
	<!-- Tabs End -->

	<!-- Content Start -->
	<div id="Content">
	%%BODY%%
	</div>
	<!-- Content End -->
</div>
<!-- Container End -->
</body>
</html>