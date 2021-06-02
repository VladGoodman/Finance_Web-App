<script>
import { Line } from 'vue-chartjs'

export default {
  props: ['info'],
  extends: Line,
  async mounted(){
    this.setup()
  },
  methods: {
    setup(){
      console.log(this.info.data)
      this.renderChart({
        labels: this.info.labels.map((el) =>{
          let month=[
            'Января',
            'Февраля',
            'Марта',
            'Апреля',
            'Мая',
            'Июня',
            'Июля',
            'Августа',
            'Сентября',
            'Ноября',
            'Декабря',
          ];
          return new Date(el).getDate() + " " + month[new Date(el).getUTCMonth()]
        }),
        datasets: [
          {
            label: 'Затраты',
            backgroundColor: '#F86B4F',
            data: this.info.data.costs,
          }, {
            label: 'Пополнения',
            backgroundColor: '#364A62',
            data: this.info.data.income
          }
        ],
      },
          {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              labels: {
                fontColor: '#2C2C2C',
                fontSize: 20
              },
            },
            scales: {
              yAxes: [{
                ticks: {
                  fontColor: "2C2C2C",
                  fontSize: 18,
                }
              }],
              xAxes: [{
                ticks: {
                  fontColor: "2C2C2C",
                  fontSize: 16,
                }
              }]
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
    color: #4E4E50 !important;
  }
</style>
