<?php

date_default_timezone_set('America/Santo_Domingo');

class ListWar
{
    private $dbName = __DIR__ . '/list/';

    public function __construct($name = 'listWar')
    {
        $this->dbName .= ((Session::getClanTag() != '')?md5(Session::getClanTag()):md5($name)) . '.json';
        if(!file_exists($this->dbName)){
            file_put_contents($this->dbName, '[]');
        }
    }

    public function getList($idList = null)
    {
        $listMembersWars = json_decode(file_get_contents($this->dbName), true);
        foreach ($listMembersWars as $key => $listMembersWar) {
            if ($listMembersWar['delete']) {
                unset($listMembersWars[$key]);
            } else {
                $listMembersWars[$key]['date'] = date('d M Y', $listMembersWars[$key]['date']);
                if ($idList != null) {
                    if ($listMembersWar['id'] == $idList) {
                        break;
                    }
                    unset($listMembersWars[$key]);
                }
            }
        }
        $listMembersWars = ($idList != null) ? $listMembersWars[$key] : $listMembersWars;
        return $listMembersWars;
    }

    public function getListWarSearch(string $search){
        $listDB = json_decode(file_get_contents($this->dbName), true);
        $array = [];
        foreach($listDB as $list){
            if($list['cantMember'] == $search || strpos(strtolower('-' . $list['clanName']), strtolower($search)) != 0 || strpos(strtolower('-' . $list['description']), strtolower($search)) != 0){
                array_push($array, $list);
            }else{
                foreach($list['members'] as $member){
                    if(strpos(strtolower('-' . $member['name']), strtolower($search)) != 0 || strpos(strtolower('-' . $member['trophies']), strtolower($search))){
                        array_push($array, $list);
                        break;
                    }
                }
            }
        }
        return $array;
    }

    public function setList($list){
        $listMembersWars = json_decode(file_get_contents($this->dbName), true);
        $list['members'] = $this->orderList($list['members']);
        array_push($listMembersWars, $list);
        file_put_contents($this->dbName, json_encode($listMembersWars));
    }

    public function deleteList(string $idList): bool
    {
        $lists = $this->getList();
        $answer = false;
        foreach ($lists as $key => $list) {
            if ($list['id'] == $idList) {
                $lists[$key]['delete'] = true;
                $answer = true;
                break;
            }
        }
        if ($answer) {
            file_put_contents($this->dbName, json_encode($lists));
        }

        return $answer;
    }

    private function orderList(array $members): array
    {
        $trophy = [];
        foreach ($members as $member) {
            array_push($trophy, intval($member['trophies']));
        }
        rsort($trophy);
        $acumMembers = [];
        foreach ($trophy as $trophies) {
            foreach ($members as $key => $member) {
                if ($member['trophies'] == $trophies) {
                    array_push($acumMembers, $member);
                    unset($members[$key]);
                    break;
                }
            }
        }
        return $acumMembers;
    }

    public function updateList(array $list)
    {
        $listDB = $this->getList();
        foreach ($listDB as $key => $listVal) {
            if ($listVal['id'] == $list['id']) {
                $listDB[$key]['date'] = time();
                $listDB[$key]['cantMember'] = count($list['members']);
                $listDB[$key]['members'] = $this->orderList($list['members']);
                $listDB[$key]['description'] = $list['description'];
                break;
            }
        }

        file_put_contents($this->dbName, json_encode($listDB));
    }
}
