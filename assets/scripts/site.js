// site.js
import "../scss/main.scss"

import { createApp } from "vue";
import App from "./vue/App.vue";
jQuery(document).ready(function ($) {
  console.log("El script site.js se ha cargado correctamente");


  // Crear instancia de Vue
  createApp(App).mount("#app");
});
