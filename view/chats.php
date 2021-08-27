<?php
//$chat->newMessage('Hola Mundo');
$chats = $chat->getMessages();
?>

<link rel="stylesheet" href="./css/chats.css">
<div class="container-fluid mt-6">
    <br>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="mesgs">
                <div class="msg_history" id="messages">
                    <?php foreach ($chats as $message) : ?>
                        <?php if ($message['id'] != md5(Session::getUserId())) : ?>
                            <div class="incoming_msg">
                                <div class="incoming_msg_img"> <img class="avatar rounded-circle" src="<?= $img['profile'][$message['image']] ?>"> </div>
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <span class="time_date"> <?= $message['username'] ?></span>
                                        <p><?= $message['text'] ?></p>
                                        <span class="time_date"> <?= $message['time'] ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="outgoing_msg">
                                <div class="sent_msg">
                                    <p><?= $message['text'] ?></p>
                                    <span class="time_date"> <?= $message['time'] ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="text" id="txtMessage" class="write_msg" placeholder="Escribe un mensaje" />
                        <button onclick="onClickSend()" class="msg_send_btn" type="button"><i class="far fa-paper-plane" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ws = new WebSocket('wss://us-nyc-1.piesocket.com/v3/1?api_key=SplVgmZU1YcDl4io30IQd2H4uceIzJunpidnkVdY&notify_self');

    var cant = '<?= count($chats) ?>';
    var userid = '<?= md5(Session::getUserId()) ?>';

    function onClickSend() {
        var message = $('#txtMessage').val();
        $('#txtMessage').val('');
        if (message.length > 0) {
            $.post(
                '<?= $request['post']['chats'] ?>', {
                    txtMessage: message
                }, (data) => {
                    ws.send(data);
                }
            )
        }
    }

    ws.onmessage = (e) => {
        try{
            var data = JSON.parse(e.data);
    
            var div = [];
            for (let i = 0; i < 4; i++) {
                div[i] = document.createElement('div');
            }
    
            var p = document.createElement('p');
            var span = document.createElement('span');
            var span1 = document.createElement('span');
            var text = document.createTextNode(data.text);
            var datetime = document.createTextNode(data.time);
            var username = document.createTextNode(data.username);
            span.className = 'time_date';
            span1.className = 'time_date';
            span1.append(username);
            span.append(datetime);
            p.append(text);
    
            if (data.id != userid) {
                div[0].className = 'incoming_msg';
                div[1].className = 'incoming_msg_img';
                div[2].className = 'received_msg';
                div[3].className = 'received_withd_msg';
                var img = document.createElement('img');
                img.src = data.image;
                img.className = 'avatar rounded-circle';
    
                div[3].append(span1);
                div[3].append(p);
                div[3].append(span);
    
                div[2].append(div[3]);
                div[1].append(img);
    
                div[0].append(div[1]);
                div[0].append(div[2]);
                document.getElementById('messages').append(div[0]);
            } else {
                div[0].className = 'outgoing_msg';
                div[1].className = 'sent_msg';
    
                div[1].append(p);
                div[1].append(span);
    
                div[0].append(div[1]);
                document.getElementById('messages').append(div[0]);
            }
        }catch(e){}

        $("#messages").animate({
            scrollTop: $('#messages').prop("scrollHeight")
        }, 1000);
    }

    window.onload = () => {
        $("#messages").animate({
            scrollTop: $('#messages').prop("scrollHeight")
        }, 1000);
    }

    document.addEventListener('keyup', logKey);

    function logKey(e) {
        if (e.keyCode == 13) {
            onClickSend();
        }
    }
</script>