<?php
	require_once 'db.php';
    $db = new Database;
    $print_messages = $db->query("SELECT `username`,`send_time`,`message` FROM `messages`,`user` WHERE `messages`.`from` = `user`.`id`;");
    function print_row(&$item) {
	  echo('<tr>');
	  array_walk($item, 'print_cell');
	  echo('</tr>');
	}

	function print_cell(&$item) {
	  echo('<td  class="table_block">');
	  echo("&nbsp".$item."&nbsp");
	  echo('</td>');
	}
	array_walk($print_messages, 'print_row');
	echo('<td id="downstairs"></td>');
 ?>
 <script>
 	window.location.href = "room.php";
 </script>
