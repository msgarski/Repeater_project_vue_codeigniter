<template>
<div class="contain">
    <div v-if="isLoggedIn">
                <!-- <div>Użytkownik jast zalogowany? {{ isLoggedIn }}</div> -->
                <div>
                    <h3 class="title">Tworzenie nowego kursu</h3>
                </div>
                



        <form @submit.prevent="addCourse" class="forma">

                    <div>
                        <label for="name">Nazwa</label>
                        <input type="text" name="name" v-model.trim="name" id="name">
                    </div>

                    <div>
                        <label for="description">Opis</label>
                        <textarea 
                            rows="5" 
                            cols="50" 
                            v-model.trim="description" 
                            id="description" 
                            name="description" 
                            placeholder="Tematyka kursu..." class="area">
                        </textarea>
                    </div>



            <div>
                <label for="genre" >Rodzaj</label>
                <select name="genre" v-model="genre" id="genre">
                    <option selected value="private">Prywatny</option>
                    <option value="public">Publiczny</option>
                </select>
            </div>

            <div class="button-contaainer">
                <div id="btn">
                    <button class="button">Dodaj kurs</button>
                </div>
            </div>    
        </form>





        <div id="btn">
            <router-link to="/mainscreen"><button class="button-1">Anuluj</button></router-link>
            
        </div>
    </div>
</div>
    

    
    
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    name: 'NewCourse',
    data(){
        return {
            'name': '',
            'description': '',
            'genre': '',
            'options': ['prywatny', 'publiczny']
        };
    },
    setup() {
        
    },
    computed: {
        isLoggedIn(){
            return this.$store.getters.logInState;
        }
    },
    methods: {
        addCourse(){
            const pack = {
                name: this.name,
                description: this.description,
                expires_in: null,
                genre_id: this.genre,
                user_id: this.$store.getters.getUserId,
                token: localStorage.getItem('token')
            }
            console.log('user id:', pack.user_id)

            http.post('/course/createCourse', pack)
                .then(response=>{
                    console.log('odpowiedź serwera: ', response);
                })
                .then(()=>{
                    this.$router.push('/mainscreen');
                    //! a może lepiej przejść do tego kursu nowego?
                    //!wtedy trzeba w odpowiedzi dostać id tego kursu
                    //this.$router.go(-1);
    
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
.contain {
    position: absolute;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 5px 5px 5px 5px grey;
    width: 80%;
    margin-top: 80px;
    margin-left: 10%;
    margin-right: 10%;
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
margin-left: 46%;
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