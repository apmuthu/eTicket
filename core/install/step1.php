<?php
if (!isset($step)) {
    header('Location: install.php');
    die();
} 
$output = '<p>eTicket - The Support Help Desk Ticket System<br>
<br>
<b>Licence</b><br>
</p>
<hr>
<ol>
    <li type="i"><a href="http://www.gnu.org/licenses/gpl-2.0.html">GPL v2.0</a></li>
</ol>
<br>
<hr><b>THIS PACKAGE IS PROVIDED "AS IS" AND WITHOUT ANY WARRANTY. ANY EXPRESS OR<br>
IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF<br>
MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO<br>
EVENT SHALL THE AUTHORS BE LIABLE TO ANY PARTY FOR ANY DIRECT, INDIRECT,<br>
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES ARISING IN ANY WAY<br>
OUT OF THE USE OR MISUSE OF THIS PACKAGE.</b><br>
<br>
<p></p>
<form id="license" name="license" method="post">
    <p><input type="submit" value="I Agree">
    <input type="reset" value="I Do Not Agree" onclick="alert(\'You must accept the license agreement to install eTicket\n\n\n\nIf you do not agree you must remove eTicket immediately.\');"></p>
    <input type="hidden" name="step" value="2" />
</form>';
echo $output; 
