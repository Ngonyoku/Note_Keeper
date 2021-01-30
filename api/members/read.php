<?php

header('Allow-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Allow-Control-Allow-Method: GET');

include_once '../../config/Database.php';
include_once '../../models/Members.php';

$database = new Database();

$membersObj = new Members($database->connect());
$members = $membersObj->read();

if ($members->rowCount() > 0) {
    $membersArray = array();
    $membersArray['members'] = array();

    while($row = $members->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $memberItem = array('id' => $id, 'first_name' => $first_name, 'last_name' => $last_name);
        array_push($membersArray['members'], $memberItem);
    }

    echo json_encode($membersArray);
} else {
    print_r(array("message" => "No Members Found"));
}