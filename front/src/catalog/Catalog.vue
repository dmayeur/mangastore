<template lang="html">
<div class="catalog">
    <h1>Notre catalogue</h1>
    <div class="catalog-search--pages">
        <Button v-for="n in pages-1" :key="n" @click="onPageChange(n)">
            {{n}}
        </Button>
    </div>
        <div class="catalog-search--toggle">
            <!-- Display the aside in mobile -->
            <input type="checkbox" id="filter" />
            <Button @click='onToggleFilter' class="mobileOnly filter-button">
                Filtrer les séries
            </Button>

            <CatalogAside @form-change="onInputChange" @close-aside="onToggleFilter">

            </CatalogAside>
        </div>
        <p v-if="errorMessage">{{ errorMessage }}</p>
        <ul class="catalog-search--results">
            <Loader v-if="loadingMangas">

            </Loader>
            <transition-group
                name="slide-right"
            >
                <li v-for="manga in mangas" :key="manga.id">

                    <CatalogArticle
                        :manga="manga"
                    ></CatalogArticle>

                </li>
            </transition-group>

        </ul>
</div>
</template>

<script>
import CatalogArticle from '@/catalog/CatalogArticle.vue'
import CatalogAside from '@/catalog/CatalogAside.vue'
import Button from '@/components/Button.vue'
import Loader from '@/components/Loader.vue'

import  {SeriesBroker} from '@/js/SeriesBroker.js';

export default {
    data: function () {
        return {
            mangas: [],
            errorMessage: "",
            editors: [],
            editorsChecked: [],
            categories: [],
            categoriesChecked: [],
            search: "",
            queryURL: "?sort=alphabetical",
            pages: 1,
            page: 1,
            loadingMangas: false
        }
    },
    computed: {

    },
    components: {
        CatalogAside,
        CatalogArticle,
        Loader,
        Button
    },
    methods: {
        onToggleFilter: function(){
            document.querySelector('#filter').checked = !document.querySelector('#filter').checked
        },
        reloadMangas: function() {
            this.loadingMangas=true;
            let series = new SeriesBroker();
            Promise.resolve(series.getAll(this.queryURL+'&page='+this.page))
            .then( (response) => {
                this.mangas = response.data.data;
                this.loadingMangas = false;
                this.errorMessage = "";
                this.pages = response.data.pages;

            })
            .catch ((e) => {
                if(e.response.data.errorMessage) {
                    this.errorMessage = e.response.data.errorMessage
                }
                this.pages = 0;
                this.mangas = [];
                this.loadingMangas = false;
            });
        },
        onInputChange: function(queryURL) {
            this.queryURL = queryURL;
            this.reloadMangas();

        },
        onPageChange: function(page) {
            this.page=page;
            this.reloadMangas();
        }
    },
    mounted(){
        //initializing the catalog
        let series = new SeriesBroker();
        Promise.resolve(series.getAll(""))
        .then( (response) => {
            this.mangas = response.data.data;
            this.pages = response.data.pages;
        })
        .catch (() => {
            this.series = [];
        });

    }
}
</script>

<style lang="scss" scoped>

.slide-right-move{
  transition: transform 0.3s;
}

.slide-right-enter-active {
    transition: all .3s ease;
}

.slide-right-leave-active{
    transform: translateX(50px);
    transition: all .5s;
}

.slide-right-enter-from, .slide-right-leave-to {
    transform: translateX(20px);
    opacity: 0;
}



// the hidden checkbox code that is used to display the menu in mobile
.catalog-search--toggle{
    & > input {
        position:absolute;
        top:-50px;
        left:-50px;
    }

    & > input:checked ~ aside {
        transform: translateX(750px);
    }
}

.filter-button {
    margin-bottom:20px;
}



.catalog-search--results {
    display: flex;
    flex-flow: row wrap;
    justify-content: space-around;

    //So it doesn't break the display
    &:after {
      content: "";
      flex: auto;
    }

    li {
        display:flex;
        flex: 0 0 40%;
        font-size: 2rem;
        text-align: left;
    }
}

.catalog-search--pages {
    text-align: right;
    flex: 0 0 100%;
}
/* ===================================================
                TABLETS - 768 PX AND UP
================================================== */
@include tablet {

    /* Catalog
    ================================================== */
    .catalog {
        display:flex;
        flex-wrap: wrap;
        justify-content: space-around;


        .catalog-search--toggle {
            flex: 0 0 200px;
        }

        h1 {
            flex: 0 0 100%;
        }


        aside {
            position:static;

            padding:0;
        }

        .catalog-search--results {
            flex: 1 0 0;
            padding-left:20px;



            li {
                width:33.33%;
                flex:0 1 auto;
                margin-bottom:50px;
            }
        }
    }
}


/* ===================================================
                DESKTOPS - 992 PX AND UP
================================================== */
@include desktop {
    aside {
        margin-left:0px;
        margin-right:10px;
    }

}


/* ===================================================
                LARGE SCREEN
================================================== */
@include large {
    .catalog {
        .catalog-search--results {
            li {
                width:25%;
            }
        }
    }
}

/* ===================================================
                EXTRA LARGE SCREEN
================================================== */
@include extralarge {
    .catalog {
        .catalog-search--results {
            li {
                width:20%;
            }
        }
    }
}


</style>
