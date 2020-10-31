import {BrokerCore} from './BrokerCore.js'

/**
 * EditorsBroker class handle the API requests directed to editors
 * Does not handle API request directly
 */
export class EditorsBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getAll(){
        return await this.APICommunicator.getRequest('/editors');
    }

    async getById(editor){
        return await this.APICommunicator.getRequest('/editors/'+editor);
    }

    async getPrices(editor){
        return await this.APICommunicator.getRequest('/editors/'+editor+'/prices');

    }

    async createPrice(id, data) {
        return await this.APICommunicator.postRequest('/editors/'+ id + '/prices', data);
    }

    async modify(id, data) {
        return await this.APICommunicator.putRequest('/editors/'+id, data)
    }

    async create(data) {
        return await this.APICommunicator.postRequest('/editors', data)
    }
}
