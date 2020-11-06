<template lang="html">
<div>
    <h1>Commande n°{{order.id}}</h1>
    <p>Nombre de volumes:</p>

</div>
</template>

<script>
import  {OrdersBroker} from '@/js/OrdersBroker.js';


// import Button from '@/components/Button.vue';

export default {
    data: function() {
        return {
            order: {}
        }
    },
    components: {
        // Button
    },
    methods: {

    },
    beforeCreate() {
        this.$store.dispatch('isAdmin')
        .catch (() => {
            this.$router.push('/');
        })
    },
    mounted() {
        let orders = new OrdersBroker();
        Promise.resolve(orders.getById(this.$route.params.id))
        .then( (response) => {
            this.order=response.data;
        })
        .catch ((e) => {
            if(e.response.data.errorMessage) {
                this.errorMessage = e.response.data.errorMessage
            }
        });
    }
}
</script>

<style lang="scss" scoped>
input:not([type='checkbox']), select {
    @include input-field;

    margin-bottom: 10px;
}

section {
    border-bottom: 2px solid $primary-color;
    padding-bottom: 20px;
    overflow:hidden;
}

img {
    max-width: 80%;
    height:300px;
}

.fas {
    @include red-icon
}

article {
    margin-bottom: 50px;
}

@include tablet {
    img{
        float:left;
        margin-right: 20px;
    }
}
</style>
