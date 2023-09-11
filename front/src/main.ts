// import './assets/main.css'
import "bootstrap/dist/css/bootstrap.css"

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.config.globalProperties.API_URL = import.meta.env.VITE_API_URL

app.use(router)

app.mount('#app')

import "bootstrap/dist/js/bootstrap.js"