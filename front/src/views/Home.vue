<template>
<div class="home">
    <img alt="MangaStore Logo" src="../media/logo.png">
    <h1>Blablablabala page d'accueil</h1>
    <section>
        <h2>Nos sorties récentes</h2>
        <Slider>
            <div class="slider-item" v-for="manga in mangas" :key="manga.id">
                <CatalogArticle
                    :manga="manga"
                ></CatalogArticle>
            </div>
        </Slider>
    </section>
</div>
</template>

<script>
import Slider from '@/components/Slider.vue';
import CatalogArticle from '@/catalog/CatalogArticle.vue';

import  {SeriesBroker} from '@/js/SeriesBroker.js';
export default {
  name: 'Home',
  data: function() {
      return {
          mangas:[]
      };
  },
  components: {
      Slider,
      CatalogArticle

  },
  created() {
      let series = new SeriesBroker();
      Promise.resolve(series.getAll('?sort=date'))
      .then( (response) => {
          this.mangas = response.data.data;
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
img {
    width: 150px;
}


.home {
    text-align: center;
}
</style>
