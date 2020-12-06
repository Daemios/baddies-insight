<?php

use DynamicSuite\API\Response;
use DynamicSuite\Database\Query;
use DynamicSuite\Pkg\BaddiesInsight\Storable\Mia;

try {

    $character = (new Query())
        ->select()
        ->from('wow_members')
        ->where('name', '=', $_POST['character'])
        ->execute(true);

    error_log(strtotime($_POST['date']));

    $mia = new Mia([
        'character_id' => $character['character_id'],
        'date'         => (new DateTime($_POST['date']))->format('U'),
        'duration'     => $_POST['duration'],
        'note'         => $_POST['note']
    ]);

    $mia_created = $mia->create();

    /**
     * Send a message to the webhook
     */
    if (false) {
        $webhook = 'https://discordapp.com/api/webhooks/784915695132868620/zk4qB_8Ru0bFdkfYt4ITAdJZRrlxvm4DGmgf9mfFqBh0qOFW_KHoqXwJ3CoSp3Z5ec6V';
        $content = '`' . $_POST['character'] . "` has posted out via baddies.org/mia\n\nDuration: `".
            $_POST['duration'] . "` | Date: `" . $_POST['date'] . "`\n\nNote:\n`" . $_POST['note'] . '`';

        $ch = curl_init($webhook);

        $message = [
            'username' => 'It\'s Ya Boi, Mr. Late Bot',
            'content' => $content
        ];

        $message = "payload_json=" . urlencode(json_encode($message))."";

        if(isset($ch)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
    }


    return new Response('OK', 'Retrieved mains', $mia_created);

} catch (Exception $e) {

    error_log($e->getMessage());
    return new Response('ERROR', 'Error retrieving mains');

}