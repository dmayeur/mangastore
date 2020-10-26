<template lang="html">
<div :class="`${type}`">
    <slot>

    </slot>
</div>
</template>

<script>
export default {
    props: {
        type: {
            default: "error",
            type: String
        }
    }
}
</script>

<style lang="scss" scoped>
.slide-bottom-enter-active {
    transition: all .3s ease;
}

.slide-bottom-leave-active{
    transform: translateY(50px);
    transition: all .5s;
}

.slide-bottom-enter-from, .slide-bottom-leave-to {
    transform: translateY(20px);
    opacity: 0;
}


div {
    padding: 10px;
    margin-bottom: 10px;

}
.error {
    background-color: #F8D7DA;
    color:#ad5a61;
    border: 1px solid #ad5a61;
}
.success {
    background-color: #D4EDDA;
    color:#588e65;
}
</style>
