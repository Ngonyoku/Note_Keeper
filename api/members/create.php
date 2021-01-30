<?php
header('Allow-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Accesss-Control-Allow-Methods: POST');
header('Access-Control-Allow-Header: Access-Control-Allow-Header, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Members.php';

$database = new Database();
$members = new Members($database->connect());

$memberData = json_decode(file_get_contents("php://input"));

$members->first_name = $memberData->first_name;
$members->last_name = $memberData->last_name;

if($members->create()) {
    print_r(
        json_encode(array("message" => "Member has been added Successfully"))
    );
} else {
    print_r(
        json_encode(array("message" => "Member NOT created"))
    );
}
