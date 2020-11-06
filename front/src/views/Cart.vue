<template lang="html">
<div class="cart">
    <div v-if="Object.keys(items).length">
        <div class="cart-item" v-for="(item, index) of items" :key="item.id">
            <img :src="getImgPath(item.image)" :alt="`Couverture de ${item.title}`">
            <p>{{ item.serie }} vol {{ item.volume }}</p>
            <p>{{ item.total }}€</p>
            <p><input type="number" v-model=item.quantity @change="quantityChange(index)"><i class="fas fa-trash" @click="deleteItem(index)"></i></p>

        </div>

        <section class="order-address" v-if="isAuthenticated">
            <h2>Informations de livraison:</h2>
            <div class="form-input">
                <label for="firstname">Prénom: </label>
                <input type="text" name="firstname" id="firstname" v-model="user.firstname">
            </div>

            <div class="form-input">
                <label for="lastname">Nom de famille: </label>
                <input type="text" name="lastname" id="lastname" v-model="user.lastname">
            </div>

            <div class="form-input">
                <label for="address">Addresse:  </label>
                <input type="text" name="address" id="address" v-model="user.address">
            </div>

            <div class="form-input">
                <label for="city">Ville: </label>
                <input type="text" name="city" id="city" v-model="user.city">
            </div>

            <div class="form-input">
                <label for="zipcode">Code postal: </label>
                <input type="text" name="zipcode" id="zipcode" v-model="user.zip_code">
            </div>
            <div class="form-input">
                <label for="country">Pays: </label>
                <input type="text" name="country" id="country" v-model="user.country">
            </div>
            <Button @click="order">
                Valider la commande
            </Button>
        </section>
        <p v-else>
            Veuillez-vous connecter pour valider votre commande.
        </p>
    </div>

    <p v-else>
        Votre panier est vide.
    </p>

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
            total: Number,
            user: {}
        }
    },
    components: {
        Button
    },
    computed: {
        ...mapGetters(["isAuthenticated", "cartPrice"])
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

            let data  = {
                ...this.user,
                items: items,
                token: this.$store.getters.token
            };

            Promise.resolve(orders.order(data))
            .then( () => {
                // emptying the cart
                this.$store.dispatch('deleteAllItems');
                this.items = {};
            });
        },
        quantityChange(index) {
            this.$store.dispatch('changeQuantity',this.items[index]).then( () => {
                if(this.items[index].quantity <= 0) { //delete if there's no item left
                    delete this.items[index]
                } else { // or update price otherwise
                    this.items[index].total = (this.items[index].price * this.items[index].quantity).toFixed(2);
                }
            });

        },
        deleteItem(index) {
            // we setup the quantity to 0 because that's how the store delete it
            this.items[index].quantity = 0;

            //ask the store to delete the item
            this.$store.dispatch('changeQuantity',this.items[index]).then( () => {
                //reflect the change on the page
                delete this.items[index];
            });


        },
        updateUser() {
            this.$store.dispatch('getUser')
            .then( (response) => {
                this.user = response.data
            });
        }
    },
    watch: {
        //automatically load the user infos on login
        isAuthenticated: function(val) {
            if(val) { //if it's a log in not a logout
                this.updateUser();
            }
        }
    },
    created() {
        //initializing the cart items
        let items = this.$store.getters.items;

        if(Object.keys(items).length){
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
        }

        //initializing the user
        this.updateUser();
    }
}
</script>

<style lang="scss" scoped>
.order-address input {
    @include input-field;
    margin-bottom: 10px;
}

.cart-item {
    overflow:hidden; //so it doesn't break with the images

    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 2px solid $primary-color;


    img {
        float:left;
        max-width:100px;
        margin-right: 10px;
    }

    input {
        @include input-field;
        display: inline-block;
        margin-right: 10px;
        width: 20%;
    }

    .fas {
        @include red-icon;
    }
}

</style>
