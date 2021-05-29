<template>
    <div>
        <h1>Wnętrze lekcji nr: {{ lessonId }}</h1>
    </div>



<button><a href="">Dodaj wiele kart</a></button>

<button><a href="">Dodaj karty pojedynczo</a></button>


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