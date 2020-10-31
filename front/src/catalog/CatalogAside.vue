<template lang="html">
<aside class="catalog-search">
    <!-- wrapper only to not break scrolling on mobile -->
    <div class="catalog-search-wrapper">
        <button type="button" class="btn-close mobileOnly" @click="closeAside">
            <i class="far fa-times-circle"></i>
        </button>
        <form class="catalog-search--form" method="GET" @submit.prevent>
            <transition
                name="fade-in-down"
                enter-active-class="animated fadeInDown"
                leave-active-class="animated fadeOutUp"
            >
                <div class="searchProposition" v-if="search">

                </div>
            </transition>

            <div class="catalog-search--header">
                Trier par
            </div>

            <ul>
                <li>
                    <input type="radio" id="alphabetical" name="sort" value="alphabetical" v-model="sortBy" @change="onInputChange">
                    <label for="alphabetical">Ordre alphabétique</label>
                </li>
                <li>
                    <input type="radio" id="release-date" name="sort" value="date" v-model="sortBy" @change="onInputChange">
                    <label for="release-date">Date de sortie</label>
                </li>
                <li>
                    <input type="radio" id="rating" name="sort" value="rating" v-model="sortBy" @change="onInputChange">
                    <label for="rating">Note moyenne</label>
                </li>
            </ul>

            <div v-for="category in categories" :key="category.id" class="catalog-search--item" @change="onInputChange">
                <div class="catalog-search--header">
                    {{category.name}}
                </div>
                <ul>
                    <li v-for="childCategory in category.childs" :key="childCategory.id">
                        <input class="category" type="checkbox" :name="`${childCategory.id}`" :value="`${childCategory.name}`" v-model="categoriesChecked" :id="`${childCategory.name}`">
                        <label :for="`${childCategory.name}`">{{childCategory.name}}</label>
                    </li>
                </ul>
            </div>

            <div class="catalog-search--item" @change="onInputChange">
                <div class="catalog-search--header">
                    Editeur
                </div>
                <ul>
                    <li v-for="editor in editors" :key="editor.id">
                        <input class='editor' type="checkbox" :name="`${editor.name}`" :value="`${editor.name}`" v-model="editorsChecked" :id="`${editor.name}`">
                        <label :for="`${editor.name}`">{{editor.name}}</label>
                    </li>
                </ul>
            </div>
        </form>
    </div>
</aside>

</template>

<script>

import  {EditorsBroker} from '@/js/EditorsBroker.js';
import  {CategoriesBroker} from '@/js/CategoriesBroker.js';


export default {
    data: function () {
        return {
            editors: [],
            editorsChecked: [],
            categories: [],
            categoriesChecked: [],
            sortBy: "alphabetical",
            // search: "",
            queryURL: "",
            loadingMangas: false
        }
    },
    props: {
        search: String
    },
    watch: {
        search: function(){
            this.onInputChange();
        }
    },
    methods: {
        onInputChange: function(){
            this.queryURL="?";
            if(this.search){
                this.queryURL += "search="+this.search+"&";
            }
            this.queryURL += "sort=" + this.sortBy+"&";

            if(this.categoriesChecked.length){
                for (let category of this.categoriesChecked){
                    this.queryURL +='category='+category+'&';
                }
            }
            if(this.editorsChecked.length){
                for (let editor of this.editorsChecked){
                    this.queryURL +='editor='+editor+'&';
                }
            }

            //empty string if no request, delete the trailing & otherwise
            this.queryURL = this.queryURL.slice(0, -1);
            this.$emit('form-change',this.queryURL);
        },
        updateMangas(response) {
            this.loadingMangas = false;
            this.mangas = response.data;
        },
        updateEditors(response) {
            this.editors = response.data;
        },
        updateCategories(response) {
            this.categories = response.data;
        },
        closeAside(){
            this.$emit('close-aside')
        }
    },
    mounted(){
        let editors = new EditorsBroker();
        Promise.resolve(editors.getAll())
        .then( (response) => {
            this.editors = response.data;
        })
        .catch (() => {
            this.editors = [];
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

//Make the menu scrollable on mobile
.catalog-search-wrapper {
    max-height: calc(100vh - 20px);
    overflow-y: auto;
}

//hiding the menu
aside {
    width: 100%;
    text-align: left;
    padding:20px;
    position:fixed;
    top:0;
    left:-750px;

    overflow-y: auto;
    transition: transform 1s;
    z-index:3;
    background-color: $secondary-color;

    ul {
        padding: 5px 20px;
        border: 1px solid black;
        border-top: none;
    }
}

.btn-close {
    position: relative;
    left:80%;
    padding: 20px;

    color:$primary-color;
    border: none;
    font-size: 20px;

    cursor: pointer;
    font-weight: bold;
    background: transparent;
}


.catalog-search--item {
    li label {
        padding-left:5px;
    }

    li:not(:last-child) {
        margin-bottom:0.8rem;
    }
}


.catalog-search--header {

    border: 1px solid #000;
    padding: 5px 20px;
    margin-top:20px;

    color: $primary-color-text;
    background-color: $primary-color;

}

/* ===================================================
                DESKTOPS - 992 PX AND UP
================================================== */
@media screen and (min-width: 992px) {
    aside {
        margin-left:20px;
    }

}
</style>
