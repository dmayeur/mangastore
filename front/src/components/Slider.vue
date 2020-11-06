<template lang="html">
<div class="slider">
    <i class="fas fa-arrow-circle-left  arrow previous" @click="previous"></i>
    <transition-group tag="ul" :name="sliderTransition" class="slider-items" v-if="isInnit">
        <li v-for="manga in mangasToDisplay" :key="manga.id">
            <CatalogArticle :manga="manga"></CatalogArticle>
        </li>
    </transition-group>
    <i class="fas fa-arrow-circle-right arrow next" @click="next"></i>
    <div class="slider-selectors">
        <i class="fas fa-circle"></i>
        <i class="fas fa-circle"></i>
        <i class="fas fa-circle"></i>
        <i class="fas fa-circle"></i>
        <i class="fas fa-circle"></i>
    </div>
</div>
</template>

<script>
// import  {SeriesBroker} from '@/js/SeriesBroker.js';
import CatalogArticle from '@/catalog/CatalogArticle.vue';

export default {
    data: function () {
        return {
            mangasToDisplay: [],
            upperIndex: 3,
            lowerIndex: 0,
            sliderTransition: "slider-transition-next",
            isInnit:false
        }
    },
    props: {
        mangas: Object
    },
    components: {
        CatalogArticle
    },
    methods: {
        next: function() {
            this.sliderTransition = "slider-transition-next";

            //we add the next image
            this.mangasToDisplay.push(this.mangas[this.upperIndex]);

            //we remove the first
            this.mangasToDisplay.shift();

            //we now change the indexes
            this.upperIndex++;
            this.lowerIndex++;
            if(this.upperIndex == this.mangas.length) {
                this.upperIndex = 0;
            }

            if(this.lowerIndex == this.mangas.length) {
                this.lowerIndex = 0;
            }
        },
        previous: function() {
            this.sliderTransition = "slider-transition-previous";

            //we add the next image
            this.mangasToDisplay.unshift(this.mangas[this.lowerIndex]);

            //we remove last element
            this.mangasToDisplay.pop();

            //we now change the indexes
            this.upperIndex--;
            this.lowerIndex--;
            if(this.upperIndex == -1) {
                this.upperIndex = this.mangas.length -1;
            }

            if(this.lowerIndex == -1) {
                this.lowerIndex = this.mangas.length -1;
            }
        }
    },
    mounted() {
        // this.mangas = Object.values(this.mangasProps).slice(0,5);
        this.mangasToDisplay.push(this.mangas[0]);
        this.mangasToDisplay.push(this.mangas[1]);
        this.lowerIndex = this.mangas.length-1;
        this.mangasToDisplay.push(this.mangas[2]);
        this.isInnit = true;
    }

}
</script>

<style lang="scss" scoped>
.slider {
    margin: 0 auto;
    width: 50%;
    position: relative;
}

.slider-items {
    padding:20px;
    display:flex;
}

.fas {
    color: $primary-color;
}

.arrow {
    font-size: 3rem;
    position: absolute;
    top: 45%;

    &.previous {
        left: 0%;
    }

    &.next {
        left:90%;
    }


}

li {
    padding-left: 20px;
}



/* ===================================================
                ANIMATIONS
================================================== */
.slider-transition-next-move {
    transition: all .5s;
}

.slider-transition-next-enter-active {
    transition: all .3s ease;
}

.slider-transition-next-leave-active{
    transform: translateX(-20px);
    transition: all .3s;
}

.slider-transition-next-enter-from, .slider-transition-next-leave-to {
    transform: translateX(-20px);
    opacity: 0;
}

.slider-transition-previous-move {
    transition: all .5s;
}

.slider-transition-previous-enter-active {
    transition: all .3s ease;
}

.slider-transition-previous-leave-active{
    transform: translateX(-20px);
    transition: all .3s;
}

.slider-transition-previous-enter-from, .slider-transition-previous-leave-to {
    transform: translateX(-20px);
    opacity: 0;
}

/* ===================================================
                HOVER FOR DESKTOP ONLY
================================================== */

@media (hover: hover) {
    .fas {
        cursor: pointer;
    }
}
</style>
