<?php
const ULTIMO_ID = "ultimoID";
error_reporting(E_ALL);
require 'tmOAuth.php';

function getContent($tipo, $recurso, $param = [])
{
    $connection = new tmhOAuth(array(
        'consumer_key' => 'l0t4mpJct6tjv77BQqW7stxzt',
        'consumer_secret' => 'yVOhgqAtMTjd2kcct21XvrMjnRteFrldHz6ib7my3OCleIHJot',
        'user_token' => '911231393618890752-qoJzTvUTVSergJ3B4P0kQUL106iNLHW',
        'user_secret' => 'GxFweRftE1DrT2owYfzYO0zebPHp3S8nkshEdOgYk8Ehf'
    ));

    $multipart = false;
    if (isset($param['media_data'])) {
        $multipart = true;
    }

    $response = $connection->request($tipo, $connection->url($recurso), $param, true, $multipart);

    if ($response == 200) {
        return (array)json_decode($connection->response['response'], true);
    }

    return [];
}

function loadUltimoId()
{
    //Carregando ultimo ID de mention processado
    $fileMentions = fopen(ULTIMO_ID, "r");
    if ($fileMentions) {
        $ultimoID = intval(fread($fileMentions, filesize(ULTIMO_ID)));
    } else {
        $ultimoID = 0;
    }
    fclose($fileMentions);

    return $ultimoID;
}

function getMusica($letra) {
    $apiUrl = 'https://studiosolsolr-a.akamaihd.net/letras/m1/?callback=LetrasSug&q=';
    //$apiUrl = 'https://api.vagalume.com.br/search.excerpt?q=';

    $url = $apiUrl . rawurlencode($letra);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,$url);
    $result=curl_exec($ch);
    curl_close($ch);

    $removerInicio = strlen('LetrasSug(');
    $removerFim = strlen($result) -$removerInicio -2;
    $arrayResp = json_decode(substr($result, $removerInicio, $removerFim), true);

    if($arrayResp['response']['numFound'] > 0) {
        return $arrayResp['response']['docs'][0];
    }

    return false;
}

function getSilvioMessage($musica) {

    $mensagem = "Ma ôe haha hihi,";

    $artista = $musica['art'];
    $titulo = $musica['txt'];

    $estilo = explode(',', $musica['g'])[0];

    $comentario = getComentarioSilvio($estilo);

    return "{$mensagem} {$comentario}\nO artista é {$artista} e a músicam {$titulo}";

}

function getComentarioSilvio($estilo) {

    if (strpos($estilo, 'Romântico') !== false) {
        return 'mande pro seu amorm!';
    }
    if (strpos($estilo, 'Alternativo') !== false) {
        return 'música de Hipster chatom!';
    }
    if (strpos($estilo, 'Axé') !== false) {
        return 'ritmom de carnaval!';
    }
    if (strpos($estilo, 'Blues') !== false) {
        return 'vocês estão sofrendom?';
    }
    if (strpos($estilo, 'Bolero') !== false) {
        return 'o ritmo da paixão Maestrom!';
    }
    if (strpos($estilo, 'Bossa Nova') !== false) {
        return 'essa é do meu tempo Maestrom!';
    }
    if (strpos($estilo, 'Brega') !== false) {
        return 'é do Calypsomm? Toca aí Maestrom!';
    }
    if (strpos($estilo, 'Clássico') !== false) {
        return 'essa é das boas, toca ai Maestrom!';
    }
    if (strpos($estilo, 'Country') !== false) {
        return 'só os cowboys de rodeiom!';
    }
    if (strpos($estilo, 'Dance') !== false) {
        return 'é ritmom de festam!';
    }
    if (strpos($estilo, 'Disco') !== false) {
        return 'é ritmom de festam!';
    }
    if (strpos($estilo, 'Eletrônica') !== false) {
        return 'é ritmom de festa com muita droga Maestrom!';
    }
    if (strpos($estilo, 'Emocore') !== false) {
        return 'esconde as navalhas Leminham!';
    }
    if (strpos($estilo, 'Fado') !== false) {
        return 'que saudade de Portugalm';
    }
    if (strpos($estilo, 'Folk') !== false) {
        return 'que diabos é isso Maestrom?';
    }
    if (strpos($estilo, 'Forró') !== false) {
        return 'o ritmom de festa pra dança agarradom!';
    }
    if (strpos($estilo, 'Funk') !== false) {
        return 'desce e sobe a rabam Maestrom!';
    }
    if (strpos($estilo, 'Gospel/Religioso') !== false) {
        return 'essa é pra se arrepender dos pecados Maestrom!';
    }
    if (strpos($estilo, 'Gótico') !== false) {
        return 'essa é pra montar o pentagrama invertidom na salam e chamar o satanás!';
    }
    if (strpos($estilo, 'Grunge') !== false) {
        return 'música de drogado suicída Maestrom!';
    }
    if (strpos($estilo, 'Hard Rock') !== false) {
        return 'essa é bem xexelentam!';
    }
    if (strpos($estilo, 'Hardcore') !== false) {
        return 'essa é pauleram Maestrom!';
    }
    if (strpos($estilo, 'Heavy Metal') !== false) {
        return 'essa música é do demôniom!';
    }
    if (strpos($estilo, 'Hip Hop/Rap') !== false) {
        return 'me traz o boné de aba reta Leminham!';
    }
    if (strpos($estilo, 'House') !== false) {
        return 'essa música é de fritadom, toca ai Maestrom!';
    }
    if (strpos($estilo, 'Indie') !== false) {
        return 'essa música é de Hipster chatom!';
    }
    if (strpos($estilo, 'Infantil') !== false) {
        return 'essa é aquela da Maísa Leminham?';
    }
    if (strpos($estilo, 'J-Pop/J-Rock') !== false) {
        return 'direto do outro lado do planetam';
    }
    if (strpos($estilo, 'Jazz') !== false) {
        return 'aahh essa é das boas';
    }
    if (strpos($estilo, 'Jovem Guarda') !== false) {
        return 'que saudadem!';
    }
    if (strpos($estilo, 'K-Pop/K-Rock') !== false) {
        return 'essa é aquela música dos jovemsm';
    }
    if (strpos($estilo, 'K-Pop/K-Rock') !== false) {
        return 'essa é aquela música dos jovemsm';
    }
    if (strpos($estilo, 'Mariachi') !== false) {
        return 'traz a tequila Leminham!';
    }
    if (strpos($estilo, 'Merengue') !== false) {
        return 'traz a tequila Leminham!';
    }
    if (strpos($estilo, 'MPB') !== false) {
        return 'música boamm!';
    }
    if (strpos($estilo, 'Pagode') !== false) {
        return 'é ritmo de festamm!';
    }
    if (strpos($estilo, 'Pop Rock') !== false) {
        return 'o roque sem sal!';
    }
    if (strpos($estilo, 'Pop') !== false) {
        return 'essa é aquela que fez sucesso Leminham?';
    }
    if (strpos($estilo, 'Post-Rock') !== false) {
        return 'mas que diabo é isso Maestrom?';
    }
    if (strpos($estilo, 'Power-Pop') !== false) {
        return 'mas que diabo é isso Maestrom?';
    }
    if (strpos($estilo, 'Rock Progressivo') !== false) {
        return 'traz o LSD Leminham!';
    }
    if (strpos($estilo, 'Psicodelia') !== false) {
        return 'traz o LSD Leminham!';
    }
    if (strpos($estilo, 'Punk Rock') !== false) {
        return 'essa é aquela que os jovems quebram tudo Leminham?';
    }
    if (strpos($estilo, 'Reggae') !== false) {
        return 'traz o verde Leminham!';
    }
    if (strpos($estilo, 'Reggaeton') !== false) {
        return 'traz o verde Leminham e vamo dançarm!';
    }
    if (strpos($estilo, 'Rock') !== false) {
        return 'é o roquem!';
    }
    if (strpos($estilo, 'Salsa') !== false) {
        return 'dançandom e rodandom!';
    }
    if (strpos($estilo, 'Samba') !== false) {
        return 'é ritmo de carnaval Leminham!';
    }
    if (strpos($estilo, 'Sertanejo') !== false) {
        return 'é de afia o chifre no asfalto Leminham!';
    }
    if (strpos($estilo, 'Velha Guarda') !== false) {
        return 'éssa meu vô escutavam!';
    }

    return 'que música estranha é essa Maestrom?';
}


$ultimoID = loadUltimoId();

//Recursos utilizados
$recursoMentions = '1.1/statuses/mentions_timeline.json';
$recursoTweet = '1.1/statuses/show.json';
$recursoPost = '1.1/statuses/update';
$recursoMedia = '1.1/statuses/media/upload.json?media_category=tweet_image';

//Buscando mentions
$paramMentions = [
    'count' => 200,
    'include_entities' => true,
];

if ($ultimoID > 0) {
    $paramMentions['since_id'] = $ultimoID;
}

$tweets = getContent('GET', $recursoMentions, $paramMentions);

foreach ($tweets as $key => $tweet) {

    if ($key == 0) {
        $ultimoID = $tweet['id_str'];
    }

    $nome = $tweet['user']['name'];

    $tweetMusicaId = $tweet['in_reply_to_status_id_str'];

    //Buscando Tweet da musica
    $tweetMusica = getContent('GET', $recursoTweet, ['id' => $tweetMusicaId]);

    $letra = $tweetMusica['text'];

    $musica = getMusica($letra);

    if ($musica) {
        $mensagem = getSilvioMessage($musica);
        $mensagem .= ' https://www.letras.mus.br/'. $musica['dns']. '/'. $musica['url'];

        getContent('POST', $recursoPost, [
            'status' => $mensagem,
            'in_reply_to_status_id' => $tweet['id_str'],
            'auto_populate_reply_metadata' => true
        ]);

    } else {
        getContent('POST', $recursoPost, [
            'status' => 'Não sabe nada! Vai pra lá, vai pra lá haha hihi!',
            'in_reply_to_status_id' => $tweet['id_str'],
            'auto_populate_reply_metadata' => true
        ]);
    }
}


$file = fopen(ULTIMO_ID, "w");
fwrite($file, $ultimoID);
fclose($file);

