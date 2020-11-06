import {BrokerCore} from './BrokerCore.js'

export class SeriesBroker extends BrokerCore {
    constructor(){
        super();
    }

    async getAll(queryURL){
        return await this.APICommunicator.getRequest('/series'+queryURL);
    }

    async getAdmin(){
        return await this.APICommunicator.getRequest('/admin/series');
    }

    async create(formDatas){
        return await this.APICommunicator.postRequest('/series',formDatas);
    }

    async createManga(id,datas){
        return await this.APICommunicator.postRequest('/series/'+id+'/mangas',datas);
    }

    async modifyManga(id, idManga, datas) {
        return await this.APICommunicator.putRequest('/series/' + id + '/mangas/' + idManga,datas);
    }

    async delete(id, token) {
        return await this.APICommunicator.deleteRequest('/series/'+id, token)
    }

    async createRating(id,datas) {
        return await this.APICommunicator.postRequest('/series/'+id+'/reviews',datas)
    }

    async modifyRating(id,datas) {
        return await this.APICommunicator.putRequest('/series/'+id+'/ratings',datas)
    }

    async modifyReview(id,datas) {
        return await this.APICommunicator.putRequest('/series/'+id+'/reviews',datas)
    }

    async createCategories(id, datas) {
        return await this.APICommunicator.postRequest('/series/'+id+'/categories', datas)
    }


    async createAuthor(id, datas) {
        return await this.APICommunicator.postRequest('/series/'+id+'/authors', datas)
    }

    async deleteCategory(id, datas) {
        return await this.APICommunicator.deleteRequest('/series/'+id+'/categories',datas)
    }

    async deleteAuthor(id,idAuthor, datas) {
        return await this.APICommunicator.deleteRequest('/series/'+id+'/authors/'+idAuthor,datas)
    }

    getById(id){
        return this.APICommunicator.getRequest('/series/'+id+'/');
    }
}
