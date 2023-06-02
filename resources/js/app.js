require('./bootstrap');

import { createApp } from 'vue';
import App from './components/App.vue';
import '../sass/app.scss';

const app = createApp({})

document.querySelector('#app').appendChild(document.createElement('app'))
app.component('app', App)
app.mount('#app')