<?php

class Request extends Connection{
    public function requestSQLCode(string $sql){
        $filter = ['update', 'delete', 'alter', 'insert', 'create', 'drop', 'show', 'select'];
        foreach($filter as $value){
            if(strpos(' ' . strtolower($sql), $value) > 0){
                if($value == 'select' || $value == 'show'){
                    return json_encode(parent::getData($sql));
                }else{
                    parent::execNoQuery($sql);
                    return '{"request":"Success: ' . $sql . '"}';
                }
                break;
            }
        }
        return '{"request":"none"}';
    }

    public function exportData(){
        $tables = parent::getData('SHOW TABLES');
        $data = [];
        $info = [];
        foreach($tables as $table){
            if(strpos(' ' . $table[0], 'view_') == 0){
                $info['table_name'] = $table[0];
                $info['params'] = [];
                $info['values'] = parent::getData('SELECT * FROM ' . $table[0]);
                foreach($info['values'] as $key => $values){
                    $cant = count($values);
                    for($i=0; $i<$cant-1; $i++){
                        unset($info['values'][$key][$i]);
                    }
                    if(empty($info['params'])){
                        foreach($info['values'][$key] as $keyValues => $value){
                            array_push($info['params'], $keyValues);
                        }
                    }
                }
                array_push($data, $info);
            }
        }

        file_put_contents('./json/database.json', json_encode($data));
    }

    private function existsRegister(string $table, string $columname,  int $id){
        return count(parent::getData("SELECT * FROM $table WHERE $columname=$id")) != 0;
    }

    public function importData(array $json){
        $insert = [];
        foreach($json as $keyJson => $data){
            if(count($data['values']) > 0){
                $params = join(',', $data['params']);
                $values = '';
                foreach($data['values'] as $keyValues => $val){
                    if(!$this->existsRegister($data['table_name'], $data['params'][0], $val[$data['params'][0]])){
                       $info = [];
                       foreach($val as $value){
                           array_push($info, $value);
                       }
                       $values .= '(\'' . join('\',\'', $info) . '\'),';
                    }
                }

                if(!empty($values)){
                    $values = substr($values, 0, strlen($values)-1);
                    array_push(
                        $insert,
                        "INSERT INTO {$data['table_name']}($params) VALUES $values"
                    );
                }
            }
        }

        foreach($insert as $sql){// insertando registros.
            $this->requestSQLCode($sql);
        }

        return ['state' => (!empty($insert)?'success':'error')];
    }
}