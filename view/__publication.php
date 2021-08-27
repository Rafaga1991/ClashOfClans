<link rel="stylesheet" href="./css/publication.css">
<?php foreach ($publications as $key => $value) : ?>
    <div class="card">
        <?php if (isset($value['file']['type'])) : ?>
            <?php if ($value['file']['type'] == 'image') : ?>
                <a href="#" data-toggle="modal" data-target="#img-<?= $value['file']['name'] ?>">
                    <img class="card-img-top" src="<?= $img['publication'][$value['file']['name']] ?>">
                </a>
                <div class="modal fade bd-example-modal-lg" id="img-<?= $value['file']['name'] ?>" tabindex="-1" role="dialog" aria-labelledby="img-<?= $value['file']['name'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <br><br><br><br><br>
                        <img width="100%" class="rounded" src="<?= $img['publication'][$value['file']['name']] ?>">
                    </div>
                </div>
            <?php elseif ($value['file']['type'] == 'video') : ?>
                <video onclick="onPlay('userPub<?= $key ?>')" onmouseover="onPause('userPub<?= $key ?>')" onmouseout="onPlay('userPub<?= $key ?>')" class="card-img-top" controls>
                    <source src="<?= $video[$value['file']['name']] ?>">
                </video>
            <?php elseif ($value['file']['type'] == 'youtube') : ?>
                <iframe onplay="onPlay('userPub<?= $key ?>')" onmouseover="onPause('userPub<?= $key ?>')" onmouseout="onPlay('userPub<?= $key ?>')" onpause="onPause('userPub<?= $key ?>')" width="100%" height="500" src="https://www.youtube.com/embed/<?= $value['file']['name'] ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php elseif ($value['file']['type'] == 'tiktok') : ?>
                <?php
                $dataTiktok = explode('/', $value['file']['name']);
                $idTiktok = $dataTiktok[count($dataTiktok) - 1];
                ?>
                <blockquote class="tiktok-embed" cite="https://www.tiktok.com/<?= $value['file']['name'] ?>" data-video-id="<?= $idTiktok ?>" style="max-width: 605px;min-width: 325px;">
                    <section></section>
                </blockquote>
                <script async src="https://www.tiktok.com/embed.js"></script>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (($value['idUser'] == Session::getUserId() && (strtotime($value['date']) + 3600) >= time()) || Session::Admin() || Session::superAdmin()) : ?>
            <a onclick="onClickDelete(<?= $value['idUser'] ?>, <?= $value['idPublication'] ?>)" class="text-danger" style="position: absolute;right: 5px;top: 5px;cursor: pointer;" data-toggle="tooltip" title="Borrar Publicación"><i class="fas fa-trash-alt"></i></a>
        <?php endif; ?>

        <a onmouseout="onPlay('userPub<?= $key ?>')" onmouseover="onPause('userPub<?= $key ?>')" class="opacity-5" href="./?view=profile&id=<?= md5($value['idUser']) ?>&publication" id="userPub<?= $key ?>" style="position: absolute;top: 5px;left: 5px;" data-toggle="tooltip" title="Perfil de <?= $value['user']['username'] ?>">
            <img src="<?= $img['profile'][$value['user']['imageurl']] ?>" class="avatar rounded-circle" style="width: 25px; height: 25px;">
        </a>

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <?php if (!empty($value['description'])) : ?>
                        <?php if (isset($value['file']['type'])) : ?>
                            <pre class="card-text"><?= $publication->getLink($value['description']) ?></pre>
                        <?php else : ?>
                            <br><br><br>
                            <h1 class="card-text text-muted"><?= $publication->getLink($value['description']) ?></h1>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col text-muted">
                    <?= date('d M Y', strtotime($value['date'])) ?>
                </div>
                <div class="col">
                    <div class="text-right">
                        <span style="font-size: 1.8rem;cursor: pointer;" onclick="onClickShowComments('<?= $value['idPublication'] ?>', 0)">
                            <i class="fas fa-comment-alt" data-toggle="tooltip" title="Ver Comentarios"></i>
                            <?php if ($value['commentary']['cant'] > 0) : ?>
                                <span class="badge badge-danger" style="font-size: 12px;position: absolute;right: 70px;"><?= $value['commentary']['cant'] ?></span>
                            <?php endif; ?>
                            &nbsp;&nbsp;
                        </span>
                        <span onclick="onClickLike(<?= Session::getUserId() ?>, <?= $value['idPublication'] ?>, 'likeName<?= $value['idPublication'] ?>', <?= $value['idUser'] ?>)" class="text-danger text-center" data-toggle="tooltip" title="Me Gusta" style="cursor: pointer;font-size: 2rem;">
                            <i id="likeName<?= $value['idPublication'] ?>" class="fa<?= $value['like'] ? 's' : 'r' ?> fa-heart"></i>
                            <span style="font-size: 12px;position: absolute;bottom: -7px;right: 15px;"><?= $value['likes'] ?></span>
                        </span>
                    </div>
                </div>
            </div>
            <hr class="dropdown-divider">
            <input type="text" onclick="onClick(this)" idPublication="<?= $value['idPublication'] ?>" idCommentary="0" class="commentary" placeholder="Agregar un comentario">
            <hr class="dropdown-divider">

            <div id="commentary-p<?= $value['idPublication'] ?>-c0"></div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    const socket = new WebSocket('wss://us-nyc-1.piesocket.com/v3/1?api_key=A9Qtxiqn8Du367gWXYZhq7cBiueo86UziWBu2boh&notify_self');

    function addCommentary(data) {
        var ul = document.createElement('ul');
        var li = document.createElement('li');

        var text = document.createTextNode(data.commentarypublication);
        var username = document.createTextNode(data.username);

        var row = document.createElement('div');
        var row1 = document.createElement('div');
        var row2 = document.createElement('div');
        var row3 = document.createElement('div');

        var col = document.createElement('div');
        var col1 = document.createElement('div');
        var col2 = document.createElement('div');
        var col3 = document.createElement('div');
        var col4 = document.createElement('div');
        var col5 = document.createElement('div');
        var col6 = document.createElement('div');

        var divContainer = document.createElement('div');
        var img = document.createElement('img');
        var a = document.createElement('a');
        var i = document.createElement('i');
        var i2 = document.createElement('i');
        var span = document.createElement('span');
        var strong = document.createElement('strong');

        span.append(document.createTextNode(data.datecommentarypublication));
        span.style.fontSize = '10px';

        strong.append(document.createTextNode(data.comments));
        strong.style.fontSize = '12px';
        strong.style.position = 'absolute';
        strong.style.left = '0px';

        i.className = 'btnVisivility fas fa-comment';
        i.title = 'Ver Comentarios';
        if (data.comments > 0) {
            i.append(strong);
        }
        i.onclick = (e) => {
            onClickShowComments(data.idPublicationcommentarypublication, data.idcommentarypublication);
        }

        i2.className = 'btnVisivility fas fa-reply';
        i2.title = 'Responder';
        i2.onclick = (e) => {
            var input = document.createElement('input');
            input.type = 'text';
            input.className = 'commentary';
            input.placeholder = "Agregar un comentario";

            input.setAttribute('idPublication', data.idPublicationcommentarypublication);
            input.setAttribute('idCommentary', data.idcommentarypublication);

            input.onkeypress = (e) => {
                if (e.keyCode == 13) {
                    if ($(e.target).val() != '') {
                        $.post(
                            '<?= $request['post']['publication'] ?>', {
                                idPublication: $(e.target).attr('idPublication'),
                                idCommentary: $(e.target).attr('idCommentary'),
                                commentary: $(e.target).val()
                            }, (val) => {
                                socket.send(val);
                            }
                        )
                        $(e.target).val('')
                    }
                }
            }

            $('#commentary-p' + data.idPublicationcommentarypublication + '-c' + data.idcommentarypublication)[0].innerHTML = '';
            $('#commentary-p' + data.idPublicationcommentarypublication + '-c' + data.idcommentarypublication)[0].append(input);
        }

        a.href = './?view=profile&id=' + data.idUsercommentarypublication;
        a.innerHTML = '&nbsp';
        a.style.fontSize = '12px';
        a.append(username);

        img.src = data.imageurl;
        img.className = 'avatar rounded-circle';
        img.style.width = '25px';
        img.style.height = '25px';

        row.className = 'row';
        row1.className = 'row';
        row2.className = 'row';
        row3.className = 'row';

        divContainer.id = 'commentary-p' + data.idPublicationcommentarypublication + '-c' + data.idcommentarypublication;

        ul.style.listStyle = 'none';

        /* Comentarios y responder */
        col5.className = 'col';
        col5.append(i);
        col6.className = 'col';
        col6.append(i2);

        row3.append(col5);
        row3.append(col6);
        /* fin */

        col.className = 'col';

        col1.className = 'col-sm-0';
        col1.append(img);

        col2.className = 'col';
        col2.append(a);

        col3.className = 'col';
        col3.append(row3);

        col4.className = 'col';
        col4.innerHTML = data.commentarypublication;
        col4.style.fontSize = '15px';
        col4.append(document.createElement('br'))
        col4.append(span)
        col4.append(divContainer);

        row1.append(col2);
        row1.append(col3);

        row2.append(col4);

        col.append(row1);
        col.append(row2);

        row.append(col1);
        row.append(col)

        li.append(row);

        ul.append(li)

        return ul;
    }

    var url = '<?= $request['get']['comments'] ?>';

    function onClickShowComments(idPublication, idRequest) {
        $('#commentary-p' + idPublication + '-c' + idRequest)[0].innerHTML = '';
        $.post(
            url, {
                idPublication: idPublication,
                idRequest: idRequest
            }, (data) => {
                data = JSON.parse(data);
                data.comments.forEach((value, index) => {
                    $('#commentary-p' + idPublication + '-c' + idRequest)[0].append(addCommentary(value));
                })
            }
        )
    }

    socket.onmessage = (e) => {
        try {
            var data = JSON.parse(e.data);
            $('#commentary-p' + data.idPublicationcommentarypublication + '-c' + data.idRequestcommentarypublication)[0].append(addCommentary(data))
        } catch (event) {}

    }

    function onClick(element) {
        $(element).keypress((e) => {
            if (e.keyCode == 13) {
                if ($(e.target).val() != '') {
                    $.post(
                        '<?= $request['post']['publication'] ?>', {
                            idPublication: $(e.target).attr('idPublication'),
                            idCommentary: $(e.target).attr('idCommentary'),
                            commentary: $(e.target).val()
                        }, (val) => {
                            socket.send(val);
                        }
                    )
                    $(e.target).val('')
                }
            }
        })
    }
</script>