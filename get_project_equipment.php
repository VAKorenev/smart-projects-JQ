<?php

include("./_classes/template.class.php");
include("./_classes/project.class.php");

$param = [
    'pID' => $_POST["ID"],
    'ID' => $_POST["ID"]
];

$projects = new Projects(0, '127.0.0.1', 'project_db', 'php_local_user', 'php_local_user');

foreach ($projects->getProjectEquipment($param) as $work) {
    $row = new Template('./_templates/project_equipment.html');
    foreach ($work as $key => $value) {
//        echo $key." => ".$value."<BR>";
        $row->set($key, $value);
    }
    $rows[] = $row;
}

$rows = isset($rows) ? $rows : array();

$all_rows = Template::merge($rows);

$profile = new Template('./_templates/project_equipment_header.html');
$profile->set("ID", $param['ID']);
$profile->set("content", $all_rows);

echo $profile->output();
?>