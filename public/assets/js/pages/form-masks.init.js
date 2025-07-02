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

/***/ "./resources/js/pages/form-masks.init.js":
/*!***********************************************!*\
  !*** ./resources/js/pages/form-masks.init.js ***!
  \***********************************************/
/***/ (() => {

eval("/*\nTemplate Name: Ubold - Responsive Bootstrap 4 Admin Dashboard\nAuthor: CoderThemes\nWebsite: https://coderthemes.com/\nContact: support@coderthemes.com\nFile: Form mask init js\n*/\n$(document).ready(function () {\n  $('[data-toggle=\"input-mask\"]').each(function (idx, obj) {\n    var maskFormat = $(obj).data(\"maskFormat\");\n    var reverse = $(obj).data(\"reverse\");\n    if (reverse != null) $(obj).mask(maskFormat, {\n      'reverse': reverse\n    });else $(obj).mask(maskFormat);\n  });\n  $('.autonumber').each(function (i, e) {\n    new AutoNumeric(e);\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly91Ym9sZC1sYXJhdmVsLy4vcmVzb3VyY2VzL2pzL3BhZ2VzL2Zvcm0tbWFza3MuaW5pdC5qcz8xMWJkIl0sIm5hbWVzIjpbIiQiLCJkb2N1bWVudCIsInJlYWR5IiwiZWFjaCIsImlkeCIsIm9iaiIsIm1hc2tGb3JtYXQiLCJkYXRhIiwicmV2ZXJzZSIsIm1hc2siLCJpIiwiZSIsIkF1dG9OdW1lcmljIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBQSxDQUFDLENBQUVDLFFBQUYsQ0FBRCxDQUFjQyxLQUFkLENBQW9CLFlBQVc7QUFDM0JGLEVBQUFBLENBQUMsQ0FBQyw0QkFBRCxDQUFELENBQWdDRyxJQUFoQyxDQUFxQyxVQUFVQyxHQUFWLEVBQWVDLEdBQWYsRUFBb0I7QUFDckQsUUFBSUMsVUFBVSxHQUFHTixDQUFDLENBQUNLLEdBQUQsQ0FBRCxDQUFPRSxJQUFQLENBQVksWUFBWixDQUFqQjtBQUNBLFFBQUlDLE9BQU8sR0FBR1IsQ0FBQyxDQUFDSyxHQUFELENBQUQsQ0FBT0UsSUFBUCxDQUFZLFNBQVosQ0FBZDtBQUNBLFFBQUlDLE9BQU8sSUFBSSxJQUFmLEVBQ0lSLENBQUMsQ0FBQ0ssR0FBRCxDQUFELENBQU9JLElBQVAsQ0FBWUgsVUFBWixFQUF3QjtBQUFDLGlCQUFXRTtBQUFaLEtBQXhCLEVBREosS0FHSVIsQ0FBQyxDQUFDSyxHQUFELENBQUQsQ0FBT0ksSUFBUCxDQUFZSCxVQUFaO0FBQ1AsR0FQRDtBQVNBTixFQUFBQSxDQUFDLENBQUMsYUFBRCxDQUFELENBQWlCRyxJQUFqQixDQUFzQixVQUFTTyxDQUFULEVBQVlDLENBQVosRUFBZTtBQUNqQyxRQUFJQyxXQUFKLENBQWdCRCxDQUFoQjtBQUNILEdBRkQ7QUFHSCxDQWJEIiwic291cmNlc0NvbnRlbnQiOlsiLypcblRlbXBsYXRlIE5hbWU6IFVib2xkIC0gUmVzcG9uc2l2ZSBCb290c3RyYXAgNCBBZG1pbiBEYXNoYm9hcmRcbkF1dGhvcjogQ29kZXJUaGVtZXNcbldlYnNpdGU6IGh0dHBzOi8vY29kZXJ0aGVtZXMuY29tL1xuQ29udGFjdDogc3VwcG9ydEBjb2RlcnRoZW1lcy5jb21cbkZpbGU6IEZvcm0gbWFzayBpbml0IGpzXG4qL1xuXG4kKCBkb2N1bWVudCApLnJlYWR5KGZ1bmN0aW9uKCkge1xuICAgICQoJ1tkYXRhLXRvZ2dsZT1cImlucHV0LW1hc2tcIl0nKS5lYWNoKGZ1bmN0aW9uIChpZHgsIG9iaikge1xuICAgICAgICB2YXIgbWFza0Zvcm1hdCA9ICQob2JqKS5kYXRhKFwibWFza0Zvcm1hdFwiKTtcbiAgICAgICAgdmFyIHJldmVyc2UgPSAkKG9iaikuZGF0YShcInJldmVyc2VcIik7XG4gICAgICAgIGlmIChyZXZlcnNlICE9IG51bGwpXG4gICAgICAgICAgICAkKG9iaikubWFzayhtYXNrRm9ybWF0LCB7J3JldmVyc2UnOiByZXZlcnNlfSk7XG4gICAgICAgIGVsc2VcbiAgICAgICAgICAgICQob2JqKS5tYXNrKG1hc2tGb3JtYXQpO1xuICAgIH0pO1xuXG4gICAgJCgnLmF1dG9udW1iZXInKS5lYWNoKGZ1bmN0aW9uKGksIGUpIHtcbiAgICAgICAgbmV3IEF1dG9OdW1lcmljKGUpO1xuICAgIH0pO1xufSk7XG5cbiJdLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvcGFnZXMvZm9ybS1tYXNrcy5pbml0LmpzLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/pages/form-masks.init.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/pages/form-masks.init.js"]();
/******/ 	
/******/ })()
;