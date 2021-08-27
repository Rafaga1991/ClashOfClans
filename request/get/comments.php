<?php
include '../load.php';

if(isset($_POST['idPublication']) && isset($_POST['idRequest'])){
    $comments = $publication->getComments($_POST['idPublication'], $_POST['idRequest']);
    foreach($comments['comments'] as $key => $commentary){
        if(!empty($commentary['commentarypublication'])){
            $comments['comments'][$key]['commentarypublication'] = $publication->getLink($commentary['commentarypublication']);
        }
    }
    echo json_encode($comments);
}