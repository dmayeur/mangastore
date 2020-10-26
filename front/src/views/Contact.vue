<template lang="html">
  <div class="contact">
      <h1>Nous contacter</h1>
      <div class="input-item">
          <label for="reason">La raison de votre contact: </label>
          <input type="text" name="reason" id="reason">
      </div>

      <div class="input-item">
          <label for="content">Contenu: </label>
          <textarea name="name" rows="8" cols="80"></textarea>
      </div>


  </div>
</template>

<script>
export default {
}
</script>

<style lang="scss" scoped>
input {
    @include input-field;
}
</style>
