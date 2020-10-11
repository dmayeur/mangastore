import axios from 'axios'

export class APICommunicator {
    constructor(){
        this.urlApi = '/api'
    }

    async getRequest(url){
        return await axios.get(this.urlApi+url);
    }

    async postRequest(url,formDatas){
        return await axios.post(this.urlApi+url,formDatas
        );
    }


}
