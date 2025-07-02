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

/***/ "./resources/js/pages/crm-opportunities.init.js":
/*!******************************************************!*\
  !*** ./resources/js/pages/crm-opportunities.init.js ***!
  \******************************************************/
/***/ (() => {

eval("/*\nTemplate Name: Ubold - Responsive Bootstrap 4 Admin Dashboard\nAuthor: CoderThemes\nWebsite: https://coderthemes.com/\nContact: support@coderthemes.com\nFile: CRM Opportunities init\n*/\n$(document).ready(function () {\n  var colors = ['#4fc6e1', '#6658dd', '#f7b84b', '#f1556c', '#1abc9c'];\n  var dataColors = $(\"#status-chart\").data('colors');\n\n  if (dataColors) {\n    colors = dataColors.split(\",\");\n  }\n\n  var DrawSparkline = function DrawSparkline() {\n    $('#status-chart').sparkline([20, 40, 30, 10, 28], {\n      type: 'pie',\n      width: '220',\n      height: '220',\n      sliceColors: colors\n    });\n  };\n\n  DrawSparkline();\n  var resizeChart;\n  $(window).resize(function (e) {\n    clearTimeout(resizeChart);\n    resizeChart = setTimeout(function () {\n      DrawSparkline();\n    }, 300);\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly91Ym9sZC1sYXJhdmVsLy4vcmVzb3VyY2VzL2pzL3BhZ2VzL2NybS1vcHBvcnR1bml0aWVzLmluaXQuanM/MDE1OSJdLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsImNvbG9ycyIsImRhdGFDb2xvcnMiLCJkYXRhIiwic3BsaXQiLCJEcmF3U3BhcmtsaW5lIiwic3BhcmtsaW5lIiwidHlwZSIsIndpZHRoIiwiaGVpZ2h0Iiwic2xpY2VDb2xvcnMiLCJyZXNpemVDaGFydCIsIndpbmRvdyIsInJlc2l6ZSIsImUiLCJjbGVhclRpbWVvdXQiLCJzZXRUaW1lb3V0Il0sIm1hcHBpbmdzIjoiQUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBQSxDQUFDLENBQUVDLFFBQUYsQ0FBRCxDQUFjQyxLQUFkLENBQW9CLFlBQVc7QUFDM0IsTUFBSUMsTUFBTSxHQUFHLENBQUMsU0FBRCxFQUFXLFNBQVgsRUFBcUIsU0FBckIsRUFBK0IsU0FBL0IsRUFBeUMsU0FBekMsQ0FBYjtBQUNBLE1BQUlDLFVBQVUsR0FBR0osQ0FBQyxDQUFDLGVBQUQsQ0FBRCxDQUFtQkssSUFBbkIsQ0FBd0IsUUFBeEIsQ0FBakI7O0FBQ0EsTUFBSUQsVUFBSixFQUFnQjtBQUNaRCxJQUFBQSxNQUFNLEdBQUdDLFVBQVUsQ0FBQ0UsS0FBWCxDQUFpQixHQUFqQixDQUFUO0FBQ0g7O0FBQ0QsTUFBSUMsYUFBYSxHQUFHLFNBQWhCQSxhQUFnQixHQUFXO0FBQzNCUCxJQUFBQSxDQUFDLENBQUMsZUFBRCxDQUFELENBQW1CUSxTQUFuQixDQUE2QixDQUFDLEVBQUQsRUFBSyxFQUFMLEVBQVMsRUFBVCxFQUFhLEVBQWIsRUFBaUIsRUFBakIsQ0FBN0IsRUFBbUQ7QUFDL0NDLE1BQUFBLElBQUksRUFBRSxLQUR5QztBQUUvQ0MsTUFBQUEsS0FBSyxFQUFFLEtBRndDO0FBRy9DQyxNQUFBQSxNQUFNLEVBQUUsS0FIdUM7QUFJL0NDLE1BQUFBLFdBQVcsRUFBRVQ7QUFKa0MsS0FBbkQ7QUFNSCxHQVBEOztBQVNBSSxFQUFBQSxhQUFhO0FBRWIsTUFBSU0sV0FBSjtBQUVBYixFQUFBQSxDQUFDLENBQUNjLE1BQUQsQ0FBRCxDQUFVQyxNQUFWLENBQWlCLFVBQVNDLENBQVQsRUFBWTtBQUN6QkMsSUFBQUEsWUFBWSxDQUFDSixXQUFELENBQVo7QUFDQUEsSUFBQUEsV0FBVyxHQUFHSyxVQUFVLENBQUMsWUFBVztBQUNoQ1gsTUFBQUEsYUFBYTtBQUNoQixLQUZ1QixFQUVyQixHQUZxQixDQUF4QjtBQUdILEdBTEQ7QUFNSCxDQXpCRCIsInNvdXJjZXNDb250ZW50IjpbIi8qXG5UZW1wbGF0ZSBOYW1lOiBVYm9sZCAtIFJlc3BvbnNpdmUgQm9vdHN0cmFwIDQgQWRtaW4gRGFzaGJvYXJkXG5BdXRob3I6IENvZGVyVGhlbWVzXG5XZWJzaXRlOiBodHRwczovL2NvZGVydGhlbWVzLmNvbS9cbkNvbnRhY3Q6IHN1cHBvcnRAY29kZXJ0aGVtZXMuY29tXG5GaWxlOiBDUk0gT3Bwb3J0dW5pdGllcyBpbml0XG4qL1xuXG4kKCBkb2N1bWVudCApLnJlYWR5KGZ1bmN0aW9uKCkge1xuICAgIHZhciBjb2xvcnMgPSBbJyM0ZmM2ZTEnLCcjNjY1OGRkJywnI2Y3Yjg0YicsJyNmMTU1NmMnLCcjMWFiYzljJ107XG4gICAgdmFyIGRhdGFDb2xvcnMgPSAkKFwiI3N0YXR1cy1jaGFydFwiKS5kYXRhKCdjb2xvcnMnKTtcbiAgICBpZiAoZGF0YUNvbG9ycykge1xuICAgICAgICBjb2xvcnMgPSBkYXRhQ29sb3JzLnNwbGl0KFwiLFwiKTtcbiAgICB9XG4gICAgdmFyIERyYXdTcGFya2xpbmUgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgJCgnI3N0YXR1cy1jaGFydCcpLnNwYXJrbGluZShbMjAsIDQwLCAzMCwgMTAsIDI4XSwge1xuICAgICAgICAgICAgdHlwZTogJ3BpZScsXG4gICAgICAgICAgICB3aWR0aDogJzIyMCcsXG4gICAgICAgICAgICBoZWlnaHQ6ICcyMjAnLFxuICAgICAgICAgICAgc2xpY2VDb2xvcnM6IGNvbG9yc1xuICAgICAgICB9KTtcbiAgICB9O1xuICAgIFxuICAgIERyYXdTcGFya2xpbmUoKTtcbiAgICBcbiAgICB2YXIgcmVzaXplQ2hhcnQ7XG5cbiAgICAkKHdpbmRvdykucmVzaXplKGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgY2xlYXJUaW1lb3V0KHJlc2l6ZUNoYXJ0KTtcbiAgICAgICAgcmVzaXplQ2hhcnQgPSBzZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgRHJhd1NwYXJrbGluZSgpO1xuICAgICAgICB9LCAzMDApO1xuICAgIH0pO1xufSk7Il0sImZpbGUiOiIuL3Jlc291cmNlcy9qcy9wYWdlcy9jcm0tb3Bwb3J0dW5pdGllcy5pbml0LmpzLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/pages/crm-opportunities.init.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/pages/crm-opportunities.init.js"]();
/******/ 	
/******/ })()
;