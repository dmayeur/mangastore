<template lang="html">
<div>
    <Notice
        :message="notice.message"
        v-if="notice.message"
    ></Notice>
      <form class="signup-form" method="post" @submit.prevent="signUp">
          <fieldset>

              <legend>Informations principales</legend>
              <div class="form-input">
                  <label for="username">Nom d'utilisateur: </label>
                  <input type="text" name="username" id="username" v-model="account.username" required>
              </div>

              <div class="form-input">
                  <label for="email">Email: </label>
                  <input type="email" name="email" id="email" v-model="account.email" required>
              </div>

              <div class="form-input">
                  <label for="password">Password: </label>
                  <input type="password" name="password" id="password" v-model="account.password" required>
              </div>

          </fieldset>
          <fieldset>

              <legend>Information de livraison</legend>
              <p>Ces informations ne sont pas obligatoires lors de l'inscription.</p>
              <div class="form-input">
                  <label for="firstname">Prénom: </label>
                  <input type="text" name="firstname" id="firstname" v-model="account.firstname">
              </div>

              <div class="form-input">
                  <label for="lastname">Nom de famille: </label>
                  <input type="text" name="lastname" id="lastname" v-model="account.lastname">
              </div>

              <div class="form-input">
                  <label for="address">Addresse:  </label>
                  <input type="text" name="address" id="address" v-model="account.address">
              </div>

              <div class="form-input">
                  <label for="city">Ville: </label>
                  <input type="text" name="city" id="city" v-model="account.city">
              </div>

              <div class="form-input">
                  <label for="zipcode">Code postal: </label>
                  <input type="text" name="zipcode" id="zipcode" v-model="account.zipcode">
              </div>
              <div class="form-input">
                  <label for="country">Pays: </label>
                  <input type="text" name="country" id="country" v-model="account.country">
              </div>
          </fieldset>
          <button type="submit">S'inscrire</button>
      </form>
</div>
</template>

<script>
import  {UsersBroker} from '@/js/UsersBroker.js';
import Notice from '@/components/Notice.vue'
export default {
    data: function() {
        return {
            account:{},
            isValid: true,
            notice: {
                message:"",
                type:""
            }
        };
    },
    components: {
        Notice
    },
    methods: {
        signUp: function() {
            if (this.isValid) {
                let form_data = new FormData();

                for ( let key in this.account ) {
                    form_data.append(key, this.account[key]);
                }
                let users = new UsersBroker();
                users.signUp(form_data,this.signUpCallback);
            }
        },
        signUpCallback: function(response) {
            if(response.errorMessage){
                this.notice.message=response.errorMessage
                this.notice.type="error"
            } else {
                this.notice.message="L'utilisateur a bien été créé"
                this.notice.type="success"
            }
        }
    }
}
</script>

<style lang="scss" scoped>
fieldset {
    margin: 0 auto;
    width: 900px;

    display: flex;
    justify-content: space-around;
    flex-flow: row wrap;

    .form-input {
        width:40%
    }
}

.form-input {
    padding: 10px;
}

input {
    background-color:transparent;
    border:none;
    border-bottom: 1px solid rgba(0,0,0,0.5);

    &:focus {
        outline:none;
        border-bottom: 1px solid #000;
    }
}

</style>
