import './bootstrap';
import { createApp } from 'vue'
import moment from 'moment';

import app from './components/app.vue'
import router from './router/index.js'


import { TailwindPagination } from 'laravel-vue-pagination';
createApp(app).use(router).component('TailwindPagination',TailwindPagination).mount("#app")