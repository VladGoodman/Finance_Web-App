<script>
import { Doughnut } from 'vue-chartjs'

export default {
  props: ['info'],
  extends: Doughnut,
  async mounted(){
    this.setup()
  },
  methods: {
    setup(){
      console.log(this.info)
      this.renderChart({
        type: 'doughnut',
        labels: this.info.labels,
        datasets: [{
          label: 'My First Dataset',
          data: this.info.data,
          backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(0, 0, 86)',
          ],
          borderWidth: 0,
          hoverOffset: 20,
        }],
      },
          {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 80,
            legend: {
              labels: {
                fontColor: '#2C2C2C',
                fontSize: 20
              }
            }
          })
    },
    getRandomInt () {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 5
    }
  }

}
</script>

<style scoped="scoped">
  *{
    color: white;
  }
</style>
