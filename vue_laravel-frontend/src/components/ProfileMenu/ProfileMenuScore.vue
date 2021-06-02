<template>
  <div class="container__score">
    Счет: {{formatted}}
  </div>
</template>

<script>
export default {
  name: "ProfileMenuScore",
  data(){
    return{
      score: 0
    }
  },
  computed:{
    formatted() {
      return this.score.replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1.') + " ₽";
    },
  },
  created() {
    this.getScoreInStore()
  },
  methods:{
    getScoreInStore(){
      this.score = this.$store.getters.user_sum_change
    }
  }
}
</script>

<style scoped>
  .container__score{
    margin-right: 10px;
    font-size: 20px;
    font-weight: normal;
  }

</style>
