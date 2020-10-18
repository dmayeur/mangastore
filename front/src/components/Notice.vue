<template lang="html">
<div :class="`${type}`">
    <slot>

    </slot>
    <button type="button" class="btn-close" @click="remove" ref="btnclose" v-if="closable">
        <i class="far fa-times-circle"></i>
    </button>
</div>
</template>

<script>
export default {
    props: {
        message: String,
        type: {
            default: "error",
            type: String
        },
        closable: {
            default: false,
            type: Boolean
        }
    }
}
</script>

<style lang="scss" scoped>
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
