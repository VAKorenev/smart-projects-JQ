<?php

include("./_classes/template.class.php");
include("./_classes/project.class.php");

$projects = new Projects(0, '127.0.0.1', 'project_db', 'php_local_user', 'php_local_user');


foreach ($projects->getEquipmetn() as $work) {
    $row = new Template('./_templates/equipment_price.html');
    foreach ($work as $key => $value) {
        $row->set($key, $value);
    }
    $rows[] = $row;
}

$all_rows = Template::merge($rows);

$profile = new Template('./_templates/equipment_price_header.html');
$profile->set("price", $all_rows);

echo $profile->output();
?>