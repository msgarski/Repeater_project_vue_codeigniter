<template>
    <div>Tabela słów w lekcji</div>
    <div>
        <div>
            <label for="search">Wyszukaj</label>
            <input type="search" v-model="filter" id="search">
        </div>
        <table>
            <thead>
                <tr>
                    <th @click="sort('question')">Pytanie</th>
                    <th @click="sort('answer')">Odpowiedź</th>
                    <th @click="sort('next_repeat')">Powtórka</th>
                    <th>Działania</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="card in sortedCards"
                        :key="card.card_id">
                    <td>{{ card.question }}</td>
                    <td>{{ card.answer }}</td>
                    <td>{{ card.next_repeat }}</td>
                    <td>
                        <button @click="deleteCard(card.card_id)">Usuń</button>
                        <button @click="editCard(card.card_id)">Edytuj</button>

                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <button @click="prevPage">Poprzednia</button>
            <button @click="nextPage">Następna</button>
        </div>
    </div>

</template>

<script>
import { relativeTimeThreshold } from 'moment';
import http from '../../plugins/axios.js'

export default {
    name: 'LessonTable',
    props: [
        'lessonId',
    ],
    data() {
        return {
            cards   :   [],
            currSort :   'question',
            currSortDir  :   'asc',
            currPage    :   1,
            pageDim     :   10,
            filter      :   '',
        };
    },
    // watch: {
    //     filter() {
    //         //console.log('reset to p1 due to filter');
    //         this.currPage = 1;
    //     }
    // },
    computed:{
        filteredCards() {
            return this.cards.filter(c => {
                if(this.filter == '') return true;
                return c.question.toLowerCase().indexOf(this.filter.toLowerCase()) >= 0;
            })
        },
        sortedCards:function() {
            return this.filteredCards.slice(0).sort((a,b) => {
                let modifier = 1;
                if(this.currSortDir === 'desc') modifier = -1;
                if(a[this.currSort] < b[this.currSort]) return -1 * modifier;
                if(a[this.currSort] > b[this.currSort]) return 1 * modifier;
                return 0;
            })
            .filter((row, index) => {
                let start = (this.currPage-1)*this.pageDim;
                let end = this.currPage*this.pageDim;
                if(index >= start && index < end) return true;
            });
        }
    },
    created() {
        this.getCardsForLesson();
    },
    methods: {
        deleteCard(cardId){
            console.log('usuń kartę', cardId)
           this.eraseCardFromDatabase(cardId)

        },
        editCard(cardId){
            let currCard = this.cards.find(card=>card.card_id==cardId)
            //console.log('bieżąca karta', currCard)
            this.$store.dispatch('card/setCurrCard', currCard)
            console.log('bież karta  ze stora: ', this.$store.getters['card/getCurrCard'])
            this.$router.push('/editcard/' + cardId)

        },
        sort:function(sortingCol) {
            //if s == current sort, reverse
            if(sortingCol === this.currSort) {
            this.currSortDir = this.currSortDir==='asc'?'desc':'asc';
            }
            this.currSort = sortingCol;
        },
        prevPage:function() {
            if(this.currPage > 1) this.currPage--;
        },
        nextPage:function() {
            if((this.currPage*this.pageDim) < this.cards.length) this.currPage++;
        },
        backToPrevious: function(event){
            this.$router.go(-1);
        },
        getCardsForLesson(){
            http.get('cards/fillLessonTable/' + this.lessonId)
            .then((result) => {
                this.cards = result.data;
                console.log('widok słów do lekcji z http: ', this.cards[0].answer);
            })
            .catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });
        },
        eraseCardFromDatabase(cardId){
            http.get('cards/deleteCard/' + cardId)
            .then((result) => {
    
                console.log('widok słów do lekcji z http: ', result.data);
            })
            .then(()=>{
                this.getCardsForLesson()
            })
            .catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });
        },
    }
}
</script>

<style scoped>
    table {
    border: 2px solid #42b983;
    border-radius: 3px;
    background-color: #fff;
    }

    th {
    background-color: #42b983;
    color: rgba(255, 255, 255, 0.66);
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -user-select: none;
    }

    td {
    background-color: #f9f9f9;
    }

    th,
    td {
    min-width: 120px;
    padding: 10px 20px;
    }

    #search {
    margin-bottom: 10px;
    }

    td, th {
        padding: 5px;
    }
</style>