function addUser(data, users) {
    var a = document.createElement('a');
    var text = document.createTextNode(data.username);
    var img = document.createElement('img');
    var div = document.createElement('div');
    var row = document.createElement('div');
    var col = document.createElement('div');

    div.className = 'bg-success rounded-circle';
    div.style.width = '10px';
    div.style.height = '10px';
    div.style.position = 'absolute';
    div.style.left = '50px';
    div.style.bottom = '10px';

    row.className = 'row style-user';
    row.id = 'container-user-' + data.id;
    col.className = 'col';

    a.className = 'dropdown-item';
    a.href = './?view=profile&id=' + data.id;
    a.id = 'user-' + data.id;
    a.style.fontSize = '12px';

    img.className = 'avatar rounded-circle';
    img.src = data.image;
    img.style.width = '25px';
    img.style.height = '25px';

    a.append(img);
    a.append(div);
    a.innerHTML += '&nbsp&nbsp';
    a.append(text);
    col.append(a);
    row.append(col);
    $('#cantuseronline')[0].innerHTML = users;
    $('#usersonline')[0].append(row);
    return users;
}

function dataUser(id, username, image) {
    const ss = new WebSocket('wss://us-nyc-1.piesocket.com/v3/1?api_key=QwegJnsAj2uz9P64MenQOj3gFx0bGKlFYPPFmmH9&notify_self');

    let users = 0;
    var usersOnline = [];

    var userData = {
        id: id,
        username: username,
        image: image,
        online: true
    };

    ss.onmessage = (e) => {
        try {
            var data = JSON.parse(e.data);
            if (document.getElementById('user-' + data.id) == null && data.id !== id) {
                usersOnline[data.id] = data;
                users = addUser(data, users+1);
                usersOnline[data.id].online = true;
            }
        } catch (ex) {
            ss.send(JSON.stringify(userData));
        }
    }

    setInterval((e) => {
        if(usersOnline.length > 0){
            usersOnline = [];
            users = 0;
            $('#cantuseronline')[0].innerHTML = '';
            $('#usersonline')[0].innerHTML = '';
            ss.send('new');
        }
    }, 60000);

    ss.onopen = (e) => {
        ss.send(JSON.stringify(userData));
        ss.send('new');
    }

    /*setInterval((e) => {
        ss.send(
            JSON.stringify(
                {
                    id: id,
                    username: username,
                    image: image,
                    ip: ipAddress,
                    online: true
                }
            )
        );
    }, 1000);

    setInterval(() => {
        for (var key in usersOnline) {
            usersOnline[key].online = false;
        }

        setTimeout(() => {
            for (var keyUser in usersOnline) {
                if (!usersOnline[keyUser].online) {
                    $('#container-user-' + usersOnline[keyUser].id)[0].innerHTML = '';
                    users--;
                    delete usersOnline[keyUser];
                    $('#cantuseronline')[0].innerHTML = users;
                }
            }
        }, 2000);
    }, 10000);*/
}

var btnShowUser;
function onClickShowUser(element) {
    btnShowUser = element;
    $(element)[0].style.visibility = 'hidden';
    $('#showUser')[0].style.visibility = 'visible';
}

function onClickHiddenUser(element) {
    $(element)[0].style.visibility = 'hidden';
    $(btnShowUser)[0].style.visibility = 'visible';
}

function sleep(milisec) {
    var limit = new Date().getTime() + milisec;
    while (true) {
        if (new Date().getTime() >= limit) {
            break;
        }
    }
}

window.onload = () => {
    dataUser(
        $('#cantuseronline').attr('userid'),
        $('#cantuseronline').attr('username'),
        $('#cantuseronline').attr('image')
    );

    $('#initScroll').click(() => {
        var body = $("html, body");
        body.stop().animate({ scrollTop: 0 }, 500, 'swing');
    })

    $('#activity').DataTable({
        "order": [[0, 'desc'], [1, 'desc']]
    })

    // DataTable de Miembros Fuera del clan
    $('#membersOut').DataTable();
}