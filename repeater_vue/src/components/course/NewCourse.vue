<template>
    <div v-if="isLoggedIn">
        <div>Użytkownik jast zalogowany? {{ isLoggedIn }}</div>
        <div><h3>Tworzenie nowego kursu</h3></div>
        
        <form @submit.prevent="addCourse">

    <div>
        <label for="name">Nazwa</label>
        <input type="text" name="name" v-model="name" id="name">
    </div>

    <div>
        <label for="description">Opis</label>
        <textarea rows="5" cols="50" v-model="textarea" id="description" name="description" placeholder="Tematyka kursu..."></textarea>
    </div>

    <div>
        <label for="genre">Rodzaj</label>
        <select name="genre" v-model="genre" id="genre">
            <option default>Prywatny</option>
            <option>Publiczny</option>
        </select>
    </div>

    <button>Dodaj kurs</button>
    
    </form>
    </div>
    
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    name: 'NewCourse',
    data(){
        return {
            'name': '',
            'textarea': '',
            'genre': ''
            //todo tu będą jeszcze rozdzielacze tekstu
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
                textarea: this.textarea,
                expires_in: null,
                token: localStorage.getItem('token')
            }

            http.post('/course/createCourse', pack)
                .then(Response=>{

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

</style>