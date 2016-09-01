<?php
session_start();

$page_title="Users";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../auth/users/users.php">Users</a></li>
	<li><a class="button icon chat" href="../../auth/rules/rules.php">Rules</a></li>
	<li><a class="button icon chat" href="../../auth/roles/roles.php">Roles</a></li>
	<li><a class="button icon chat" href="../../auth/levels/levels.php">Levels</a></li>
</ul>
<?php
include"../../../foot.php";
?>
