


//import Vue from "vue"
import axios from 'axios'

export const http = axios.create({
    baseURL: "http://localhost:8080/restapi",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest"
    }
})


//export default http
//module.exports = ht
//Vue.prototype.$ht = ht

