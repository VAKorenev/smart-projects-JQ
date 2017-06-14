<?php

include("./_classes/template.class.php");
include("./_classes/project.class.php");


$ID = $_POST["ID"];

function insert($data) {
    return $data ? $data : "-";
}

$projects = new Projects(0, '127.0.0.1', 'project_db', 'php_local_user', 'php_local_user');

foreach ($projects->getProjectMsg($ID) as $mesg) {
    $pMsg_tmpl = new Template('./_templates/project_comments.html');
    foreach ($mesg as $key => $value) {
        $pMsg_tmpl->set($key, $value);
    }
    $arrMsg[] = $pMsg_tmpl;
}

$project_tmpl = new Template('./_templates/project.html');

foreach ($projects->getProject($ID) as $key => $value) {
    $project_tmpl->set($key, insert($value));
}

$Msgs = isset($arrMsg) ? Template::merge($arrMsg) : "Нет комментариев";
$project_tmpl->set("comments", $Msgs);

echo $project_tmpl->output();
?>