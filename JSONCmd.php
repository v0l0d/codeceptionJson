<?php

/**
 * Class JSONCmd
 *
 * sample:
 * <code>[
{
"wantTo":["#2 Create stream session id"],
"cmd": "sendPOST",
"haveHttpHeader": ["Content-Type","application/x-www-form-urlencoded"], //optional
"url": "getStreamSessionId.json.php",
"param":{
"user_id":38126,
"lat":48.1234,
"lng":35.5432,
"tag":"#PERCEPATAR",
"social":""},
"test": [
{"seeResponseCodeIs":200},
"seeResponseIsJson",
{"seeResponseContains":"session_id"},
{"seeResponseContains":"token"},
{"seeResponseContains":"stream_id"}
]
}
]</code>
 */
class JSONCmd {
    private $I;
    private $scenario;

    public function processFile($scenario, $filename) {
        $this->scenario = $scenario;

        $rawJson = file_get_contents($filename);
        $jsonCmd = json_decode($rawJson, true);
        foreach ($jsonCmd as $cmd) {
            $func = $cmd['cmd'];
            self::$func($cmd);
        }
    }

    public function wantTo($rawCommand) {
        $this->I = new ApiTester($this->scenario);
        $this->I->wantTo($rawCommand['param'][0]);
    }

    public function sendPOST($rawCommand) {
        $this->I = new ApiTester($this->scenario);
        $this->I->wantTo($rawCommand['wantTo'][0]);

        $headerName = null;
        $headerValue = null;

        if (isset($rawCommand['haveHttpHeader'])) {
            list($headerName,$headerValue)  = $rawCommand['haveHttpHeader'];
        }else{
            $headerName="Content-Type";
            $headerValue="application/x-www-form-urlencoded";
        }
        $this->I->haveHttpHeader($headerName, $headerValue);

        $this->I->sendPOST($rawCommand['url'], $rawCommand['param']);

        if (isset($rawCommand['test'])) {
            foreach ($rawCommand['test'] as $cmd) {
                if (is_array($cmd)) {
                    $func = key($cmd);
                    $this->I->$func(current($cmd));
                } else {
                    $func = $cmd;
                    $this->I->$func();
                }
            }
        }
    }
}