<template>
  <div class="container">
    <div class="body">
      2021 JAN
    </div>
    <div class="btn">
      >
    </div>
  </div>
</template>

<script>
export default {
  name: 'TimeSwap'
}
</script>

<style lang="scss" scoped>
.container {
  background: #40467C;
  width: 200px;
  height: 40px;
  border-radius: 40px;
  color: white;
  position: relative;
  .body{
    padding: 5px 20px;
    white-space: nowrap;
    display: flex;
    align-items: center;
  }
  .btn {
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 0;
    right: 0;
    width: 40px;
    height: 40px;
    border-radius: 40px;
    background: #42b983;
  }
}

</style>
