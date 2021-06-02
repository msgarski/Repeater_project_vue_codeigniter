<template>
    <h3>Słów do nauki dzisiaj: {{ listLength }}</h3>
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

export default {
    name: 'learn-present',
    components: {
        'normal-scale'  :   NormalScale
    },
    data() {
        return {
            wordsList           :   '',
            index               :   0,
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
    methods: {
        whatNote(nota){
            alert(nota);
            switch(nota)
            {
                case 1:
                    console.log(1);
                    this.easyNoting();
                    this.nextCard();
                    break;
                case 2:
                    console.log(2);
                    break;
                case 3:
                    console.log(3);
                    break;
            }
        },
        nextCard(){
            if(this.index < this.listLength)
            {
                this.index += 1;
            }
            else{
                //todo dezaktywacja przycisku
            }
        },
        easyNoting(){
            console.log('data: ', this.$store.getters.getTodayDate)
            this.wordsList[this.index]['learned_at'] = this.$store.getters.getTodayDate;
            console.log('this.wordsList[this.index][learned_at]', this.wordsList[this.index]['learned_at'])
                //setting today as last repeat:
            this.wordsList[this.index]['last_repeat'] = this.$store.getters.getTodayDate;
            console.log('this.wordsList[this.index][last_repeat]', this.wordsList[this.index]['last_repeat'])

                // ustawienie powtórki za 5 dni
            this.wordsList[this.index]['next_repeat'] =
                                this.$store.getters.getTodayDate +
                                this.$store.getters.getPeriodforEasyWord;
                                
            console.log('this.wordsList[this.index][next_repeat]', this.wordsList[this.index]['next_repeat'])

            // todo zapisać hasło z tabeli do bazy danych
                // delete easy word from wordsList: 
            //this.wordsList.splice(this.index,1);
            //this.loopIterator += 1;
            this.successes += 1;
            console.log('sukces')
        },


        confirm(){
            this.confirmation = true;
            // increase number of tries of card:
            // todo do sprawdzenia:
            if(this.wordsList[this.index]['learned_at'] == null)
            {
                this.wordsList[this.index]['tries'] += 1;
            }
        },
        wordPresent(){
            this.question = this.wordsList[this.index]['question'];
            this.answer = this.wordsList[this.index]['answer'];
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

        //             //todo zapisać gdzieś usyskaną odpowiedź
        //             // Service of EASY WORD:
        //             if(answer == easy)
        //             {
        //                 // tie today date to this learning:
        //                 this.wordsList[this.index]['learned_at'] = this.$store.getters.getTodayDate;
        //                 //setting today as last repeat:
        //                 this.wordsList[this.index]['last_repeat'] = this.$store.getters.getTodayDate;
        //                 // ustawienie powtórki za 5 dni
        //                 this.wordsList[this.index]['next_repeat'] =
        //                                     this.$store.getters.getTodayDate +
        //                                     this.$store.getters.getPeriodforEasyWord;
        //                                                          //! czy powstaje dobra data???
        //                 // todo zapisać hasło z tabeli do bazy danych

        //                 // delete easy word from wordsList: 
        //                 this.wordsList.splice(this.index,1);

        //                 this.loopIterator += 1;
        //                 this.successes += 1;
        //             }
        //             else if (answer == know)
        //             {
                        
        //             }
        //             else
        //             {
                        
        //             }
                    
        //             if(answer == know)
        //             {
        //                 //todo osobna funkcja tu się nada
        //             }
        //             else
        //             {
        //                 if(this.wordsList[this.index]['tries']<=10) //! tu na sztywno ustawiony ogranicznik 
        //                 {
        //                     //todo ustawienie: słowo trudne
        //                     // zapis do bazy
        //                     // todo wyskoczyć z warunku do toku po answer == easy
        //                 }
        //             }                   
        //         }
        //     }
        // }

    },
    created(){
        console.log('kreowanie....');
        //todo przemieszać listę do nauki:
        this.wordsList = this.$store.getters['learning/getBatchForLearning'];
        this.question = this.wordsList[this.index]['question'];
        this.listLength = this.$store.getters['learning/getBatchForLearning'].length;
    }
}
</script>