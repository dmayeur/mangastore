<template lang="html">
<div class="cart">

</div>
</template>

<script>
// import { mapGetters } from "vuex";
import  {MangasBroker} from '@/js/MangasBroker.js';

export default {
    data: function() {
        return {
            items:  this.$store.getters.items
        }
    },
    computed: {
        // ...mapGetters(["items"])
    },
    mounted() {
        if(this.items){
            let url="?id=";
            url+=Object.keys(this.items).join('&id=');
            let mangas = new MangasBroker();


            Promise.resolve(mangas.getAll(url))
            .then( (response) => {
                console.log(response);
            })
            .catch ((e) => {
                console.log(e.response.data);
            });

        }

    }
}
</script>

<style lang="scss" scoped>
</style>
