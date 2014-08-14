codeceptionJson
===============

Codeception Tests in JSON format

<pre>
[
    {
        "wantTo":["Create stream session id"],
        "cmd": "sendPOST",
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
    },
    {...}
}
</pre>

    