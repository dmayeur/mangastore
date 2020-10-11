import {BrokerCore} from './BrokerCore.js'

export class SeriesBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getAll(queryURL){
            return await this.APICommunicator.getRequest('/series'+queryURL);
            // Promise.resolve(this.APICommunicator.getRequest('/series'+queryURL))
            // .then( (response) => {
            //     callback(response);
            // })
            // .catch (() => {
            //     // callback(e.response)
            // });
    }

    async getAdmin(){
            return await this.APICommunicator.getRequest('/admin/series');
    }

    getById(id){
        return this.APICommunicator.getRequest('/series/'+id+'/');
    }
}
