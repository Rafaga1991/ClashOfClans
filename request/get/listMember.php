<?php

include '../load.php';

if(!Session::Auth()){
    header("location: {$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}");
}

$list = $listWar->getList($_GET['id']);
$mpdf->AddPage();
$mpdf->SetTitle('Lista de Guerra');
$mpdf->SetAuthor($list['clanName']);

$html = '<style>';
$html .= 'body{ font-family: Arial, Helvetica, sans-serif; }';
$html .= 'table{ width: 100%; border-collapse: collapse; }';
$html .= 'caption{ background-color: #22A912; color: white; padding: 5px; font-weight: bold;}';
$html .= 'th { background-color: #25B614; color: white; text-align: left; padding-left: 5px;}';
$html .= 'td { background-color: #E3EEE2; color: black; border-bottom: 1px solid white;border-left: 1px solid white;padding: 10px;}';
$html .= '</style>';
$html .= '<h4 style="width: 100%;text-align: right; color: #22A912;">';
$html .=  $list['date'];
$html .= '</h4>';
$mpdf->WriteHTML("<div style='color: #22A912;font-weight: bold;text-align:center;'>" . $list['cantMember'] . ' vs ' . $list['cantMember'] . "</div>");
$mpdf->WriteHTML("<span style='color: #22A912;font-weight: bold;'>" . $list['clanName'] . "</span>");
$mpdf->Image($list['badgeUrls'], 10 + (strlen($list['clanName']) / 2) + 1, 5, 19);

$html .= '<table>';
$html .= '<caption>';
$html .= 'LISTA DE GUERRA';
$html .= '</caption>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>';
$html .= 'ID';
$html .= '</th>';
$html .= '<th>';
$html .= 'MIEMBROS';
$html .= '</th>';
$html .= '<th>';
$html .= 'COPAS';
$html .= '</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
foreach ($list['members'] as $key => $member) {
    $style = ((($key + 1) % 2) == 0) ? 'style=\'background-color: #F4F6F4;\'' : '';
    $html .= '<tr>';
    $html .= "<td $style>";
    $html .= $key + 1;
    $html .= '</td>';
    $html .= "<td $style>";
    $html .= '<img src="' . $member['url'] . '" width="25px" /> ';
    $html .= $member['name'];
    $html .= '</td>';
    $html .= "<td $style>";
    $html .= $member['trophies'];
    $html .= '</td>';
    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';

$mpdf->WriteHTML($html);
if (!empty($list['description'])) {
    $mpdf->WriteHTML('
        <br>
        <h4>Descripción</h4>
        <p>' . $list['description'] . '</p>
    ');
}

$mpdf->AddPage();// jugadores en espera
$html = '';

$listwait = json_decode(file_get_contents('../../json/listwait/listwait_' . str_replace('#', '', Session::getClanTag()) . '.json'), true);

$html .= "<table>";
    $html .= "<caption>LISTA DE ESPERA</caption>";

    $html .= "<thead>";
        $html .= "<tr>";
            $html .= "<th>Miembros</th>";
            $html .= "<th>Fecha</th>";
        $html .= "</tr>";
    $html .= "</thead>";
        
    $html .= "<tbody>";
        foreach($listwait as $index => $member){
            $html .= "<tr>";
                $html .= "<td>" . ($index+1) . ". <img src='{$member['image']['small']}' width='25px'/> {$member['name']}</td>";
                $html .= "<td>" . date('h:i A | M d', $member['date']) . "</td>";
            $html .= "</tr>";
        }
    $html .= "</tbody>";
    
$html .= "</table>";

$mpdf->WriteHTML($html);

$mpdf->AddPage();// jugadores en descanso
$html = '';
$listbreak = json_decode(file_get_contents('../../json/listbreak/listbreak_' . str_replace('#', '', Session::getClanTag()) . '.json'), true);

$html .= "<table>";
    $html .= "<caption>LISTA DE DESCANSO</caption>";

    $html .= "<thead>";
        $html .= "<tr>";
            $html .= "<th>Miembros</th>";
            $html .= "<th>Fecha</th>";
        $html .= "</tr>";
    $html .= "</thead>";
        
    $html .= "<tbody>";
        foreach($listbreak as $index => $member){
            $html .= "<tr>";
                $html .= "<td>" . ($index+1) . ". <img src='{$member['image']['small']}' width='25px'/> {$member['name']}</td>";
                $html .= "<td>" . date('h:i A | M d', $member['date']) . "</td>";
            $html .= "</tr>";
        }
    $html .= "</tbody>";
    
$html .= "</table>";

$mpdf->WriteHTML($html);
$mpdf->WriteHTML("
    <br><hr>Página del Clan: <strong style='color: blue;'>{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}</strong><br>
");

$mpdf->Output('Lista de Guerra.pdf', 'I');
