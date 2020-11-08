<template lang="html">
<div>
    <h1>Commande n°{{order.id}}</h1>

    <Notice type="error" v-if="errorMessage">
        <p>{{errorMessage}}</p>
    </Notice>

    <h2>Détail de la commande</h2>
    <p>Prix total de la commande: {{ order.total_order_price }}€</p>
    <p>Date de commande: {{order.order_date}}</p>
    <ul>
        <li class="order-item" v-for="item in order.items" :key="item.id">
            <img :src="getImgPath(item.image)" :alt="`Couverture de ${item.serie}`">
            <p>{{ item.serie }}</p>
            <p> Volume {{ item.volume }} </p>
            <p>{{ item.quantity }} manga commandé</p>
            <p>{{ item.price }}€ unité</p>
        </li>
    </ul>
    <section>
        <p>Status de la commande: {{order.status}}</p>
        <label for="status">Statut de la commande</label>
        <select id="status" v-model="status">
            <option value="In process">In process</option>
            <option value="Shipped">Shipped</option>
            <option value="Cancelled">Cancelled</option>
            <option value="Delivered">Delivered</option>
        </select>
        <Button @click="modifyStatus">Modifier le statut</Button>
    </section>


</div>
</template>

<script>
import  {OrdersBroker} from '@/js/OrdersBroker.js';


import Button from '@/components/Button.vue';
import Notice from '@/components/Notice.vue';

export default {
    data: function() {
        return {
            order: {},
            status: "In process",
            errorMessage: ""
        }
    },
    components: {
        Button,
        Notice
    },
    methods: {
        getImgPath(image) {
            try {
                return require('@/media/covers/'+image);
            } catch {
                return require('@/media/covers/empty.jpg');
            }
        },
        modifyStatus() {
            let orders = new OrdersBroker();

            Promise.resolve(orders.putStatus(this.$route.params.id, {status: this.status, token: this.$store.getters.token}))
            .then( () => {
                //update the value on success
                this.order.status = this.status;
            });
        }
    },
    beforeCreate() {
        this.$store.dispatch('isAdmin')
        .catch (() => {
            this.$router.push('/');
        })
    },
    mounted() {
        let orders = new OrdersBroker();
        Promise.resolve(orders.getById(this.$route.params.id))
        .then( (response) => {
            this.order=response.data;
        })
        .catch ((e) => {
            if(e.response.data.errorMessage) {
                this.errorMessage = e.response.data.errorMessage
            }
        });
    }
}
</script>

<style lang="scss" scoped>
.order-item {
    overflow:hidden; //so it doesn't break with the images

    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 2px solid $primary-color;


    img {
        float:left;
        max-width:150px;
        height: auto;
        margin-right: 10px;
    }
}

input:not([type='checkbox']), select {
    @include input-field;

    margin-bottom: 10px;
}

section {
    border-bottom: 2px solid $primary-color;
    padding-bottom: 20px;
    overflow:hidden;
}

img {
    max-width: 80%;
    height:300px;
}

.fas {
    @include red-icon
}

article {
    margin-bottom: 50px;
}

@include tablet {
    .order-item img {
        max-width: 250px;
    }
}
</style>
