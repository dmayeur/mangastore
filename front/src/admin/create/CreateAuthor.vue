<template lang="html">
<div>
    <h1>Création d'un nouveau mangaka</h1>

    <Notice type="error" v-if="errorMessage">
        <p>{{errorMessage}}</p>
    </Notice>

    <form method="post" @submit.prevent="onSubmit">
        <div class="input-item">
            <label for="author">Nom de l'auteur: </label>
            <input type="text" name="author" id="author" v-model="author">
        </div>
        <Button v-if="edit" type="submit">
            Modifier l'auteur
        </Button>
        <Button v-else type="submit">
            Créer l'auteur
        </Button>
    </form>
</div>
</template>

<script>
import  {AuthorsBroker} from '@/js/AuthorsBroker.js';
import Button from '@/components/Button.vue'
import Notice from '@/components/Notice.vue';

export default {
    data: function () {
        return {
            author: "",
            edit: false,
            errorMessage: ""
        }
    },
    components: {
        Button,
        Notice
    },
    methods: {
        onSubmit() {
            let authors = new AuthorsBroker();
            if(this.edit){
                Promise.resolve(authors.modify(this.$route.params.id,{author: this.author, token: this.$store.getters.token})).then ( () => {
                    this.$router.go(-1);
                })
                .catch ((e) => {
                    if(e.response.data.errorMessage) {
                        this.errorMessage = e.response.data.errorMessage
                    }
                });
            } else {
                Promise.resolve(authors.create({author: this.author, token: this.$store.getters.token})).then( () => {
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
    beforeCreate() {
        this.$store.dispatch('isAdmin')
        .catch (() => {
            this.$router.push('/');
        })
    },
    mounted() {
        if( this.$route.name.includes('Modify') ){
            this.edit=true;
            let authors = new AuthorsBroker();
            Promise.resolve(authors.getById(this.$route.params.id)).then( (response) => {
                this.author = response.data.name;
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
