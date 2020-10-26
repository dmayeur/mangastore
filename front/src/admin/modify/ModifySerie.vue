<template lang="html">
<div>
    <h1>{{serie.title}}</h1>
    <p>Nombre de volumes: {{serie.nbVolumes}}</p>

    <section class="mangas-add">
        <h2>Ajouter un volume</h2>
        <form method="post" enctype="multipart/form-data">
            <p>Volume n°{{ mangaToAdd.volume }} à ajouter</p>
            <input type="date" v-model="mangaToAdd.releaseDate">
            <input type="number" v-model="mangaToAdd.stock">
            <input type="file" @change="processFile($event)">

            <Button @click.prevent="addManga">Ajouter le volume</Button>
        </form>
    </section>

    <section class="mangas-modify">
        <h2>Modifier un volume</h2>
        <form method="post" v-for="manga in serie.mangas" :key="manga.id">
            <article>
                <img :src="getImgPath(manga.image)" :alt="`Couverture de ${manga.title}`">
                <p>Volume {{manga.volume}}</p>
                <label for="cover">Couverture du manga:</label>
                <input type="file" name="cover">
                <label for="releaseDate">Date de sortie</label>
                <input type="date" name="releaseDate" :value="manga.release_date">
                <label for="stock">Stock:</label>
                <input type="number" name="stock" :value="manga.stock">
                <Button>
                    Editer le volume
                </Button>
            </article>
        </form>
    </section>


    <section>
        <h2>Catégories actuelles: </h2>
        <ul>
            <li v-for="(category, index) in serie.categories" :key="category.id">
                {{category.name}} <i class="fas fa-trash" @click="deleteCategory(index)"></i>
            </li>
        </ul>
    </section>

    <section class="mangas-modify-categories">
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


</div>
</template>

<script>
import  {SeriesBroker} from '@/js/SeriesBroker.js';
import  {CategoriesBroker} from '@/js/CategoriesBroker.js';

import Button from '@/components/Button.vue';

export default {
    data: function() {
        return {
            serie: {},
            mangasAddNumber: 0,
            mangaToAdd: {},
            categories: {},
            categoriesChecked: []
        }
    },
    components: {
        Button
    },
    methods: {
        processFile(event) {
            this.mangaToAdd.cover = event.target.files[0]
        },
        addManga() {
            let series = new SeriesBroker();
            console.log(this.mangaToAdd);
            Promise.resolve(series.createManga(this.$route.params.id,this.mangaToAdd))
            .then( (response) => {
                console.log(response);
            })
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
            }

            let series = new SeriesBroker();
            Promise.resolve(series.createCategories(this.$route.params.id, datas)).then( (response) => {
                console.log(response);
            })
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        }
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
    }
}
</script>

<style lang="scss" scoped>

section {
    border-bottom: 2px solid $primary-color;
    padding-bottom: 20px;
}

img {
    max-width: 80%;
    height:300px;
}

.fas {
    background-color: #F8D7DA;
    padding:10px;
    font-size:2rem;
    color:#ad5a61;
    border: 1px solid #ad5a61;
    border-radius: 0.5rem;

}
</style>
