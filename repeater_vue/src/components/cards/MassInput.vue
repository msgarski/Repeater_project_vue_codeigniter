<template>
    <p>Wprowadź listę słów:</p>
<form>
<div>
    <label for="cardsInput"></label>
    <textarea rows="10" cols="100" name="cardsInput" id="cardsInput" 
    placeholder="<?= $placeholder ?>"></textarea>
</div>

<div>
    <label for="reckon">wykrywaj znaki rozdzielające</label>
    <input type="checkbox" name="reckon" id="reckon" checked>
</div>

<div>
        <input type="hidden" name="lesson_id" id="lesson_id" value="<?= $lesson_id ?>">
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