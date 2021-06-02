<template>
    <div>
        <div>
            <button v-show="firstLoop()" @click="$emit('note-level', 1)">Łatwe</button>
            <button @click="$emit('note-level', 2)">Nie znam</button>
            <button @click="$emit('note-level', 3)">Umiem</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'normal-scale',
    date() {
        return {

        };
    },
    methods: {
        firstLoop(){
            if(this.$store.getters['learning/getLoopNumber'] == 1)
            {
            console.log('mniejsze niż 1')

                return true;
            }
            console.log('większe niż 1')
            return false;
        },
    },
}
</script>

<style scoped>

</style>