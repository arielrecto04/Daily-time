import "./bootstrap";
import { createApp } from "vue";
import App from "@/App.vue";
import router from "@/router";
import { createPinia } from "pinia";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { QuillEditor } from '@vueup/vue-quill'



createApp(App).use(router).use(createPinia())
.component('QuillEditor', QuillEditor).mount("#app");
