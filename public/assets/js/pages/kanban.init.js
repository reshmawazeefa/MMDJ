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

/***/ "./resources/js/pages/kanban.init.js":
/*!*******************************************!*\
  !*** ./resources/js/pages/kanban.init.js ***!
  \*******************************************/
/***/ (() => {

eval("/*\nTemplate Name: Ubold - Responsive Bootstrap 4 Admin Dashboard\nAuthor: CoderThemes\nWebsite: https://coderthemes.com/\nContact: support@coderthemes.com\nFile: Kanban Board init js\n*/\n!function ($) {\n  \"use strict\";\n\n  var KanbanBoard = function KanbanBoard() {\n    this.$body = $(\"body\");\n  }; //initializing various charts and components\n\n\n  KanbanBoard.prototype.init = function () {\n    $('.tasklist').each(function () {\n      Sortable.create($(this)[0], {\n        group: 'shared',\n        animation: 150,\n        ghostClass: 'bg-ghost'\n      });\n    });\n  }, //init KanbanBoard\n  $.KanbanBoard = new KanbanBoard(), $.KanbanBoard.Constructor = KanbanBoard;\n}(window.jQuery), //initializing KanbanBoard\nfunction ($) {\n  \"use strict\";\n\n  $.KanbanBoard.init();\n}(window.jQuery);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly91Ym9sZC1sYXJhdmVsLy4vcmVzb3VyY2VzL2pzL3BhZ2VzL2thbmJhbi5pbml0LmpzPzM5MDIiXSwibmFtZXMiOlsiJCIsIkthbmJhbkJvYXJkIiwiJGJvZHkiLCJwcm90b3R5cGUiLCJpbml0IiwiZWFjaCIsIlNvcnRhYmxlIiwiY3JlYXRlIiwiZ3JvdXAiLCJhbmltYXRpb24iLCJnaG9zdENsYXNzIiwiQ29uc3RydWN0b3IiLCJ3aW5kb3ciLCJqUXVlcnkiXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUEsQ0FBRSxVQUFTQSxDQUFULEVBQVk7QUFDYjs7QUFFQSxNQUFJQyxXQUFXLEdBQUcsU0FBZEEsV0FBYyxHQUFXO0FBQzVCLFNBQUtDLEtBQUwsR0FBYUYsQ0FBQyxDQUFDLE1BQUQsQ0FBZDtBQUNBLEdBRkQsQ0FIYSxDQU9iOzs7QUFDQUMsRUFBQUEsV0FBVyxDQUFDRSxTQUFaLENBQXNCQyxJQUF0QixHQUE2QixZQUFXO0FBQ3ZDSixJQUFBQSxDQUFDLENBQUMsV0FBRCxDQUFELENBQWVLLElBQWYsQ0FBb0IsWUFBWTtBQUMvQkMsTUFBQUEsUUFBUSxDQUFDQyxNQUFULENBQWdCUCxDQUFDLENBQUMsSUFBRCxDQUFELENBQVEsQ0FBUixDQUFoQixFQUE0QjtBQUMzQlEsUUFBQUEsS0FBSyxFQUFFLFFBRG9CO0FBRTNCQyxRQUFBQSxTQUFTLEVBQUUsR0FGZ0I7QUFHM0JDLFFBQUFBLFVBQVUsRUFBRTtBQUhlLE9BQTVCO0FBTUEsS0FQRDtBQVFBLEdBVEQsRUFXQTtBQUNBVixFQUFBQSxDQUFDLENBQUNDLFdBQUYsR0FBZ0IsSUFBSUEsV0FBSixFQVpoQixFQVlpQ0QsQ0FBQyxDQUFDQyxXQUFGLENBQWNVLFdBQWQsR0FDakNWLFdBYkE7QUFlQSxDQXZCQyxDQXVCQVcsTUFBTSxDQUFDQyxNQXZCUCxDQUFGLEVBeUJBO0FBQ0EsVUFBU2IsQ0FBVCxFQUFZO0FBQ1g7O0FBQ0FBLEVBQUFBLENBQUMsQ0FBQ0MsV0FBRixDQUFjRyxJQUFkO0FBQ0EsQ0FIRCxDQUdFUSxNQUFNLENBQUNDLE1BSFQsQ0ExQkEiLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuVGVtcGxhdGUgTmFtZTogVWJvbGQgLSBSZXNwb25zaXZlIEJvb3RzdHJhcCA0IEFkbWluIERhc2hib2FyZFxuQXV0aG9yOiBDb2RlclRoZW1lc1xuV2Vic2l0ZTogaHR0cHM6Ly9jb2RlcnRoZW1lcy5jb20vXG5Db250YWN0OiBzdXBwb3J0QGNvZGVydGhlbWVzLmNvbVxuRmlsZTogS2FuYmFuIEJvYXJkIGluaXQganNcbiovXG5cbiEgZnVuY3Rpb24oJCkge1xuXHRcInVzZSBzdHJpY3RcIjtcblxuXHR2YXIgS2FuYmFuQm9hcmQgPSBmdW5jdGlvbigpIHtcblx0XHR0aGlzLiRib2R5ID0gJChcImJvZHlcIilcblx0fTtcblxuXHQvL2luaXRpYWxpemluZyB2YXJpb3VzIGNoYXJ0cyBhbmQgY29tcG9uZW50c1xuXHRLYW5iYW5Cb2FyZC5wcm90b3R5cGUuaW5pdCA9IGZ1bmN0aW9uKCkge1xuXHRcdCQoJy50YXNrbGlzdCcpLmVhY2goZnVuY3Rpb24gKCkge1xuXHRcdFx0U29ydGFibGUuY3JlYXRlKCQodGhpcylbMF0sIHtcblx0XHRcdFx0Z3JvdXA6ICdzaGFyZWQnLFxuXHRcdFx0XHRhbmltYXRpb246IDE1MCxcblx0XHRcdFx0Z2hvc3RDbGFzczogJ2JnLWdob3N0J1xuXHRcdFx0fSk7XG5cdFx0XHRcblx0XHR9KTtcdFxuXHR9LFxuXG5cdC8vaW5pdCBLYW5iYW5Cb2FyZFxuXHQkLkthbmJhbkJvYXJkID0gbmV3IEthbmJhbkJvYXJkLCAkLkthbmJhbkJvYXJkLkNvbnN0cnVjdG9yID1cblx0S2FuYmFuQm9hcmRcblxufSh3aW5kb3cualF1ZXJ5KSxcblxuLy9pbml0aWFsaXppbmcgS2FuYmFuQm9hcmRcbmZ1bmN0aW9uKCQpIHtcblx0XCJ1c2Ugc3RyaWN0XCI7XG5cdCQuS2FuYmFuQm9hcmQuaW5pdCgpXG59KHdpbmRvdy5qUXVlcnkpOyJdLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvcGFnZXMva2FuYmFuLmluaXQuanMuanMiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/pages/kanban.init.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/pages/kanban.init.js"]();
/******/ 	
/******/ })()
;