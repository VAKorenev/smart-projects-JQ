<?php

class SQL {

    protected $sql_query = [
'all_projects' => "select top.TYPE_OF_PROJECT, p.ID,p.NAME,p.ORG,p.ADDR,IFNULL(pe.RTOTAL,0) as TOTAL, IFNULL(pp.WTOTAL,0) as WORK_TOTAL, p.DPROJECT_UP_PLAN,p.DPROJECT_UP, '' as CHECK_DONE from projects p
left join (
select pp.project_id, sum(pp.REAL_UNIT * p.COST ) WTOTAL from project_price pp
left join price p on pp.PRICE_ID = p.ID
group by pp.PROJECT_ID
) pp on p.ID = pp.PROJECT_ID
left join (
select pe.project_id, sum(pe.REAL_UNIT * e.COST ) RTOTAL from project_equipment pe
left join equipment e on pe.PRICE_ID = e.ID
group by pe.PROJECT_ID
) pe on p.ID = pe.PROJECT_ID
left join ( 
  select id, name as TYPE_OF_PROJECT from type_of_project
) top on p.TYPE_OF_PROJECT_ID = top.ID",
        
'project' => "select p.ID_IN, p.ID,p.NAME, p.ORG,p.ADDR,IFNULL(pe.RTOTAL,0) as TOTAL, IFNULL(pp.WTOTAL,0) as WORK_TOTAL, top.TYPE_OF_PROJECT, p.DPROJECT_UP_PLAN,p.DPROJECT_UP, '' as CHECK_DONE from projects p
left join (
  select pp.project_id, sum(pp.REAL_UNIT * p.COST ) WTOTAL from project_price pp
  left join price p on pp.PRICE_ID = p.ID
  group by pp.PROJECT_ID
) pp on p.ID = pp.PROJECT_ID
left join (
  select pe.project_id, sum(pe.REAL_UNIT * e.COST ) RTOTAL from project_equipment pe
  left join equipment e on pe.PRICE_ID = e.ID
  group by pe.PROJECT_ID
) pe on p.ID = pe.PROJECT_ID
left join ( 
  select id, name as TYPE_OF_PROJECT from type_of_project
) top on p.TYPE_OF_PROJECT_ID = top.ID
where p.id = ",
        
'get_project_works' => 'select pp.ID, p.NAME, p.COST ,pp.REAL_UNIT as UNIT, p.COST*pp.REAL_UNIT as TOTAL from project_price pp left join price p on pp.PRICE_ID = p.ID where pp.PROJECT_ID = ',

'get_price' => "select ID, NAME, COST from price",

'insertWorkPosition' => 'INSERT INTO project_price (PROJECT_ID, PRICE_ID, REAL_UNIT, REAL_PRICE) VALUES ([@pID],[@prID], 1, 0)',

'insertEquipmentPosition' => 'INSERT INTO project_equipment (PROJECT_ID, PRICE_ID, REAL_UNIT, REAL_PRICE) VALUES ([@pID], [@prID], 1, 0)',        

'updatePosition' => 'UPDATE project_price SET REAL_UNIT = [@NUM] where ID = [@pID]',

'updateEquipmentPosition' => 'UPDATE project_equipment SET REAL_UNIT = [@NUM] where ID = [@pID]',

'getProjectEquipment' => 'select pp.ID as ID, e.NAME as NAME, pp.REAL_UNIT as UNIT, e.COST as COST, pp.REAL_UNIT * e.COST as TOTAL from project_equipment pp, equipment e where pp.PROJECT_ID = [@pID] and pp.PRICE_ID = e.ID ORDER BY DPUT',
'getEquipment' => 'select ID, NAME, COST from equipment',
'deleteEquipment' => 'delete from project_equipment where id = [@ID]',
'deleteWork' => 'delete from project_price where id = [@ID]',
'updateOrganizationName' => "update projects set org = '[@VAL]' where ID = [@ID]",
'updateProjectName' => "update projects set name = '[@VAL]' where ID = [@ID]",
'getComments' => "select * from messages where project_id = ",
'addNewComments' => "insert into messages (project_id, message) values([@ID],'[@MESSAGE]')"        
];
    protected $sql_insert;

    function prepare($type, $id) {

        if ($id !== 0) {

            return $this->sql_query[$type] . $id;
        }

        return $this->sql_query[$type];
    }

    function parse($sqlName, $param) {

        $output = $this->sql_query[$sqlName];

        foreach ($param as $key => $value) {
            $tagToReplace = "[@$key]";
            $output = str_replace($tagToReplace, $value, $output);
        }

//                echo "pID => " . $param['pID'] . " prID => " . $param['prID'] . $output;

        return $output;
    }

}

?>
