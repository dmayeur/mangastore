import {BrokerCore} from './BrokerCore.js'

export class OrdersBroker extends BrokerCore {
    constructor(){
        super();
    }

    async order(data){
        let items = JSON.stringify(data);
        return await this.APICommunicator.postRequestJSON('/orders',items);
    }

}
