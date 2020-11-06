import {BrokerCore} from './BrokerCore.js'

export class UsersBroker extends BrokerCore {
    constructor(){
        super();
    }

    async login(datas){
        return await(this.APICommunicator.postRequest('/users/authentication',datas));
    }

    async signUp(datas){
        return await this.APICommunicator.postRequest('/users/creation',datas);

    }

    async isAdmin(data) {
        return await this.APICommunicator.postRequest('/users/admin', data);
    }

    async get(token) {
        return await this.APICommunicator.getRequest('/users/', token);
    }

}
