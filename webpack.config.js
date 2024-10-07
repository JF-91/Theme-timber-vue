const path = require("path");
const { VueLoaderPlugin } = require('vue-loader');
const MiniCssExtractPlugin = require("mini-css-extract-plugin"); 


module.exports = {
  mode: "development", // Modo de desarrollo
  devtool: "eval-source-map", // Mejora la depuración
  optimization: {
    minimize: false, // Desactiva la minificación
    usedExports: false, // No aplica tree shaking
  },
  entry: "./assets/scripts/site.js", // Archivo de entrada principal
  output: {
    filename: "bundle.js", // Nombre del archivo de salida
    path: path.resolve(__dirname, "dist"), // Ruta de salida
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: "vue-loader",
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader", // Loader de Babel
          options: {
            presets: ["@babel/preset-env"], // Preset para compilar el código
          },
        },
      },
      {
        test: /\.scss$/, // Archivos SCSS
        use: [
          //   "style-loader", // Inyecta CSS en la página
          MiniCssExtractPlugin.loader, // Extrae CSS en archivos separados
          "css-loader",
          "sass-loader",
        ],
      },
    ],
  },
  plugins: [
    new VueLoaderPlugin(),
    new MiniCssExtractPlugin({
      filename: "styles.css", // Nombre del archivo de salida CSS
    }),
  ],
  resolve: {
    alias: {
      vue$: "vue/dist/vue.esm-bundler.js",
    },
    extensions: [".js", ".json", ".vue"],
  },
  devServer: {
    static: {
      directory: path.join(__dirname, "dist"),
    },
    compress: true, // Activa la compresión
    port: 8080, // Puerto del servidor
    hot: true, // Habilita el Hot Module Replacement
    open: true, // Abre automáticamente el navegador
    historyApiFallback: true, // Para manejar rutas de SPA
  },
};
