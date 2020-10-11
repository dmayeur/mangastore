<template lang="html">
<div :class="`${type}`">
    {{message}}
</div>
</template>

<script>
export default {
    props: {
        message: String,
        type: {
            default: "error",
            type: String
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
