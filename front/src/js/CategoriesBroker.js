import {BrokerCore} from './BrokerCore.js'

export class CategoriesBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getAll(){
        return await this.APICommunicator.getRequest('/categories');
    }

}
