<template lang="html">
<div>
    <form method="post" @submit.prevent="onSubmit">
        <div class="input-item">
            <label for="editor">Nom de l'éditeur: </label>
            <input type="text" name="editor" id="editor" v-model="editor">
        </div>
        <Button type="submit">
            Créer l'éditeur
        </Button>
    </form>
</div>
</template>

<script>
import  {EditorsBroker} from '@/js/EditorsBroker.js';
import Button from '@/components/Button.vue'

export default {
    data: function () {
        return {
            editor: "",
        }
    },
    components: {
        Button
    },
    methods: {
        onSubmit() {
            let editors = new EditorsBroker();
            Promise.resolve(editors.create(this.$route.params.id,{editor: this.editor})).then( () => {
                this.$router.go(-1);
            })
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        }
    }
}
</script>

<style lang="scss" scoped>
li > ul {
    padding-left: 20px;
}
</style>
