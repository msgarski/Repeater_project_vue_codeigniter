<template>
    <div>
        <h1>Wnętrze lekcji nr: {{ lessonId }}</h1>
    </div>



<button><router-link :to="'/massimport/' + lessonId">Dodaj wiele kart</router-link></button>

<button><router-link :to="'/singleimport/' + lessonId">Dodaj karty pojedynczo</router-link></button>


<div>
    <label for="tryouts">Oczekujące testy:</label>
</div>

<div>
    <label for="repetitions">Powtórki na dziś:</label>
</div>

<p>Twoje karty w tej lekcji:</p>

<div>
    <a href="">Powrót do kursu</a>
</div>






</template>

<script>
export default {
    name: 'inner-lesson',
    data(){
        return{
            lessonId: this.$route.params.lessonId,
        };
    },
    setup() {
        
    },
}
</script>

<style scoped>

</style>