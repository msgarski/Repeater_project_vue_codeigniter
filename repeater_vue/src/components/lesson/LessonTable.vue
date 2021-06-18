<template>
    
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
                    <td class="small-button">
                        <button @click="deleteCard(card.card_id)" class="s-button">Usuń</button>

                        <button @click="editCard(card.card_id)" class="s-button-1">Edytuj</button>

                    </td>
                </tr>
            </tbody>
        </table>

        <div>
            <button @click="prevPage" class="button-t">Poprzednia</button>
            <button @click="nextPage" class="button-t">Następna</button>
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
    border-radius: 12px;
    background-color: #fff;
    }

    th {
    background-color: #42b983;
    color: white;
    font-weight: bold;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -user-select: none;
    }
    .button-t {
        background-color: #42b983; /* Green */
        font-weight: bold;
        position: relative;
        border: none;
        color: white;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        height: 30px;
        border-radius: 15px;
        margin-top: 10px;
    }
    .s-button {
        background-color: #ffae00; /* Green */
        font-weight: bold;
        position: relative;
        border: none;
        color: white;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        height: 20px;
        border-radius: 10px;
    }
    .s-button-1 {
        background-color: #718bff; /* Green */
        font-weight: bold;
        position: relative;
        border: none;
        color: white;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        height: 20px;
        border-radius: 10px;
        width: 200px;
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
    .container {
    position: absolute;
    width: 95%;
    height: 60px;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 2px 2px 2px 2px grey;
    margin-top: 80px;
    margin-left: 2%;
    margin-right: auto;
    padding-bottom: 5px;
    padding-top: auto;
}
.table-container {
    position: absolute;
    width: 95%;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 2px 2px 2px 2px grey;
    margin-top: 160px;
    margin-left: 2%;
    margin-right: 100px;
}
.title {
    margin-top: 0px;
    position: relative;
    color: gray;
    font-weight: bold;
    font-size: 25px;
    margin-left: 10px;
    float: left;
    margin-top: 20px;
    }
.button-tab {
    display: flex;
    justify-content:space-between;
    padding-right: 2%;
    padding-left: 30%;
    padding-top: 0px;
}
.form {
    padding-top: 40px;
    padding-bottom: 40px;
    padding-left: 40%;
    }
.button-container {
    display: flex;
    justify-content: flex-start;
    padding-bottom: 10px;
}
.button {
background-color: #ffae00; /* Green */
font-weight: bold;
position: relative;
border: none;
color: white;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
height: 40px;
border-radius: 20px;
margin-top: 4px;
}
.button-1 {
background-color: #718bff; /* Green */
font-weight: bold;
position: relative;
border: none;
color: white;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 14px;
height: 40px;
border-radius: 20px;
width: 200px;
margin-top: 4px;
}
input {
    width: 20%;
    padding: 5px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 5px;
}
.btn {
    width: 100%;
    padding: 10px;
}
.btn-1 {
    width: 15%;
    padding-bottom: 10px;
    padding-right: 10px;
    margin-left: 80%;
}
ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
a {
    color: white;
}
</style>