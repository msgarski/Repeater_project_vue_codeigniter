<template>

        <div>
            <h3>Opcje główne</h3>
            <!-- <p>imie: {{imie}}</p> -->
        </div>
        <div class="container">
            <div class="title">
                <h3>Opcje główne</h3>
                <!-- <p>imie: {{imie}}</p> -->
            </div>
            <form @submit.prevent="addChanges" class="form">
                <div class="label">
                    <label for="learningBatchLimit">Limit słów do nauki w jednej serii</label>
                    <select name="learningBatchLimit" v-model="learningBatchLimit" id="learningBatchLimit">
                            <option v-for="limit in learningAmountBatch"
                                :key="limit.id" 
                                :learningLimit="limit.value">{{limit}}
                            </option>
                    </select>
                </div>

                <div class="label">
                    <label for="learningLimit">Limit słów do nauki dziennej</label>
                    <select name="learningLimit" v-model="learningLimit" id="learningLimit">
                        <option v-for="limit in learningLimitsTable"
                            :key="limit.id" 
                            :learningLimit="limit.value">{{limit}}
                        </option>
                    </select>
                </div>  

                <div class="label">
                    <label for="repeatLimit">Limit powtórek do przeprowadzenia dziennie</label>
                    <select name="repeatLimit" v-model="repeatLimit" id="repeatLimit" class="input">
                            <option v-for="limit in repeatLimitsTable"
                                :key="limit.id" 
                                :learningLimit="limit.value">{{limit}}
                            </option>
                    </select>
                </div>
                <div class="label">
                    <label for="overlearning" >Przeuczenie w fazie nauki</label>
                    <input type="checkbox" v-model="overlearning" id="overlearning" name="overlearning">
                </div>

                <div class="label">
                    <label for="overlearning" >Odpytywanie odwrotne</label>
                    <input type="checkbox" id="overlearning" >
                </div>

                <div class="btn">
                    <button class="button">Zatwierdź zmiany</button>
                </div>
                      
            </form>
            <div class="btn">
                <button @click="backToPrevious" class="button-1">Anuluj</button>
            </div>
        </div>
        
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    name: 'MainOptions',
    data(){
        return {
            learningLimitsTable :   [5, 10, 20, 40, 60, 80, 100, 150, 200],
            learningAmountBatch :   [5, 10, 15, 20, 25, 30, 35, 40],
            repeatLimitsTable   :   [20, 30, 40, 50, 60, 70, 80, 90, 100,
                                    150, 200, 250, 300, 350, 400, 450, 500],
            learningLimit       :   '',
            learningBatchLimit  :   '',
            repeatLimit         :   '',
            overlearning        :   true,
            imie: '' // to na próbę
        };
    },
    setup() {
        
    }, //! w created trzeba pobrać limity ze store'a i wpisać do zmiennych w data
    created() {
            this.learningLimit = this.$store.getters['option/getLearningDayLimit'];
            this.learningBatchLimit = this.$store.getters['option/getLearningBatchLimit'];
            this.repeatLimit = this.$store.getters['option/getRepeatDayLimit'];
            this.overlearning = this.$store.getters['option/getOverlearning'];

            this.imie = this.$store.getters['option/getUserName'];
    },
    methods: {
        backToPrevious: function(event){
            this.$router.go(-1);
        },
        addChanges(){
            const pack = {
                learningBatch   :   this.learningBatchLimit,
                learningLim     :   this.learningLimit,
                repeatLim       :   this.repeatLimit, 
                overlearn       :   this.overlearning,
                expires_in      :   null,
                userId         :   this.$store.getters.getUserId,
                token           :   localStorage.getItem('token')
            }
            console.log('user id:', pack.userId)
            http.post('/options/updateOptions', pack)
                .then(response=>{
                    console.log('odpowiedź serwera: ', response.data);
                })
                .then(()=>{
                    // ustawienie nowych wartości w storze:
                    this.$store.dispatch('option/setLearningBatchLimit', pack.learningBatch);
                    this.$store.dispatch('option/setLearningDayLimit', pack.learningLim);
                    this.$store.dispatch('option/setOverlearning', pack.overlearn);
                    this.$store.dispatch('option/setRepeatDayLimit', pack.repeatLim);
                    //console.log('sklepik: ', this.$store);
                    this.$router.push('/mainscreen');
                })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
                });
        }
        
    }
}
</script>

<style scoped>
    .container {
    position: absolute;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 5px 5px 5px 5px grey;
    width: 80%;
    margin-top: 95px;
    margin-left: 10%;
    margin-right: 100px;
}
.button-container {
    position: relative;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 5px 5px 5px 5px grey;
    width: 80%;
    margin-top: 110px;
    margin-left: 10%;
    margin-right: 100px;
}
.title {
    margin-top: 0px;
    position: relative;
    text-align: center;
    color: gray;
    font-weight: bold;
    font-size: 25px;
    margin-left: 10px;
    margin-top: 20px;
    }
.form {
    padding-top: 40px;
    padding-bottom: 40px;
    padding-left: 25%;
    padding-right: 30%;
    }
label {
    display: block;
    font-size: 16px;
    font-style: italic;
    padding-top: 7px;
    }
.label {
    display: flex;
    justify-content:space-between;
    height: 30px;
}
.select {
    width: 10%;
    padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 5px;
}
textarea {
    width: 50%;
    padding: 12px 20px;
    border-width: 2px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 5px;
}
#genre {
    width: 30%;
    padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 5px;

  border-width: 2px;
}
.button {
background-color: #ffae00; /* Green */
font-weight: bold;
border: none;
color: white;
text-align: center;
text-decoration: none;
font-size: 14px;
width: 30%;
height: 40px;
border-radius: 20px;
margin-left: 40%;
}
.button-1 {
background-color: #718bff; /* Green */
font-weight: bold;
margin-left: 100px;
border: none;
color: white;
text-align: center;
text-decoration: none;
font-size: 14px;
height: 40px;
border-radius: 20px;
width: 80px;
margin-left: 46%;

}
.btn {
    width: 100%;
    float: left;
    padding: 20px;
}

a {
    color: white;
}
</style>