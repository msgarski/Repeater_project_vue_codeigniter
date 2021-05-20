//import * as Vue from 'vue'
import axios from 'axios'

const http = axios.create({
    baseURL: "http://localhost:8080",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest"
    }
})
//Vue.prototype.$http = http
export default http;

