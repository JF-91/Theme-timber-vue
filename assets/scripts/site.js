// site.js
import "../scss/main.scss"

import { createApp } from "vue";
import App from "./vue/App.vue";
import componentLoader from "./component-vue-loader";

jQuery(document).ready(function ($) {
  console.log("El script site.js se ha cargado correctamente");


  // Crear instancia de Vue
  // createApp(App).mount("#app");
  const app = createApp({});

  // Registra automáticamente los componentes en la carpeta "components"
  componentLoader(app);

  app.mount("#app");
});
