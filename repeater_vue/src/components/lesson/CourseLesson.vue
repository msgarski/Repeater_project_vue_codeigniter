<template>
    <li>
        <router-link :to="'/innerlesson/' + id">
            <div>
                <hr>
                <p>Numer lekcji: {{ id }}</p>
                <!-- <div>Liczba kart w lekcji: {{ courseInfo.card_amount }}</div>
                <div>Do nauki: {{ courseInfo.for_learning }}</div>
                <div>Do powtórek:  {{ courseInfo.for_repeating }} </div> -->
                <p> Temat lekcji: {{ name }}</p>
                <p>Opis: {{ description }}</p>
            </div>   
        </router-link>
    </li>
</template>

<script>
export default {
    name: 'course-lesson',
    props: [
        'id',
        'name',
        'description'
    ],
    data(){
        return{

        };
    },
    setup() {
        
    },
    methods:{

    }
}
</script>

<style scoped>

</style>