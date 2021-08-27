<?php

date_default_timezone_set('America/Santo_Domingo');

class Chat
{
    private $location;
    private $imgURL;

    public function __construct(string $location, string $imgURL=null)
    {
        $this->location = $location;
        $this->imgURL = $imgURL;
        $this->newFile();
    }

    private function getFiles(string $nameDir):array{
        $dir = opendir($nameDir);
        $files = "{";
        while ($file = readdir($dir)) {
            if (strlen($file) > 2) {
                $file = explode('.', $file);
                $fileName = $file[0];
                $ext = $file[count($file) - 1];
                $path = "$nameDir/$fileName.$ext";
                $files .= "\"{$fileName}\":\"{$path}\",";
            }
        }
        $files = substr($files, 0, (strlen($files) - 1));
        $files .= "}";
        $files = json_decode(trim($files), true);
        $files = $files == NULL ? [] : $files;
        return $files;
    }

    public function getMessages()
    {
        $files = $this->getFiles($this->location);
        $messages = [];
        $times = [];
        foreach ($files as $key => $file) {
            if ($key != 'NAME_DIR') {
                $data = json_decode(file_get_contents($file), true);
                foreach ($data as $value) {
                    $messages[count($messages)] = $value;
                    array_push($times, $value['time']);
                }
            }
        }
        sort($times);

        $orderMessages = [];
        foreach ($times as $keyTimes => $valueTimes) {
            foreach ($messages as $key => $valueMessages) {
                if ($valueTimes == $valueMessages['time'] && !$valueMessages['delete']) {
                    $orderMessages[$keyTimes] = $valueMessages;
                    @$orderMessages[$keyTimes]['text'] = openssl_decrypt($valueMessages['text'], 'aes128', md5($valueMessages['time']));
                    $orderMessages[$keyTimes]['time'] = date('h:i A | M j', $valueMessages['time']);
                    if($this->imgURL != null){
                        $orderMessages[$keyTimes]['image'] = './' . str_replace('../','',$this->getFiles($this->imgURL)[$orderMessages[$keyTimes]['image']]);
                    }
                    unset($messages[$key]);
                    break;
                }
            }
        }

        return $orderMessages;
    }

    public function newMessage(string $text):string
    {
        $file = $this->newFile();
        $messages = json_decode(file_get_contents($file['path']), true);
        $cant = count($messages);
        $messages[$cant]['id'] = $file['file'];
        $messages[$cant]['image'] = Session::getImage();
        $messages[$cant]['username'] = Session::getUsername();
        $messages[$cant]['admin'] = Session::Admin();
        $messages[$cant]['time'] = time();
        @$messages[$cant]['text'] = openssl_encrypt($text, 'aes128', md5($messages[$cant]['time']));
        $messages[$cant]['delete'] = false;
        file_put_contents($file['path'], json_encode($messages));
        
        $messages[$cant]['time'] = date('h:i A | M j', $messages[$cant]['time']);
        $messages[$cant]['text'] = $text;
        $messages[$cant]['image'] = './' . str_replace('../','',$this->getFiles($this->imgURL)[$messages[$cant]['image']]);

        return json_encode($messages[$cant]);
    }

    private function newFile(): array
    {
        $fileName = md5(Session::getUserId());
        $path = $this->location . '/' . $fileName . '.json';

        if (!file_exists($path)) {
            file_put_contents($path, '[]');
        }

        return ['file' => $fileName, 'path' => $path];
    }
}
