<?php

header('Allow-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Allow-Control-Allow-Method: GET');

include_once '../../config/Database.php';
include_once '../../models/Notes.php';

$db = new Database();
$notes = new Notes($db->connect());

$notes->memberId = isset($_GET['user_id'])? $_GET['user_id'] : null;
// $notes->setMemberId($memberId);

$allNotes = $notes->readAllByUser();

if ($allNotes->rowCount() > 0) {
    $notesArray = array();
    $notesArray['Notes'] = array();
    while($tuple = $allNotes->fetch(PDO::FETCH_ASSOC)) {
        extract($tuple);
        $noteItem = array(
            'note_id' => $id,
            'user_id' => $member_id,
            'user_first_name' => $first_name,
            'user_last_name' => $last_name,
            'category_name' => $category_name,
            'note_title' => $title,
            'note_description' => $description,
            'date_created' => $date_created
        );
        array_push($notesArray['Notes'], $noteItem);
    }
    print_r(
        json_encode($notesArray)
    );
} else {
    echo json_encode(
        array('message' => 'No Notes Found')
    );
}