<template>
    <form @submit.prevent="wyslij">

<p>Wprowadź nowe hasło:</p>

<div>
    <label for="password">Podaj hasło</label>
    <input type="password" name="password" v-model="password">
</div>

<div>
    <label for="password_confirmation">Powtórz hasło</label>
    <input type="password" name="password_confirmation" v-model="password_confirmation">
</div>

<button>Wyślij</button>

</form>
</template>

<script>
export default {
    data(){
        return{
            password: '',
            password_confirmation: ''

        };
    },
    setup() {
        
    },
    methods:{
        wyslij(){
            const pack = {
                password: this.password,
                password_confirmation: this.password_confirmation
            }
            console.log('pack:', pack)
            http.post("/password/newPassword", pack)
            .then(response => {
                console.log(response)
                //this.$router.push('/signin')
            })
                .catch(error => {
                    this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
                });

        }
    }
}
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