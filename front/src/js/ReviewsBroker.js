import {BrokerCore} from './BrokerCore.js'

export class ReviewsBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getByUser(queryURL, token){
        return await this.APICommunicator.getRequest('/users/series/'+queryURL+'/reviews',token);
    }

}
