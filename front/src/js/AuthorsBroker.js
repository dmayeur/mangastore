import {BrokerCore} from './BrokerCore.js'

export class AuthorsBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getAll() {
        return await this.APICommunicator.getRequest('/authors')
    }

    async getById(id) {
        console.log(id);
        return await this.APICommunicator.getRequest('/authors/'+id);
    }

    async create(formDatas) {
        return await this.APICommunicator.postRequest('/authors',formDatas)
    }

    async modify(id,objectData) {
        return await this.APICommunicator.putRequest('/authors/'+id,objectData)
    }

    async delete(id) {
        return await this.APICommunicator.deleteRequest('/authors/'+id)
    }
}
