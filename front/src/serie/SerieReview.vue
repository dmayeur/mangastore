<template lang="html">
    <section class="serie-reviews">
        <h2>Les reviews:</h2>

        <section class="serie-reviews-content">
            <ul v-if="reviews.length">
                test
            </ul>
            <p v-else>
                Aucune critique pour cette série.
            </p>
        </section>

        <div v-if="isAuthenticated" class="serie-reviews-new">

            <!-- <p>Votre note: </p> -->
            <div class="serie-reviews-rating">
                <!-- order will be reversed for hover effects -->
                <i class="fas fa-star" @click="rate(5)"></i>
                <i class="fas fa-star" @click="rate(4)"></i>
                <i class="fas fa-star" @click="rate(3)"></i>
                <i class="fas fa-star" @click="rate(2)"></i>
                <i class="fas fa-star" @click="rate(1)"></i>
            </div>
            <!-- <Loader v-if="loadingMangas">

            </Loader> -->
            <section v-if="rating">
                <h2>Ajouter une critique</h2>
                <form method="post" @submit.prevent="postReview">
                    <label for="review">Votre critique</label>
                    <textarea name="content" id="review" rows="8" cols="80" v-model="review"></textarea>
                    <small>{{review.length}}/10 000</small>
                    <Button>
                        Submit
                    </Button>
                </form>
            </section>

        </div>
        <p v-else>
            Veuillez vous connecter pour laisser une critique.
        </p>

    </section>
</template>

<script>
import Button from '@/components/Button.vue'
// import Loader from '@/components/Loader.vue'
import { mapGetters } from "vuex";

import  {SeriesBroker} from '@/js/SeriesBroker.js';
import  {ReviewsBroker} from '@/js/ReviewsBroker.js';

export default {
    data: function() {
        return {
                id: this.$route.params.id,
                reviews: [],
                review: "",
                rating: 0
            };
    },
    components: {
        Button,
        // Loader
    },
    computed: {
        ...mapGetters(["isAuthenticated", "authStatus","token"])
    },
    methods: {
        postReview() {
            let series = new SeriesBroker();
            Promise.resolve(series.createReview(this.$route.params.id,{token: this.$store.getters.token, content: this.review})).then ( (response) => {
                console.log(response);
            });
        },
        rate(rating) {
            let series = new SeriesBroker();

            if(this.rating) { // if a rating already exist we use put method
                Promise.resolve(series.modifyRating(this.$route.params.id,{token: this.$store.getters.token, rating: rating})).then ( (response) => {
                    this.rating = parseInt(response.data.rating);
                    this.checkStars();
                });
            } else { // post otherwise
                Promise.resolve(series.createRating(this.$route.params.id,{token: this.$store.getters.token, rating: rating})).then ( (response) => {
                    this.rating = parseInt(response.data.rating);
                    this.checkStars();
                });
            }

        },
        checkStars() {
            let stars = document.querySelectorAll('.fa-star');

            for(let i = 0; i < 5 ; i++) {
                //we get the stars in a reversed order
                if (5-i <= this.rating ) {
                    stars[i].classList.add('checked');
                } else {
                    stars[i].classList.remove('checked');
                }
            }
        }
    },
    mounted() {
        if(this.$store.getters.isAuthenticated) {
            let reviews = new ReviewsBroker();
            Promise.resolve(reviews.getByUser(this.$route.params.id,  this.$store.getters.token))
            .then( (response) => {
                this.rating = parseInt(response.data.rating);
                this.checkStars();
            })
            .catch(() => {
                this.review = "";
                this.rating = 0;
            })
        }
    }
}
</script>

<style lang="scss" scoped>
.reviews, #showPost .article{
   width:50%;
   flex: 0 0 50%;
   flex-grow: 0.5;
}

.article{
   flex-basis:100%;
}

form{
   background-color: #c4c4c4;
   padding:100px 20px 20px;
   margin-top:-40px;
   z-index:-100;
}

form input,  form textarea, button {
   text-align: left;
   margin-bottom:20px;
   display:block;
}

.serie-reviews-new h2{
   padding:10px;
   background-color:$primary-color;
   color:$primary-color-text;
   z-index:1;
   width:80%;
   margin:0 auto;
   border-radius: 20px;
   position:relative;
}

form label {
   text-align: left;
   display:block;
}

.serie-reviews-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;

    font-size: 5rem;
}

.checked {
    color:orange;
}

@media (hover: hover) {
    .serie-reviews-rating > .fas:hover {
        color:orange;
        cursor: pointer;

        ~ .fas {
            color:orange;
        }
    }
}
</style>
