import {BrokerCore} from './BrokerCore.js'

export class ReviewsBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getByUser(queryURL, token){
        return await this.APICommunicator.getRequest('/users/series/'+queryURL+'/reviews',token);
    }

    async getAll(idSerie) {
        return await this.APICommunicator.getRequest('/series/'+idSerie+'/reviews');
    }

    async getAllAdmin() {
        return await this.APICommunicator.getRequest('/reviews');
    }

    async removeReview(id, data) {
        return await this.APICommunicator.deleteRequest('/admin/reviews/'+id, data);
    }
}
