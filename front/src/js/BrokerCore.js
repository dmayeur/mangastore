import { APICommunicator } from './APICommunicator.js';

export class BrokerCore {
    constructor() {
        this.APICommunicator = new APICommunicator();
    }
}
