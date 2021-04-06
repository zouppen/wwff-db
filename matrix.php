<?php
// Class for sending messages to Matrix chat
class Matrix {
    private $ch;

    public function __construct($hs, $token) {
        $this->hs = $hs;
        $this->token = $token;

        // Configure Matrix cURL handle
        $this->ch = curl_init();
        curl_setopt_array($this->ch, [
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_FAILONERROR => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);
    }

    function notice($room, $msg, $dom = NULL) {
        return $this->msg('m.notice', $room, $msg, $dom);
    }

    function msg($msgtype, $room, $msg, $dom = NULL) {
        $url = $this->hs . '/_matrix/client/r0/rooms/' . urlencode($room) . '/send/m.room.message/' . uniqid() . '?access_token=' . urlencode($this->token);

        $payload = [
            'body'    => $msg,
            'msgtype' => $msgtype,
        ];

        if ($dom !== NULL) {
            $payload += [
                'format' => 'org.matrix.custom.html',
                'formatted_body' => $dom->saveHTML(),
            ];
        }

        curl_setopt_array($this->ch, [
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => json_encode($payload),
        ]);

        return curl_exec($this->ch);
    }

    function get_error() {
        return curl_error($this->ch);
    }
}
