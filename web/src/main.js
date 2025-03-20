import { createApp } from "vue";
import { createPinia } from "pinia";
import VueTheMask from 'vue-the-mask';
import "./assets/styles/app.scss";
import App from "./App.vue";
import router from "./router";

const pinia = createPinia();

createApp(App)
    .use(pinia)
    .use(router)
    .use(VueTheMask)
    .mount("#app");
