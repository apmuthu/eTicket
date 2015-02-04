<?php
if (!defined('ISINC')) die('serious error! File: '.__FILE__.' File line: '.__LINE__.'');
$footer = str_replace("<!--", "", $footer);
$footer = str_replace("-->", "", $footer);
if (!empty($footer)) {
    echo $footer;
    unset($footer);
}
if (!show_copy(true)) {
    echo '<div class="footer"><center><font color="black" size="5"><strong>Copyright<br></strong></font></center>';
    echo '</div>';
}
?>
