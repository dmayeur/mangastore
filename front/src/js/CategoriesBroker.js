import {BrokerCore} from './BrokerCore.js'

export class CategoriesBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getAll(){
        return await this.APICommunicator.getRequest('/categories');
    }

    async getById(id){
        return await this.APICommunicator.getRequest('/categories/'+id);
    }

    async getAdmin(){
        return await this.APICommunicator.getRequest('/admin/categories');
    }

    async create(){
        return await this.APICommunicator.postRequest('/categories');
    }

}
