import {BrokerCore} from './BrokerCore.js'

export class UsersBroker extends BrokerCore {
    constructor(){
        super();
    }

    async login(formDatas){
        return await(this.APICommunicator.postRequest('/users/authentication',formDatas));
    }

    async signUp(formDatas){
        return await this.APICommunicator.postRequest('/users/creation',formDatas);

    }

}
