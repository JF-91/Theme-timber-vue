// assets/scripts/component-loader.js
function registerComponents(app) {
  const requireComponent = require.context("./vue/components", true, /\.vue$/);

  requireComponent.keys().forEach((fileName) => {
    const componentConfig = requireComponent(fileName);
    const componentName = fileName
      .replace(/^\.\/(.*)\.\w+$/, "$1") // Extrae el nombre del componente
      .replace(/\/([a-z])/g, (_, char) => char.toUpperCase()) // Convierte en PascalCase
      .replace(/-/g, ""); // Elimina guiones

    // Registra el componente
    app.component(componentName, componentConfig.default || componentConfig);
  });
}

export default registerComponents;
