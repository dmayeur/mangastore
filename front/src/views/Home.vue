<template>
<div class="home">
    <img alt="MangaStore Logo" src="../media/logo.png">
    <h1>Bienvenue sur MangaStore</h1>
    <section>
        <h2>Nos dernières sorties</h2>
        <Slider :mangas="mangas1" v-if="sliderMangas1">
        </Slider>
    </section>
    <section>
        <h2>Nos mangas les mieux notés</h2>
        <Slider :mangas="mangas2" v-if="sliderMangas2"></Slider>
    </section>
</div>
</template>

<script>
import Slider from '@/components/Slider.vue';

import  {SeriesBroker} from '@/js/SeriesBroker.js';

export default {
  name: 'Home',
  data: function() {
      return {
          mangas1: [],
          sliderMangas1: false,
          mangas2: [],
          sliderMangas2: false
      };
  },
  components: {
      Slider
  },
  created() {
      let series = new SeriesBroker();
      Promise.resolve(series.getAll('?sort=date'))
      .then( (response) => {
          this.mangas1 = Object.values(response.data.data).slice(0,5) ;
          this.sliderMangas1 = true;
      })

      Promise.resolve(series.getAll('?sort=rating'))
      .then( (response) => {
          this.mangas2 = Object.values(response.data.data).slice(0,5) ;
          this.sliderMangas2 = true;
      })
  }

}
</script>

<style lang="scss" scoped>
img {
    width: 150px;
}

p {
    text-align: left;
}

.home {
    text-align: center;
}
</style>
