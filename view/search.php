<?php
$results = [];
if (isset($_POST['search'])) {
    $notificationResult = $notification->getNotificationSearch($_POST['search']);
    foreach ($notificationResult as $value) {
        array_push(
            $results,
            [
                "id" => $value['idNotification'],
                "title" => '<a href="./?view=notification">Notificación</a>',
                "body" => $value['descriptionNotification'],
                "date" => $value['dateNotification']
            ]
        );
    }
    $publicationResult = $publication->getPublicationSearch($_POST['search']);
    foreach ($publicationResult as $value) {
        array_push(
            $results,
            [
                "id" => $value['idPublication'],
                "title" => '<a href="./?view=profile&id=' . md5($value['idUser']) . '&publication">' . 'Publicación' . "</a>",
                "body" => $publication->getLink($value['descriptionPublication']),
                "date" => $value['datePublication']
            ]
        );
    }
    $userResult = $user->getUserSearch($_POST['search']);
    foreach ($userResult as $value) {
        array_push(
            $results,
            [
                "id" => $value['idUser'],
                "title" => '<a href="./?view=profile&id=' . md5($value['idUser']) . '">' . 'Perfil' . "</a>",
                "body" => $value['username'],
                "date" => date('Y-m-d H:i:s', time())
            ]
        );
    }
    $listWarResult = $listWar->getListWarSearch($_POST['search']);
    foreach ($listWarResult as $value) {
        array_push(
            $results,
            [
                "id" => $value['id'],
                "title" => '<a target="__blanck" href="' . $request['get']['listMember'] . '?&id=' . $value['id'] . '">' . 'Lista de Guerra' . "</a>",
                "body" => "<i>{$value['cantMember']} vs {$value['cantMember']}</i><br><strong>{$value['clanName']}</strong><br>{$value['description']}",
                "date" => date('Y-m-d H:i:s', $value['date'])
            ]
        );
    }
    $commentaryResult = $publication->getCommentarySearch($_POST['search']);
    foreach ($commentaryResult as $value) {
        array_push(
            $results,
            [
                "id" => $value['idcommentarypublication'],
                "title" => '<strong>Comentario</strong>',
                "body" => "<img src='{$img['profile'][$value['imageurl']]}' style='width: 25px;height: 25px;' class='avatar rounded-circle'> {$value['username']}<br>" . $publication->getLink($value['commentarypublication']),
                "date" => date('Y-m-d H:i:s', $value['date'])
            ]
        );
    }
    $questionResult = $question->getQuestionSearch($_POST['search']);
    foreach ($questionResult as $value) {
        array_push(
            $results,
            [
                "id" => $value['idquestion'],
                "title" => "<strong>{$value['question']}</strong>",
                "body" => $value['answerquestion'],
                "date" => $value['date']
            ]
        );
    }
} else {
    reloadPage('publication');
}
?>

<div class="container-fluid mt-7">
    <h1 class="text-muted">Resultados de Busqueda (<?=count($results)?>)</h1>
    <table class="table">
        <tbody>
            <?php foreach ($results as $result) : ?>
                <tr>
                    <td>
                        <?= $result['title'] ?>
                        <br>
                        <?=$result['body']?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br><br><br><br><br>