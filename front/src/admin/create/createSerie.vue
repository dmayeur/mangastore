<template lang="html">
<div>
    <form method="post" @submit.prevent="onSubmit">
        <div class="input-item">
            <label for="serie-name">Nom de la série: </label>
            <input type="text" name="serie-name" id="serie-name" v-model="serieName">
        </div>
        <div class="input-item">
            <label for="editor">Editeur: </label>
            <select name="editor" id="editor" v-model="editor">
                <option v-for="editor in editors" :key="editor.id" :value="`${editor.id}`">{{ editor.name }}</option>
            </select>
        </div>
        <div class="input-item">
            <label for="price">Prix: </label>
            <select name="price" id="price" v-model="price">
                <option v-for="price in prices" :key="price.code" :value="`${price.price_code}`">{{ price.price_code }} - {{ price.price }}€</option>
            </select>
        </div>
        <ul>
            <li v-for="category in categories" :key="category.id" class="catalog-search--item">
                {{category.name}}
                <ul>
                    <li v-for="childCategory in category.childs" :key="childCategory.id">
                        <input class="category" type="checkbox" :name="`${childCategory.name}`" :value="`${childCategory.id}`" v-model="categoriesChecked" :id="`${childCategory.name}`">
                        <label :for="`${childCategory.name}`">{{childCategory.name}}</label>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="input-item">
            <label for="author-number">Nombre d'auteurs: </label>
            <select class="author-number" id="author-number" v-model="authorsNumber">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>

        <div class="input-item">
            <label for="author">Auteur: </label>
            <select name="author" id="author" v-model="author">
                <option v-for="author in authors" :key="author.id" :value="`${author.id}`">{{ author.name }}</option>
            </select>
        </div>

        <div class="input-item" v-if="authorsNumber==2">
            <label for="author2">Auteur n°2: </label>
            <select name="author2" id="author2" v-model="author2">
                <option v-for="author in authors" :key="author.id" :value="`${author.id}`">{{ author.name }}</option>
            </select>
        </div>
        <Button type="submit">
            Créer la série
        </Button>
    </form>
</div>
</template>

<script>
import  {EditorsBroker} from '@/js/EditorsBroker.js';
import  {CategoriesBroker} from '@/js/CategoriesBroker.js';
import  {AuthorsBroker} from '@/js/AuthorsBroker.js';
import  {SeriesBroker} from '@/js/SeriesBroker.js';
import Button from '@/components/Button.vue'

export default {
    data: function () {
        return {
            serieName: "",
            editors: [],
            editor: 1,
            categories: [],
            prices: [],
            price: "",
            categoriesChecked: [],
            authors: [],
            author: 1,
            author2: 1,
            authorsNumber: 1,
            mangaNumber: 1
        }
    },
    components: {
        Button
    },
    methods: {
        updateEditors(response) {
            this.editors = response.data;
            this.editor = this.editors[0].id;
        },
        updatePrices(response) {
            this.prices = response.data;
            this.price = this.prices[0].price_code;
        },
        updateCategories(response) {
            this.categories = response.data;
        },
        updateAuthors(response) {
            this.authors = response.data;
            this.author = response.data[0].id;
            this.author2 = response.data[0].id;
        },
        onSubmit() {
            let authors = [];
            authors.push(this.author);
            if (this.authorsNumber==2){
                authors.push(this.author2);
            }

            let datas = {
                name: this.serieName,
                editor: this.editor,
                categories: this.categoriesChecked,
                authors: authors,
                price: this.price,
                token: this.$store.getters.token
            }

            let series = new SeriesBroker();
            Promise.resolve(series.create(datas)).then( (response) => {
                //redirect to the newly created serie where you can add volumes
                this.$router.push('/admin/series/'+response.data.id);
            })
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        }
    },
    watch: {
        editor: function (editor){
            let editors = new EditorsBroker();
            Promise.resolve(editors.getPrices(editor,this.updatePrices))
            .then( (response) => {
                this.updatePrices(response);
            })
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
    mounted(){
        let editors = new EditorsBroker();
        Promise.resolve(editors.getAll())
        .then( (response) => {
            this.editors = response.data;
        })
        .catch ((e) => {
            if(e.response.data.errorMessage) {
                this.errorMessage = e.response.data.errorMessage
            }
        });
        Promise.resolve(editors.getPrices(this.editor,this.updatePrices))
        .then( (response) => {
            this.updatePrices(response);
        })
        .catch ((e) => {
            if(e.response.data.errorMessage) {
                this.errorMessage = e.response.data.errorMessage
            }
        });

        let authors = new AuthorsBroker();
        Promise.resolve(authors.getAll())
        .then( (response) => {
            this.authors=response.data;
        })
        .catch ((e) => {
            if(e.response.data.errorMessage) {
                this.errorMessage = e.response.data.errorMessage
            }
        });

        let categories = new CategoriesBroker();
        Promise.resolve(categories.getAll())
        .then( (response) => {
            this.categories = response.data;
        })
        .catch (() => {
            this.categories = [];
        });
    }
}
</script>

<style lang="scss" scoped>
input:not([type='checkbox']), select {
    @include input-field;

    margin-bottom: 10px;
}

li > ul {
    padding-left: 20px;
}
</style>
