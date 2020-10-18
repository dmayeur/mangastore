import {BrokerCore} from './BrokerCore.js'

export class AuthorsBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getAll() {
        return await this.APICommunicator.getRequest('/authors')
    }

    async getById(id) {
        return await this.APICommunicator.getRequest('/authors/'+id);
    }

    async create(datas) {
        return await this.APICommunicator.postRequest('/authors',datas)
    }

    async modify(id,objectData) {
        return await this.APICommunicator.putRequest('/authors/'+id,objectData)
    }

    async delete(id) {
        return await this.APICommunicator.deleteRequest('/authors/'+id)
    }
}
