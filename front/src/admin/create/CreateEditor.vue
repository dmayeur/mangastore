<template lang="html">
<div>
    <h1>Création d'un éditeur</h1>

    <Notice type="error" v-if="errorMessage">
        <p>{{errorMessage}}</p>
    </Notice>

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
import Notice from '@/components/Notice.vue';

export default {
    data: function () {
        return {
            editor: "",
            errorMessage: ""
        }
    },
    components: {
        Button,
        Notice
    },
    methods: {
        onSubmit() {
            let editors = new EditorsBroker();
            Promise.resolve(editors.create({editor: this.editor, token: this.$store.getters.token})).then( () => {
                this.$router.go(-1);
            })
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
            });
        }
    },
    beforeCreate() {
        this.$store.dispatch('isAdmin')
        .catch (() => {
            this.$router.push('/');
        })
    },
}
</script>

<style lang="scss" scoped>
li > ul {
    padding-left: 20px;
}
</style>
