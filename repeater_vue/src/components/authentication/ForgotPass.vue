<template>
  <h1 id="title">Odnowienie hasła</h1>

  <div v-if="emailSent">
    <p>
      email z linkiem do zresetowania Twojego hasła, został wysłany na adres
      podany przy rejestracji
    </p>
  </div>
  <div v-else-if="userNotFound">
    <p>Użytkownik o podanym adresie email, nie jest zarejestrowany...</p>
  </div>
  <div v-else class="container">
    <form @submit.prevent="passRemind" class="form">
      <div>
        <label for="email">Adres e-mail</label>
        <input type="text" name="email" v-model.trim="email" id="email" />
      </div>
      <div>
        <label for="email">Powtórz adres e-mail</label>
        <input type="text" name="email" v-model.trim="email" id="email" />
      </div>

      <button class="button">Wyślij</button>
    </form>
  </div>

  <div id="btn">
    <button class="button-1"><router-link to="/">Wyjście</router-link></button>
  </div>
</template>

<script>
//import forgottenPass from '../functions/requests/forgottenPass.js'
import http from "../../plugins/axios.js";

export default {
  data() {
    return {
      email: "",
      emailSent: false,
      userNotFound: false,
    };
  },
  setup() {},
  methods: {
    passRemind() {
      const pack = {
        email: this.email,
      };
      console.log("pack:", pack);
      http
        .post("/password/checking", pack)
        .then((response) => {
          console.log("sprawdzenie wyslania emaila: ", response.data);
          if (response.status === 200) {
            // console.log("wyslanie udane: ", response);
            this.emailSent = true;
          }
          //this.$router.push('/signin');
        })
        .catch((error) => {
          this.errorMessage = error.message;
          console.error("coś poszło nie tak...", error);
          this.userNotFound = true;
        });
    },
  },
  created() {
    console.log("ścieżka w funkcji created: ", this.$route);
    //alert(this.$route.params.resetToken)
  },
};
</script>

<style scoped>
#title {
  margin-top: 70px;
  text-align: center;
  color: gray;
}
.container {
  border: 1px solid grey(39, 39, 39);
  border-radius: 12px;
  box-shadow: 5px 5px 5px 5px grey;
  margin-top: 20px;
  margin-left: 20%;
  margin-right: 20%;
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
.buttons {
  width: 100%;
  padding-left: 25%;
  padding-top: 5%;
}
.button-1 {
  background-color: #718bff; /* Green */
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  height: 40px;
  border-radius: 20px;
  width: 80px;
  margin-left: 20%;
  margin-top: 50px;
}
.btn {
  width: 20%;
  text-align: center;
  float: left;
  padding: 20px;
}

a {
  color: white;
}
</style>
