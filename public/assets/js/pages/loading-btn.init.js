/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/pages/loading-btn.init.js":
/*!************************************************!*\
  !*** ./resources/js/pages/loading-btn.init.js ***!
  \************************************************/
/***/ (() => {

eval("/*\nTemplate Name: Ubold - Responsive Bootstrap 4 Admin Dashboard\nAuthor: CoderThemes\nWebsite: https://coderthemes.com/\nContact: support@coderthemes.com\nFile: Loading Button init js\n*/\n// Bind normal buttons\nLadda.bind('.ladda-button', {\n  timeout: 2000\n}); // Bind progress buttons and simulate loading progress\n\nLadda.bind('.progress-demo .ladda-button', {\n  callback: function callback(instance) {\n    var progress = 0;\n    var interval = setInterval(function () {\n      progress = Math.min(progress + Math.random() * 0.1, 1);\n      instance.setProgress(progress);\n\n      if (progress === 1) {\n        instance.stop();\n        clearInterval(interval);\n      }\n    }, 200);\n  }\n}); // You can control loading explicitly using the JavaScript API\n// as outlined below:\n// var l = Ladda.create( document.querySelector( 'button' ) );\n// l.start();\n// l.stop();\n// l.toggle();\n// l.isLoading();\n// l.setProgress( 0-1 );//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly91Ym9sZC1sYXJhdmVsLy4vcmVzb3VyY2VzL2pzL3BhZ2VzL2xvYWRpbmctYnRuLmluaXQuanM/ZTA0OSJdLCJuYW1lcyI6WyJMYWRkYSIsImJpbmQiLCJ0aW1lb3V0IiwiY2FsbGJhY2siLCJpbnN0YW5jZSIsInByb2dyZXNzIiwiaW50ZXJ2YWwiLCJzZXRJbnRlcnZhbCIsIk1hdGgiLCJtaW4iLCJyYW5kb20iLCJzZXRQcm9ncmVzcyIsInN0b3AiLCJjbGVhckludGVydmFsIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUlDO0FBQ0FBLEtBQUssQ0FBQ0MsSUFBTixDQUFZLGVBQVosRUFBNkI7QUFBRUMsRUFBQUEsT0FBTyxFQUFFO0FBQVgsQ0FBN0IsRSxDQUVBOztBQUNBRixLQUFLLENBQUNDLElBQU4sQ0FBWSw4QkFBWixFQUE0QztBQUN4Q0UsRUFBQUEsUUFBUSxFQUFFLGtCQUFVQyxRQUFWLEVBQXFCO0FBQzNCLFFBQUlDLFFBQVEsR0FBRyxDQUFmO0FBQ0EsUUFBSUMsUUFBUSxHQUFHQyxXQUFXLENBQUUsWUFBVztBQUNuQ0YsTUFBQUEsUUFBUSxHQUFHRyxJQUFJLENBQUNDLEdBQUwsQ0FBVUosUUFBUSxHQUFHRyxJQUFJLENBQUNFLE1BQUwsS0FBZ0IsR0FBckMsRUFBMEMsQ0FBMUMsQ0FBWDtBQUNBTixNQUFBQSxRQUFRLENBQUNPLFdBQVQsQ0FBc0JOLFFBQXRCOztBQUVBLFVBQUlBLFFBQVEsS0FBSyxDQUFqQixFQUFxQjtBQUNqQkQsUUFBQUEsUUFBUSxDQUFDUSxJQUFUO0FBQ0FDLFFBQUFBLGFBQWEsQ0FBRVAsUUFBRixDQUFiO0FBQ0g7QUFDSixLQVJ5QixFQVF2QixHQVJ1QixDQUExQjtBQVNIO0FBWnVDLENBQTVDLEUsQ0FlQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwic291cmNlc0NvbnRlbnQiOlsiLypcblRlbXBsYXRlIE5hbWU6IFVib2xkIC0gUmVzcG9uc2l2ZSBCb290c3RyYXAgNCBBZG1pbiBEYXNoYm9hcmRcbkF1dGhvcjogQ29kZXJUaGVtZXNcbldlYnNpdGU6IGh0dHBzOi8vY29kZXJ0aGVtZXMuY29tL1xuQ29udGFjdDogc3VwcG9ydEBjb2RlcnRoZW1lcy5jb21cbkZpbGU6IExvYWRpbmcgQnV0dG9uIGluaXQganNcbiovXG5cblxuXG4gLy8gQmluZCBub3JtYWwgYnV0dG9uc1xuIExhZGRhLmJpbmQoICcubGFkZGEtYnV0dG9uJywgeyB0aW1lb3V0OiAyMDAwIH0gKTtcblxuIC8vIEJpbmQgcHJvZ3Jlc3MgYnV0dG9ucyBhbmQgc2ltdWxhdGUgbG9hZGluZyBwcm9ncmVzc1xuIExhZGRhLmJpbmQoICcucHJvZ3Jlc3MtZGVtbyAubGFkZGEtYnV0dG9uJywge1xuICAgICBjYWxsYmFjazogZnVuY3Rpb24oIGluc3RhbmNlICkge1xuICAgICAgICAgdmFyIHByb2dyZXNzID0gMDtcbiAgICAgICAgIHZhciBpbnRlcnZhbCA9IHNldEludGVydmFsKCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICBwcm9ncmVzcyA9IE1hdGgubWluKCBwcm9ncmVzcyArIE1hdGgucmFuZG9tKCkgKiAwLjEsIDEgKTtcbiAgICAgICAgICAgICBpbnN0YW5jZS5zZXRQcm9ncmVzcyggcHJvZ3Jlc3MgKTtcblxuICAgICAgICAgICAgIGlmKCBwcm9ncmVzcyA9PT0gMSApIHtcbiAgICAgICAgICAgICAgICAgaW5zdGFuY2Uuc3RvcCgpO1xuICAgICAgICAgICAgICAgICBjbGVhckludGVydmFsKCBpbnRlcnZhbCApO1xuICAgICAgICAgICAgIH1cbiAgICAgICAgIH0sIDIwMCApO1xuICAgICB9XG4gfSApO1xuXG4gLy8gWW91IGNhbiBjb250cm9sIGxvYWRpbmcgZXhwbGljaXRseSB1c2luZyB0aGUgSmF2YVNjcmlwdCBBUElcbiAvLyBhcyBvdXRsaW5lZCBiZWxvdzpcblxuIC8vIHZhciBsID0gTGFkZGEuY3JlYXRlKCBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCAnYnV0dG9uJyApICk7XG4gLy8gbC5zdGFydCgpO1xuIC8vIGwuc3RvcCgpO1xuIC8vIGwudG9nZ2xlKCk7XG4gLy8gbC5pc0xvYWRpbmcoKTtcbiAvLyBsLnNldFByb2dyZXNzKCAwLTEgKTsiXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL3BhZ2VzL2xvYWRpbmctYnRuLmluaXQuanMuanMiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/pages/loading-btn.init.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/pages/loading-btn.init.js"]();
/******/ 	
/******/ })()
;