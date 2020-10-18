<template lang="html">
  <article>
      <img :src="getImgPath(manga.image)" :alt="`Couverture de ${manga.title}`">
      <p>Volume {{manga.volume}}</p>
      <Button @click="addCart">
          <i class="fas fa-shopping-cart"></i>
      </Button>
  </article>
</template>

<script>
import Button from '@/components/Button.vue';

export default {
    props: {
        manga: Object

    },
    components: {
        Button
    },
    methods: {
        getImgPath(image) {
            try {
                return require('../media/covers/'+image);
            } catch {
                return require('../media/covers/empty.jpg');
            }

        },
        addCart(){
            this.$store.dispatch('addCart', {id: this.manga.id ,quantity: 1});
        }
    }
}
</script>

<style lang="scss" scoped>

article {
    @include article;
    width:150px;
}

img {
    max-width:100%;
}

//make the add cart button aligned
p  {
    flex: 1 0 auto;
}

.add-cart {
    background-color: $primary-color;
    color: $primary-color-text;
    padding:5px;
    text-align:center;
}

button {
    font-size:1.5rem;
}

</style>
