<template lang="html">
    <button>
        <slot>
            Button
        </slot>
    </button>
</template>

<script>
export default {
}
</script>

<style lang="scss" scoped>
button {
    background-color: $primary-color;
    color: $primary-color-text;

    padding:10px;
    border:none;
    text-align:center;

    cursor:pointer;
}

@media (hover: hover){
    button:hover{
        background-color:#2D61CF;
    }
}
</style>
