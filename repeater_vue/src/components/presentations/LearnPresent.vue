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
        <normal-scale v-if="confirmation" @note-level="whatNote" ></normal-scale>
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
            wordsList           :   '',
            index               :   0,
            wordBaseId          :   null,
            question            :   '',
            answer              :   this.$store.getters['learning/getBatchForLearning'][0]['answer'],
            listLength          :   this.$store.getters['learning/getBatchForLearning'].length,
            overlearningAmount  :   0,
            successes           :   0,
            loopIterator        :   1,
            endLearning         :   false,
            confirmation        :   false
        };
    },
    watch: {
        index(){
            this.wordPresent();
            this.confirmation = false;
        }
    },
    created(){
        console.log('kreowanie....');
        //todo przemieszać listę do nauki:
        this.wordsList = this.$store.getters['learning/getBatchForLearning'];
        this.question = this.wordsList[this.index]['question'];
        this.listLength = this.$store.getters['learning/getBatchForLearning'].length;
    },
    methods: {
        whatNote(nota){
            switch(nota)
            {
                case 1: // Easy card
                    this.easyNoting();
                    this.afterEasyCard();
                    break;
                case 2: // Unknown card
                    console.log(2);
                    this.unknownNoting();
                    break;
                case 3: // Well known card
                    console.log(3);
                    break;
            }
        },
        unknownNoting(){
            if(this.wordsList[this.index]['tries'] >= this.$store.getters['getMaxNumTries'])
            {// we have difficult card!!!
                    // set difficulty flag:
                this.wordsList[this.index]['awkward'] = true;

                    //todo save card in db:

                    // update store state:
                this.$store.dispatch('learning/setBatchForLearning', this.wordsList);

                    // card is awkward and should be removed from the list:
                this.wordsList.splice(this.index,1);
                this.listLength -= 1;

                this.wordPresent();
                this.confirmation = false;
            }
        },
        afterEasyCard(){
            if(this.index < this.listLength)// todo czy ten warunek jest potrzebny???
            {
                // todo zapisać słowo do db

                this.wordsList.splice(this.index,1);
                this.listLength -= 1;
                // remains to update source table in store, 
                // to avoid reseting table after accidentally back&forwading page:
                this.$store.dispatch('learning/setBatchForLearning', this.wordsList);

                console.log('widok sklepu z presentacji: ', this.$store);
            }
            this.wordPresent();
            this.confirmation = false;
        },
        easyNoting(){
            this.wordsList[this.index]['learned_at'] = date.getToday();
                console.log('this.wordsList[this.index][learned_at]', this.wordsList[this.index]['learned_at'])
                //setting today's date as last repeat date:
            this.wordsList[this.index]['last_repeat'] = date.getToday();
                console.log('this.wordsList[this.index][last_repeat]', this.wordsList[this.index]['last_repeat'])
                // ustawienie powtórki za 5 dni
            this.wordsList[this.index]['next_repeat'] = 
                                date.getDatePlusDays(this.$store.getters['getPeriodForEasyWord']);                
                console.log('this.wordsList[this.index][next_repeat]', this.wordsList[this.index]['next_repeat'])

            // todo zapisać dane karty z tabeli do bazy danych

            this.successes += 1;
        },
        confirm(){
            this.confirmation = true;
            // increase number of tries of card:
            // todo do sprawdzenia:
            if(this.wordsList[this.index]['learned_at'] == null)
            {
                // Increasing number of tries:
                this.wordsList[this.index]['tries'] += 1;
            }
        },
        wordPresent(){
            this.question = this.wordsList[this.index]['question'];
            this.answer = this.wordsList[this.index]['answer'];
        },
        sendDataToCardInDb(pack){
        http.post('learning/updateCard/' + this.wordBaseId, pack)
            .then((result) => {
                console.log('odpowiedź po próbie updatu karty', result)
            })
            .catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });
        }
        //loopLearning(){
        //     while(this.listLength)
        //     {
        //         // ! początek
        //         while(this.loopIterator == this.listLength)
        //         {
        //             if((this.successes == this.listLength)&&(this.overlearningAmount == 0))
        //             {
        //                 //todo przejście do fazy podsumowania
        //                 return true;
        //             }
        //             else
        //             {
        //                 //todo mieszanie pozostałej listy - ale jakiej pozostałej?
        //                 this.loopIterator = 0;
        //             }
        //         }
        //         // czy hasło było uczone i już nie podlega overlearningowi?:
        //         if((this.wordsList[this.index]['learned_at'] == true)&&(!this.wordsList[this.index]['overlearning']))
        //         {
        //             this.loopIterator += 1;
        //             //todo zaczynamy całą funkcję od początku....
        //             continue;
        //         }
        //         else 
        //         {
        //             // więc nie było nauczone, lub jest na overlearningu:
        //             // todo uruchomienie prezentacji question 
        //             // todo potwierdzić
        //             // todo uruchomienie prezentacji answer

        //             if(this.wordsList[this.index]['learned_at'] != true)
        //             {
        //                 // jeśli doopiero się uczy, to liczba prób wzrasta...
        //                 this.wordsList[this.index]['tries'] += 1;
        //             }

        //             if(this.wordsList[this.index]['tries'] == 1)
        //             {
        //                 // jeśli jest to pierwsze podejście do hasła, to 3 stopnie oceny
        //                 //todo pokazać skalę ocen z Łatwym włącznie
        //             }
        //             else
        //             {
        //                 // to nie jest pierwsze czytanie, więc tylko 2 stopnie oceny:
        //                 //todo pokazać 2 stopnie oceny...
        //             }

        //             //todo zapisać gdzieś usyskaną     
        //         }
        //     }
        // }

    }
    
}
</script>