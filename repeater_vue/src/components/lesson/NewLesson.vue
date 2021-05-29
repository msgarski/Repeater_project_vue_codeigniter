<template>
        <div>
            <h3>Tworzenie nowej lekcji do kursu nr:</h3>
        </div>

        <form @submit.prevent="addLesson">
            <div>
                <label for="name">Temat lekcji</label>
                <input type="text" name="name" v-model.trim="name" id="name">
            </div>

            <div>
                <label for="description">Opis lekcji</label>
                <textarea 
                    rows="5" 
                    cols="50" 
                    v-model.trim="description" 
                    id="description" 
                    name="description" 
                    placeholder="Tematyka lekcji...">
                </textarea>
            </div>
            <button>Dodaj lekcję</button>      
        </form>
    
</template>

<script>
import http from '../../plugins/axios.js'

export default {
    name: 'NewLesson',
    data(){
        return {
            name: '',
            description: '',
            courseId: this.$route.params.courseId,
        };
    },
    mounted(){
        console.log('lekcja jest do kursu: ', this.courseId)
    },
    computed: {
        
    },
    methods: {
        isLoggedIn(){
            console.log('lekcja jest do: ')
            return this.$store.getters.logInState;
        },
        addLesson(){
                const pack = {
                    name: this.name,
                    description: this.description,
                    courseId: this.courseId,
                    expires_in: null,
                    user_id: this.$store.getters.getUserId,
                    token: localStorage.getItem('token')
                }
                console.log('pack w requescie:', pack)

                http.post('/lesson/create', pack)
                    .then(response=>{
                        console.log('odpowiedź serwera: ', response);
                    })
                    .then(()=>{
                        this.$router.go(-1)
        
                    })
                    .catch(error => {
                        this.errorMessage = error.message;
                        console.error("coś poszło nie tak...", error);
                    });
            return true;
        }
    }
}
</script>

<style scoped>

</style>