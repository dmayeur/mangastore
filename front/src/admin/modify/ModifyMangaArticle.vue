<template lang="html">
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
                return require('@/media/covers/'+image);
            } catch {
                return require('@/media/covers/empty.jpg');
            }
        }
    }
}
</script>

<style lang="css" scoped>
</style>
