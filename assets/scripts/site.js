import "../scss/main.scss";
import { createApp } from "vue";
import componentLoader from "./component-vue-loader";

jQuery(document).ready(function ($) {
  console.log("El script site.js se ha cargado correctamente");

  const app = createApp({});

  componentLoader(app);

  app.mount("#app");
});
