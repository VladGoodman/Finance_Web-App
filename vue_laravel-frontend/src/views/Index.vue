<template>
  <div class="index">
    <div class="index__header">
      <div class="index__container">
        <div class="index__header-name">
          <router-link to="/">Finanser</router-link>
        </div>
      </div>
    </div>
    <div class="index__container">
      <div class="body">
        <div class="body-image">
          <img class="img" src="../assets/icons/dollar.png">
        </div>
        <div class="body-title">
          <div class="body-title__text">
            Applications for keeping track
            of your finances
          </div>
          <router-link class="body-title__link" to="/auth">start now</router-link>
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

<style scoped="scoped">
  .index{
    width: 100%;
    min-height: 700px;
    height: 100%;
    background: linear-gradient(117.91deg, #313D99 0%, #5D3C87 100%);
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
  }
  .index__container{
    max-width: 1440px;
    margin: 0 auto;
  }
  .index__header-name{
    width: 100%;
  }
  .index__header-name a{
    color: white;
  }
  .index__header{
    padding-top: 20px;
  }

  .img{
    width: 100%;
    max-width: 400px;
    height: auto;
  }
  .body{
    display: flex;
    justify-content: space-between;
  }
  .body-title{
    flex-grow: 1.35;
    padding: 0 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  .body-title__text{
    color: white;
  }
  .body-title__link{
    background: #17D5FF;
    padding: 10px 38px;
    border-radius: 68px;
    color: white;
    text-transform: uppercase;
    font-weight: bold;
  }
  .body-title__text{
    font-size: 48px;
    color: white;
    margin-bottom: 100px;
    text-align: center;
  }
</style>



