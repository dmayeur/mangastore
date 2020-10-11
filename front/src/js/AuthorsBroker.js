import {BrokerCore} from './BrokerCore.js'

export class AuthorsBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getAll(){
        return await this.APICommunicator.getRequest('/authors')
    }
}
