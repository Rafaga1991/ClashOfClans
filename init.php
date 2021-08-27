<?php

define("url", $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
define('urlMail', 'https://clanhechiceros.000webhostapp.com');

use \Statickidz\GoogleTranslate;

function getJson(string $file): array
{
    $file = file_get_contents($file);
    return json_decode($file, true);
}

function getTraslation(string $text)
{
    $data = getJson('./json/traslations.json');
    foreach ($data as $key => $definition) {
        if ($key == strtolower($text)) {
            return $definition;
        }
    }
    return $text;
}

function getSuperTroop(array $troop): array
{
    $superTroops = getJson('./json/supertroops.json');
    $troopName = strtolower(str_replace(' ', '', $troop['name']));
    foreach ($superTroops as $superTroop) {
        if ($superTroop['troopName'] == $troopName) {
            if ($troop['level'] >= $superTroop['levelToUnlock']) {
                return $superTroop;
            }
            break;
        }
    }
    return [];
}

function getSuperTroopsName(): array
{
    $superTroops = getJson('./json/supertroops.json');
    $names = [];
    foreach ($superTroops as $superTroop) {
        array_push($names, $superTroop['name']);
    }
    return $names;
}

function getTraslate(string $text): string
{
    $traslate = new GoogleTranslate();
    return $traslate->translate('en', 'es', $text);
}

function getAnswerDonations(int $send, int $received)
{
    $total = $send - $received;
    return ($total > 0) ? 'text-success' : 'text-danger';
}

function __to(string $date){
    $date = str_replace('T', '', explode('.', $date)[0]);
    $year = substr($date, 0, 4);
    $month = substr($date, 4, 2);
    $day = substr($date, 6, 2);
    $hour = substr($date, 8, 2);
    $minut = substr($date, 10, 2);
    $second = substr($date, 12, 2);

    return strtotime("$year-$month-$day" . 'T' . "$hour:$minut:$second." . $date[1]) - 14400;
}

function toDate(string $date): string
{
    return date('d/m/o h:i:s a', __to($date));
}

function toTime(string $date){
    return __to($date);
}

function getFiles($nameDir)
{ // retorna los archivos que encuentra en una carpeta
    $dir = opendir($nameDir);
    $files = "{";
    while ($file = readdir($dir)) {
        if (strlen($file) > 2) {
            $file = explode('.', $file);
            $fileName = $file[0];
            $ext = $file[count($file) - 1];
            $path = "./$nameDir/$fileName.$ext";
            $files .= "\"{$fileName}\":\"{$path}\",";
        }
    }
    $files = substr($files, 0, (strlen($files) - 1));
    $files .= "}";
    $files = json_decode(trim($files), true);
    $files = $files == NULL ? [] : $files;
    $files['NAME_DIR'] = $nameDir;
    return $files;
}

function showConsole($title, $message)
{ // Muestra un mensaje en la consola
    $title = strtoupper($title);
    $message = strtolower($message);
    echo "<script>console.log('$title: $message')</script>";
}

function __getPlayer(array $members, string $tag)
{
    foreach ($members as $member) {
        if ($member['tag'] == $tag) {
            return array('name' => $member['name'], 'townhallLevel' => $member['townhallLevel'], 'mapPosition' => $member['mapPosition']);
        }
    }
    return [];
}

function getPlayer(array $currentWar, string $tag): array
{ // retorna los datos del jugador que ataco
    $player = __getPlayer($currentWar['clan']['members'], $tag);
    if (empty($player)) {
        $player = __getPlayer($currentWar['opponent']['members'], $tag);
    }
    return $player;
}

function getDuration(int $second): string
{ // retorna la duración del ataque en la guerra
    $minut = 0;
    while (true) {
        if ($second >= 60) {
            $second -= 60;
            $minut++;
        } else {
            break;
        }
    }

    return "$minut:$second";
}

function __getPlayerAttack(array $members, string $tag): array
{
    $acum = [];
    foreach ($members as $member) {
        if (isset($member['attacks'])) {
            foreach ($member['attacks'] as $attack) {
                if ($attack['defenderTag'] == $tag) {
                    $member['attacks'] = $attack;
                    array_push($acum, $member);
                }
            }
        }
    }

    return $acum;
}

function getPlayerAttack(array $currentWar, string $tag): array
{ // retorna los jugadores que atacaron al mismo jugador
    $acum = __getPlayerAttack($currentWar['clan']['members'], $tag);
    if ($acum == []) {
        $acum = __getPlayerAttack($currentWar['opponent']['members'], $tag);
    }

    return $acum;
}

function getColorResultWar(string $state)
{ // Retorna un color dependiendo del resultado
    switch ($state) {
        case 'win':
            return '#0EBE14';
            break;
        case 'lose':
            return '#C81807';
            break;
        case 'tie':
            return '#939393';
            break;
    }
}

function isMember(array $members, string $playerTag){
    foreach($members as $member){
        if($member['tag'] == $playerTag){
            return true;
        }
    }
    return false;
}

function getColor(string $action): string{
    switch ($action) {
        case 'login':
            return 'info';
            break;
        case 'register':
            return 'success';
            break;
        case 'delete':
            return 'danger';
            break;
        case 'update':
            return 'primary';
            break;
        case 'publication':
            return 'default';
            break;
        case 'logout':
            return 'warning';
            break;
    }
}

function sendPost(string $url, array $data)
{
    $data['text'] = str_replace('\n', '', $data['text']);
    echo '
    <script>
        window.onload = ()=>{
            $.post(
                "' . $url . '",
                {
                    title: "' . $data['title'] . '",
                    name: "' . $data['name'] . '",
                    usermail: "' . $data['usermail'] . '",
                    text: \'' . $data['text'] . '\'
                }
            )
        }
    </script>
    ';
}

function sendGet(string $url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function getPlaneText(string $txt)
{
    $filter = ['<', '>', '/', "'", '"'];
    foreach ($filter as $char) {
        $txt = str_replace($char, '&#' . ord($char), $txt);
    }
    return $txt;
}

function inArray(string $searchVal, array $data, string $index = null)
{
    foreach ($data as $value) {
        if ($index != null) {
            if ($searchVal == $value[$index]) {
                return true;
            }
        } else {
            if ($searchVal == $value) {
                return true;
            }
        }
    }
    return false;
}

function reloadPage(string $view = 'login')
{
    echo '<script>location.href = "./?view=' . $view . '"</script>';
}

function orderListWar(array $list): array
{
    $newList = [];
    $mapPositions = [];
    foreach ($list as $value) {
        array_push($mapPositions, $value['mapPosition']);
    }
    sort($mapPositions);
    foreach ($mapPositions as $key => $position) {
        foreach ($list as $member) {
            if ($member['mapPosition'] == $position) {
                $member['mapPosition'] = $key + 1;
                array_push($newList, $member);
                break;
            }
        }
    }
    return $newList;
}

function showArray(array $data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function getMember(array $members, string $tag){
    foreach($members as $member){
        if($member['tag'] == $tag){
            return $member;
        }
    }
    return [];
}

function orderBy(array $data, string $orderBy, string $by='desc'){
    $order = [];
    foreach($data as $member){
        if(!isset($order[$member[$orderBy]])){
            $order[$member[$orderBy]] = [];
        }
        array_push($order[$member[$orderBy]], $member);
    }

    if($by == 'desc'){
        krsort($order);
    }else{
        ksort($order);
    }
    return $order;
}

function inArraySearch(string $search, array $data){
    foreach($data as $value){
        if(strpos(' ' . $value, $search) > 0){
            return true;
        }
    }

    return false;
}