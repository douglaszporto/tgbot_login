<?php

define('BOT_TOKEN', '868173379:AAH6TR6O4YBRlXRRpk0-94UUBTcuHEp7-W0');

try {

    $check_hash = $_GET['hash'];
    unset($_GET['hash']);

    $data_check_arr = [];
    foreach ($_GET as $key => $value) {
        $data_check_arr[] = $key . '=' . $value;
    }

    sort($data_check_arr);
    $data_check_string = implode("\n", $data_check_arr);

    $secret_key = hash('sha256', BOT_TOKEN, true);
    $hash = hash_hmac('sha256', $data_check_string, $secret_key);

    if (strcmp($hash, $check_hash) !== 0) {
        throw new Exception('Data is NOT from Telegram');
    }

    if ((time() - $_GET['auth_date']) > 86400) {
        throw new Exception('Data is outdated');
    }

    setcookie('tg_user', json_encode($_GET));

} catch (Exception $e) {
    die ($e->getMessage());
}

header('Location: index.php');

?>