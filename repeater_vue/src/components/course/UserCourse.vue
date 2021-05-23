<template>
    <li>
        <router-link to="">
            <div>
                <hr>
                <p>Numer kursu: {{ id }}</p>
                <p> Kurs {{ name }}</p>
                <p>Opis: {{ description }}</p>
            </div>   
        </router-link>
        
    </li>
</template>

<script>
export default {
    name: 'user-course',
    props:[
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
    methods: {

    }
}
</script>