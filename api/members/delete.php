<?php

header('Allow-Control-Allow-Origin: *');
header('Content-type: applicatio/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Header: Access-Control-Allow-Header, Content-type, Access-control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Members.php';

$database = new Database();
$members = new Members($database->connect());

$inputId = json_decode(file_get_contents('php://input'));

$members->id = $inputId->member_id;

if ($members->delete()) {
    print_r(
        json_encode(array("Message" => "User Deleted Successfully"))
    );
} else {
    print_r(
        json_encode(array("Message" => "Unable to Delete User"))
    );
}