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
                <SerieArticle  @add-cart="addCart"
                    :manga="manga"
                ></SerieArticle>
            </li>
        </ul>
    </section>
    <section class="serie-reviews">
        <h2>Les reviews:</h2>

        <div v-if="isAuthenticated" class="comment-new">
            <h2>Ajouter un commentaire</h2>
            <form method="post" @submit.prevent="">

                <!-- crsf token -->
                <input
                    type="hidden"
                    name="token"
                    :value="token"
                >

                <label for="comment">Votre commentaire</label>
                <textarea name="content" id="comment" rows="8" cols="80"></textarea>

            <Button>
                Submit
            </Button>
            </form>
        </div>
        <div v-else>
            Veuillez vous connecter pour laisser une critique.
        </div>

    </section>
</div>
</template>

<script>
import Button from '@/components/Button.vue'

import  {SeriesBroker} from '@/js/SeriesBroker.js';
import SerieArticle from '@/serie/SerieArticle.vue';
import { mapGetters } from "vuex";

export default {
    computed: {
        ...mapGetters(["isAuthenticated", "authStatus","token"])
    },
    data: function() {
        return {
                id: this.$route.params.id,
                serie: Object
            };
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
    components: {
        SerieArticle,
        Button
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
    display:flex;
    flex-wrap:wrap;
    justify-content:space-around;

    li {
        padding:2rem;


    }

}

 .comments, #showPost .article{
    width:50%;
    flex: 0 0 50%;
    flex-grow: 0.5;
}

.article{
    flex-basis:100%;
}

 form{
    background-color: #af7ac5;
    padding:100px 20px 20px;
    margin-top:-40px;
    z-index:-100;
}

 form input,  form textarea, button {
    text-align: left;
    margin-bottom:20px;
    display:block;
}

.comment-new h2{
    padding:10px;
    background-color:$primary-color;
    color:$primary-color-text;
    z-index:1;
    width:80%;
    margin:0 auto;
    border-radius: 20px;
    position:relative;
}

 form label{
    text-align: left;
    display:block;
}
 form button {
    padding:10px;
    color:white;
    background-color: #4A90E2;
}

</style>
