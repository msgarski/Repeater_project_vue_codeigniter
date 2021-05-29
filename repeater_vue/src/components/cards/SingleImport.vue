<template>
    <form>
<div>
    <label for="question">Pytanie</label>
    <input type="text" name="question" id="question" value="">
</div>
<div>
    <label for="answer">Odpowiedź</label>
    <input type="text" name="answer" id="answer" value="">
</div>
<div>
    <label for="pronounciation">Wymowa</label>
    <input type="text" name="pronounciation" id="pronounciation" value="">
</div>
<div>
    <label for="sentence">Przykład użycia</label>
    <input type="text" name="sentence" id="sentence" value="">
</div>
<div>
    <label for="image">Dodaj obrazek</label>
    <!-- <input type="button" id="loadFile" value="Wybierz obrazek z dysku" onclick="document.getElementById('image').click();" /> -->
    <input type="file" id="image" name="image"  size="300" value=""/>
</div>

<div>
        <!-- <input type="hidden" name="lesson_id" id="lesson_id"> -->
</div>

<button>Zapisz</button>
    </form>
</template>

<script>
export default {
    setup() {
        
    },
}
</script>

<style scoped>

</style>