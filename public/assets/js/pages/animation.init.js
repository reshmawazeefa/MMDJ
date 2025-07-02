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

/***/ "./resources/js/pages/animation.init.js":
/*!**********************************************!*\
  !*** ./resources/js/pages/animation.init.js ***!
  \**********************************************/
/***/ (() => {

eval("/*\nTemplate Name: Ubold - Responsive Bootstrap 4 Admin Dashboard\nAuthor: CoderThemes\nWebsite: https://coderthemes.com/\nContact: support@coderthemes.com\nFile: Animation demo only\n*/\nfunction testAnim(x) {\n  $('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {\n    $(this).removeClass();\n  });\n}\n\n;\n$(document).ready(function () {\n  $('.js--triggerAnimation').click(function (e) {\n    e.preventDefault();\n    var anim = $('.js--animations').val();\n    testAnim(anim);\n  });\n  $('.js--animations').change(function () {\n    var anim = $(this).val();\n    testAnim(anim);\n  });\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly91Ym9sZC1sYXJhdmVsLy4vcmVzb3VyY2VzL2pzL3BhZ2VzL2FuaW1hdGlvbi5pbml0LmpzP2JjNWEiXSwibmFtZXMiOlsidGVzdEFuaW0iLCJ4IiwiJCIsInJlbW92ZUNsYXNzIiwiYWRkQ2xhc3MiLCJvbmUiLCJkb2N1bWVudCIsInJlYWR5IiwiY2xpY2siLCJlIiwicHJldmVudERlZmF1bHQiLCJhbmltIiwidmFsIiwiY2hhbmdlIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBLFNBQVNBLFFBQVQsQ0FBa0JDLENBQWxCLEVBQXFCO0FBQ2pCQyxFQUFBQSxDQUFDLENBQUMsbUJBQUQsQ0FBRCxDQUF1QkMsV0FBdkIsR0FBcUNDLFFBQXJDLENBQThDSCxDQUFDLEdBQUcsV0FBbEQsRUFBK0RJLEdBQS9ELENBQW1FLDhFQUFuRSxFQUFtSixZQUFVO0FBQ3pKSCxJQUFBQSxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFDLFdBQVI7QUFDSCxHQUZEO0FBR0g7O0FBQUE7QUFFREQsQ0FBQyxDQUFDSSxRQUFELENBQUQsQ0FBWUMsS0FBWixDQUFrQixZQUFVO0FBQ3hCTCxFQUFBQSxDQUFDLENBQUMsdUJBQUQsQ0FBRCxDQUEyQk0sS0FBM0IsQ0FBaUMsVUFBU0MsQ0FBVCxFQUFXO0FBQ3hDQSxJQUFBQSxDQUFDLENBQUNDLGNBQUY7QUFDQSxRQUFJQyxJQUFJLEdBQUdULENBQUMsQ0FBQyxpQkFBRCxDQUFELENBQXFCVSxHQUFyQixFQUFYO0FBQ0FaLElBQUFBLFFBQVEsQ0FBQ1csSUFBRCxDQUFSO0FBQ0gsR0FKRDtBQU1BVCxFQUFBQSxDQUFDLENBQUMsaUJBQUQsQ0FBRCxDQUFxQlcsTUFBckIsQ0FBNEIsWUFBVTtBQUNsQyxRQUFJRixJQUFJLEdBQUdULENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUVUsR0FBUixFQUFYO0FBQ0FaLElBQUFBLFFBQVEsQ0FBQ1csSUFBRCxDQUFSO0FBQ0gsR0FIRDtBQUlILENBWEQiLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuVGVtcGxhdGUgTmFtZTogVWJvbGQgLSBSZXNwb25zaXZlIEJvb3RzdHJhcCA0IEFkbWluIERhc2hib2FyZFxuQXV0aG9yOiBDb2RlclRoZW1lc1xuV2Vic2l0ZTogaHR0cHM6Ly9jb2RlcnRoZW1lcy5jb20vXG5Db250YWN0OiBzdXBwb3J0QGNvZGVydGhlbWVzLmNvbVxuRmlsZTogQW5pbWF0aW9uIGRlbW8gb25seVxuKi9cblxuZnVuY3Rpb24gdGVzdEFuaW0oeCkge1xuICAgICQoJyNhbmltYXRpb25TYW5kYm94JykucmVtb3ZlQ2xhc3MoKS5hZGRDbGFzcyh4ICsgJyBhbmltYXRlZCcpLm9uZSgnd2Via2l0QW5pbWF0aW9uRW5kIG1vekFuaW1hdGlvbkVuZCBNU0FuaW1hdGlvbkVuZCBvYW5pbWF0aW9uZW5kIGFuaW1hdGlvbmVuZCcsIGZ1bmN0aW9uKCl7XG4gICAgICAgICQodGhpcykucmVtb3ZlQ2xhc3MoKTtcbiAgICB9KTtcbn07XG5cbiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCl7XG4gICAgJCgnLmpzLS10cmlnZ2VyQW5pbWF0aW9uJykuY2xpY2soZnVuY3Rpb24oZSl7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIGFuaW0gPSAkKCcuanMtLWFuaW1hdGlvbnMnKS52YWwoKTtcbiAgICAgICAgdGVzdEFuaW0oYW5pbSk7XG4gICAgfSk7XG5cbiAgICAkKCcuanMtLWFuaW1hdGlvbnMnKS5jaGFuZ2UoZnVuY3Rpb24oKXtcbiAgICAgICAgdmFyIGFuaW0gPSAkKHRoaXMpLnZhbCgpO1xuICAgICAgICB0ZXN0QW5pbShhbmltKTtcbiAgICB9KTtcbn0pOyAgICAiXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL3BhZ2VzL2FuaW1hdGlvbi5pbml0LmpzLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/pages/animation.init.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/pages/animation.init.js"]();
/******/ 	
/******/ })()
;