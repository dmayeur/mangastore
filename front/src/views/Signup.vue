<template lang="html">
<div>
    <Notice
        :message="errorMessage"
        v-if="errorMessage"
    ></Notice>
    <form class="signup-form" method="post" @submit.prevent="signUp">
        <fieldset>
            <legend>Informations principales</legend>
            <div class="form-input">
                <label for="username">Nom d'utilisateur: </label>
                <input type="text" name="username" id="username" v-model="username" required>
                <transition
                    name="slide-bottom"
                >
                    <Notice
                        v-if="errors.username"
                    >
                        {{errors.username}}
                    </Notice>
                </transition>
            </div>
            <div class="form-input">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" v-model="email" required>
            </div>

            <div class="form-input">
                <label for="password">Mot de passe: </label>
                <input type="password" name="password" id="password" v-model="password" required>
                <transition
                    name="slide-bottom"
                >
                    <Notice
                        v-if="errors.password"
                    >
                        {{errors.password}}
                    </Notice>
                </transition>
            </div>

            <div class="form-input">
                <label for="password-confirmation">Confirmation du mot de passe: </label>
                <input type="password"  id="password-confirmation" v-model="passwordVerif" required>
            </div>
        </fieldset>
        <fieldset>

            <legend>Information de livraison</legend>
            <p>Ces informations ne sont pas obligatoires lors de l'inscription.</p>
            <div class="form-input">
                <label for="firstname">Prénom: </label>
                <input type="text" name="firstname" id="firstname" v-model="firstname">
            </div>

            <div class="form-input">
                <label for="lastname">Nom de famille: </label>
                <input type="text" name="lastname" id="lastname" v-model="lastname">
            </div>

            <div class="form-input">
                <label for="address">Addresse:  </label>
                <input type="text" name="address" id="address" v-model="address">
            </div>

            <div class="form-input">
                <label for="city">Ville: </label>
                <input type="text" name="city" id="city" v-model="city">
            </div>

            <div class="form-input">
                <label for="zipcode">Code postal: </label>
                <input type="text" name="zipcode" id="zipcode" v-model="zipcode">
            </div>
            <div class="form-input">
                <label for="country">Pays: </label>
                <input type="text" name="country" id="country" v-model="country">
            </div>
        </fieldset>
        <Button
            type="submit"
        >
             S'inscrire
        </Button>
        <Button
            type="reset"
        >
            Effacer
        </Button>
    </form>
</div>
</template>

<script>
import  {UsersBroker} from '@/js/UsersBroker.js';
import Button from '@/components/Button.vue';
import Notice from '@/components/Notice.vue';

export default {
    data: function() {
        return {
            account: {},
            errors: {},
            errorMessage: "",
            username: "",
            password: "",
            passwordVerif: "",
            email: "",
            firstname: "",
            lastname: "",
            address: "",
            city: "",
            zipcode: "",
            country: ""
        };
    },
    components: {
        Notice,
        Button
    },
    watch: {
        password: function() {
            this.checkPassword();
        },
        passwordVerif: function() {
            this.checkPassword();
        },
        username: function() {
            if (this.username.length == 0) {
                document.querySelector('#username').classList.remove('error');
                delete this.errors.username;
                return;
            } else if (this.username.length < 4) {
                document.querySelector('#username').classList.add('error');
                this.errors.username = "Le nom d'utilisateur doit faire 4 caractères minimum";
                return;
            }

            document.querySelector('#username').classList.remove('error');
            delete this.errors.username;
        }
    },
    methods: {
        signUp: function() {
            //the object errors is empty if we have no error
            if(!Object.keys(this.errors).length ) {
                let account = {
                    username: this.username,
                    password: this.password,
                    email: this.email,
                    firstname: this.firstname,
                    lastname: this.lastname,
                    address: this.address,
                    city: this.city,
                    zipcode: this.zipcode,
                    country: this.country
                }
                let users = new UsersBroker();
                Promise.resolve(users.signUp(account))
                .then( () => {
                    this.$router.push(-1);
                })
                .catch ((e) => {
                    if(e.response.data.errorMessage) {
                        this.errorMessage = e.response.data.errorMessage
                    }
                });
            }
        },
        checkPassword: function() {
            if (this.password == "") {
                document.querySelector('#password').classList.remove('error');
                delete this.errors.password;
            } else if (this.password.length < 6) {
                document.querySelector('#password').classList.add('error');
                this.errors.password = "Le mot de passe doit faire plus de 6 caractères";
                return;
            } else if (this.password.length > 50) {
                document.querySelector('#password').classList.add('error');
                this.errors.password = "Le mot de passe est trop long";
                return;
            } else if (this.password.search(/\d/) == -1) {
                document.querySelector('#password').classList.add('error');
                this.errors.password = "Le mot de passe doit contenir au moins un chiffre";
                return;
            } else if (this.password.search(/[a-zA-Z]/) == -1) {
                document.querySelector('#password').classList.add('error');
                this.errors.password = "Le mot de passe doit contenir au moins une lettre";
                return;
            // eslint-disable-next-line
            } else if (this.password.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
                document.querySelector('#password').classList.add('error');
                this.errors.password ="Le mot de passe ne doit pas contenir de caractères illégaux";
                return;
            }
            if(this.password!=this.passwordVerif) {
                document.querySelector('#password').classList.add('error');
                this.errors.password = "Le mot de passe doit correspondre à la confirmation";
            } else {
                document.querySelector('#password').classList.remove('error');
                delete this.errors.password;
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.slide-bottom-enter-active {
    transition: all .3s ease;
}

.slide-bottom-leave-active{
    transform: translateY(-50px);
    transition: all .5s;
}

.slide-bottom-enter-from, .slide-bottom-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}

fieldset {
    margin: 10px auto 20px;

    display: flex;
    justify-content: space-around;
    flex-flow: row wrap;

    .form-input {
        width:100%
    }

    p {
        flex-basis: 100%;
    }
}

.form-input {
    padding: 10px;
}

button {
    margin: 20px;
}
input {
    @include input-field
}

.error {
    @include input-field-invalid
}
@include tablet {
    fieldset .form-input {
        width:50%;
    }
}

</style>
