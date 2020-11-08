<template lang="html">
  <div>
      <h1>Bienvenue sur la page d'administration de mangastore !</h1>
      <p>Ici vous pouvez gérer le contenu de votre site selon votre besoin.</p>

      <Notice type="error" v-if="errorMessage">
          <p>{{errorMessage}}</p>
      </Notice>

      <nav>
          <ul>
              <li><router-link to="/admin/series">Séries</router-link></li>
              <li><router-link to="/admin/commandes">Commandes</router-link></li>
              <li><router-link to="/admin/editeurs">Editeurs</router-link></li>
              <li><router-link to="/admin/categories">Catégories</router-link></li>
              <li><router-link to="/admin/critiques">Critiques</router-link></li>
              <li><router-link to="/admin/auteurs">Auteurs</router-link></li>
          </ul>
      </nav>
      <router-link :to="$route.path.replace(/\/+$/, '')+'/create'" v-if="create"><Button>Créer</Button></router-link>
      <AdminTable
        :header="tableHeader"
        :body="tableValues"
        :modify="modify"
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
import  {ReviewsBroker} from '@/js/ReviewsBroker.js';
import  {OrdersBroker} from '@/js/OrdersBroker.js';

import Button from '@/components/Button.vue';
import Notice from '@/components/Notice.vue';
import AdminTable from '@/admin/AdminTable.vue';

export default {
    data: function() {
        return {
            tableHeader: {},
            tableValues: {},
            create: this.$route.meta.create, //some routes doesn't need a create or modify button (configured in the router)
            modify: this.$route.meta.modify,
            errorMessage: ""
        }
    },
    components: {
        AdminTable,
        Button,
        Notice
    },
    methods: {
        updateTable: function(response) {
            //we separate the header and the values from the response
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
            //reload the table with the right values on route change
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
                    Promise.resolve(categories.getAdmin())
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
                case 'AdminReviews': {
                    let reviews = new ReviewsBroker();
                    Promise.resolve(reviews.getAllAdmin())
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
                case 'AdminOrders': {
                    let orders = new OrdersBroker();
                    Promise.resolve(orders.getAll())
                    .then( (response) => {
                        this.updateTable(response);
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
        del(id, index){
            //the API call depends of the URL
            let token = {token: this.$store.getters.token};
            switch(this.$route.name) {
                case 'AdminAuthors': {
                    let authors = new AuthorsBroker();
                    Promise.resolve(authors.delete(id, token))
                    .then( () => {
                        this.tableValues.splice(index,1);
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
                    Promise.resolve(series.delete(id, token))
                    .then( () => {
                        this.tableValues.splice(index,1);
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
                    Promise.resolve(categories.delete(id, token))
                    .then( () => {
                        this.tableValues.splice(index,1);
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
                    Promise.resolve(editors.delete(id, token))
                    .then( () => {
                        this.tableValues.splice(index,1);
                    })
                    .catch ((e) => {
                        if(e.response.data.errorMessage) {
                            this.errorMessage = e.response.data.errorMessage
                        }
                    });
                    break;
                }
                case 'AdminReviews': {
                    let reviews = new ReviewsBroker();
                    Promise.resolve(reviews.removeReview(id, token))
                    .then( () => {
                        this.tableValues.splice(index,1);
                    })
                    .catch ((e) => {
                        if(e.response.data.errorMessage) {
                            this.errorMessage = e.response.data.errorMessage
                        }
                    });
                    break;
                }
                case 'AdminOrders': {
                    let orders = new OrdersBroker();
                    Promise.resolve(orders.delete(id, token))
                    .then( () => {
                        this.tableValues.splice(index,1);
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
    beforeCreate() {
        this.$store.dispatch('isAdmin')
        .catch (() => { //we only care about errors
            this.$router.push('/');
        })
    },
    mounted(){
        //we initialize the table when it's mounted
        this.onChangeRoute(this.$route.name);
    },
    watch: {
        //everytime we change route, we'll reload the table
        $route: function(newRoute) {
            this.onChangeRoute(newRoute.name);
            this.create = newRoute.meta.create;
            this.modify = newRoute.meta.modify;
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
    flex-wrap: wrap;
    justify-content: space-around;
}

button {
    margin: 10px auto;
}
</style>
