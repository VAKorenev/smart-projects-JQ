<?php
include("./_classes/template.class.php");
include("./_classes/project.class.php");

$param = [
    'ID' => $_POST["ID"],
    'VAL' => $_POST['VAL']
];

$projects = new Projects(0, '127.0.0.1', 'project_db', 'php_local_user', 'php_local_user');
$projects->updateOrganizationName($param);
?>