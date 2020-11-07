import {BrokerCore} from './BrokerCore.js'

export class OrdersBroker extends BrokerCore {
    constructor(){
        super();
    }

    async order(data){
        let items = JSON.stringify(data);
        return await this.APICommunicator.postRequestJSON('/orders',items);
    }

    async getAll(){
        return await this.APICommunicator.getRequest('/orders');
    }

    async getById(id){
        return await this.APICommunicator.getRequest('/orders/'+id);
    }

    async putStatus(id, data){
        return await this.APICommunicator.putRequest('/orders/'+id, data);
    }

    async delete(id, token){
        return await this.APICommunicator.deleteRequest('/orders/'+id, token);
    }
}
