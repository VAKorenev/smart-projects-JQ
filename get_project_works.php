<?php

include("./_classes/template.class.php");
include("./_classes/project.class.php");

$ID = $_POST["ID"];

$projects = new Projects(0, '127.0.0.1', 'project_db', 'php_local_user', 'php_local_user');

foreach ($projects->getProjectWorks($ID) as $work) {
    $row = new Template('./_templates/project_works.html');
    foreach ($work as $key => $value) {
        $row->set($key, $value);
    }
    $rows[] = $row;
}

$all_rows = isset($rows) ? Template::merge($rows) : NULL;

$profile = new Template('./_templates/project_works_header.html');
$profile->set("ID", $ID);
$profile->set("work_rows", $all_rows);

echo $profile->output();
?>