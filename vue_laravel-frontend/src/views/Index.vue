<template>
  <div class="container">
    <div class="header">
      <a href="">Index</a>
      <a href="">News</a>
    </div>
    <div class="body">
      <div class="body-image">
          <div class="img"></div>
      </div>
      <div class="body-title">
          <div class="body-title__text">
            Applications for keeping track
            of your finances
          </div>
        <div class="body-title__link">
          <router-link to="/auth">start now</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Index'
}
</script>



