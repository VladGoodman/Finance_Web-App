<template>
  <div class="converter-container">
    <form class="input-form" v-on:submit.prevent="convert">
      <h1 class="input-form__title">Конвертация валюты</h1>
      <div class="first-input">
        <span>RUB: </span>
        <b-input placeholder="Number"
                 type="number"
                 min="1"
                 v-model="input">
        </b-input>
      </div>
      <button class="btn-converter">
        <img class="btn-image" src="../../assets/icons/down-arrow.svg" alt="">
      </button>
      <div class="second-input">
        <span>Конвертация в валюту:</span>
        <b-select v-model="selected[1]" placeholder="Выбрать валюту" expanded>
          <option
              v-for="item in countries">
            {{item}}
          </option>
        </b-select>
      </div>
      <div class="input-form__result">
        {{result}}
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "Converter",
  data(){
    return{
      converter_data: [],
      result:null,
      selected: ['RUB', 'USD'],
      input: 0,
      countries: []
    }
  },
  created() {
    this.converter_data = this.$store.getters.converter_data
    this.setAllInfo()
  },
  methods:{
    setAllInfo(){
      for(let item in this.converter_data){
        this.countries.push(item)
      }
    },
    convert(){
      let defaultValute = {
        Value: 1,
        Nominal: 1
      };
      let firstValute = this.converter_data[this.selected[0]] ?? defaultValute,
          firstValuteValue = firstValute.Value * Number(this.input),
          firstValuteNominal = firstValute.Nominal;
      let secondValute = this.converter_data[this.selected[1]] ?? defaultValute,
          secondValuteValue = secondValute.Value,
          secondValuteNominal = secondValute.Nominal;
      let result = (firstValuteValue / firstValuteNominal) / (secondValuteValue / secondValuteNominal);
      this.result = result ? Math.floor(result * 10000) / 10000 : null;
    }
  }
}
</script>

<style scoped>
  .converter-container{
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .input-form{
    margin-top: 100px;
    border: 5px solid #242B35;
    background-color: #A8CCEE;
    border-radius: 15px;
    padding: 20px;
    width: 500px;
  }

  .input-form__result{
    margin-top: 10px;
    color: #242B35;
    font-size: 30px;
    border-bottom: 2px solid white;
    width: 100%;
  }
  .btn-image{
    width: 30px;
    border: 3px solid #242B35;
    padding: 10px;
    box-sizing: content-box;
    border-radius: 50%;
    cursor: pointer;
  }
  .btn-converter{
    background: none;
    border: none;
    width: 100%;
    text-align: center;
    margin: 30px 0;
  }
  .btn-image:hover{
    background-color: #242B35;
    transition: background-color .4s ease .2s;

  }
  .btn-converter:active,.btn-converter:focus{
    outline: none;
  }
  .input-form__title{
    color: #3F3F3F;
    text-align: center;
    text-transform: uppercase;
  }
  .second-input > span, .first-input > span{
    display: block;
    color: #3F3F3F;
    font-weight: bold;
    margin-bottom: 10px;
    font-size: 20px;
  }
</style>
