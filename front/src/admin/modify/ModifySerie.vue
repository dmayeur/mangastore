<template lang="html">
<div>
    <h1>{{serie.title}}</h1>
    <p>Nombre de volumes: {{serie.nbVolumes}}</p>

    <section class="mangas-add">

        <form method="post" enctype="multipart/form-data">
            <p>Volume n°{{ mangaToAdd.volume }} à ajouter</p>
            <input type="date" v-model="mangaToAdd.releaseDate">
            <input type="number" v-model="mangaToAdd.stock">
            <input type="file" @change="processFile($event)">

            <Button @click.prevent="addManga">Ajouter le volume</Button>
        </form>

    </section>

    <section class="mangas-modify">
        <form method="post" v-for="manga in serie.mangas" :key="manga.id">
            <ModifyMangaArticle :manga="manga"></ModifyMangaArticle>
        </form>
    </section>

</div>
</template>

<script>
import  {SeriesBroker} from '@/js/SeriesBroker.js';

import Button from '@/components/Button.vue';
import  ModifyMangaArticle from '@/admin/modify/ModifyMangaArticle.vue';

export default {
    data: function() {
        return {
            serie: {},
            mangasAddNumber: 0,
            mangaToAdd: {}
        }
    },
    components: {
        ModifyMangaArticle,
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
        }
    },
    mounted() {
        let series = new SeriesBroker();
        Promise.resolve(series.getById(this.$route.params.id))
        .then( (response) => {
            this.serie=response.data;
            this.mangaToAdd.volume=parseInt(this.serie.nbVolumes)+1;
            console.log(this.serie.mangas);
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
</style>
