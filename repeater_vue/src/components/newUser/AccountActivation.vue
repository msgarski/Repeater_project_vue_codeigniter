<template>
  <div>Aktywacja konta</div>
  <div v-if="activated">
    <p>Twoje konto jest już aktywne</p>
    <p>Możesz się zalogować</p>
    <div>
      <router-link to="/signin"><p>Logowanie</p></router-link>
    </div>
  </div>
</template>

<script>
import http from "../../plugins/axios.js";

export default {
  data() {
    return {
      token: this.$route.params.token,
      activated: false,
    };
  },
  created() {
    this.activateAccount();
  },
  methods: {
    activateAccount() {
      let url = "/signup/activate/" + this.token;

      http
        .post(url)
        .then((response) => {
          console.log(response.data);
          this.activated = true;
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
#title {
  margin-top: 70px;
  text-align: center;
  color: gray;
}
.form {
  margin-top: 100px;
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
  height: 25px;
  border-radius: 12px;
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
  height: 25px;
  border-radius: 12px;
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
