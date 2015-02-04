<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
?>
<!-- SEARCH FORM START -->
<div align="center" class="searchBox">
  <form action="" method="GET" name="search">
    <input type="hidden" name="s" value="<?php echo $s; ?>">
<?php if ($_SESSION['user']['type'] == 'admin'): ?>
    <?php echo LANG_EMAIL; ?>:
    <input type="text" name="email" id="email" value="<?php echo $vars['email']; ?>" size="25">
<?php
endif;
?>
    <?php echo LANG_QUERY; ?>:
    <input type="text" name="text" id="text" value="<?php echo $vars['text']; ?>">
<?php
if ($s == 'advanced'):
?>
    <?php echo LANG_CAT; ?>:
    <select name="cat"><option value=""><?php echo LANG_ALL; ?></option>
      <?php echo $vars['cats']; ?>
    </select>

     <?php echo LANG_REP; ?>:
     <select name="rep"><option value=""><?php echo LANG_ALL; ?></option>
      <?php echo $vars['reps']; ?>
     </select>

    <?php echo LANG_STATUS; ?>:
    <select name="status">
        <option value="all"><?php echo LANG_ALL; ?></option>
        <option value="new"<?php echo $_SESSION['view']['status'] == 'new' ? ' SELECTED' : ''; ?>><?php echo LANG_NEW; ?></option>
        <option value="onhold"<?php echo $_SESSION['view']['status'] == 'onhold' ? ' SELECTED' : ''; ?>><?php echo LANG_ONHOLD; ?></option>
        <option value="awaitingcustomer"<?php echo $_SESSION['view']['status'] == 'awaitingcustomer' ? ' SELECTED' : ''; ?>><?php echo LANG_AWAITINGCUSTOMER; ?></option>
        <option value="custreplied"<?php echo $_SESSION['view']['status'] == 'custreplied' ? ' SELECTED' : ''; ?>><?php echo LANG_CUSTREPLIED; ?></option> 
        <option value="reopened"<?php echo $_SESSION['view']['status'] == 'reopened' ? ' SELECTED' : ''; ?>><?php echo LANG_REOPENED; ?></option> 
        <option value="closed"<?php echo $_SESSION['view']['status'] == 'closed' ? ' SELECTED' : ''; ?>><?php echo LANG_CLOSED; ?></option>
    </select>

    <?php echo LANG_SORT_BY; ?>:
    <select name="sort">
      <option value="timestamp"<?php echo $_SESSION['view']['sort'] == 'timestamp' ? ' SELECTED' : ''; ?>><?php echo LANG_DATE; ?></option>
      <option value="ID"<?php echo $_SESSION['view']['sort'] == 'ID' ? ' SELECTED' : ''; ?>><?php echo LANG_TICKET_ID; ?></option>
      <option value="subject"<?php echo $_SESSION['view']['sort'] == 'subject' ? ' SELECTED' : ''; ?>><?php echo LANG_SUBJECT; ?></option>
      <option value="cat"<?php echo $_SESSION['view']['sort'] == 'cat' ? ' SELECTED' : ''; ?>><?php echo LANG_CAT; ?></option>
      <option value="rep"<?php echo $_SESSION['view']['sort'] == 'rep' ? ' SELECTED' : ''; ?>><?php echo LANG_REP; ?></option>
      <option value="priority"<?php echo $_SESSION['view']['sort'] == 'priority' ? ' SELECTED' : ''; ?>><?php echo LANG_PRIORITY; ?></option>
      <option value="name"<?php echo $_SESSION['view']['sort'] == 'name' ? ' SELECTED' : ''; ?>><?php echo LANG_NAME; ?></option>
      <option value="email"<?php echo $_SESSION['view']['sort'] == 'email' ? ' SELECTED' : ''; ?>><?php echo LANG_EMAIL; ?></option>
      <option value="status"<?php echo $_SESSION['view']['sort'] == 'status' ? ' SELECTED' : ''; ?>><?php echo LANG_STATUS; ?></option>
    </select>
    <select name="way">
        <option value="ASC"<?php echo $_SESSION['view']['way'] == 'ASC' ? ' SELECTED' : ''; ?>><?php echo LANG_ASC; ?></option>
        <option value="DESC"<?php echo $_SESSION['view']['way'] == 'DESC' ? ' SELECTED' : ''; ?>><?php echo LANG_DES; ?></option>
    </select>
    
    <?php echo LANG_USE_DATES; ?>
    <input type="checkbox" name="use_dates" value="1"<?php echo $_REQUEST['use_dates'] ? ' checked' : ''; ?>>
    <?php echo LANG_BETWEEN; ?>
    <input type="text" name="date_from" id="date_from" value="<?php echo $_SESSION['view']['date_from'] ? $_SESSION['view']['date_from'] : 'yesterday'; ?>" size="8">
   	&
   	<input type="text" name="date_to" id="date_to" value="<?php echo $_SESSION['view']['date_to'] ? $_SESSION['view']['date_to'] : 'now'; ?>" size="8">
    

    <?php echo LANG_RESULTS_PP; ?>:
    <select name="per">
      <?php echo $vars['results_pp']; ?>
    </select>
<?php
endif; // advanced

?>
    <input type="submit" name="search_submit" class="inputsubmit" value="<?php echo LANG_SEARCH; ?>">
    [<a href="<?php echo $vars['surl']; ?>"><?php echo $vars['stext']; ?></a>] [<a href="?s=reset"><?php echo LANG_RESET; ?></a>]
</form>
</div>
<!-- SEARCH FORM END -->