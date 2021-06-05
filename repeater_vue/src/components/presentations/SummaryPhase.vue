<template>
<div>
    <h3>Słów do podsumowania: {{ listLength }}</h3>
</div>
<div>
    <h3></h3>
</div>
    
    <div>
        <h2>{{index}}</h2>
        <h1>{{ question }}</h1>
    </div>
    <div v-show="confirmation">
        <h1>{{ answer }}</h1>
    </div>
    <div v-if="!confirmation">
        <button @click.prevent="confirm">Pokaż</button>
    </div>
    <div >
        <normal-scale v-if="confirmation" @note-level="whatNote" :summary="endLearning"></normal-scale>
    </div>
</template>

<script>
import NormalScale from './NormalScale';
import date from '../../functions/time/dates.js'
import http from '../../plugins/axios.js';


export default {
    name: 'summary-phase',
    components: {
        'normal-scale'  :   NormalScale
    },
    data() {
        return {
            ocena               :   null,
            wordsList           :   '',
            index               :   0,
            wordIdInDataBase    :   '', //this.$store.getters['learning/getBatchForLearning'][0]['card_id'],
            question            :   '',
            answer              :   '',
            listLength          :   null,
            successes           :   0,  // todo
            awkwards            :   0,
            easyWords           :   0,  // todo
            endLearning         :   true,  //todo
            confirmation        :   false,  
            bottomLine          :   false  // todo gives info about entirety of recent learning phase
        };
    },
    watch: {
        index(){
            if(this.index < this.listLength)
            {
                this.$store.dispatch('learning/setIndex', this.index);
                this.confirmation = false;
                this.newWordPresentation();
            }
            else
            {
                // End of summary phase:
                this.bottomLine = true;
                alert('Kończymy fazę posumowania');
                this.$router.go(-1);
            }
        },
        listLength(){
            if(this.listLength == 0)
            {
                this.bottomLine = true;
            }
        }
    },
    created(){
        console.log('kreowanie....');

        this.wordsList = this.$store.getters['learning/getBatchForLearning'];
        this.listLength = this.$store.getters['learning/getBatchForLearning'].length;

        this.index = this.$store.getters['learning/getIndex'];

        this.newWordPresentation();
    },
    methods: {
        whatNote(nota){
            switch(nota)
            {
                case 2: // Unknown card
                    this.ocena = 2
                    this.unknownNoting();
                    break;
                case 3: // Well known card
                    this.ocena = 3;
                    this.knownNoting();
                    break;
            }
        },
        knownNoting(){
            console.log('w funkcji : knownNoting')
            
                //this.wordsList[this.index]['learned_at'] = date.getToday();
                this.wordsList[this.index]['summary'] = true;            

            this.setTenMinsRepetition();

            this.updateDataCardInDb(this.wordsList[this.index]);

            this.index += 1;

        },
        setTenMinsRepetition(){
                // set repetition in 10 minutes
            this.wordsList[this.index]['next_repeat'] = 
                                date.getDatePlusMinutes(10);   
        },
        unknownNoting(){
            
                this.wordsList[this.index]['awkward'] = 1;

                    //save card in db:
                this.updateDataCardInDb(this.wordsList[this.index]);
            
                this.index += 1;
            
        },
        afterEndCard(){
            if(this.index < this.listLength)// todo czy ten warunek jest potrzebny???
            {
                    // card is awkward or easy, so should be removed from the list:
                this.wordsList.splice(this.index,1);
                this.listLength -= 1;
                // remains to update source table in store, 
                // to avoid reseting table after accidentally back&forwading page:
                this.$store.dispatch('learning/setBatchForLearning', this.wordsList);

            }
            this.newWordPresentation();

            this.confirmation = false;
        },
        confirm(){
            this.confirmation = true;
                this.$store.dispatch('learning/setIndex', this.index);
                console.log('nowy index w storze: ', this.$store.getters['learning/getIndex']);
        },
        newWordPresentation(){ 
                    // todo mixowanie tablicy
                    //this.index = 0;
                    this.synchronization();
                    return true;
        },
        synchronization(){
            this.question = this.wordsList[this.index]['question'];
            this.answer = this.wordsList[this.index]['answer'];
            this.wordIdInDataBase = this.wordsList[this.index]['card_id'];
        },
        updateDataCardInDb(pack){
        http.post('learning/updateCard/' + this.wordIdInDataBase, pack)
            .then((result) => {
                console.log('odpowiedź po próbie update karty', result.data);
            })
            .then(()=>{
                console.log('Update karty udany!!!!');
            })
            .catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });
        }
    }
}
</script>