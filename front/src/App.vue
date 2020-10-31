<template>
<div id="app">
    <header class="app-header">
        <div class="logo">
            <router-link to="/"><img src="./media/logo.png" /></router-link>
        </div>
        <div class="admin" v-if="isAdmin">
            <router-link to="/admin/series"><i class="fas fa-tools"></i>Admin</router-link>
        </div>
        <section id="searchBar">
            <input type="search" name="search" placeholder="Votre recherche ici..." v-model="search"><!--
            --><router-link to="/catalogue" :search="search"><button type="submit"><i class="fas fa-search"></i></button></router-link>
        </section>
        <nav>
            <ul>
                <li><router-link to="/catalogue"><i class="fas fa-book-open"></i><span>Catalogue</span></router-link></li>
                <li v-if="!isAuthenticated"><a href="#" @click.prevent="openModal"><i class="fas fa-user"></i><span>Se connecter</span></a></li>
                <li v-else><a href="#" @click.prevent="logOut"><i class="fas fa-user"></i><span>Se déconnecter</span></a></li>
                <li><router-link to="/panier"><i class="fas fa-shopping-cart"></i><span class="price">{{cartPrice}}€ ({{cartNbItems}})</span></router-link></li>
            </ul>
        </nav>

    </header>


    <div class="container">
        <router-view :search="search"/>
    </div>


    <footer>
        <nav>
            <ul>
                <li><router-link to="/contact">Contact</router-link></li>
                <li><router-link to="/about">A propos</router-link></li>
            </ul>
        </nav>
    </footer>

    <LoginModal v-show="isModalVisible" @close="closeModal">

    </LoginModal>
</div>
</template>

<script>
import LoginModal from '@/components/LoginModal.vue';
import { mapGetters } from "vuex";
export default {

    data: function() {
        return {
                id: this.$route.params.id,
                serie: Object,
                isModalVisible: false,
                search: "",
                currentPage: ""
            };
    },
    methods: {
        openModal: function() {
            this.isModalVisible = true
        },
        closeModal: function() {
            this.isModalVisible = false
        },
        logOut: function() {
            this.$store.dispatch('authLogout')
        }
    },
    computed: {
        ...mapGetters(["isAuthenticated", "authStatus", "isAdmin","cartPrice","cartNbItems"])
    },
    watch: {
        '$route' (to) {
            document.title = to.meta.title + ' - MangaStore' || 'MangaStore'
            this.currentPage = to.name;
        }
    },
    components: {
        LoginModal
    },
    created() {
        this.$store.dispatch('getTotalPrice');
    }
}
</script>


<style lang="scss">

/* ===================================================
                GENERAL PROPERTIES
================================================== */
//since this is not scoped all these properties will be useful for the whole app
ul {
  list-style: none;
  padding:0;
  margin:0;
  text-align: left;
}


* {
    box-sizing: border-box;
}

html {
    font-size:62.5%;
}

//Container that will be used for all pages
.container {
    padding:20px;
}


a {
    text-decoration: none;
}

body {
    font-family: $main-font;
    font-size: 1.6rem;
    text-align: center;
    background-color: $secondary-color;
}

h1, h2, h3, nav ul li a {
    font-family: $title-font;
}

/* ===================================================
                HEADER
================================================== */
.app-header {
    width:100%;
    background-color: $primary-color;

    img {
        max-width: 50%;
        //so it doesn't look too big on vertical tablets
        max-height: 150px;

        margin: 15px auto;
    }

    .container {
        padding:20px;
    }

}


nav ul li a {
    color: $primary-color-text;
    font-size:1.8rem;
    display: block;
    padding: 15px;

    margin: 0 10px;
    position: relative;
}

nav ul li a:after {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    width: 0%;
    content: '.';
    color: transparent;
    background: #fff;
    height: 2px;
}

nav ul li {
    text-align: center;

    .fas {
        display:block;
        margin-top: 20px;
        margin-bottom: 5px;
    }
}

nav ul li a.selected:after {
    width: 100%;
}


/* Search bar
================================================== */

#searchBar {
    display:flex;
    justify-content: center;
}

//Some properties for the two parts of the search bar to have the same size
%searchBar-element{
    display: inline-block;
    padding: 10px 15px;
    font-size: 1.6rem;
    border-radius: 0;
    -webkit-appearance: none;
    border: 1px solid black;
}

#searchBar input {
    @extend %searchBar-element;
    border-right: none;
}

#searchBar button {
    @extend %searchBar-element;
}

footer nav {
    background-color: $primary-color;
    width:100%;
    padding-bottom:10px;
}
@media screen and (min-width: 768px) {
    .mobileOnly{
        display:none;
    }
}

/* ===================================================
                DESKTOPS - 992 PX AND UP
================================================== */
@media screen and (min-width: 992px) {
    body {
        text-align: left;
    }


    /* ===================================================
                        HEADER
    ================================================== */
    /* Header always stays on top
    ================================================== */
    .app-header {
        display:flex;
        justify-content:center;
        align-items: center;

        #searchBar {
            width:33.33%;

            form {
                width:100%;
            }

            input[type="search"] {
                width:80%;
            }
        }

        .logo {
            width:33.33%;
            margin-left:50px;

            img {
                width: 75px;
            }
        }
    }
    /* Nav goes in one line, and reorder its content
    ================================================== */
    nav {
        width:33.33%;

        ul {
            display:flex;
            justify-content: space-around;
        }
    }

}
@media (hover:hover) {
    nav ul li a,
    nav ul li a:after {
      transition: all .5s;
    }


    nav ul li a:hover:after {
        width: 100%;
    }

}
</style>
