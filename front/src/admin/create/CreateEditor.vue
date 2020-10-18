<template lang="html">
<div>
    <form method="post" @submit.prevent="onSubmit">
        <div class="input-item">
            <label for="editor">Nom de l'éditeur: </label>
            <input type="text" name="editor" id="editor" v-model="editor">
        </div>
        <Button v-if="edit">
            Modifier l'éditeur
        </Button>
        <Button v-else>
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
            edit: false
        }
    },
    components: {
        Button
    },
    methods: {
        onSubmit() {
            let editors = new EditorsBroker();
            if(this.edit){
                Promise.resolve(editors.modify(this.$route.params.id,{editor: this.editor})).then ( () => {
                    this.$router.go(-1);
                })
                .catch ((e) => {
                    if(e.response.data.errorMessage) {
                        this.errorMessage = e.response.data.errorMessage
                    }
                });
            } else {
                Promise.resolve(editors.create({editor: this.editor})).then( () => {
                    this.$router.go(-1);
                })
                .catch ((e) => {
                    if(e.response.data.errorMessage) {
                        this.errorMessage = e.response.data.errorMessage
                    }
                });
            }

        }
    },
    mounted() {
        if( this.$route.name.includes('Modify') ){
            this.edit=true;
            let editors = new EditorsBroker();
            Promise.resolve(editors.getById(this.$route.params.id)).then( (response) => {
                this.editor = response.data.name;
            })
            .catch (() => {
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
