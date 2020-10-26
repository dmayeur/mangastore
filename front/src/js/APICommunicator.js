import axios from 'axios'

export class APICommunicator {
    constructor(){
        this.urlApi = '/api'
    }

    async getRequest(url, token = ""){
        return await axios.get(this.urlApi+url, {
            headers: {
                'token': token
            }
        });
    }

    /**
     * [postRequest description]
     * @param  {[type]}  url        [description]
     * @param  {[type]}  objectData [description]
     * @return {Promise}            [description]
     */
    async postRequest(url,objectData){
        //we do the conversion to formdata here so if we ever change the way the app communicates with the back we only change it here
        let formData = new FormData();

        for ( let key in objectData ) {
            if(Array.isArray(objectData[key])){
                formData.append(key+"[]", objectData[key]);
            } else {
                formData.append(key, objectData[key]);
            }
        }
        
        return await axios.post(this.urlApi+url,formData);
    }

    async postRequestJSON(url,objectData){

        return await axios.post(this.urlApi+url,objectData, {
            headers: {
                'Content-Type': 'application/json'
            }
        });
    }

    async deleteRequest(url,objectData = []){

        let formData = new FormData();
        formData.append('method','delete');
        for ( let key in objectData ) {
            if(Array.isArray(objectData[key])){
                formData.append(key+"[]", objectData[key]);
            } else {
                formData.append(key, objectData[key]);
            }
        }
        return await axios.post(this.urlApi+url,formData);
    }

    async putRequest(url,objectData){
        let formData = new FormData();
        for ( let key in objectData ) {
            if(Array.isArray(objectData[key])){
                formData.append(key+"[]", objectData[key]);
            } else {
                formData.append(key, objectData[key]);
            }
        }
        formData.append('method','put');

        return await axios.post(this.urlApi+url,formData);
    }
}
