<template lang="html">
<transition
    enter-active-class="animated fadeIn faster"
    v-on:enter="enter"
    leave-active-class="animated fadeOut faster"
>
    <div class="modal-backdrop" role="dialog">
        <transition

            enter-active-class="animated fadeInDown faster"
            leave-active-class="animated fadeOutDown faster"
            v-on:after-enter="focus"
        >
            <div class="modal" ref="modal" v-if="isEntering">
                <header class="modal-header">
                    <h2>
                        Se connecter
                    </h2>

                    <button type="button" class="btn-close" @click="close" ref="btnclose">
                        <i class="far fa-times-circle"></i>
                    </button>
                </header>
                <section class="modal-body">
                    <form class="" method="post" @submit.prevent="onLogin">
                        <div class="input-label-container">
                            <label for="email">Votre e-mail ou votre pseudo:</label>
                                <div class="input-container">
                                    <i class="fas fa-at"></i>
                                    <input type="text" name="login" v-model="login" required>
                                </div>
                        </div>
                        <Notice v-if="errorCode==403">
                            Le nom d'utilisateur ou l'adresse mail n'existe pas
                        </Notice>
                        <div class="input-label-container">
                            <label for="password">Votre mot de passe:</label>
                            <div class="input-container">
                                <i class="fas fa-key"></i>
                                <input type="password" name="password" v-model="password" required>
                            </div>
                        </div>
                        <Notice v-if="errorCode==401">
                            Le mot de passe est incorrect
                        </Notice>
                        <router-link to="/inscription" @click="close">Pas de compte? Créer en un.</router-link>
                        <div class='button-container'>
                            <Button type="submit">Connexion</Button>
                        </div>
                        <small>Pour des soucis de test, le compte <strong>Toto</strong> avec le mot de passe <strong>test01</strong> est un compte admin. </small>
                    </form>
                </section>
                <footer class="modal-footer">
                    <slot name="footer">
                    </slot>
                </footer>
            </div>
        </transition>
    </div>
</transition>
</template>

<script>
import Button from '@/components/Button.vue';
import Notice from '@/components/Notice.vue';

export default {
    data: function() {
        return {
            isEntering: false,
            login: "",
            password: "",
            errorCode: false
        };
    },
    components: {
        Button,
        Notice
    },
    methods: {
        close() {
            this.isEntering= false;
            this.$emit('close');
        },

        enter() {
            this.isEntering= true;
        },

        focus() {
            //We put focus on element for accessibility reasons
            this.$refs.btnclose.focus();
        },
        onLogin() {
            this.$store.dispatch('authRequest',{
                login:this.login,
                password: this.password
            }).then( () => {
                //close the window if it's a success
                this.$emit('close');
                this.errorCode="";
            }).catch ((e) => {
                this.errorCode=e.response.status;
            })
        }
    },

}
</script>

<style lang="scss" scoped>
//center the modal vertically and darken screen
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal {
    display: flex;
    flex-direction: column;

    width:90%;

    background: $secondary-color;
    box-shadow: 12px 12px 2px 1px rgba(0, 0, 255, .2);

}

.modal-header{
    display:flex;
    justify-content:space-between;
    padding:15px;

    background-color: $primary-color;
    color: $primary-color-text;

}


.modal-body {
    position: relative;
    width:90%;
    margin: 0 auto;
    padding: 20px 10px;

}

small {
    margin-bottom: 10px;
}

.btn-close {
    padding: 20px;

    color:$primary-color-text;
    border: none;
    font-size: 20px;

    cursor: pointer;
    font-weight: bold;
    background: transparent;
}

.input-label-container {
    margin-bottom:25px;
}

.input-container {
    display:flex;
    margin:0 auto;
    align-content:center;
}

input {
    @include input-field;
}

p {
    margin-bottom:30px;
}

//for the icons next to the inputs
input {
    padding: 5px;
    border:1px solid black;
    border-left:none;
}

.fas {
    padding:5px;
    background-color:$primary-color;
    color:$primary-color-text;
    border:1px solid black;
    border-right:none;
}

.button-container {
    margin: 20px 0;
}

/* ===================================================
                DESKTOPS - 992 PX AND UP
================================================== */
@include desktop {
    .modal {
        width:500px;
    }
}

</style>
