<template>
  <div class="container">
    <div>
      <h3 class="title">Edycja lekcji</h3>
    </div>

    <form @submit.prevent="changeLesson" class="form">
      <div>
        <label for="name">Zmień temat lekcji</label>
        <input type="text" name="name" v-model.trim="name" id="name" />
      </div>

      <div>
        <label for="description">Zmień opis lekcji</label>
        <textarea
          rows="5"
          cols="50"
          v-model.trim="description"
          id="description"
          name="description"
          placeholder="Tematyka lekcji..."
        >
        </textarea>
      </div>
      <div class="button-contaainer">
        <div id="btn">
          <button class="button">Zatwierdź zmiany</button>
        </div>
        <div id="btn">
          <button @click="goBack" class="button-1">Anuluj</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import http from "../../plugins/axios.js";

export default {
  name: "EditLesson",
  data() {
    return {
      name: "",
      description: "",
      lessonId: this.$route.params.lessonId,
    };
  },
  mounted() {},
  computed: {},
  methods: {
    goBack() {
      this.$router.go(-1);
    },
    isLoggedIn() {
      return this.$store.getters.logInState;
    },
    changeLesson() {
      const pack = {
        name: this.name,
        description: this.description,
        courseId: this.courseId,
        expires_in: null,
        user_id: this.$store.getters.getUserId,
        token: localStorage.getItem("token"),
      };

      http
        .post("/lesson/create", pack)
        .then(() => {
          this.$router.go(-1);
        })
        .catch((error) => {
          this.errorMessage = error.message;
          console.error("coś poszło nie tak...", error);
        });
      return true;
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
  margin-top: 100px;
  margin-left: 10%;
  margin-right: 100px;
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
  color: grey;
  font-weight: bold;
  font-size: 25px;
  margin-left: 10px;
  margin-top: 20px;
}
form {
  padding-top: 40px;
  padding-bottom: 40px;
  padding-left: 35%;
}
label {
  display: block;
  font-size: 16px;
  font-style: italic;
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
  margin-left: 7%;
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
  margin-left: 17%;
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
