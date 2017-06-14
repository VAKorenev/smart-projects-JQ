<?php

include("./_classes/template.class.php");
include("./_classes/project.class.php");

$param = [
    'pID' => $_POST["pID"],
    'NUM' => $_POST['NUM']
];

$projects = new Projects(0, '127.0.0.1', 'project_db', 'php_local_user', 'php_local_user');
$projects->updateEquipmentPosition($param);

print_r($param);

?>