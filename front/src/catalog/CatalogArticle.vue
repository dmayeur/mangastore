<template lang="html">
  <article>
      <router-link :to="`/serie/${manga.id}/`"><img :src="getImgPath(manga.image)" :alt="`Couverture de ${manga.title}`"></router-link>
      <h2><router-link :to="`/serie/${manga.id}/`">{{manga.title}}</router-link></h2>
      <p>{{manga.author}}</p>
      <div>
          <div class="rating">
              <i class="far fa-star"></i>
              <i class="far fa-star"></i>
              <i class="far fa-star"></i>
              <i class="far fa-star"></i>
              <i class="far fa-star"></i>
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
article{
    display:flex;
    flex-direction:column;

    padding:10px;
    max-width:200px;
    background-color: #fff;

    transition: box-shadow 0.3s, transform 0.3s;

    margin-bottom:20px;
}

//the image at the top of the article
img {
    max-width:100%;
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

/* ===================================================
                DESKTOPS - 992 PX AND UP
================================================== */
@media screen and (min-width: 992px) {

    article{
        max-width:250px;
    }

    img {
        max-width:100%;
        height:350px;
    }

    .rating {
        display:inline;
    }
}

//For the hover effects
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
