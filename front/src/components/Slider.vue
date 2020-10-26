<template lang="html">
<div class="slider">
    <i class="fas fa-arrow-circle-left" @click="previous"></i>
    <slot>

    </slot>
    <i class="fas fa-arrow-circle-right" @click="next"></i>
</div>
</template>

<script>
export default {
    data: function () {
        return {

        }
    },
    methods: {
        next: function() {

        },
        previous: function() {

        }
    }
}
</script>

<style lang="scss" scoped>
.fas {
    color: $primary-color;
    font-size: 3rem;
}
</style>
