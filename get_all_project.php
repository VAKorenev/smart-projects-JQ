<?php
    include("./_classes/template.class.php");
    include("./_classes/project.class.php");
    
    $projects = new Projects(0, '127.0.0.1', 'project_db', 'php_local_user', 'php_local_user');

    foreach ($projects->getAllProjects() as $project) {
        $row = new Template('./_templates/desctop_table_row.html');
        foreach ($project as $key => $value) {
            $row->set($key, $value);
        }
        $rows[] = $row;
    }

    $desctop_rows_all = Template::merge($rows);

    $profile = new Template('./_templates/desctop.html');
    $profile->set("title", "Отдел развития");
    $profile->set("desctop_rows", $desctop_rows_all);

    echo $profile->output();
?>