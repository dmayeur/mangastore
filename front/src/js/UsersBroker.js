import {BrokerCore} from './BrokerCore.js'

export class UsersBroker extends BrokerCore {
    constructor(){
        super();
    }

    async login(formDatas){
        return await(this.APICommunicator.postRequest('/users/authentication',formDatas));
            // Promise.resolve(this.APICommunicator.postRequest('/users/login',formDatas))
            // .then( (response) => {
            //     callback(response);
            // })
            // .catch (() => {
            //     callback(false)
            // });
    }

    signUp(formDatas,callback){
        Promise.resolve(this.APICommunicator.postRequest('/users/creation',formDatas))
        .then( (response) => {
            callback(response);
        })
        .catch ((e) => {
            // console.log(e.response.data.errorMessage);
            callback(e.response.data);
        });
    }
    getById(id){
        return this.APICommunicator.getRequest('/series/'+id+'/');
    }
}
