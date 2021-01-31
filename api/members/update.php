<?php

header('Allow-Control-Allow-Origin: *');
header('Content-type: applicatio/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Header: Access-Control-Allow-Header, Content-type, Access-control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Members.php';

$database = new Database();
$members = new Members($database->connect());

$updatedData = json_decode(file_get_contents('php://input'));//Get the Raw JSON data

//Load the Updated Data
$members->id = $updatedData->member_id;
$members->first_name = $updatedData->first_name;
$members->last_name = $updatedData->last_name;

if ($members->updateAll()) {
    print_r(
        json_encode(array("Message" => "User Updated Successfully"))
    );
} else {
    print_r(
        json_encode(array("Message" => "Unable to update User"))
    );
}