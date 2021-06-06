<template>
    <div>Faza powtórki</div>

    <!-- <div>
        <h2>{{index}}</h2>
        <h1>{{ question }}</h1>
    </div>
    <div v-show="confirmation">
        <h1>{{ answer }}</h1>
    </div>
    <div v-if="!confirmation">
        <button @click.prevent="confirm">Pokaż</button>
    </div>
    <div >
        <normal-scale v-if="confirmation" @note-level="whatNote" :summary="endLearning"></normal-scale>
    </div> -->
</template>

<script>
import NormalScale from './NormalScale';
import date from '../../functions/time/dates.js'
import http from '../../plugins/axios.js';

export default {
    name: 'repeat-present',
    // components: {
    //     'normal-scale'  :   NormalScale
    // },
    data() {
        return {
            ocena               :   null,
            repeatList           :   '',
            index               :   0,
            wordIdInDataBase    :   '', //this.$store.getters['learning/getBatchForLearning'][0]['card_id'],
            question            :   '',
            answer              :   '',
            //listLength          :   this.$store.getters['learning/getBatchForLearning'].length,
            successes           :   0,
            awkwards            :   0,
            loopIterator        :   1,
            endRepeating         :   false,
            confirmation        :   false,
            bottomLine          :   false  // gives info about entirety of recent learning phase
        };
    },
    watch: {
        // index(){
        //     if(this.index < this.listLength)
        //     {
        //         this.newWordPresentation();
        //         this.confirmation = false;
        //     }
        //     else
        //     {
                
        //         console.log('przekroczenie indeksu!!!', this.index, this.listLength)
        //         this.$store.dispatch('learning/increaseLoopNumber');
        //         console.log('loop number: ', this.$store.getters['learning/getLoopNumber'])
        //         //this.index = 0;
        //         this.newWordPresentation();
        //     }
        // },
        // listLength(){
        //     if(this.listLength == 0)
        //     {
        //         this.bottomLine = true;
        //         console.log('Nie ma nic do przeglądania już')
        //     }
        // }
    },
}
</script>

<style scoped>

</style>