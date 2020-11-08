<template lang="html">
<div>
    <h1>{{serie.title}}</h1>
    <p>Nombre de volumes: {{serie.nbVolumes}}</p>

    <Notice type="error" v-if="errorMessage">
        <p>{{errorMessage}}</p>
    </Notice>

    <section class="serie-mangas-add">
        <h2>Ajouter un volume</h2>
        <form method="post" enctype="multipart/form-data">
            <p>Volume n°{{ mangaToAdd.volume }} à ajouter</p>
            <div class="input-item">
                <label for="release-date">Date de sortie: </label>
                <input type="date" id="release-date" v-model="mangaToAdd.releaseDate">
            </div>
            <div class="input-item">

            </div>
            <div class="input-item">
                <label for="stock">Stock: </label>
                <input type="number" id="stock" v-model="mangaToAdd.stock">
            </div>
            <div class="input-item">
                <label for="cover">Couverture du tome: </label>
                <input type="file" id="cover" @change="processFile($event)">
            </div>

            <Button @click.prevent="addManga">Ajouter le volume</Button>
        </form>
    </section>

    <section class="serie-mangas-modify">
        <h2>Modifier un volume</h2>
        <article v-for="(manga, index) in serie.mangas" :key="manga.id">
            <img :src="getImgPath(manga.image)" :alt="`Couverture de ${manga.title}`">
            <p>Volume {{manga.volume}}</p>
            <div class="input-item">
                <label for="cover">Couverture du manga:</label>
                <input type="file" name="cover" @change="processFileModify($event, index)">
            </div>
            <div class="input-item">
                <label for="releaseDate">Date de sortie</label>
                <input type="date" name="releaseDate" v-model="manga.release_date">
            </div>
            <div class="input-item">
                <label for="stock">Stock:</label>
                <input type="number" name="stock" v-model="manga.stock">
            </div>
            <Button @click="modifyManga(manga, index)">
                Editer le volume
            </Button>
        </article>
    </section>


    <section class="serie-categories">
        <h2>Catégories actuelles: </h2>
        <ul>
            <li v-for="(category, index) in serie.categories" :key="category.id">
                {{category.name}} <i class="fas fa-trash" @click="deleteCategory(index)"></i>
            </li>
        </ul>
    </section>

    <section class="serie-categories-add">
        <h2>Catégories à ajouter:</h2>
        <ul>
            <li v-for="category in categories" :key="category.id" class="catalog-search--item">
                <h3>{{category.name}}</h3>
                <ul>
                    <li v-for="childCategory in category.childs" :key="childCategory.id">
                        <input class="category" type="checkbox" :name="`${childCategory.name}`" :value="`${childCategory.id}`" v-model="categoriesChecked" :id="`${childCategory.name}`">
                        <label :for="`${childCategory.name}`">{{childCategory.name}}</label>
                    </li>
                </ul>
            </li>
        </ul>
        <Button @click="addCategories">
            Ajouter les catégories
        </Button>
    </section>

    <section class="serie-authors">
        <h2>Auteurs actuels: </h2>
        <ul>
            <li v-for="(author, index) in serie.authors" :key="author.id">
                {{author.name}} <i class="fas fa-trash" @click="deleteAuthor(index)"></i>
            </li>
        </ul>
    </section>

    <section class="serie-authors-add">
        <h2>Ajouter un auteur</h2>
        <div class="input-item">
            <label for="author">Auteur: </label>
            <select name="author" id="author" v-model="author">
                <option v-for="author in authors" :key="author.id" :value="`${author.id}`">{{ author.name }}</option>
            </select>
            <Button @click="addAuthor">
                Ajouter l'auteur
            </Button>
        </div>
    </section>
</div>
</template>

<script>
import  {SeriesBroker} from '@/js/SeriesBroker.js';
import  {CategoriesBroker} from '@/js/CategoriesBroker.js';
import  {AuthorsBroker} from '@/js/AuthorsBroker.js';

import Button from '@/components/Button.vue';
import Notice from '@/components/Notice.vue';

export default {
    data: function() {
        return {
            serie: {},
            mangaToAdd: {},
            mangaToAddModify: {},
            mangaToAddModifyCover: {},
            categories: {},
            categoriesChecked: [],
            authors: {},
            author: "",
            errorMessage: ""
        }
    },
    components: {
        Button,
        Notice
    },
    methods: {
        processFile(event) {
            this.mangaToAdd.cover = event.target.files[0]
        },
        processFileModify(event, index) {
            this.mangaToAddModifyCover[index] = event.target.files[0]
        },
        addManga() {
            let series = new SeriesBroker();
            Promise.resolve(series.createManga(this.$route.params.id,{...this.mangaToAdd, token: this.$store.getters.token}))
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        },
        modifyManga(manga, index) {
            let series = new SeriesBroker();

            let data = {
                ...manga,
                cover: this.mangaToAddModifyCover[index],
                token: this.$store.getters.token
            }

            Promise.resolve(series.modifyManga(this.$route.params.id, manga.id, data))
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });

        },
        getImgPath(image) {
            try {
                return require('@/media/covers/'+image);
            } catch {
                return require('@/media/covers/empty.jpg');
            }
        },
        deleteCategory(index) {
            let series = new SeriesBroker();
            Promise.resolve(series.deleteCategory(this.$route.params.id, {category: this.serie.categories[index].id, token: this.$store.getters.token}))
            .then( () => {
                delete this.serie.categories[index]
            })
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        },
        addCategories() {
            let datas = {
                categories: this.categoriesChecked,
                token: this.$store.getters.token
            }

            let series = new SeriesBroker();
            Promise.resolve(series.createCategories(this.$route.params.id, datas))
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        },
        deleteAuthor(index) {
            let series = new SeriesBroker();
            Promise.resolve(series.deleteAuthor(this.$route.params.id, this.serie.authors[index].id,{ token: this.$store.getters.token }))
            .then( () => {
                delete this.serie.authors[index]
            })
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        },
        addAuthor() {
            let datas = {
                author: this.author,
                token: this.$store.getters.token
            }

            let series = new SeriesBroker();
            Promise.resolve(series.createAuthor(this.$route.params.id, datas)).then( () => {
                this.$forceUpdate();
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
    mounted() {
        let series = new SeriesBroker();
        Promise.resolve(series.getById(this.$route.params.id))
        .then( (response) => {
            this.serie=response.data;
            this.mangaToAdd.volume=parseInt(this.serie.nbVolumes)+1;
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

        let authors = new AuthorsBroker();
        Promise.resolve(authors.getAll())
        .then( (response) => {
            this.authors=response.data;
            this.author = response.data[0].id;
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

input {
    margin-bottom: 10px;
}

@include tablet {
    img{
        float:left;
        margin-right: 20px;
    }
}
</style>
