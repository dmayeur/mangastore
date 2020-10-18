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

    async create(datas) {
        return await this.APICommunicator.postRequest('/editors',datas)
    }
}
