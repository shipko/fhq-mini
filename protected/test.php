<?php
echo serialize(array(
	'username' => 'admin',
	'password' => sha1('admin'),
	'perm' => 100
	));


?>