<template lang="html">
    <section class="serie-reviews">
        <h2>Les reviews:</h2>

        <section class="serie-reviews">
            <ul v-if="reviews.length">
                <li class="serie-review" v-for="review in reviews" :key="review.id">
                    <p class="serie-review--rating">Note: {{ review.rating }}/5</p>
                    <h3>{{ review.username }}</h3>
                    <p>{{ review.content }}</p>
                </li>
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

            <section class="serie-reviews-content" v-if="rating">
                <h2>Ajouter une critique</h2>
                <form method="post" @submit.prevent="sendReview">
                    <label for="review">Votre critique</label>
                    <textarea name="content" id="review" rows="8" cols="80" v-model="review"></textarea>
                    <small>{{ review.length }}/10 000</small>
                    <Button type="submit" v-if="!reviewExist">
                        Envoyer la critique
                    </Button>
                    <Button type="submit" v-else>
                        Modifier la critique
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
import { mapGetters } from "vuex";

import  {SeriesBroker} from '@/js/SeriesBroker.js';
import  {ReviewsBroker} from '@/js/ReviewsBroker.js';

export default {
    data: function() {
        return {
                id: this.$route.params.id,
                reviews: [],
                review: "",
                rating: 0,
                reviewExist: false
            };
    },
    components: {
        Button,
    },
    computed: {
        ...mapGetters(["isAuthenticated", "authStatus","token"])
    },
    watch: {
        //automatically fill the fields upon login
        isAuthenticated: function(val) {
            if(val) {
                this.updateUserReview();
            }
        }
    },
    methods: {
        updateUserReview() {
            let reviews = new ReviewsBroker();

            Promise.resolve(reviews.getByUser(this.$route.params.id,  this.$store.getters.token))
            .then( (response) => {
                this.rating = parseInt(response.data.rating);
                if (response.data.content) {
                    this.review = response.data.content;
                    this.reviewExist = true;
                }
                this.checkStars();
            })
            .catch(() => {
                this.review = "";
                this.rating = 0;
            })
        },
        sendReview() {
            let series = new SeriesBroker();
            //the review is always initialized because it needs to have a rating first, so that method is always called
            Promise.resolve(series.modifyReview(this.$route.params.id,{token: this.$store.getters.token, content: this.review}));
        },
        rate(rating) {
            let series = new SeriesBroker();

            if(this.rating) { // if a rating already exist we use put method
                Promise.resolve(series.modifyRating(this.$route.params.id,{token: this.$store.getters.token, rating: rating})).then ( (response) => {
                    this.rating = parseInt(response.data.rating);
                    // we don't forget to update the star display if the update was done correctly to the server
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
            //we select all the stars not forgetting we get them in reversed orders
            let stars = document.querySelectorAll('.fa-star');

            for(let i = 0; i < 5 ; i++) {
                if (5-i <= this.rating ) {
                    stars[i].classList.add('checked');
                } else {
                    stars[i].classList.remove('checked');
                }
            }
        }
    },
    created() {
        let series = new SeriesBroker();
        Promise.resolve(series.getAllReviews(this.$route.params.id))
        .then( (response) => {
            this.reviews = Object.values(response.data);
        })
        .catch(() => {
            this.reviews = [];
        })

        //if the user is logged in
        if(this.$store.getters.isAuthenticated) {
            this.updateUserReview();
        }
    }
}
</script>

<style lang="scss" scoped>


/* User reviews
================================================== */
.serie-review {
    padding: 10px;
    border:1px solid black;

    &:nth-of-type(odd){
        background-color:#e1e7f5;

    }
    &:nth-of-type(even){
        background-color:#fff;
        border-top: none;
    }

    &--rating {
        float:right;
    }
}

/* stars rating
================================================== */
.serie-reviews-rating {
    margin-top: 30px;

    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;

    font-size: 5rem;
}

.checked {
    color:orange;
}


/* Create review
================================================== */
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

textarea {
    @include input-field;
    margin-top: 5px;
    margin-bottom: 5px;
    max-width: 100%;
}

.serie-reviews-content {
    margin-top: 20px;
}

.serie-reviews-content button {
    display:block;
    margin-top: 10px;
}

form{
   background-color: #c4c4c4;
   padding:100px 20px 20px;
   margin-top:-40px;
   z-index:-100;
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
