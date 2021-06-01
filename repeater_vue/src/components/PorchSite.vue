<template>
    <div v-if="isLoggedIn">
        <h1>Strona wejściowa </h1>
        <h3> </h3>
        <div>
            <button>Krótkie powtórki</button>
        </div>
        <div>
            <button>Zadania na dzisiaj</button>
        </div>
        <div>
            <router-link to="/mainscreen"><button>Przejdź do programu</button></router-link>
        </div>
        <div>
            <form @submit.prevent="test">
                <button>próba zapytania z Id usera</button>
            </form>
        </div>
    </div>
    <div v-else>
        <p>No i sie zmyło...</p>
    </div>
    
</template>


<script>
import http from '../plugins/axios.js'

export default {
    name: 'PorchSite',
    data(){
        return{
            isLogged: this.$store.getters.logInState,
            userId  :   this.$store.getters.getUserId,
            firstname: 'Robert',
            lastname: 'Górski',
            prawda: 'działa'
        };
    },
    computed:{
        isLoggedIn(){
            return this.$store.getters.logInState;
        },
        
    },
    created(){
        console.log('tylko userId: ', this.userId)
        http.get('options/getOptionsForUser/' + this.userId)
            .then((result) => {
                console.log('oto same data json: ', result.data.batch_learning_limit)

                this.$store.dispatch('option/setLearningBatchLimit', result.data.batch_learning_limit);
                this.$store.dispatch('option/setLearningDayLimit', result.data.day_learning_limit);
                this.$store.dispatch('option/setOverlearning', result.data.overlearning);
                this.$store.dispatch('option/setRepeatDayLimit', result.data.day_repeat_limit);

                console.log('oto same data : ', this.$store.getters['option/getLearningDayLimit']);
                console.log('oto same data : ', this.$store.getters['option/getLearningBatchLimit']);
                console.log('oto same data : ', this.$store.getters['option/getRepeatDayLimit']);
                console.log('oto same data : ', this.$store.getters['option/getOverlearning']);

            }).catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });

    },
    methods: {
        test(){
            console.log('tylko userId: ', this.userId)
        http.get('options/getOptionsForUser/' + this.userId)
            .then((result) => {
                console.log('oto same data json: ', result.data.batch_learning_limit)

                this.$store.dispatch('option/setLearningBatchLimit', result.data.batch_learning_limit);
                this.$store.dispatch('option/setLearningDayLimit', result.data.day_learning_limit);
                this.$store.dispatch('option/setOverlearning', result.data.overlearning);
                this.$store.dispatch('option/setRepeatDayLimit', result.data.day_repeat_limit);

                console.log('oto same data : ', this.$store.getters['option/getLearningDayLimit']);
                console.log('oto same data : ', this.$store.getters['option/getLearningBatchLimit']);
                console.log('oto same data : ', this.$store.getters['option/getRepeatDayLimit']);
                console.log('oto same data : ', this.$store.getters['option/getOverlearning']);

            }).catch((error) => {
                this.errorMessage = error.message;
                    console.error("coś poszło nie tak...", error);
            });
        }
    }
    
    
}
</script>

<style scoped>

</style>
