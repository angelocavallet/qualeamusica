const got = require('got');

class Musica {

    url = 'https://studiosolsolr-a.akamaihd.net/letras/m1/?callback=LetrasSug&q=';

    constructor(letra){
        this.letra = letra;
        this.data = null;
    }

    async load() {
        try {
            const response = await got(this.url + encodeURIComponent(this.letra));

            let removeInicio = 'LetrasSug('.length;
            let removeFim = response.body.length -2;
            let resp = JSON.parse(response.body.substring(removeInicio, removeFim));

            if(resp.response.numFound > 0) {
                this.data = resp.response.docs[0];
            }

        } catch (error) {
            console.log(error);
        }
    }

}
module.exports = Musica;