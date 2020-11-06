<template lang="html">
  <div class="contact">
      <h1>Nous contacter</h1>
      <p>Un problème, une question, un avis? Nous sommes à votre disponibilité !</p>
      <Notice v-if="error">
          {{errorMessage}}
      </Notice>
      <div class="input-item">
          <label for="reason">La raison de votre contact*: </label>
          <input type="text" name="reason" id="reason" v-model="reason">
      </div>

      <div class="input-item">
          <label for="content">Contenu*: </label>
          <textarea name="name" rows="8" cols="80" v-model="content"></textarea>
          <small>{{ content.length }}/10 000</small>

      </div>
      <p>
          <small>* champ obligatoire</small>
      </p>

      <Button @click="simulateSending">
          Envoyer le message
      </Button>

  </div>
</template>

<script>
import Button from '@/components/Button.vue'
import Notice from '@/components/Notice.vue'
export default {
    data: function () {
        return {
            content: "",
            reason: "",
            error: false,
            errorMessage: ""
        }
    },
    components: {
        Button,
        Notice
    },
    methods: {
        simulateSending: function() {
            this.error = false;
            if(!(this.content.length && this.reason.length)){
                this.error = true;
                this.errorMessage = "Veuillez remplir les champs obligatoires"
            }

            if (this.content.length > 10000) {
                this.error = true;
                this.errorMessage = "Pas plus de 10000 caractères"
            }

            if(!this.error) {
                this.error = false;
                // eslint-disable-next-line
                NProgress.start(); //start a progress bar to act like the message is sending
                // eslint-disable-next-line
                setTimeout(function(){ NProgress.done(); }, 1000); //end the bar after a second to act like the message took time to send
            }

        }
    }
}
</script>

<style lang="scss" scoped>
input, textarea {
    @include input-field;
}

.input-item {
    margin-bottom: 20px;
}
</style>
