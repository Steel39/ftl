import './bootstrap';
import '../css/tail.css';

import {createApp} from 'vue'
import App from './App.vue'
import router from './router'
import { initFlowbite } from 'flowbite';

createApp(App).use(router, initFlowbite).mount("#app")
