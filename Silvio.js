const SilvioComentario = require('./SilvioComentario');

class Silvio {

    getComentario(musica) {

        if (!musica) {
            return 'Não sabe nada! Vai pra lá, vai pra lá haha hihi!';
        }

        let artista = musica.art;
        let titulo = musica.txt;
        let estilo = musica.g.split(',')[0];

        let mensagem = null;

        SilvioComentario.comentarios.forEach(comentario => {
            if (estilo.includes(comentario.estilo)) {
                mensagem = `Ma ôe haha hihi, ${comentario.comentario}`;
           }
        });

        let link = `https://www.letras.mus.br/${musica.dns}/${musica.url}`;

        if (!mensagem) {
            mensagem = 'Que música estranha é essa Maestrom?';
        }

        return `${mensagem}
O artista é ${artista} e a músicam ${titulo} ${link}`;
    }
}
module.exports = Silvio;