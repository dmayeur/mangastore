<template lang="html">
<div>
    <div class="banner" v-if="serie.banner">
        <img :src="getImgPath(serie.banner)" :alt="`Banniere de ${serie.name}`" >
    </div>

    <h1>{{serie.title}}</h1>
    <section class="serie-description">

        <ul>
            <li><p>Auteur: {{serie.author}}</p></li>
            <li><p>Nombre de volumes: {{ serie.nbVolumes }} </p></li>
            <li><p>Prix du tome: {{ serie.price }}€ </p></li>
            <li><p>Editeur: {{ serie.editor }}</p></li>
        </ul>
    </section>
    <section class="serie-mangas">
        <h2>Les volumes de la série:</h2>
        <ul>
            <li v-for="manga in serie.mangas" :key="manga.id">
                <SerieArticle
                    :manga="manga"
                ></SerieArticle>
            </li>
        </ul>
    </section>

    <SerieReview></SerieReview>
</div>
</template>

<script>
import  {SeriesBroker} from '@/js/SeriesBroker.js';

import SerieArticle from '@/serie/SerieArticle.vue';
import SerieReview from '@/serie/SerieReview.vue';

export default {

    data: function() {
        return {
                id: this.$route.params.id,
                serie: Object,
                reviews: [],
                review: ""
            };
    },
    components: {
        SerieArticle,
        SerieReview
    },
    methods: {
        getImgPath(image) {
            try {
                return require('../media/banner/'+image);
            } catch {
                return require('../media/covers/empty.jpg');
            }
        },
        addCart(manga) {
            console.log(manga);
        }
    },
    mounted() {
        let series = new SeriesBroker();
        Promise.resolve(series.getById(this.id)).then( (response)=>{
                this.serie=response.data;
        });
    }

}
</script>

<style lang="scss" scoped>

.banner img{
    max-width:100%;
}


.serie-description{
    li{

        padding:10px;

        &:nth-of-type(odd){
            background-color:#e1e7f5;
        }
        &:nth-of-type(even){
            background-color:#fff;
        }

        p{
            margin:0;
        }
    }
}

.serie-mangas ul {
    @include articles;
}



/* ===================================================
                TABLETS - 768 PX AND UP
================================================== */
@include tablet {
    .serie-mangas {

    }
}

/* ===================================================
                EXTRA LARGE SCREEN
================================================== */
@include extralarge {
    .serie-mangas {
        ul li {
            width:10%;
            flex:0 1 auto;
        }
    }
}

</style>
