<template>
  <div class="container">
    <div>
      <p class="title">Nowa fiszka</p>
    </div>
    <form ref="anyName" @submit.prevent="addCard">
      <div>
        <div class="label">
          <label for="cardpriority">Nauka priorytetowa</label>
          <input
            type="checkbox"
            v-model="cardPriority"
            id="cardpriority"
            name="cardpriority"
          />
        </div>

        <div class="label">
          <label for="question">Pytanie</label>
          <input type="text" name="question" v-model="question" id="question" />
        </div>
        <div class="label">
          <label for="answer">Odpowiedź</label>
          <input type="text" name="answer" v-model="answer" id="answer" />
        </div>
        <div class="label">
          <label for="pronounciation">Wymowa</label>
          <input
            type="text"
            name="pronounciation"
            v-model="pronounciation"
            id="pronounciation"
          />
        </div>
        <div class="label">
          <label for="sentence">Przykład użycia</label>
          <textarea
            rows="3"
            cols="50"
            name="sentence"
            v-model="sentence"
            id="sentence"
          ></textarea>
        </div>
      </div>

      <div class="btn">
        <button class="button">Zapisz</button>
      </div>
    </form>

    <div class="btn">
      <button @click="backToPrevious" class="button-1">Anuluj</button>
    </div>
  </div>
</template>

<script>
import http from "../../plugins/axios.js";

export default {
  data() {
    return {
      lessonId: this.$route.params.lessonId,
      question: "",
      answer: "",
      pronounciation: "",
      sentence: "",
      image: null,
      cardPriority: "",
    };
  },
  setup() {},
  methods: {
    backToPrevious: function(event) {
      this.$router.go(-1);
    },
    addCard() {
      const pack = {
        lessonId: this.lessonId,
        question: this.question,
        answer: this.answer,
        pronounciation: this.pronounciation,
        sentence: this.sentence,
        image: this.image,
        priority: this.cardPriority,
        userId: this.$store.getters.getUserId,
        token: localStorage.getItem("token"),
      };
      console.log("lesson id:", pack.lessonId);
      this.$refs.anyName.reset();
      http
        .post("/cards/createCard", pack)
        .then((response) => {
          console.log("odpowiedź serwera: ", response);
        })
        .catch((error) => {
          this.errorMessage = error.message;
          console.error("nie udało się zapisać karty...", error);
          this.question = "";
          this.answer = "";
          this.pronounciation = "";
          this.sentence = "";
        });
    },
  },
};
</script>

<style scoped>
.container {
  position: absolute;
  border: 1px solid grey(39, 39, 39);
  border-radius: 12px;
  box-shadow: 5px 5px 5px 5px grey;
  width: 80%;
  margin-top: 80px;
  margin-left: 10%;
  margin-right: 10%;
}
.inputses {
  display: flex;
  justify-content: space-between;
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
  margin-top: 5px;
}
form {
  padding-top: 40px;
  padding-bottom: 30px;
  padding-left: 25%;
  padding-right: 30%;
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
input {
  width: 50%;
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
  margin-top: 40px;
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
  margin-left: 47%;
}
.btn {
  width: 100%;
  padding: 20px;
}
a {
  color: white;
}
</style>
