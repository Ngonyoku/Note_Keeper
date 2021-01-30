<?php
header('Allow-Control-Allow-Origin: *');
header('content-type: application/json');
header('Allow-Control-Allow-Methods: GET');

include_once '../../config/Database.php';
include_once '../../models/Members.php';

$database = new Database();
$members = new Members($database->connect());

//Get the Id from the URL
$members->id = isset($_GET['id'])? $_GET['id'] : die();
$tuple = $members->readById();

print_r(
    json_encode(
        array(
            'Member Id' => $members->id,
            'First Name' => $members->first_name,
            'Last Name' => $members->last_name
        )
    )
);
