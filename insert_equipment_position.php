<?php
include("./_classes/template.class.php");
include("./_classes/project.class.php");

$param = [
    'pID' => $_POST["pID"],
    'prID' => $_POST["prID"]
];

$projects = new Projects(0, '127.0.0.1', 'project_db', 'php_local_user', 'php_local_user');
$projects->insertEquipmentPosition($param);
echo $param[pID] ." => ".$param[prID] . "<BR>";
?>