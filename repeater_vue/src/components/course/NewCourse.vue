<template>
    <div v-if="isLoggedIn">
        <div>Użytkownik jast zalogowany? {{ isLoggedIn }}</div>
        <div>
            <h3>Tworzenie nowego kursu</h3>
        </div>
        
        <form @submit.prevent="addCourse">

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
                    placeholder="Tematyka kursu...">
                </textarea>
            </div>

            <div>
                <label for="genre" >Rodzaj</label>
                <select name="genre" v-model="genre" id="genre">
                    <option selected value="private">Prywatny</option>
                    <option value="public">Publiczny</option>
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
            'description': '',
            'genre': '',
            'options': ['prywatny', 'publiczny'],
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
                    this.$router.push('/mainscreen')
    
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