<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
load_buttons();
if ($login['ID'] == ADMIN) {
    checkversion();
    if (version_compare(PHP_VERSION, '5.0.0', '<')) {
        echo '<b>WARNING:</b> You are using PHP version ' . PHP_VERSION . " it is highly recommended that you use at least PHP version 5\n";
        echo "This script will continue to work but in the future you may not be able to use it.\n";
        echo "This message will go away once you upgrade to PHP 5 or higher.\n";
    }
}
if ($vars['search_include']) {
    include (INC_DIR . 'search_form.php');
}
?>
<h2><?php echo $pagetitle; ?></h2>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  <div id="main">
    <?php echo $main_table;
unset($main_table); ?>
  	<input class="inputsubmit2" id="checkall" type="button" onclick="checkAll(this.form)" value="<?php echo LANG_SELECT_ALL; ?>"> 
  	<input class="inputsubmit2" id="uncheckall" type="button" onclick="uncheckAll(this.form)" value="<?php echo LANG_UNSELECT; ?>">
  	<br>
    <span id="tickets_found"><?php echo intval($total); ?> <em><?php echo LANG_TICKETS_FOUND; ?></em></span>
    <?php if ($pgs) { ?>
    <span class="pages"><b><?php echo LANG_PAGES; ?>:</b> <?php echo $pgs;
    unset($pgs); ?></span>
    <?php
} ?>
  </div>

<br>

<!-- buttons start -->
<div class="buttons">
<input class="inputsubmit" type="submit" id="close" name="close" title="<?php echo LANG_TIP_CLOSE; ?>" value="<?php echo LANG_CLOSE; ?>"> 
<?php
if ($_SESSION['user']['type'] == 'admin'):
?>
<input class="inputsubmit" type="submit" id="delete" name="delete" title="<?php echo LANG_TIP_DELETE; ?>" onClick='if(confirm("<?php echo LANG_DELETE_CONFIRM; ?>")) return; else return false;' value="<?php echo LANG_DELETE; ?>">
<input class="inputsubmit" type="submit" id="onhold" name="onhold" title="<?php echo LANG_TIP_ONHOLD; ?>" value="<?php echo LANG_ONHOLD; ?>"> 
<br><br>
<?php echo LANG_SHOW_TICKETS; ?>
<select onChange="window.location=this.options[this.selectedIndex].value;" >
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_all"<?php echo $_SESSION['view']['status'] == 'all' ? ' selected' : ''; ?>><?php echo LANG_ALL; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_new"<?php echo $_SESSION['view']['status'] == 'new' ? 'selected' : ''; ?>><?php echo LANG_NEW; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_open"<?php echo $_SESSION['view']['status'] == 'open' ? ' selected' : ''; ?>><?php echo LANG_OPEN; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_onhold"<?php echo $_SESSION['view']['status'] == 'onhold' ? ' selected' : ''; ?>><?php echo LANG_ONHOLD; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_awaitingcustomer"<?php echo $_SESSION['view']['status'] == 'awaitingcustomer' ? ' selected' : ''; ?>><?php echo LANG_AWAITINGCUSTOMER; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_reopened"<?php echo $_SESSION['view']['status'] == 'reopened' ? ' selected' : ''; ?>><?php echo LANG_REOPENED; ?></option>
    <option value="<?php echo $_SERVER["PHP_SELF"]?>?a=view_closed"<?php echo $_SESSION['view']['status'] == 'closed' ? ' selected' : ''; ?>><?php echo LANG_CLOSED; ?></option>
</select>
<?php
endif; ?>
<input class="inputsubmit" type="submit" id="refresh" name="refresh" title="<?php echo LANG_TIP_REFRESH; ?>" value="<?php echo LANG_REFRESH; ?>">
 </div>
<!-- buttons end -->
</form>