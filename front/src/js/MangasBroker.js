import {BrokerCore} from './BrokerCore.js'

export class MangasBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getAll(queryURL){
            return await this.APICommunicator.getRequest('/mangas'+queryURL);
    }

}
