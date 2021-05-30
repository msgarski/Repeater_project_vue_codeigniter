<template>

        <div>
            <h3>Opcje główne</h3>
        </div>
        
        <form @submit.prevent="addChanges">
            <div>
                <label for="learningBatchLimit">Limit słów do nauki w jednej serii</label>
                <select name="learningBatchLimit" v-model="learningBatchLimit" id="learningBatchLimit">
                        <option v-for="limit in learningAmountBatch"
                            :key="limit.id" 
                            :learningLimit="limit.value">{{limit}}
                        </option>
                </select>
            </div>
            <div>
                <label for="learningLimit">Limit słów do nauki dziennej</label>
                <select name="learningLimit" v-model="learningLimit" id="learningLimit">
                        <option v-for="limit in learningLimitsTable"
                            :key="limit.id" 
                            :learningLimit="limit.value">{{limit}}
                        </option>
                </select>
            </div>  
            <div>
                <label for="repeatLimit">Limit powtórek do przeprowadzenia dziennie</label>
                <select name="repeatLimit" v-model="repeatLimit" id="repeatLimit">
                        <option v-for="limit in repeatLimitsTable"
                            :key="limit.id" 
                            :learningLimit="limit.value">{{limit}}
                        </option>
                </select>
            </div>
            <div>
                <label for="overlearning" >Przeuczenie w fazie nauki</label>
                <input type="checkbox" v-model="overlearning" id="overlearning" name="overlearning">
            </div>
            <button>Zatwierdź zmiany</button>      
        </form>
    <div>
        <button @click="backToPrevious">Powrót bez zatwierdzania zmian</button>
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
            learningLimit       :   '20',
            learningBatchLimit  :   '20',
            repeatLimit         :   '30',
            overlearning        :   false
        };
    },
    setup() {
        
    }, //! w created trzeba pobrać limity ze store'a i wpisać do zmiennych w data
    methods: {
        backToPrevious: function(event){
            this.$router.go(-1);
        },
        addChanges(){
            const pack = {
                learningDay :   this.learningBatchLimit,
                learningLim :   this.learningLimit,
                repeatLim   :   this.repeatLimit, 
                overlearn   :   this.overlearning,
                expires_in  :   null,
                user_id     :   this.$store.getters.getUserId,
                token       :   localStorage.getItem('token')
            }
            console.log('user id:', pack.user_id)
            //! limity powinny być od razu zmienione w storze
            http.post('/course/createCourse', pack)
                .then(response=>{
                    console.log('odpowiedź serwera: ', response);
                })
                .then(()=>{
                    this.$router.push('/mainscreen')
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

</style>