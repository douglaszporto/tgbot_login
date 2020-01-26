<?php

function getTelegramUserData() {
    return isset($_COOKIE['tg_user']) ? json_decode(urldecode($_COOKIE['tg_user']), true) : false;
}

if (isset($_GET['logout'])) {
  setcookie('tg_user', '');
  header('Location: index.php');
}

$tg_user = getTelegramUserData();
$html = "";
$bkgclass = "";

if ($tg_user !== false) {
    $first_name = htmlspecialchars($tg_user['first_name']);
    $last_name = htmlspecialchars($tg_user['last_name']);

    $html .= "<h1>Sua classe ideal é...</h1>";
    //$val = (int)$tg_user["id"] % 12;
    $val = rand(0,11);

    $class_list = [
        "mago" => "Mago",
        "guerreiro" => "Guerreiro",
        "paladino" => "Paladino",
        "clerigo" => "Clérigo",
        "bardo" => "Bardo",
        "druida" => "Druida",
        "arqueiro" => "Arqueiro",
        "barbaro" => "Bárbaro",
        "feiticeiro" => "Feiticeiro",
        "monge" => "Monge",
        "ladino" => "Ladino",
        "ferreiro" => "Ferreiro"
    ];

    $class_desc = [
        "Você me ensina uma magia?",
        "Vamos derrotar alguns goblins?",
        "Com seu escudo, sempre estaremos seguros",
        "Sua fé é inabalável!",
        "Vamos contar boas histórias!",
        "A natureza é linda, não é?",
        "Uma boa flecha é como uma ideia: melhor na cabeça",
        "Hora de quebrar os inimigos na porrada!",
        "Eu senti isso em você...",
        "Armas são para amadores, para quem tem punhos como estes",
        "Só deixe minha carteira em paz, ok?",
        "Espero que os espetos não sejam de pau por ai..."
    ];
    
    $key = array_keys($class_list)[$val];
    $bkgclass = 'bkgclass-' . $key;
    $html .= "<h2>{$class_list[$key]}!</h2>";
    $html .= "<div id='images'>";
    
    if (isset($tg_user['photo_url'])) {
        $html .= "<img id='userphoto' src='" . htmlspecialchars($tg_user['photo_url']) . "'>";
    }

    $html .= "<img id='classimage' class='img-{$key}' src='img/{$key}.png'>";
    $html .= "</div>";
    $html .= "<div id='description'><p>Então, ${first_name}, Parece que sua classe ideal é {$class_list[$key]}<br />{$class_desc[$val]}  </p></div>";
    $html .= "<div id='more'>Mais informações em: <a href='https://github.com/douglaszporto/tgbot_login'>Github</a></div>";
    $html .= "<div id='quit'><a href='?logout=1'>Log out</a></div>";
} else {
    $html .= "<h1>Qual sua classe de RPG?</h1>";
    $html .= "<div id='description'><p>Vamos descobrir qual a sua classe de RPG?<br />Basta logar com seu Telegram e nossos <s>escravos</s> escudeiros cuidarão de verificar<br />cada aspecto necessário para descobrir qual a classe perfeita para você</p></div>";
    $html .= "<div id='button'><script async src='https://telegram.org/js/telegram-widget.js?2' data-telegram-login='SiteDZanottaBot' data-size='large' data-auth-url='login.php'></script></div>";
    $html .= "<img id='allclassesimg' src='classes.png' alt='classes'/>";
    $html .= "<img id='allclassesimg_m' src='classes_m.png' alt='classes'/>";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Classes de RPG</title>

    <link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div id='bkg' class='<?php echo $bkgclass; ?>'>
        <div id='content'>
            <?php echo($html); ?>
        </div>
    </div>
  </body>
</html>