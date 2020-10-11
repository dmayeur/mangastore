<template lang="html">
<transition
    enter-active-class="animated fadeIn"
    v-on:enter="enter"
    leave-active-class="animate__animated animate__fadeOutDown"
>
    <div class="modal-backdrop" role="dialog">
        <transition
            enter-active-class="animated fadeInDown"
        >
            <div class="modal" ref="modal" v-if="isEntering">
                <header class="modal-header">
                    <slot name="header">
                        <h2>
                            This is the default tile!
                        </h2>

                        <button type="button" class="btn-close" @click="close" aria-label="Close modal">
                            <i class="far fa-times-circle"></i>
                        </button>
                     </slot>
                </header>

                <section class="modal-body">
                    <slot name="body">
                    </slot>
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
export default {
    data: function() {
        return {
            isEntering: false
        };
    },
    methods: {
        close() {
            this.isEntering= false;
            this.$emit('close');
        },
        enter() {
            this.isEntering= true;
        }

  }
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
    background: #FFFFFF;
    // box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
  }


  .modal-header{
      display:flex;
      padding:15px;

      background-color: $primary-color;
      color: $primary-color-text;

  }
  .modal-footer {
    padding: 15px;
    display: flex;
  }

  .modal-body {
    position: relative;
    padding: 20px 10px;
  }

  .btn-close {
    border: none;
    font-size: 20px;
    padding: 20px;
    cursor: pointer;
    font-weight: bold;
    background: transparent;
  }

</style>
