<template lang="html">
<div>
    <form method="post" @submit.prevent="onSubmit">
        <div class="input-item">
            <label for="category">Nom de la catégorie: </label>
            <input type="text" name="category" id="category" v-model="category">
        </div>

        <div class="input-item">
            <label for="categoryParent">Nom de la catégorie parent: </label>
            <select  name="categoryParent" id="categoryParent" v-model="categoryParent">
                <option v-for="category in categories" :key="category.name" :value="category.id"> {{category.name}} </option>
            </select>
        </div>
        <Button type="submit" v-if="edit">
            Modifier la catégorie
        </Button>
        <Button type="submit" v-else>
            Créer la catégorie
        </Button>
    </form>
</div>
</template>

<script>
import  {CategoriesBroker} from '@/js/CategoriesBroker.js';
import Button from '@/components/Button.vue'

export default {
    data: function () {
        return {
            category: "",
            categories: {},
            categoryParent: -1,
            edit: false
        }
    },
    components: {
        Button
    },
    methods: {
        onSubmit() {
            let category = {category: this.category};
            if (this.categoryParent != -1){
                category.categoryParent = this.categoryParent
            }

            let categories = new CategoriesBroker();
            if(this.edit){
                Promise.resolve(categories.modify(this.$route.params.id,category)).then ( () => {
                    this.$router.go(-1);
                })
                .catch ((e) => {
                    if(e.response.data.errorMessage) {
                        this.errorMessage = e.response.data.errorMessage
                    }
                });
            } else {
                Promise.resolve(categories.create(category)).then( () => {
                    this.$router.go(-1);
                })
                .catch ((e) => {
                    if(e.response.data.errorMessage) {
                        this.errorMessage = e.response.data.errorMessage
                    }
                })
            }

        }
    },
    mounted() {
        let categories = new CategoriesBroker();

        Promise.resolve(categories.getAll())
        .then( (response) => {
            this.categories = response.data;
            this.categories.default = {name: 'Aucune', id: -1}
        })
        .catch (() => {
            this.categories = [];
        });

        if( this.$route.name.includes('Modify') ){
            this.edit=true;
            let categories = new CategoriesBroker();
            Promise.resolve(categories.getById(this.$route.params.id)).then( (response) => {
                this.category = response.data.name;
                if(response.data.parent) {
                    this.categoryParent = response.data.parent
                }
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
