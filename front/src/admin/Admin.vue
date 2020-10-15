<template lang="html">
  <div class="">
      <h1>Bienvenue sur la page d'administration de mangastore !</h1>
      <p>Ici vous pouvez créer, éditer, ou supprimer selon votre besoin.</p>
      <nav>
          <ul>
              <li><router-link to="series">Séries</router-link></li>
              <li>Commandes</li>
              <li><router-link to="editeurs">Editeurs</router-link></li>
              <li><router-link to="categories">Catégories</router-link></li>
              <li>Reviews</li>
              <li><router-link to="auteurs">Auteurs</router-link></li>
              <li>Prix</li>
          </ul>
      </nav>
      <router-link :to="$route.path+'/create'">Créer</router-link>
      <AdminTable
        :header="tableHeader"
        :body="tableValues"
        @del="del"
      >
      </AdminTable>
</div>
</template>

<script>
import  {SeriesBroker} from '@/js/SeriesBroker.js';
import  {EditorsBroker} from '@/js/EditorsBroker.js';
import  {CategoriesBroker} from '@/js/CategoriesBroker.js';
import  {AuthorsBroker} from '@/js/AuthorsBroker.js';

import AdminTable from '@/admin/AdminTable.vue'

export default {
    data: function() {
        return {
            tableHeader: [],
            tableValues: [],
        }
    },
    components: {
        AdminTable
    },
    methods: {
        updateTable: function(response) {
            this.tableHeader=[];
            this.tableValues=[];
            let arr=[];
            arr=Object.keys(response.data[0]);

            for(const key of arr ) {
                this.tableHeader.push(key);
            }
            for(const result of Object.values(response.data)){
                this.tableValues.push(result);
            }
        },
        onChangeRoute: function(route){
            switch (route) {
                case 'AdminSeries': {
                    let series = new SeriesBroker();
                    Promise.resolve(series.getAdmin())
                    .then( (response) => {
                        this.updateTable(response)
                    })
                    .catch ((e) => {
                        if(e.response.data.errorMessage) {
                            this.errorMessage = e.response.data.errorMessage
                        }
                    });
                    break;
                }
                case 'AdminCategories': {
                    let categories = new CategoriesBroker();
                    Promise.resolve(categories.getAll())
                    .then( (response) => {
                        this.updateTable(response)
                    })
                    .catch ((e) => {
                        if(e.response.data.errorMessage) {
                            this.errorMessage = e.response.data.errorMessage
                        }
                    });
                    break;
                }
                case 'AdminEditors': {
                    let editors = new EditorsBroker();
                    Promise.resolve(editors.getAll())
                    .then( (response) => {
                        this.updateTable(response)
                    })
                    .catch ((e) => {
                        if(e.response.data.errorMessage) {
                            this.errorMessage = e.response.data.errorMessage
                        }
                    });
                    break;
                }
                case 'AdminAuthors': {
                    let authors = new AuthorsBroker();
                    Promise.resolve(authors.getAll())
                    .then( (response) => {
                        this.updateTable(response)
                    })
                    .catch ((e) => {
                        if(e.response.data.errorMessage) {
                            this.errorMessage = e.response.data.errorMessage
                        }
                    });
                    break;
                }
            }
        },
        del(id){
            switch(this.$route.name) {
                case 'AdminAuthors': {
                    let authors = new AuthorsBroker();
                    Promise.resolve(authors.delete(id))
                    .then( (response) => {
                        console.log(response);
                    })
                    .catch ((e) => {
                        if(e.response.data.errorMessage) {
                            this.errorMessage = e.response.data.errorMessage
                        }
                    });
                    break;
                }
                case 'AdminSeries': {
                    let series = new SeriesBroker();
                    Promise.resolve(series.delete(id))
                    .then( (response) => {
                        console.log(response);
                    })
                    .catch ((e) => {
                        if(e.response.data.errorMessage) {
                            this.errorMessage = e.response.data.errorMessage
                        }
                    });
                    break;
                }

            }
        }
    },
    mounted(){
        //we initialize the table when it's mounted
        this.onChangeRoute(this.$route.name);
    },
    watch: {
        //everytime we change route, we'll reload the table
        $route: function(newRoute) {
            this.onChangeRoute(newRoute.name);
        }
    }
}
</script>

<style lang="scss" scoped>

nav {
    width:100%;
    background-color: $primary-color;
    padding:10px;

    a{
        padding:10px;
        color: $primary-color-text;
    }
}

ul {
    display:flex;
    justify-content: space-between;
}

</style>
