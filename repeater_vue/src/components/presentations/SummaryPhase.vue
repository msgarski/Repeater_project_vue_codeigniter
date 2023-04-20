<template>
  <div class="container">
    <div v-show="!changePhase">
      <div class="test">
        <div class="question">
          <h1>{{ question }}</h1>
        </div>
        <div v-show="confirmation" class="answer">
          <h1>{{ answer }}</h1>
        </div>
        <div class="wymowa"></div>
        <div class="zdanie"></div>

        <div v-if="!confirmation" class="btn-show">
          <button @click.prevent="confirm" class="button-1">Pokaż</button>
        </div>
        <div class="btn-show">
          <normal-scale
            v-if="confirmation"
            @note-level="whatNote"
            :summary="endLearning"
          ></normal-scale>
        </div>
      </div>
    </div>
    <div v-show="changePhase">
      <div class="summary">
        <div>Gratulacje!</div>
        <div>Umiesz coraz więcej!</div>
      </div>
    </div>
  </div>
</template>

<script>
import NormalScale from "./NormalScale";
import date from "../../functions/time/dates.js";
import http from "../../plugins/axios.js";

export default {
  name: "summary-phase",
  components: {
    "normal-scale": NormalScale,
  },
  data() {
    return {
      ocena: null,
      wordsList: "",
      index: 0,
      wordIdInDataBase: "", //this.$store.getters['learning/getBatchForLearning'][0]['card_id'],
      question: "",
      answer: "",
      listLength: null,
      successes: 0, // todo
      awkwards: 0,
      easyWords: 0, // todo
      endLearning: true, //todo
      confirmation: false,
      bottomLine: false, // todo gives info about entirety of recent learning phase
      changePhase: false,
    };
  },
  watch: {
    index() {
      if (this.index < this.listLength) {
        this.$store.dispatch("learning/setIndex", this.index);
        this.confirmation = false;
        this.newWordPresentation();
      } else {
        // End of summary phase:
        this.bottomLine = true;
        //alert('Kończymy fazę posumowania');
        console.log("zmiana fazy!!!");
        this.changePhase = true;
        console.log("changePhase po zmianie: ", this.changePhase);
        setTimeout(() => {
          this.changePhase = !this.changePhase;
          this.$router.go(-1);
        }, 2000);
      }
    },
    listLength() {
      if (this.listLength == 0) {
        this.bottomLine = true;
      }
    },
  },
  created() {
    console.log("kreowanie....");

    this.wordsList = this.$store.getters["learning/getBatchForLearning"];
    this.listLength = this.$store.getters[
      "learning/getBatchForLearning"
    ].length;

    this.index = this.$store.getters["learning/getIndex"];

    this.newWordPresentation();
  },
  methods: {
    whatNote(nota) {
      switch (nota) {
        case 2: // Unknown card
          this.ocena = 2;
          this.unknownNoting();
          break;
        case 3: // Well known card
          this.ocena = 3;
          this.knownNoting();
          break;
      }
    },
    knownNoting() {
      console.log("w funkcji : knownNoting");

      //this.wordsList[this.index]['learned_at'] = date.getToday();
      this.wordsList[this.index]["summary"] = true;

      this.setTenMinsRepetition();

      this.updateDataCardInDb(this.wordsList[this.index]);

      this.index += 1;
    },
    setTenMinsRepetition() {
      // set repetition in 10 minutes
      this.wordsList[this.index]["next_repeat"] = date.getDatePlusMinutes(10);
    },
    unknownNoting() {
      this.wordsList[this.index]["awkward"] = 1;

      //save card in db:
      this.updateDataCardInDb(this.wordsList[this.index]);

      this.index += 1;
    },
    afterEndCard() {
      if (this.index < this.listLength) {
        // todo czy ten warunek jest potrzebny???
        // card is awkward or easy, so should be removed from the list:
        this.wordsList.splice(this.index, 1);
        this.listLength -= 1;
        // remains to update source table in store,
        // to avoid reseting table after accidentally back&forwading page:
        this.$store.dispatch("learning/setBatchForLearning", this.wordsList);
      }
      this.newWordPresentation();

      this.confirmation = false;
    },
    confirm() {
      this.confirmation = true;
      this.$store.dispatch("learning/setIndex", this.index);
      console.log(
        "nowy index w storze: ",
        this.$store.getters["learning/getIndex"]
      );
    },
    newWordPresentation() {
      // todo mixowanie tablicy
      //this.index = 0;
      this.synchronization();
      return true;
    },
    synchronization() {
      this.question = this.wordsList[this.index]["question"];
      this.answer = this.wordsList[this.index]["answer"];
      this.wordIdInDataBase = this.wordsList[this.index]["card_id"];
    },
    updateDataCardInDb(pack) {
      http
        .post("learning/updateCard/" + this.wordIdInDataBase, pack)
        .then((result) => {
          console.log("odpowiedź po próbie update karty", result.data);
        })
        .then(() => {
          console.log("Update karty udany!!!!");
        })
        .catch((error) => {
          this.errorMessage = error.message;
          console.error("coś poszło nie tak...", error);
        });
    },
  },
};
</script>

<style scoped>
.wymowa {
  display: block;
  font-size: 24px;
  font-style: italic;
  margin-top: 30px;
}
.zdanie {
  display: block;
  font-size: 24px;
  font-style: italic;
  margin-top: 20px;
}
.container {
  position: absolute;
  border: 1px solid grey(39, 39, 39);
  border-radius: 12px;
  box-shadow: 5px 5px 5px 5px grey;
  width: 80%;
  margin-top: 30px;
  margin-left: 10%;
  margin-right: 10%;
  height: 560px;
  overflow: hidden;
}
.test {
  width: 90%;
  margin-top: 40px;
  text-align: center;
  font-size: 25px;
}
.summary {
  margin-top: 20%;
  text-align: center;
  font-size: 35px;
  height: 30vh;
  font-weight: bold;
}
.question {
  height: 30vh;
}
.scale {
  bottom: 30px;
}
.answer {
  height: 30vh;
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
.side-btn {
  border: solid black;
  width: 20%;
  display: flex;
  min-height: 70vh;
  flex-direction: column;
  float: right;
}
.title {
  margin-top: 0px;
  position: relative;
  text-align: center;
  color: gray;
  font-weight: bold;
  font-size: 25px;
  margin-left: 10px;
  margin-top: 5px;
}

label {
  display: block;
  font-size: 16px;
  font-style: italic;
  padding-top: 15px;
}
.label {
  display: flex;
  justify-content: space-between;
  height: 40px;
}

.button {
  background-color: #ffae00; /* Green */
  font-weight: bold;
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  font-size: 14px;
  width: 120px;
  height: 40px;
  border-radius: 20px;
  margin-left: 40%;
}
#btn-del {
  background-color: rgb(153, 153, 153);
  float: right;
}
#btn-edit {
  float: right;
  background-color: rgb(153, 153, 153);
  position: absolute;
  bottom: 40px;
  right: 40px;
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
  width: 120px;
  margin-left: 47%;
}
.btn {
  width: 95%;
  padding: 10px;
}
.btn-show {
  width: 70%;
  padding: 10px;
  position: absolute;
  bottom: 30px;
}
a {
  color: white;
}
</style>
