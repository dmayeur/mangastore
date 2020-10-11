<template lang="html">
<div>
    <form class="" action="index.html" method="post">
        <div class="input-item">
            <label for="serie-name">Nom de la série: </label>
            <input type="text" name="serie-name" id="serie-name" value="">
        </div>
        <div class="input-item">
            <label for="editor">Editeur: </label>
            <select name="editor" id="editor" v-model="editor">
                <option v-for="editor in editors" :key="editor.id" :value="`${editor.id}`">{{ editor.name }}</option>
            </select>
        </div>
        <div class="input-item">
            <label for="price">Prix: </label>
            <select name="price" id="price">
                <option v-for="price in prices" :key="price.code" :value="`${price.code}`">{{ price.price_code }} - {{ price.price }}€</option>
            </select>
        </div>
        <div class="categories">
            Liste des catégories: {{categoriesChecked}}
        </div>
        <ul>
            <li v-for="category in categories" :key="category.id" class="catalog-search--item">
                {{category.name}}
                <ul>
                    <li v-for="childCategory in category.childs" :key="childCategory.id">
                        <input class="category" type="checkbox" :name="`${childCategory.id}`" :value="`${childCategory.name}`" v-model="categoriesChecked" :id="`${childCategory.name}`">
                        <label :for="`${childCategory.name}`">{{childCategory.name}}</label>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="input-item">
            <label for="author">Auteur: </label>
            <select name="author" id="author">
                <option v-for="author in authors" :key="author.id" :value="`${author.id}`">{{ author.name }}</option>
            </select>
        </div>
    </form>
</div>
</template>

<script>
import  {EditorsBroker} from '@/js/EditorsBroker.js';
import  {CategoriesBroker} from '@/js/CategoriesBroker.js';
import  {AuthorsBroker} from '@/js/AuthorsBroker.js';

export default {
    data: function () {
        return {
            editors: [],
            editor: 1,
            categories: [],
            prices: [],
            categoriesChecked: [],
            authors: []
        }
    },
    methods: {
        updateEditors(response) {
            this.editors = response.data;
        },
        updatePrices(response) {
            this.prices = response.data;
        },
        updateCategories(response) {
            this.categories = response.data;
        },
        updateAuthors(response) {
            this.authors = response.data;
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
li > ul {
    padding-left: 20px;
}
</style>
