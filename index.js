const Twit = require('twit');
const Silvio = require('./Silvio')
const Musica = require('./Musica');
const keys = require('./keys.json');

(async () => {

    let T = new Twit(keys);
    let stream = T.stream(
        'statuses/filter',
        {track: '#qualeamusica'}
    );

    let silvio = new Silvio();

    stream.on('tweet', (tweetRequest) => {
        let param = {id: tweetRequest.in_reply_to_status_id_str};

        T.get('statuses/show', param, async (err, tweet, response) => {
            let musica = new Musica(tweet.text);
            await musica.load();

            let comentarioSilvio = silvio.getComentario(musica.data);

            T.post('statuses/update', {
                status: comentarioSilvio,
                in_reply_to_status_id: tweetRequest.id_str,
                auto_populate_reply_metadata: true
            });
        });
    });
})();