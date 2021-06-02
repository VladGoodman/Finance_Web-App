<template>
  <div class="graft-content">
    <b-loading v-model="loading" :can-cancel="false" :is-full-page="false"></b-loading>
    <div class="graft-statistic">
      <div class="graft-statistic__line">
        <div class="statistic__line-title">
          Статистика за всё время
        </div>
        <line-chart class="statistic__line-body"  v-if="!loading" :info="line_graf_info"/>
      </div>
      <div class="graft-statistic__expenses">
        <div class="statistic__expenses-title">
          Пополнения
        </div>
        <pie-chart class="small" v-if="!loading" :info="pie_expenses_graf_info"/>
        <div class="statistic__expenses-sum">
          Всего: {{ formatted_expenses_sum }}
        </div>
      </div>
      <div class="graft-statistic__replenishment">
        <div class="statistic__replenishment-title">
          Затраты
        </div>
        <pie-chart class="small" v-if="!loading" :info="pie_replenishment_graf_info"/>
        <div class="statistic__replenishment-sum">
          Всего: {{ formatted_replenishment_sum }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LineChart from './LineChart'
import PieChart from './PieChart/PieChart'

export default {
  components: {
    LineChart, PieChart
  },
  data(){
    return{
      line_graf_info: {
        data: {
          costs: [],
          income: []
        },
        labels: []
      },
      pie_expenses_graf_info: {
        labels: [],
        data: [],
        sum: 0
      },
      pie_replenishment_graf_info: {
        labels: [],
        data: [],
        sum: 0
      },
      loading: true
    }
  },
  computed:{
    formatted_replenishment_sum() {
      return String(this.pie_replenishment_graf_info.sum).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1.') + " ₽";
    },
    formatted_expenses_sum() {
      return String(this.pie_expenses_graf_info.sum).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1.') + " ₽";
    },
  },
  methods:{
    getContentForChart(){
      this.$store.dispatch('getAccountChanges')
          .then(res => {
            console.log(res)
            this.line_graf_info.data.costs = res.data.map((el)=>{
              if(el.change_id === 1){
                return el.quantity
              }else{
                return 0
              }
            })
            res.data.forEach((el) => {
              if(el.change_id === 2){
                this.pie_expenses_graf_info.sum += el.quantity
                if(!this.pie_expenses_graf_info.labels.includes(el.type_changes)){
                  this.pie_expenses_graf_info.labels.push(el.type_changes)
                  this.pie_expenses_graf_info.data.push(0)
                  let id_for_data = this.pie_expenses_graf_info.labels.indexOf(el.type_changes)
                  this.pie_expenses_graf_info.data[id_for_data] += el.quantity
                }else{
                  let id_for_data = this.pie_expenses_graf_info.labels.indexOf(el.type_changes)
                  this.pie_expenses_graf_info.data[id_for_data] += el.quantity
                }
              }else if( el.change_id === 1 ){
                this.pie_replenishment_graf_info.sum += el.quantity
                if(!this.pie_replenishment_graf_info.labels.includes(el.type_changes)){
                  this.pie_replenishment_graf_info.labels.push(el.type_changes)
                  this.pie_replenishment_graf_info.data.push(0)
                  let id_for_data = this.pie_replenishment_graf_info.labels.indexOf(el.type_changes)
                  this.pie_replenishment_graf_info.data[id_for_data] += el.quantity
                }else{
                  let id_for_data = this.pie_replenishment_graf_info.labels.indexOf(el.type_changes)
                  this.pie_replenishment_graf_info.data[id_for_data] += el.quantity
                }
              }
            })
            this.line_graf_info.data.income = res.data.map((el)=>{
              if(el.change_id === 2){
                return el.quantity
              }else {
                return 0
              }
            })
            this.line_graf_info.labels = res.data.map(el => el.date)
            this.loading = false
          })
          .catch(err => console.log(err))
    }
  },
  created() {
    this.getContentForChart()
  }
}
</script>

<style scoped="scoped">
  .graft-statistic{
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-auto-rows: minmax(500px, 600px);
  }
  .graft-statistic__line{
    grid-column-start: 1;
    grid-column-end: 3;
    grid-row-start: 1;
    grid-row-end: 1;
    margin-bottom: 30px;
  }
  .graft-statistic__line *{
    color: white;
  }
  .graft-content{
    padding: 30px;
  }
  .statistic__line-title{
    background-color: #A8CCEE;
    padding: 30px 30px;
    color: #3F3F3F;
    border-bottom: 4px solid #6E91B2;
    font-weight: normal;
    font-size: 24px;
  }
  .graft-statistic__expenses, .graft-statistic__replenishment{
    text-transform: uppercase;
    font-size: 30px;
    font-weight: bold;
    text-align: center;
    padding-top: 20px;
    margin: 10px 10px 0 10px;
  }

  .statistic__expenses-sum, .statistic__replenishment-sum{
    margin-top: 30px;
  }
  .statistic__line-body{
    padding: 30px;
  }
  .statistic__line-body > *{
    color: #4E4E50 !important;

  }
</style>
