<template lang="html">
<div class="cart">
    <table v-if="this.items">
        <thead>
            <tr>
                <th>Image</th>
                <th>Série</th>
                <th>Volume</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item of items" :key="item.id">
                <td><img :src="getImgPath(item.image)" :alt="`Couverture de ${item.title}`"></td>
                <td>{{ item.serie }}</td>
                <td>{{ item.volume }}</td>
                <td>{{ item.quantity }}</td>
                <td>{{ item.price }}€</td>
                <td>{{ item.total }}€</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>Prix total:</td>
                <td>{{total}}€</td>
            </tr>
        </tfoot>
    </table>
    <p v-else>
        Votre panier est vide.
    </p>
    <section>
        <div v-if="isAuthenticated">
            <Button @click="order">
                Valider la commande
            </Button>
        </div>
        <p v-else>
            Veuillez-vous connecter pour valider votre commande.
        </p>
    </section>
</div>
</template>

<script>
import { mapGetters } from "vuex";
import  {MangasBroker} from '@/js/MangasBroker.js';
import  {OrdersBroker} from '@/js/OrdersBroker.js';
import Button from '@/components/Button.vue';

export default {
    data: function() {
        return {
            items: [],
            total: Number
        }
    },
    components: {
        Button
    },
    methods: {
        getImgPath(image) {
            try {
                return require('../media/covers/'+image);
            } catch {
                return require('../media/covers/empty.jpg');
            }
        },
        order() {
            let orders = new OrdersBroker();
            let items = Object.values(this.$store.getters.items);
            Promise.resolve(orders.order(items))
        },
        ...mapGetters(["isAuthenticated"])
    },
    mounted() {
        let items = this.$store.getters.items;
        if(items){
            let total = 0;
            let url="?id=";
            url+=Object.keys(items).join('&id=');
            let mangas = new MangasBroker();

            Promise.resolve(mangas.getAll(url))
            .then( (response) => {
                this.items = response.data;
                for (let item of Object.values(this.items)){
                    item.quantity = items[item.id].quantity
                    item.total = (parseFloat(item.price) * parseInt(item.quantity)).toFixed(2);
                    total+=parseFloat(item.total)
                }
                this.total = total.toFixed(2);
            })
            .catch ((e) => {
                console.log(e);
            });

        }
    }
}
</script>

<style lang="scss" scoped>
img {
    max-width:100px;
}

</style>
