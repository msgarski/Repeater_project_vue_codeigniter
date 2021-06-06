<template>
<div>
    <h3>Słów do nauki dzisiaj: {{ listLength }}</h3>
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
        <normal-scale v-if="confirmation" @note-level="whatNote"></normal-scale>
    </div>
</template>

<script>
import NormalScale from './NormalScale';
import date from '../../functions/time/dates.js'
import http from '../../plugins/axios.js';


export default {
    name: 'learn-present',
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
            listLength          :   this.$store.getters['learning/getBatchForLearning'].length,
            overlearningAmount  :   0,
            successes           :   0,
            awkwards            :   0,
            easyWords           :   0,
            loopIterator        :   1,
            endLearning         :   false,
            confirmation        :   false,
            summaryPhaseReadiness    :   false,
            bottomLine          :   false  // gives info about entirety of recent learning phase
        };
    },
    watch: {
        index(){
            if(this.index < this.listLength)
            {
                this.newWordPresentation();
                this.confirmation = false;
            }
            else
            {

                console.log('przekroczenie indeksu!!!', this.index, this.listLength)
                this.$store.dispatch('learning/increaseLoopNumber');
                console.log('loop number: ', this.$store.getters['learning/getLoopNumber'])
                //this.index = 0;
                this.newWordPresentation();
            }
        },
        listLength(){
            if(this.listLength == 0)
            {
                this.bottomLine = true;
                console.log('Nie ma nic do przeglądania już')
            }
        }
    },
    created(){
        console.log('kreowanie....');
        //todo przemieszać listę do nauki:
        this.wordsList = this.$store.getters['learning/getBatchForLearning'];
        this.listLength = this.$store.getters['learning/getBatchForLearning'].length;

        this.index = this.$store.getters['learning/getIndex'];
        //this.endLearning = this.$store.getters['learning/getEndLearning'];

        this.newWordPresentation(); // ta funkcja, albo to poniżej:
        // this.question = this.$store.getters['learning/getBatchForLearning'][this.index]['question']
        // this.answer = this.$store.getters['learning/getBatchForLearning'][this.index]['answer']
    },
    methods: {
        whatNote(nota){
            switch(nota)
            {
                case 1: // Easy card
                    this.ocena = 1;
                    this.easyNoting();
                    this.updateDataCardInDb(this.wordsList[this.index]);
                    this.afterEndCard();
                    break;
                case 2: // Unknown card
                    this.ocena = 2
                    this.unknownNoting();
                    break;
                case 3: // Well known card
                    this.ocena = 3;
                    console.log('czy jest overlearning? ', this.$store.getters['option/getLearningDayLimit'])
                    this.knownNoting();
                    break;
            }
        },
        knownNoting(){
            console.log('w funkcji : knownNoting')
            if(this.wordsList[this.index]['learned_at'])
            {
                // już nauczone słowo, ale chyba podsumowanie lub overlearning
                if(this.wordsList[this.index]['overlearningAmount'])
                {
                    if(!this.wordsList[this.index]['overlearning'])
                    {
                        this.wordsList[this.index]['overlearning'] == true;
                    }
                    this.wordsList[this.index]['overlearningAmount'] -= 1;
                    if(this.wordsList[this.index]['overlearningAmount'] == 0)
                    {
                        if(this.overlearningAmount)
                        {
                            this.overlearningAmount -= 1;
                        }
                    }
                }
            }
            else
            {
                console.log('umiem nieznane słowo!!!')
                this.wordsList[this.index]['learned_at'] = date.getToday();
                this.wordsList[this.index]['summary'] = false;
                this.successes += 1;

                console.log('czy jest overlearning? ', this.$store.getters['option/getOverlearning'])

                if(this.$store.getters['option/getOverlearning'])
                {
                        // Overlearning is On...
                        // computing amount of demanded overlearning:
                    console.log('Obliczanie ocerlearningu wszystkie próby:', this.wordsList[this.index]['tries'])

                    console.log('Obliczanie ocerlearningu', Math.floor(this.wordsList[this.index]['tries']/2))
                    let amount = Math.floor(this.wordsList[this.index]['tries']/2);

                    this.wordsList[this.index].overlearningAmount = amount;

                    if(this.wordsList[this.index]['overlearningAmount'] != 0)
                    {
                        this.overlearningAmount += 1;
                    }
                } 
            }
            this.setTenMinsRepetition();
            this.updateDataCardInDb(this.wordsList[this.index]);
            this.index += 1;
        },
        setTenMinsRepetition(){
                // set repetition in 10 minutes
            this.wordsList[this.index]['next_repeat'] = 
                                date.getDatePlusMinutes(10);   

            console.log('this.wordsList[this.index][next_repeat]', this.wordsList[this.index]['next_repeat'])
        },
        unknownNoting(){
            console.log('Czy jestem w nieznanym słowie ?')

            if(this.wordsList[this.index]['tries'] >= this.$store.getters['getMaxNumTries'])
            {
                    // we have difficult card!!!
                this.wordsList[this.index]['tries'] = 0;
                    // set difficulty flag:
                this.wordsList[this.index]['awkward'] = 1;
                this.awkwards += 1;
                console.log('awkward: ', this.wordsList[this.index]['awkward'])
                    //save card in db:
                this.updateDataCardInDb(this.wordsList[this.index]);
                this.afterEndCard();
            }
            else
            {
                console.log('jestem w nieznanym słowie')

                this.index += 1; // todo czy watcher tego pilnuje?
            }
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

                // console.log('widok sklepu z prezentacji: ', this.$store);
            }
            this.newWordPresentation();
            this.confirmation = false;
        },
        easyNoting(){
                // When is learned:
            this.wordsList[this.index]['learned_at'] = date.getToday();
                console.log('this.wordsList[this.index][learned_at]', this.wordsList[this.index]['learned_at'])
                //setting today's date as last repeat date:
            this.wordsList[this.index]['last_repeat'] = date.getToday();
                console.log('this.wordsList[this.index][last_repeat]', this.wordsList[this.index]['last_repeat'])
                // ustawienie powtórki za 5 dni
            this.wordsList[this.index]['next_repeat'] = 
                                date.getDatePlusDays(this.$store.getters['getPeriodForEasyWord']);                
                console.log('this.wordsList[this.index][next_repeat]', this.wordsList[this.index]['next_repeat'])
            this.easyWords += 1;
        },
        confirm(){
            this.confirmation = true;
            // increase number of tries of card:
            // todo do sprawdzenia:  bo to unika wzrostu tries dla overlearningu i podsumowania
            if(this.wordsList[this.index]['learned_at'] == null)
            {
                // Increasing number of tries:
                this.wordsList[this.index]['tries'] += 1;
                this.$store.dispatch('learning/setIndex', this.index);
                console.log('nowy index w storze: ', this.$store.getters['learning/getIndex']);
            }
            // todo czy coś robimy gdy w overlearningu?
        },
        newWordPresentation(){
            if(this.index == this.listLength)
            {
                if((this.successes == this.listLength)&&(this.overlearningAmount == 0))
                {
                    //todo przejście do fazy podsumowania
                    console.log('wygląd stora po nauce: ', this.$store)
                    this.endLearning = true;
                    this.$store.dispatch('learning/setEndLearning', true);
                    this.$store.dispatch('learning/setIndex', 0);

                    alert('przechodź do podsumowania');
                    //this.$router.push('')
                    // todo mixowanie tablicy
                    
                    return true;
                }
                else
                {
                    //todo mieszanie pozostałej listy - ale jakiej pozostałej?
                    alert('mixowanie tablicy i od nowa')
                    this.index = 0;
                    // todo czy na storze też się uaktualnia?
                }
            }
            else
            {
                if((this.wordsList[this.index]['learned_at'])&&(!this.wordsList[this.index]['overlearningAmount']))
                {
                    //todo zaczynamy całą funkcję od początku....
                    this.index += 1;
                }
                else
                {
                    this.synchronization();
                } 
            }
        },
        synchronization(){
            this.question = this.wordsList[this.index]['question'];
            this.answer = this.wordsList[this.index]['answer'];
            this.wordIdInDataBase = this.wordsList[this.index]['card_id'];
        },
        updateDataCardInDb(row){
        http.post('learning/updateCard/' + this.wordIdInDataBase, row)
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