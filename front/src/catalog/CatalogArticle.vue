<template lang="html">
<article>
    <router-link :to="`/serie/${manga.id}/`"><img :src="getImgPath(manga.image)" :alt="`Couverture de ${manga.title}`"></router-link>
    <h2><router-link :to="`/serie/${manga.id}/`">{{manga.title}}</router-link></h2>
    <p>{{manga.author}}</p>
    <div>
        <div class="rating" v-if="manga.average_rating" :title="'Note: ' + parseFloat(manga.average_rating).toFixed(2)  + '/5'">
            <div class="rating-upper" :style="{width: manga.average_rating/5*100 + '%'}">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <div class="rating-lower">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
        </div>
        <span class="price">{{manga.price}}€</span>
    </div>
</article>
</template>

<script>
export default {
    props: {
        manga: Object

    },
    methods: {
        getImgPath(image) {
            try {
                return require('../media/covers/'+image);
            } catch {
                return require('../media/covers/empty.jpg');
            }
        }
    }
}
</script>

<style lang="scss" scoped>


//main properties
article {
    @include article;
}

//the image at the top of the article
img {
    // max-width:100%;
    height: 180px;
    width: auto;
}

//the title
h2 {
    padding:0;
    margin:10px 0 2px;
    a{
        display:block;

        color: $primary-color;
        font-size:1.6rem;
    }
}

//spacing everything
p {
    margin: 5px 0;
}

//Put the rating and price and addCart button at the bottom
p:first-of-type {
    flex: 1 0 auto;

    font-size:1.4rem;
    color: $tertiary-color;
}

.rating {
    display:none;
}

//price on the same line as the rating
.price {
    float:right;
    margin-bottom:5px;
}


//the addcart button
.add-cart {
    background-color: $primary-color;
    color: $primary-color-text;
    padding:5px;
    text-align:center;
}

@include tablet {

    article {
        max-width: 150px;
    }
}
/* ===================================================
                DESKTOPS - 992 PX AND UP
================================================== */
@include desktop {

    article {
        max-width:220px;
    }

    img {
        max-width:100%;
        height:350px;
    }

    .rating {
        display:inline-block;
        position:relative;
    }

    .rating-upper {
        display: flex;
        z-index: 2;
        position: absolute;
        top: 0;
        left: 0;
        color:orange;
        overflow: hidden;
    }

}

@include extralarge {
    article {
        max-width: 250px;
    }
}

@media (hover: hover) {
    h2:hover a{
        color:green;
    }

    article:hover {
        box-shadow: 12px 12px 2px 1px rgba(0, 0, 255, .2);
        transform: scale(1.1);
    }
}

</style>
