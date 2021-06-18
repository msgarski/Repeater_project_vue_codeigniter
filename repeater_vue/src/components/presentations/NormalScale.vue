<template>
    <div>
        <div class="label">
            <div class="btn-easy">
                <button v-show="firstLoop()" @click="$emit('note-level', 1)" class="button" id="btn-easy">Łatwe</button>
            </div>
            
            <div class="btn-bad">
                <button @click="$emit('note-level', 2)" class="button" id="btn-bad">Nie znam</button>
            </div>
            
            <div class="btn-good">
                <button @click="$emit('note-level', 3)" class="button" id="btn-good">Umiem</button>
            </div>
            
        </div>
    </div>
</template>

<script>
export default {
    name: 'normal-scale',
    props: [
        'summary'
    ],
    date() {
        return {

        };
    },
    methods: {
        firstLoop(){
            if((this.$store.getters['learning/getLoopNumber'] == 1)&&(!this.summary))
            {
                return true;
            }
            return false;
        },
    },
}
</script>

<style scoped>
    .container {
    position: absolute;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 5px 5px 5px 5px grey;
    width: 80%;
    margin-top: 30px;
    margin-left: 10%;
    margin-right: 10%;
}
.test {
    width: 85%;
    margin-top: 40px;
    text-align: center;
    font-size: 25px;
}
.question {
    border: solid black;
    
    height: 30vh;
}
.answer {
    border: solid black;
    height: 30vh;
}

.button-container {
    position: relative;
    border: 1px solid grey(39, 39, 39);
    border-radius: 12px;
    box-shadow: 5px 5px 5px 5px grey;
    width: 80%;
    margin-top: 110px;
    margin-left: 10%;
    margin-right: 100px;
}
.side-btn {
    border: solid black;
    width: 20%;
    display: flex;
    min-height: 70vh;
    flex-direction: column;
    float: right;
}
.title {
    margin-top: 0px;
    position: relative;
    text-align: center;
    color: gray;
    font-weight: bold;
    font-size: 25px;
    margin-left: 10px;
    margin-top: 5px;
    }

label {
    display: block;
    font-size: 16px;
    font-style: italic;
    padding-top: 15px;
    }
.label {
    display: flex;
    justify-content: space-between;
    height: 40px;
    margin-left: 30%;
    margin-right: 30%;

}

.button {
background-color: #ffae00; /* Green */
font-weight: bold;
border: none;
color: white;
text-align: center;
text-decoration: none;
font-size: 14px;
width: 120px;
height: 40px;
border-radius: 20px;
margin-left: 40%;
}
#btn-del {
    background-color: rgb(153, 153, 153);
    float: right;
}
#btn-edit {
    float: right;
    margin-bottom: 20px;
}
#btn-easy {
}
#btn-bad {
    background-color: red;
}
#btn-good {
    background-color: green;
}
.button-1 {
background-color: #718bff; /* Green */
font-weight: bold;
margin-left: 100px;
border: none;
color: white;
text-align: center;
text-decoration: none;
font-size: 14px;
height: 40px;
border-radius: 20px;
width: 120px;
margin-left: 47%;
}
.btn {
    width: 95%;
    padding: 10px;
}
a {
    color: white;
}
</style>