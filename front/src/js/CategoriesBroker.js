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

    async create(data){
        return await this.APICommunicator.postRequest('/categories',data);
    }

    async modify(id, data) {
        return await this.APICommunicator.putRequest('/categories/'+id, data)
    }

    async delete(id) {
        return await this.APICommunicator.deleteRequest('/categories/'+id)
    }
}
