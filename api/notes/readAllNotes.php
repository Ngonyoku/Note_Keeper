<?php

header('Allow-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Allow-Control-Allow-Method: GET');

include_once '../../config/Database.php';
include_once '../../models/Notes.php';

$db = new Database();
$notes = new Notes($db->connect());
$allNotes = $notes->readAllNotes();

if ($allNotes->rowCount() > 0) {
    $notesArray = array();
    $notesArray['Notes'] = array();
    while($tuple = $allNotes->fetch(PDO::FETCH_ASSOC)) {
        extract($tuple);
        $noteItem = array(
            'note_id' => $id,
            'category_name' => $category_name,
            'user_first_name' => $first_name,
            'user_last_name' => $last_name,
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