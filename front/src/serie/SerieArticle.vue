<template lang="html">
  <article>
      <img :src="getImgPath(manga.image)" :alt="`Couverture de ${manga.title}`">
      <p>Volume {{manga.volume}}</p>
      <Button @click="addCart">
          Ajouter au panier
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
    display: flex;
    flex-direction:column;
    max-width:200px;

    padding:10px;

    background-color:#fff;
    color:$tertiary-color;
}

img{
    max-width:200px;
}

.add-cart {
    background-color: $primary-color;
    color: $primary-color-text;
    padding:5px;
    text-align:center;
}
</style>
