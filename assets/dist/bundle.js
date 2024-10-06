/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/scripts/site.js":
/*!********************************!*\
  !*** ./assets/scripts/site.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _uploadImage__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./uploadImage */ \"./assets/scripts/uploadImage.js\");\n/* harmony import */ var _uploadImage__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_uploadImage__WEBPACK_IMPORTED_MODULE_0__);\n // Asegúrate de que la ruta sea correcta\n\njQuery(document).ready(function ($) {\n  console.log(\"El script site.js se ha cargado correctamente\"); // Verifica si este mensaje aparece en la consola\n});\n\n//# sourceURL=webpack://sophie/./assets/scripts/site.js?");

/***/ }),

/***/ "./assets/scripts/uploadImage.js":
/*!***************************************!*\
  !*** ./assets/scripts/uploadImage.js ***!
  \***************************************/
/***/ (() => {

eval("jQuery(document).ready(function ($) {\n  console.log(\"El script uploadImage.js se ha cargado correctamente\"); // Verifica si este mensaje aparece en la consola\n\n  var mediaUploader;\n  $(\".upload_image_button\").click(function (e) {\n    e.preventDefault(); // Prevenir el comportamiento predeterminado\n\n    // Si el media uploader ya existe, solo abrirlo\n    if (mediaUploader) {\n      mediaUploader.open();\n      return;\n    }\n\n    // Crear el media uploader\n    mediaUploader = wp.media({\n      title: \"Upload Image\",\n      button: {\n        text: \"Use this image\"\n      },\n      multiple: false // Permitir solo una imagen\n    });\n\n    // Cuando una imagen es seleccionada\n    mediaUploader.on(\"select\", function () {\n      var attachment = mediaUploader.state().get(\"selection\").first().toJSON();\n      $(\"#about_image_field\").val(attachment.url); // Guardar la URL de la imagen en el campo oculto\n      $(\"#about_image_preview\").attr(\"src\", attachment.url); // Cambiar la vista previa de la imagen\n    });\n\n    // Abrir el media uploader\n    mediaUploader.open();\n  });\n});\n\n//# sourceURL=webpack://sophie/./assets/scripts/uploadImage.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/scripts/site.js");
/******/ 	
/******/ })()
;