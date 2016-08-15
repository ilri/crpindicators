<?php
session_start();

$page_title="Tasks";
include"../../../hd.php";
?>
<ul id="cmd-buttons" style="list-style-type:none;">
	<li><a class="button icon chat" href="../../pm/taskalbums/taskalbums.php">Task Albums</a></li>
	<li><a class="button icon chat" href="../../pm/notificationtypes/notificationtypes.php">Notification Types</a></li>
	<li><a class="button icon chat" href="../../pm/notifications/notifications.php">Notifications</a></li>
	<li><a class="button icon chat" href="../../pm/notificationrecipients/notificationrecipients.php">Notification Recipients</a></li>
	<li><a class="button icon chat" href="../../pm/taskparticipants/taskparticipants.php">Task Participants</a></li>
	<li><a class="button icon chat" href="../../pm/employeecalendar/employeecalendar.php">Employee Calendar</a></li>
	<li><a class="button icon chat" href="../../pm/taskobservers/taskobservers.php">Task Observers</a></li>
	<li><a class="button icon chat" href="../../pm/tasks/tasks.php">Tasks</a></li>
	<li><a class="button icon chat" href="../../pm/taskdocuments/taskdocuments.php">Task Documents</a></li>
</ul>
<?php
include"../../../foot.php";
?>
