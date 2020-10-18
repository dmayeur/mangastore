<template lang="html">
<div class="cart">
    <ul v-if="this.items">

    </ul>
    <p v-else>
        Votre panier est vide.
    </p>
</div>
</template>

<script>
// import { mapGetters } from "vuex";

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

    }
}
</script>

<style lang="scss" scoped>
</style>
