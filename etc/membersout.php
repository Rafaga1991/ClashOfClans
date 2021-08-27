<?php

if(Session::Auth()){ 
    if(!is_dir($json['members']['NAME_DIR'])){
        mkdir($json['members']['NAME_DIR']);
    }
    
    $fileNameMembers = md5(str_replace('#', '', Session::getClanTag()));
    $fileNameMembers_out = 'out_' . md5(str_replace('#', '', Session::getClanTag()));
    
    $currentMembers = [];
    foreach($info['memberList'] as $member){
        array_push($currentMembers, [
            'tag' => $member['tag'],
            'name' => $member['name']
        ]);
    }
    
    if(!isset($json['members'][$fileNameMembers]) || !isset($json['members'][$fileNameMembers_out])){
        file_put_contents(($json['members']['NAME_DIR'] . '/' . $fileNameMembers . '.json'), json_encode($currentMembers));
        file_put_contents(($json['members']['NAME_DIR'] . '/' . $fileNameMembers_out . '.json'), '[]');
        $json['members'] = getFiles($json['members']['NAME_DIR']);
    }
    
    $lastMebers = json_decode(file_get_contents($json['members'][$fileNameMembers]), true);
    $out_member = json_decode(file_get_contents($json['members'][$fileNameMembers_out]), true);
    
    foreach($currentMembers as $member){// verificando si hay nuevos miembros.
        if(!in_array($member, $lastMebers)){
            file_put_contents(($json['members']['NAME_DIR'] . '/' . $fileNameMembers . '.json'), json_encode($currentMembers));
            break;
        }
    }

    $out_member_clan = [];
    foreach($lastMebers as $lastMember){// verificando si salieron miembros.
        if(!in_array($lastMember, $currentMembers)){
            $lastMember['date'] = date('h:i A | M d', time());
            array_push($out_member_clan, $lastMember);
        }
    }
    
    if(!empty($out_member_clan)){
        $out_members = $out_member;
        foreach($out_member_clan as $member){
            $postition = -1;
            foreach($out_member as $key_out_member => $outMember){
                if($member['tag'] == $outMember['tag']){
                    $member['cant_out'] = $outMember['cant_out'] + 1;
                    $postition = $key_out_member;
                    break;
                }
            }
    
            if(empty($out_member) || $postition == -1){
                $member['cant_out'] = 1;
                array_push($out_members, $member);
            }else{
                $out_members[$postition]['cant_out']++;
            }
        }
        file_put_contents(($json['members']['NAME_DIR'] . '/' . $fileNameMembers . '.json'), json_encode($currentMembers));
        file_put_contents($json['members'][$fileNameMembers_out], json_encode($out_members));
    }
}