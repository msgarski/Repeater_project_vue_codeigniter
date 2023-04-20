<template>
  <h1 id="title">Rejestracja</h1>

  <div class="container">
    <form v-if="!userId" @submit.prevent="register" class="form">
      <div>
        <label for="name">Imię</label>
        <input type="text" name="name" id="name" v-model.trim="name" />
      </div>

      <div>
        <label for="email">Adres e-mail</label>
        <input type="email" name="email" id="email" v-model.trim="email" />
      </div>

      <div>
        <label for="password">Hasło</label>
        <input
          type="password"
          name="password"
          id="password"
          v-model.trim="password"
        />
      </div>

      <div>
        <label for="password_confirmation">Potwierdź hasło</label>
        <input
          type="password"
          name="password_confirmation"
          id="password_confirmation"
          v-model.trim="passwordConfirmation"
        />
      </div>

      <button class="button">Stwórz konto</button>
    </form>
    <div v-else-if="userId == 'exists'">
      <p>Użytkownik o podanym adresie e-mail, istnieje już w systemie</p>
      <p>Popraw adres poczty elektronicznej</p>
      <p>Skorzystaj z opcji odzyskiwania hasła</p>
    </div>
    <div v-else>
      <p>
        Na podany podczas rejestracji adres e-mail, wysłaliśmy wiadomość z
        linkiem do aktywacji konta
      </p>
    </div>
  </div>

  <div id="btn">
    <button class="button-1">
      <router-link to="/">{{ buttonText }}</router-link>
    </button>
  </div>
</template>

<script>
import http from "../../plugins/axios.js";

export default {
  name: "SignUp",
  data() {
    return {
      userId: "",
      name: "",
      email: "",
      password: "",
      passwordConfirmation: "",
      formIsValid: true,
      message: null,
      classAlert: null,
      buttonText: "Cofnij",
      errors: [],
    };
  },
  watch: {
    userId() {
      /*
       *   if new user is created successfuly,
       *   get his id and fill his options table
       *   with default values from store
       */

      this.fillOptionsTable();
      this.buttonText = "Wyjdź";
    },
  },
  created() {},
  methods: {
    register() {
      const pack = {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.passwordConfirmation,
      };
      // First Request - signup new user:

      http
        .post("/signup/create", pack)
        .then((response) => {
          this.userId = response.data;
        })
        .catch((error) => {
          this.errorMessage = error.message;
          console.error("coś poszło nie tak...", error);
        });
    },
    fillOptionsTable() {
      /*
       *   Method for filling table of user main options
       *   with default values
       */

      // Object with data for filling options table in db:
      const pack2 = {
        learningBatch: this.$store.getters["option/getLearningBatchLimit"],
        learningLim: this.$store.getters["option/getLearningDayLimit"],
        repeatLim: this.$store.getters["option/getRepeatDayLimit"],
        overlearn: this.$store.getters["option/getOverlearning"],
        userId: this.userId,
      };

      // Http request to fill user options table in db:
      http
        .post("/options/insertOptions", pack2)
        .then((response) => {
          console.log("odpowiedź serwera na żądanie nr 2: ", response);
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
.container {
  border: 1px solid grey(39, 39, 39);
  border-radius: 12px;
  box-shadow: 5px 5px 5px 5px grey;
  margin-top: 20px;
  margin-left: 100px;
  margin-right: 100px;
  height: 400px;
}
#title {
  margin-top: 70px;
  text-align: center;
  color: gray;
}
.form {
  padding-top: 40px;
  padding-bottom: 40px;
  padding-left: 40%;
}
label {
  display: block;
  font-size: 16px;
  font-style: italic;
}
input {
  width: 40%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 5px;
}

.button {
  background-color: #ffae00; /* Green */
  font-weight: bold;
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  height: 40px;
  border-radius: 20px;
}
.buttons {
  width: 100%;
  padding-left: 25%;
  padding-top: 5%;
}
.button-1 {
  background-color: #718bff; /* Green */
  font-weight: bold;
  margin-left: 100px;
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  height: 40px;
  border-radius: 20px;
  width: 80px;
}
#btn {
  width: 100%;
  float: left;
  padding: 20px;
}

a {
  color: white;
}
</style>
