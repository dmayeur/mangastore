<template lang="html">
<div>
    <h1>Modification de l'éditeur: {{ editorStatic }}</h1>

    <Notice type="error" v-if="errorMessage">
        <p>{{errorMessage}}</p>
    </Notice>

    <section>
        <h2>Editeur:</h2>
        <div class="input-item">
            <label for="editor">Nom de l'éditeur: </label>
            <input type="text" name="editor" id="editor" v-model="editor.name">
        </div>
        <Button @click="changeEditor">
            Modifier l'éditeur
        </Button>
    </section>

    <section>
        <h2>Prix de l'éditeur:</h2>
        <article v-for="(price, index) in editor.prices" :key="price.code">
            <p>Code prix: {{ price.price_code }}</p>
            <div class="input-item">
                <label :for="'price-' + price.price_code">Prix: </label>
                <input type="text" name="price" :id="'price-' + price.price_code" v-model="price.price">
            </div>
            <Button @click="changePrice(index)">Changer le prix</Button>
        </article>
    </section>

    <section>
        <h2>Ajouter un prix</h2>
        <div class="input-item">
            <label for="price-code">Code prix: </label>
            <input type="text" name="price-code" id="price-code" v-model="priceCode">
        </div>
        <div class="input-item">
            <label for="price">Prix: </label>
            <input type="number" name="price" id="price" v-model="price">
        </div>
        <Button @click="addPrice">Ajouter le prix à l'éditeur</Button>
    </section>
</div>
</template>

<script>
import  {EditorsBroker} from '@/js/EditorsBroker.js';

import Button from '@/components/Button.vue'
import Notice from '@/components/Notice.vue';

export default {
    data: function () {
        return {
            editor: "",
            editorStatic: "",
            price: "",
            priceCode: "",
            errorMessage: ""
        }
    },
    components: {
        Button,
        Notice
    },
    methods: {
        changeEditor() {
            let editors = new EditorsBroker();
            Promise.resolve(editors.modify(this.$route.params.id, {editor: this.editor.name, token: this.$store.getters.token}))
            .then ( () => {
                this.$router.go(-1);
            })
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        },
        addPrice() {
            let editors = new EditorsBroker();
            Promise.resolve(editors.createPrice(this.$route.params.id, {price: this.price, priceCode: this.priceCode, token: this.$store.getters.token}))
            .then ( (response) => {
                this.editor.prices.push = response.data;
            })
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        },
        changePrice(index) {
            let editors = new EditorsBroker();
            Promise.resolve(editors.modifyPrice(this.$route.params.id, this.editor.prices[index].price_code, {price: this.editor.prices[index].price, token: this.$store.getters.token}))
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
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
        let editors = new EditorsBroker();
        Promise.resolve(editors.getById(this.$route.params.id)).then( (response) => {
            this.editor = response.data;
            this.editorStatic = response.data.name;
        })
        .catch (() => {
        });
    }
}
</script>

<style lang="scss" scoped>
li > ul {
    padding-left: 20px;
}

section {
    border-bottom: 2px solid $primary-color;
    padding-bottom: 20px;
    overflow:hidden;
}

input {
    @include input-field;

    margin-bottom:10px;
}
</style>
