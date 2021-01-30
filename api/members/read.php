<?php

header('Allow-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Allow-Control-Allow-Method: GET');

include_once '../../config/Database.php';
include_once '../../models/Members.php';

$database = new Database();

$membersObj = new Members($database->connect());
$members = $membersObj->read();

if ($members == null) {
    print_r(
        json_encode(array("message" => "No Members Found"))
    );
} else {
    print_r(
        json_encode($members)
    );
}