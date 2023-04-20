<template>
  <div id="title">
    <h1>Witaj w programie REPEATER</h1>
  </div>

  <img src="../../../public/sowa.png" width="350" height="300" />

  <div class="container">
    <div class="vertical" id="signin">
      <button class="button">
        <router-link to="/signin">Logowanie</router-link>
      </button>
    </div>
    <div class="vertical" id="signup">
      <button type="button" class="button">
        <router-link to="/signup">Nie mam jeszcze konta</router-link>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Home",
  data() {
    return {
      name: "",
    };
  },
  setup() {},
  props: {},
  methods: {},
};
</script>

<style scoped>
#title {
  margin-top: 70px;
  text-align: center;
  color: gray;
}

.container {
  height: 200px;
  position: relative;
}
.vertical {
  margin: 0;
  position: absolute;
  top: 50%;
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
#signin {
  left: auto;
  padding-left: 30%;
}
#signup {
  left: 60%;
}
.button {
  background-color: #ffae00;
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  height: 40px;
  border-radius: 20px;
}
a {
  color: whitesmoke;
}
</style>
