(function webpackUniversalModuleDefinition(root, factory) {
    if(typeof exports === 'object' && typeof module === 'object')
        module.exports = factory();
    else if(typeof define === 'function' && define.amd)
        define([], factory);
    else if(typeof exports === 'object')
        exports["SimpleBar"] = factory();
    else
        root["SimpleBar"] = factory();
})(this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/    // The module cache
/******/    var installedModules = {};
/******/
/******/    // The require function
/******/    function __webpack_require__(moduleId) {
/******/
/******/        // Check if module is in cache
/******/        if(installedModules[moduleId])
/******/            return installedModules[moduleId].exports;
/******/
/******/        // Create a new module (and put it into the cache)
/******/        var module = installedModules[moduleId] = {
/******/            exports: {},
/******/            id: moduleId,
/******/            loaded: false
/******/        };
/******/
/******/        // Execute the module function
/******/        modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/        // Flag the module as loaded
/******/        module.loaded = true;
/******/
/******/        // Return the exports of the module
/******/        return module.exports;
/******/    }
/******/
/******/
/******/    // expose the modules object (__webpack_modules__)
/******/    __webpack_require__.m = modules;
/******/
/******/    // expose the module cache
/******/    __webpack_require__.c = installedModules;
/******/
/******/    // __webpack_public_path__
/******/    __webpack_require__.p = "";
/******/
/******/    // Load entry module and return exports
/******/    return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

    'use strict';
    
    Object.defineProperty(exports, "__esModule", {
        value: true
    });
    
    var _from = __webpack_require__(1);
    
    var _from2 = _interopRequireDefault(_from);
    
    var _keys = __webpack_require__(54);
    
    var _keys2 = _interopRequireDefault(_keys);
    
    var _assign = __webpack_require__(58);
    
    var _assign2 = _interopRequireDefault(_assign);
    
    var _classCallCheck2 = __webpack_require__(64);
    
    var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);
    
    var _createClass2 = __webpack_require__(65);
    
    var _createClass3 = _interopRequireDefault(_createClass2);
    
    var _scrollbarwidth = __webpack_require__(69);
    
    var _scrollbarwidth2 = _interopRequireDefault(_scrollbarwidth);
    
    __webpack_require__(70);
    
    function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
    
    var SimpleBar = function () {
        function SimpleBar(element, options) {
            (0, _classCallCheck3.default)(this, SimpleBar);
    
            this.el = element;
            this.track;
            this.scrollbar;
            this.flashTimeout;
            this.contentEl = this.el;
            this.scrollContentEl = this.el;
            this.dragOffset = { x: 0, y: 0 };
            this.isVisible = { x: true, y: true };
            this.scrollOffsetAttr = { x: 'scrollLeft', y: 'scrollTop' };
            this.sizeAttr = { x: 'offsetWidth', y: 'offsetHeight' };
            this.scrollSizeAttr = { x: 'scrollWidth', y: 'scrollHeight' };
            this.offsetAttr = { x: 'left', y: 'top' };
            this.observer;
            this.currentAxis;
    
            var DEFAULT_OPTIONS = {
                wrapContent: true,
                autoHide: true,
                classNames: {
                    container: 'simplebar',
                    content: 'simplebar-content',
                    scrollContent: 'simplebar-scroll-content',
                    scrollbar: 'simplebar-scrollbar',
                    track: 'simplebar-track'
                }
            };
    
            this.options = (0, _assign2.default)({}, DEFAULT_OPTIONS, options);
            this.classNames = this.options.classNames;
    
            this.flashScrollbar = this.flashScrollbar.bind(this);
            this.startScroll = this.startScroll.bind(this);
            this.startDrag = this.startDrag.bind(this);
            this.drag = this.drag.bind(this);
            this.endDrag = this.endDrag.bind(this);
    
            this.init();
        }
    
        (0, _createClass3.default)(SimpleBar, [{
            key: 'init',
            value: function init() {
                var _this = this;
    
                // Save a reference to the instance, so we know this DOM node has already been instancied
                this.el.SimpleBar = this;
    
                // If scrollbar is a floating scrollbar, disable the plugin
                if ((0, _scrollbarwidth2.default)() === 0) {
                    this.el.style.overflow = 'auto';
    
                    return;
                }
    
                // Prepare DOM
                if (this.options.wrapContent) {
                    var wrapperScrollContent = document.createElement('div');
                    var wrapperContent = document.createElement('div');
    
                    wrapperScrollContent.classList.add(this.classNames.scrollContent);
                    wrapperContent.classList.add(this.classNames.content);
    
                    while (this.el.firstChild) {
                        wrapperContent.appendChild(this.el.firstChild);
                    }wrapperScrollContent.appendChild(wrapperContent);
                    this.el.appendChild(wrapperScrollContent);
                }
    
                var track = document.createElement('div');
                var scrollbar = document.createElement('div');
    
                track.classList.add(this.classNames.track);
                scrollbar.classList.add(this.classNames.scrollbar);
    
                track.appendChild(scrollbar);
    
                this.trackX = track.cloneNode(true);
                this.trackX.classList.add('horizontal');
    
                this.trackY = track.cloneNode(true);
                this.trackY.classList.add('vertical');
    
                this.el.insertBefore(this.trackX, this.el.firstChild);
                this.el.insertBefore(this.trackY, this.el.firstChild);
    
                this.scrollbarX = this.trackX.querySelector('.' + this.classNames.scrollbar);
                this.scrollbarY = this.trackY.querySelector('.' + this.classNames.scrollbar);
                this.scrollContentEl = this.el.querySelector('.' + this.classNames.scrollContent);
                this.contentEl = this.el.querySelector('.' + this.classNames.content);
    
                // Calculate content size
                this.resizeScrollContent();
                this.resizeScrollbar('x');
                this.resizeScrollbar('y');
    
                if (!this.options.autoHide) {
                    this.showScrollbar('x');
                    this.showScrollbar('y');
                }
    
                // Event listeners
                if (this.options.autoHide) {
                    this.el.addEventListener('mouseenter', this.flashScrollbar);
                }
    
                this.scrollbarX.addEventListener('mousedown', function (e) {
                    return _this.startDrag(e, 'x');
                });
                this.scrollbarY.addEventListener('mousedown', function (e) {
                    return _this.startDrag(e, 'y');
                });
    
                this.scrollContentEl.addEventListener('scroll', this.startScroll);
    
                // MutationObserver is IE11+
                if (typeof MutationObserver !== 'undefined') {
                    // create an observer instance
                    this.observer = new MutationObserver(function (mutations) {
                        mutations.forEach(function (mutation) {
                            if (mutation.target === _this.el || mutation.addedNodes.length) {
                                _this.recalculate();
                            }
                        });
                    });
    
                    // pass in the target node, as well as the observer options
                    this.observer.observe(this.el, { attributes: true, childList: true, characterData: true, subtree: true });
                }
            }
    
            /**
             * Start scrollbar handle drag
             */
    
        }, {
            key: 'startDrag',
            value: function startDrag(e) {
                var axis = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'y';
    
                // Preventing the event's default action stops text being
                // selectable during the drag.
                e.preventDefault();
    
                var scrollbar = axis === 'y' ? this.scrollbarY : this.scrollbarX;
                // Measure how far the user's mouse is from the top of the scrollbar drag handle.
                var eventOffset = axis === 'y' ? e.pageY : e.pageX;
    
                this.dragOffset[axis] = eventOffset - scrollbar.getBoundingClientRect()[this.offsetAttr[axis]];
                this.currentAxis = axis;
    
                document.addEventListener('mousemove', this.drag);
                document.addEventListener('mouseup', this.endDrag);
            }
    
            /**
             * Drag scrollbar handle
             */
    
        }, {
            key: 'drag',
            value: function drag(e) {
                e.preventDefault();
    
                var eventOffset = this.currentAxis === 'y' ? e.pageY : e.pageX;
                var track = this.currentAxis === 'y' ? this.trackY : this.trackX;
    
                // Calculate how far the user's mouse is from the top/left of the scrollbar (minus the dragOffset).
                var dragPos = eventOffset - track.getBoundingClientRect()[this.offsetAttr[this.currentAxis]] - this.dragOffset[this.currentAxis];
    
                // Convert the mouse position into a percentage of the scrollbar height/width.
                var dragPerc = dragPos / track[this.sizeAttr[this.currentAxis]];
    
                // Scroll the content by the same percentage.
                var scrollPos = dragPerc * this.contentEl[this.scrollSizeAttr[this.currentAxis]];
    
                this.scrollContentEl[this.scrollOffsetAttr[this.currentAxis]] = scrollPos;
            }
    
            /**
             * End scroll handle drag
             */
    
        }, {
            key: 'endDrag',
            value: function endDrag() {
                document.removeEventListener('mousemove', this.drag);
                document.removeEventListener('mouseup', this.endDrag);
            }
    
            /**
             * Resize scrollbar
             */
    
        }, {
            key: 'resizeScrollbar',
            value: function resizeScrollbar() {
                var axis = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'y';
    
                var track = void 0;
                var scrollbar = void 0;
    
                if (axis === 'x') {
                    track = this.trackX;
                    scrollbar = this.scrollbarX;
                } else {
                    // 'y'
                    track = this.trackY;
                    scrollbar = this.scrollbarY;
                }
    
                var contentSize = this.contentEl[this.scrollSizeAttr[axis]],
                    scrollOffset = this.scrollContentEl[this.scrollOffsetAttr[axis]],
                    // Either scrollTop() or scrollLeft().
                scrollbarSize = track[this.sizeAttr[axis]],
                    scrollbarRatio = scrollbarSize / contentSize,
    
                // Calculate new height/position of drag handle.
                // Offset of 2px allows for a small top/bottom or left/right margin around handle.
                handleOffset = Math.round(scrollbarRatio * scrollOffset) + 2,
                    handleSize = Math.floor(scrollbarRatio * (scrollbarSize - 2)) - 2;
    
                // Set isVisible to false if scrollbar is not necessary (content is shorter than wrapper)
                this.isVisible[axis] = scrollbarSize < contentSize;
    
                if (this.isVisible[axis]) {
                    track.style.visibility = 'visible';
    
                    if (axis === 'x') {
                        scrollbar.style.left = handleOffset + 'px';
                        scrollbar.style.width = handleSize + 'px';
                    } else {
                        scrollbar.style.top = handleOffset + 'px';
                        scrollbar.style.height = handleSize + 'px';
                    }
                } else {
                    track.style.visibility = 'hidden';
                }
            }
    
            /**
             * Resize content element
             */
    
        }, {
            key: 'resizeScrollContent',
            value: function resizeScrollContent() {
                var _scrollbarWidth = (0, _scrollbarwidth2.default)();
    
                this.scrollContentEl.style.width = this.el.offsetWidth + _scrollbarWidth + 'px';
                this.scrollContentEl.style.height = this.el.offsetHeight + _scrollbarWidth + 'px';
            }
    
            /**
             * On scroll event handling
             */
    
        }, {
            key: 'startScroll',
            value: function startScroll() {
                this.flashScrollbar();
            }
    
            /**
             * Flash scrollbar visibility
             */
    
        }, {
            key: 'flashScrollbar',
            value: function flashScrollbar() {
                this.resizeScrollbar('x');
                this.resizeScrollbar('y');
                this.showScrollbar('x');
                this.showScrollbar('y');
            }
    
            /**
             * Show scrollbar
             */
    
        }, {
            key: 'showScrollbar',
            value: function showScrollbar() {
                var axis = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'y';
    
                if (!this.isVisible[axis]) {
                    return;
                }
    
                if (axis === 'x') {
                    this.scrollbarX.classList.add('visible');
                } else {
                    this.scrollbarY.classList.add('visible');
                }
    
                if (!this.options.autoHide) {
                    return;
                }
                if (typeof this.flashTimeout === 'number') {
                    window.clearTimeout(this.flashTimeout);
                }
    
                this.flashTimeout = window.setTimeout(this.hideScrollbar.bind(this), 1000);
            }
    
            /**
             * Hide Scrollbar
             */
    
        }, {
            key: 'hideScrollbar',
            value: function hideScrollbar() {
                this.scrollbarX.classList.remove('visible');
                this.scrollbarY.classList.remove('visible');
    
                if (typeof this.flashTimeout === 'number') {
                    window.clearTimeout(this.flashTimeout);
                }
            }
    
            /**
             * Recalculate scrollbar
             */
    
        }, {
            key: 'recalculate',
            value: function recalculate() {
                this.resizeScrollContent();
                this.resizeScrollbar();
            }
    
            /**
             * Getter for original scrolling element
             */
    
        }, {
            key: 'getScrollElement',
            value: function getScrollElement() {
                return this.scrollContentEl;
            }
    
            /**
             * Getter for content element
             */
    
        }, {
            key: 'getContentElement',
            value: function getContentElement() {
                return this.contentEl;
            }
    
            /**
             * UnMount mutation observer and delete SimpleBar instance from DOM element
             */
    
        }, {
            key: 'unMount',
            value: function unMount() {
                this.observer && this.observer.disconnect();
                this.el.SimpleBar = null;
                delete this.el.SimpleBar;
            }
        }]);
        return SimpleBar;
    }();
    
    /**
     * HTML API
     */
    
    // Helper function to retrieve options from element attributes
    
    
    exports.default = SimpleBar;
    var getElOptions = function getElOptions(el) {
        var attributes = [{ autoHide: 'data-simplebar-autohide' }];
        var options = attributes.reduce(function (acc, obj) {
            var attribute = obj[(0, _keys2.default)(obj)[0]];
            acc[(0, _keys2.default)(obj)[0]] = el.hasAttribute(attribute) ? el.getAttribute(attribute) === 'false' ? false : true : true;
            return acc;
        }, {});
    
        return options;
    };
    
    // MutationObserver is IE11+
    if (typeof MutationObserver !== 'undefined') {
        // Mutation observer to observe dynamically added elements
        var observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                (0, _from2.default)(mutation.addedNodes).forEach(function (addedNode) {
                    addedNode.nodeType === 1 && addedNode.querySelectorAll('[data-simplebar]').forEach(function (el) {
                        if (typeof addedNode.SimpleBar === 'undefined') {
                            new SimpleBar(el, getElOptions(el));
                        }
                    });
                });
    
                (0, _from2.default)(mutation.removedNodes).forEach(function (removedNode) {
                    removedNode.nodeType === 1 && removedNode.querySelectorAll('[data-simplebar]').forEach(function (el) {
                        el.SimpleBar && el.SimpleBar.unMount();
                    });
                });
            });
        });
    
        observer.observe(document, { childList: true, subtree: true });
    }
    
    // Instantiate elements already present on the page
    document.addEventListener('DOMContentLoaded', function () {
        (0, _from2.default)(document.querySelectorAll('[data-simplebar]')).forEach(function (el) {
            new SimpleBar(el, getElOptions(el));
        });
    });
    module.exports = exports['default'];

/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

    module.exports = { "default": __webpack_require__(2), __esModule: true };

/***/ },
/* 2 */
/***/ function(module, exports, __webpack_require__) {

    __webpack_require__(3);
    __webpack_require__(47);
    module.exports = __webpack_require__(11).Array.from;

/***/ },
/* 3 */
/***/ function(module, exports, __webpack_require__) {

    'use strict';
    var $at  = __webpack_require__(4)(true);
    
    // 21.1.3.27 String.prototype[@@iterator]()
    __webpack_require__(7)(String, 'String', function(iterated){
      this._t = String(iterated); // target
      this._i = 0;                // next index
    // 21.1.5.2.1 %StringIteratorPrototype%.next()
    }, function(){
      var O     = this._t
        , index = this._i
        , point;
      if(index >= O.length)return {value: undefined, done: true};
      point = $at(O, index);
      this._i += point.length;
      return {value: point, done: false};
    });

/***/ },
/* 4 */
/***/ function(module, exports, __webpack_require__) {

    var toInteger = __webpack_require__(5)
      , defined   = __webpack_require__(6);
    // true  -> String#at
    // false -> String#codePointAt
    module.exports = function(TO_STRING){
      return function(that, pos){
        var s = String(defined(that))
          , i = toInteger(pos)
          , l = s.length
          , a, b;
        if(i < 0 || i >= l)return TO_STRING ? '' : undefined;
        a = s.charCodeAt(i);
        return a < 0xd800 || a > 0xdbff || i + 1 === l || (b = s.charCodeAt(i + 1)) < 0xdc00 || b > 0xdfff
          ? TO_STRING ? s.charAt(i) : a
          : TO_STRING ? s.slice(i, i + 2) : (a - 0xd800 << 10) + (b - 0xdc00) + 0x10000;
      };
    };

/***/ },
/* 5 */
/***/ function(module, exports) {

    // 7.1.4 ToInteger
    var ceil  = Math.ceil
      , floor = Math.floor;
    module.exports = function(it){
      return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
    };

/***/ },
/* 6 */
/***/ function(module, exports) {

    // 7.2.1 RequireObjectCoercible(argument)
    module.exports = function(it){
      if(it == undefined)throw TypeError("Can't call method on  " + it);
      return it;
    };

/***/ },
/* 7 */
/***/ function(module, exports, __webpack_require__) {

    'use strict';
    var LIBRARY        = __webpack_require__(8)
      , $export        = __webpack_require__(9)
      , redefine       = __webpack_require__(24)
      , hide           = __webpack_require__(14)
      , has            = __webpack_require__(25)
      , Iterators      = __webpack_require__(26)
      , $iterCreate    = __webpack_require__(27)
      , setToStringTag = __webpack_require__(43)
      , getPrototypeOf = __webpack_require__(45)
      , ITERATOR       = __webpack_require__(44)('iterator')
      , BUGGY          = !([].keys && 'next' in [].keys()) // Safari has buggy iterators w/o `next`
      , FF_ITERATOR    = '@@iterator'
      , KEYS           = 'keys'
      , VALUES         = 'values';
    
    var returnThis = function(){ return this; };
    
    module.exports = function(Base, NAME, Constructor, next, DEFAULT, IS_SET, FORCED){
      $iterCreate(Constructor, NAME, next);
      var getMethod = function(kind){
        if(!BUGGY && kind in proto)return proto[kind];
        switch(kind){
          case KEYS: return function keys(){ return new Constructor(this, kind); };
          case VALUES: return function values(){ return new Constructor(this, kind); };
        } return function entries(){ return new Constructor(this, kind); };
      };
      var TAG        = NAME + ' Iterator'
        , DEF_VALUES = DEFAULT == VALUES
        , VALUES_BUG = false
        , proto      = Base.prototype
        , $native    = proto[ITERATOR] || proto[FF_ITERATOR] || DEFAULT && proto[DEFAULT]
        , $default   = $native || getMethod(DEFAULT)
        , $entries   = DEFAULT ? !DEF_VALUES ? $default : getMethod('entries') : undefined
        , $anyNative = NAME == 'Array' ? proto.entries || $native : $native
        , methods, key, IteratorPrototype;
      // Fix native
      if($anyNative){
        IteratorPrototype = getPrototypeOf($anyNative.call(new Base));
        if(IteratorPrototype !== Object.prototype){
          // Set @@toStringTag to native iterators
          setToStringTag(IteratorPrototype, TAG, true);
          // fix for some old engines
          if(!LIBRARY && !has(IteratorPrototype, ITERATOR))hide(IteratorPrototype, ITERATOR, returnThis);
        }
      }
      // fix Array#{values, @@iterator}.name in V8 / FF
      if(DEF_VALUES && $native && $native.name !== VALUES){
        VALUES_BUG = true;
        $default = function values(){ return $native.call(this); };
      }
      // Define iterator
      if((!LIBRARY || FORCED) && (BUGGY || VALUES_BUG || !proto[ITERATOR])){
        hide(proto, ITERATOR, $default);
      }
      // Plug for library
      Iterators[NAME] = $default;
      Iterators[TAG]  = returnThis;
      if(DEFAULT){
        methods = {
          values:  DEF_VALUES ? $default : getMethod(VALUES),
          keys:    IS_SET     ? $default : getMethod(KEYS),
          entries: $entries
        };
        if(FORCED)for(key in methods){
          if(!(key in proto))redefine(proto, key, methods[key]);
        } else $export($export.P + $export.F * (BUGGY || VALUES_BUG), NAME, methods);
      }
      return methods;
    };

/***/ },
/* 8 */
/***/ function(module, exports) {

    module.exports = true;

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

    var global    = __webpack_require__(10)
      , core      = __webpack_require__(11)
      , ctx       = __webpack_require__(12)
      , hide      = __webpack_require__(14)
      , PROTOTYPE = 'prototype';
    
    var $export = function(type, name, source){
      var IS_FORCED = type & $export.F
        , IS_GLOBAL = type & $export.G
        , IS_STATIC = type & $export.S
        , IS_PROTO  = type & $export.P
        , IS_BIND   = type & $export.B
        , IS_WRAP   = type & $export.W
        , exports   = IS_GLOBAL ? core : core[name] || (core[name] = {})
        , expProto  = exports[PROTOTYPE]
        , target    = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE]
        , key, own, out;
      if(IS_GLOBAL)source = name;
      for(key in source){
        // contains in native
        own = !IS_FORCED && target && target[key] !== undefined;
        if(own && key in exports)continue;
        // export native or passed
        out = own ? target[key] : source[key];
        // prevent global pollution for namespaces
        exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
        // bind timers to global for call from export context
        : IS_BIND && own ? ctx(out, global)
        // wrap global constructors for prevent change them in library
        : IS_WRAP && target[key] == out ? (function(C){
          var F = function(a, b, c){
            if(this instanceof C){
              switch(arguments.length){
                case 0: return new C;
                case 1: return new C(a);
                case 2: return new C(a, b);
              } return new C(a, b, c);
            } return C.apply(this, arguments);
          };
          F[PROTOTYPE] = C[PROTOTYPE];
          return F;
        // make static versions for prototype methods
        })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
        // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
        if(IS_PROTO){
          (exports.virtual || (exports.virtual = {}))[key] = out;
          // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
          if(type & $export.R && expProto && !expProto[key])hide(expProto, key, out);
        }
      }
    };
    // type bitmap
    $export.F = 1;   // forced
    $export.G = 2;   // global
    $export.S = 4;   // static
    $export.P = 8;   // proto
    $export.B = 16;  // bind
    $export.W = 32;  // wrap
    $export.U = 64;  // safe
    $export.R = 128; // real proto method for `library` 
    module.exports = $export;

/***/ },
/* 10 */
/***/ function(module, exports) {

    // https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
    var global = module.exports = typeof window != 'undefined' && window.Math == Math
      ? window : typeof self != 'undefined' && self.Math == Math ? self : Function('return this')();
    if(typeof __g == 'number')__g = global; // eslint-disable-line no-undef

/***/ },
/* 11 */
/***/ function(module, exports) {

    var core = module.exports = {version: '2.4.0'};
    if(typeof __e == 'number')__e = core; // eslint-disable-line no-undef

/***/ },
/* 12 */
/***/ function(module, exports, __webpack_require__) {

    // optional / simple context binding
    var aFunction = __webpack_require__(13);
    module.exports = function(fn, that, length){
      aFunction(fn);
      if(that === undefined)return fn;
      switch(length){
        case 1: return function(a){
          return fn.call(that, a);
        };
        case 2: return function(a, b){
          return fn.call(that, a, b);
        };
        case 3: return function(a, b, c){
          return fn.call(that, a, b, c);
        };
      }
      return function(/* ...args */){
        return fn.apply(that, arguments);
      };
    };

/***/ },
/* 13 */
/***/ function(module, exports) {

    module.exports = function(it){
      if(typeof it != 'function')throw TypeError(it + ' is not a function!');
      return it;
    };

/***/ },
/* 14 */
/***/ function(module, exports, __webpack_require__) {

    var dP         = __webpack_require__(15)
      , createDesc = __webpack_require__(23);
    module.exports = __webpack_require__(19) ? function(object, key, value){
      return dP.f(object, key, createDesc(1, value));
    } : function(object, key, value){
      object[key] = value;
      return object;
    };

/***/ },
/* 15 */
/***/ function(module, exports, __webpack_require__) {

    var anObject       = __webpack_require__(16)
      , IE8_DOM_DEFINE = __webpack_require__(18)
      , toPrimitive    = __webpack_require__(22)
      , dP             = Object.defineProperty;
    
    exports.f = __webpack_require__(19) ? Object.defineProperty : function defineProperty(O, P, Attributes){
      anObject(O);
      P = toPrimitive(P, true);
      anObject(Attributes);
      if(IE8_DOM_DEFINE)try {
        return dP(O, P, Attributes);
      } catch(e){ /* empty */ }
      if('get' in Attributes || 'set' in Attributes)throw TypeError('Accessors not supported!');
      if('value' in Attributes)O[P] = Attributes.value;
      return O;
    };

/***/ },
/* 16 */
/***/ function(module, exports, __webpack_require__) {

    var isObject = __webpack_require__(17);
    module.exports = function(it){
      if(!isObject(it))throw TypeError(it + ' is not an object!');
      return it;
    };

/***/ },
/* 17 */
/***/ function(module, exports) {

    module.exports = function(it){
      return typeof it === 'object' ? it !== null : typeof it === 'function';
    };

/***/ },
/* 18 */
/***/ function(module, exports, __webpack_require__) {

    module.exports = !__webpack_require__(19) && !__webpack_require__(20)(function(){
      return Object.defineProperty(__webpack_require__(21)('div'), 'a', {get: function(){ return 7; }}).a != 7;
    });

/***/ },
/* 19 */
/***/ function(module, exports, __webpack_require__) {

    // Thank's IE8 for his funny defineProperty
    module.exports = !__webpack_require__(20)(function(){
      return Object.defineProperty({}, 'a', {get: function(){ return 7; }}).a != 7;
    });

/***/ },
/* 20 */
/***/ function(module, exports) {

    module.exports = function(exec){
      try {
        return !!exec();
      } catch(e){
        return true;
      }
    };

/***/ },
/* 21 */
/***/ function(module, exports, __webpack_require__) {

    var isObject = __webpack_require__(17)
      , document = __webpack_require__(10).document
      // in old IE typeof document.createElement is 'object'
      , is = isObject(document) && isObject(document.createElement);
    module.exports = function(it){
      return is ? document.createElement(it) : {};
    };

/***/ },
/* 22 */
/***/ function(module, exports, __webpack_require__) {

    // 7.1.1 ToPrimitive(input [, PreferredType])
    var isObject = __webpack_require__(17);
    // instead of the ES6 spec version, we didn't implement @@toPrimitive case
    // and the second argument - flag - preferred type is a string
    module.exports = function(it, S){
      if(!isObject(it))return it;
      var fn, val;
      if(S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it)))return val;
      if(typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it)))return val;
      if(!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it)))return val;
      throw TypeError("Can't convert object to primitive value");
    };

/***/ },
/* 23 */
/***/ function(module, exports) {

    module.exports = function(bitmap, value){
      return {
        enumerable  : !(bitmap & 1),
        configurable: !(bitmap & 2),
        writable    : !(bitmap & 4),
        value       : value
      };
    };

/***/ },
/* 24 */
/***/ function(module, exports, __webpack_require__) {

    module.exports = __webpack_require__(14);

/***/ },
/* 25 */
/***/ function(module, exports) {

    var hasOwnProperty = {}.hasOwnProperty;
    module.exports = function(it, key){
      return hasOwnProperty.call(it, key);
    };

/***/ },
/* 26 */
/***/ function(module, exports) {

    module.exports = {};

/***/ },
/* 27 */
/***/ function(module, exports, __webpack_require__) {

    'use strict';
    var create         = __webpack_require__(28)
      , descriptor     = __webpack_require__(23)
      , setToStringTag = __webpack_require__(43)
      , IteratorPrototype = {};
    
    // 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
    __webpack_require__(14)(IteratorPrototype, __webpack_require__(44)('iterator'), function(){ return this; });
    
    module.exports = function(Constructor, NAME, next){
      Constructor.prototype = create(IteratorPrototype, {next: descriptor(1, next)});
      setToStringTag(Constructor, NAME + ' Iterator');
    };

/***/ },
/* 28 */
/***/ function(module, exports, __webpack_require__) {

    // 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
    var anObject    = __webpack_require__(16)
      , dPs         = __webpack_require__(29)
      , enumBugKeys = __webpack_require__(41)
      , IE_PROTO    = __webpack_require__(38)('IE_PROTO')
      , Empty       = function(){ /* empty */ }
      , PROTOTYPE   = 'prototype';
    
    // Create object with fake `null` prototype: use iframe Object with cleared prototype
    var createDict = function(){
      // Thrash, waste and sodomy: IE GC bug
      var iframe = __webpack_require__(21)('iframe')
        , i      = enumBugKeys.length
        , lt     = '<'
        , gt     = '>'
        , iframeDocument;
      iframe.style.display = 'none';
      __webpack_require__(42).appendChild(iframe);
      iframe.src = 'javascript:'; // eslint-disable-line no-script-url
      // createDict = iframe.contentWindow.Object;
      // html.removeChild(iframe);
      iframeDocument = iframe.contentWindow.document;
      iframeDocument.open();
      iframeDocument.write(lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt);
      iframeDocument.close();
      createDict = iframeDocument.F;
      while(i--)delete createDict[PROTOTYPE][enumBugKeys[i]];
      return createDict();
    };
    
    module.exports = Object.create || function create(O, Properties){
      var result;
      if(O !== null){
        Empty[PROTOTYPE] = anObject(O);
        result = new Empty;
        Empty[PROTOTYPE] = null;
        // add "__proto__" for Object.getPrototypeOf polyfill
        result[IE_PROTO] = O;
      } else result = createDict();
      return Properties === undefined ? result : dPs(result, Properties);
    };


/***/ },
/* 29 */
/***/ function(module, exports, __webpack_require__) {

    var dP       = __webpack_require__(15)
      , anObject = __webpack_require__(16)
      , getKeys  = __webpack_require__(30);
    
    module.exports = __webpack_require__(19) ? Object.defineProperties : function defineProperties(O, Properties){
      anObject(O);
      var keys   = getKeys(Properties)
        , length = keys.length
        , i = 0
        , P;
      while(length > i)dP.f(O, P = keys[i++], Properties[P]);
      return O;
    };

/***/ },
/* 30 */
/***/ function(module, exports, __webpack_require__) {

    // 19.1.2.14 / 15.2.3.14 Object.keys(O)
    var $keys       = __webpack_require__(31)
      , enumBugKeys = __webpack_require__(41);
    
    module.exports = Object.keys || function keys(O){
      return $keys(O, enumBugKeys);
    };

/***/ },
/* 31 */
/***/ function(module, exports, __webpack_require__) {

    var has          = __webpack_require__(25)
      , toIObject    = __webpack_require__(32)
      , arrayIndexOf = __webpack_require__(35)(false)
      , IE_PROTO     = __webpack_require__(38)('IE_PROTO');
    
    module.exports = function(object, names){
      var O      = toIObject(object)
        , i      = 0
        , result = []
        , key;
      for(key in O)if(key != IE_PROTO)has(O, key) && result.push(key);
      // Don't enum bug & hidden keys
      while(names.length > i)if(has(O, key = names[i++])){
        ~arrayIndexOf(result, key) || result.push(key);
      }
      return result;
    };

/***/ },
/* 32 */
/***/ function(module, exports, __webpack_require__) {

    // to indexed object, toObject with fallback for non-array-like ES3 strings
    var IObject = __webpack_require__(33)
      , defined = __webpack_require__(6);
    module.exports = function(it){
      return IObject(defined(it));
    };

/***/ },
/* 33 */
/***/ function(module, exports, __webpack_require__) {

    // fallback for non-array-like ES3 and non-enumerable old V8 strings
    var cof = __webpack_require__(34);
    module.exports = Object('z').propertyIsEnumerable(0) ? Object : function(it){
      return cof(it) == 'String' ? it.split('') : Object(it);
    };

/***/ },
/* 34 */
/***/ function(module, exports) {

    var toString = {}.toString;
    
    module.exports = function(it){
      return toString.call(it).slice(8, -1);
    };

/***/ },
/* 35 */
/***/ function(module, exports, __webpack_require__) {

    // false -> Array#indexOf
    // true  -> Array#includes
    var toIObject = __webpack_require__(32)
      , toLength  = __webpack_require__(36)
      , toIndex   = __webpack_require__(37);
    module.exports = function(IS_INCLUDES){
      return function($this, el, fromIndex){
        var O      = toIObject($this)
          , length = toLength(O.length)
          , index  = toIndex(fromIndex, length)
          , value;
        // Array#includes uses SameValueZero equality algorithm
        if(IS_INCLUDES && el != el)while(length > index){
          value = O[index++];
          if(value != value)return true;
        // Array#toIndex ignores holes, Array#includes - not
        } else for(;length > index; index++)if(IS_INCLUDES || index in O){
          if(O[index] === el)return IS_INCLUDES || index || 0;
        } return !IS_INCLUDES && -1;
      };
    };

/***/ },
/* 36 */
/***/ function(module, exports, __webpack_require__) {

    // 7.1.15 ToLength
    var toInteger = __webpack_require__(5)
      , min       = Math.min;
    module.exports = function(it){
      return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
    };

/***/ },
/* 37 */
/***/ function(module, exports, __webpack_require__) {

    var toInteger = __webpack_require__(5)
      , max       = Math.max
      , min       = Math.min;
    module.exports = function(index, length){
      index = toInteger(index);
      return index < 0 ? max(index + length, 0) : min(index, length);
    };

/***/ },
/* 38 */
/***/ function(module, exports, __webpack_require__) {

    var shared = __webpack_require__(39)('keys')
      , uid    = __webpack_require__(40);
    module.exports = function(key){
      return shared[key] || (shared[key] = uid(key));
    };

/***/ },
/* 39 */
/***/ function(module, exports, __webpack_require__) {

    var global = __webpack_require__(10)
      , SHARED = '__core-js_shared__'
      , store  = global[SHARED] || (global[SHARED] = {});
    module.exports = function(key){
      return store[key] || (store[key] = {});
    };

/***/ },
/* 40 */
/***/ function(module, exports) {

    var id = 0
      , px = Math.random();
    module.exports = function(key){
      return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
    };

/***/ },
/* 41 */
/***/ function(module, exports) {

    // IE 8- don't enum bug keys
    module.exports = (
      'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
    ).split(',');

/***/ },
/* 42 */
/***/ function(module, exports, __webpack_require__) {

    module.exports = __webpack_require__(10).document && document.documentElement;

/***/ },
/* 43 */
/***/ function(module, exports, __webpack_require__) {

    var def = __webpack_require__(15).f
      , has = __webpack_require__(25)
      , TAG = __webpack_require__(44)('toStringTag');
    
    module.exports = function(it, tag, stat){
      if(it && !has(it = stat ? it : it.prototype, TAG))def(it, TAG, {configurable: true, value: tag});
    };

/***/ },
/* 44 */
/***/ function(module, exports, __webpack_require__) {

    var store      = __webpack_require__(39)('wks')
      , uid        = __webpack_require__(40)
      , Symbol     = __webpack_require__(10).Symbol
      , USE_SYMBOL = typeof Symbol == 'function';
    
    var $exports = module.exports = function(name){
      return store[name] || (store[name] =
        USE_SYMBOL && Symbol[name] || (USE_SYMBOL ? Symbol : uid)('Symbol.' + name));
    };
    
    $exports.store = store;

/***/ },
/* 45 */
/***/ function(module, exports, __webpack_require__) {

    // 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
    var has         = __webpack_require__(25)
      , toObject    = __webpack_require__(46)
      , IE_PROTO    = __webpack_require__(38)('IE_PROTO')
      , ObjectProto = Object.prototype;
    
    module.exports = Object.getPrototypeOf || function(O){
      O = toObject(O);
      if(has(O, IE_PROTO))return O[IE_PROTO];
      if(typeof O.constructor == 'function' && O instanceof O.constructor){
        return O.constructor.prototype;
      } return O instanceof Object ? ObjectProto : null;
    };

/***/ },
/* 46 */
/***/ function(module, exports, __webpack_require__) {

    // 7.1.13 ToObject(argument)
    var defined = __webpack_require__(6);
    module.exports = function(it){
      return Object(defined(it));
    };

/***/ },
/* 47 */
/***/ function(module, exports, __webpack_require__) {

    'use strict';
    var ctx            = __webpack_require__(12)
      , $export        = __webpack_require__(9)
      , toObject       = __webpack_require__(46)
      , call           = __webpack_require__(48)
      , isArrayIter    = __webpack_require__(49)
      , toLength       = __webpack_require__(36)
      , createProperty = __webpack_require__(50)
      , getIterFn      = __webpack_require__(51);
    
    $export($export.S + $export.F * !__webpack_require__(53)(function(iter){ Array.from(iter); }), 'Array', {
      // 22.1.2.1 Array.from(arrayLike, mapfn = undefined, thisArg = undefined)
      from: function from(arrayLike/*, mapfn = undefined, thisArg = undefined*/){
        var O       = toObject(arrayLike)
          , C       = typeof this == 'function' ? this : Array
          , aLen    = arguments.length
          , mapfn   = aLen > 1 ? arguments[1] : undefined
          , mapping = mapfn !== undefined
          , index   = 0
          , iterFn  = getIterFn(O)
          , length, result, step, iterator;
        if(mapping)mapfn = ctx(mapfn, aLen > 2 ? arguments[2] : undefined, 2);
        // if object isn't iterable or it's array with default iterator - use simple case
        if(iterFn != undefined && !(C == Array && isArrayIter(iterFn))){
          for(iterator = iterFn.call(O), result = new C; !(step = iterator.next()).done; index++){
            createProperty(result, index, mapping ? call(iterator, mapfn, [step.value, index], true) : step.value);
          }
        } else {
          length = toLength(O.length);
          for(result = new C(length); length > index; index++){
            createProperty(result, index, mapping ? mapfn(O[index], index) : O[index]);
          }
        }
        result.length = index;
        return result;
      }
    });


/***/ },
/* 48 */
/***/ function(module, exports, __webpack_require__) {

    // call something on iterator step with safe closing on error
    var anObject = __webpack_require__(16);
    module.exports = function(iterator, fn, value, entries){
      try {
        return entries ? fn(anObject(value)[0], value[1]) : fn(value);
      // 7.4.6 IteratorClose(iterator, completion)
      } catch(e){
        var ret = iterator['return'];
        if(ret !== undefined)anObject(ret.call(iterator));
        throw e;
      }
    };

/***/ },
/* 49 */
/***/ function(module, exports, __webpack_require__) {

    // check on default Array iterator
    var Iterators  = __webpack_require__(26)
      , ITERATOR   = __webpack_require__(44)('iterator')
      , ArrayProto = Array.prototype;
    
    module.exports = function(it){
      return it !== undefined && (Iterators.Array === it || ArrayProto[ITERATOR] === it);
    };

/***/ },
/* 50 */
/***/ function(module, exports, __webpack_require__) {

    'use strict';
    var $defineProperty = __webpack_require__(15)
      , createDesc      = __webpack_require__(23);
    
    module.exports = function(object, index, value){
      if(index in object)$defineProperty.f(object, index, createDesc(0, value));
      else object[index] = value;
    };

/***/ },
/* 51 */
/***/ function(module, exports, __webpack_require__) {

    var classof   = __webpack_require__(52)
      , ITERATOR  = __webpack_require__(44)('iterator')
      , Iterators = __webpack_require__(26);
    module.exports = __webpack_require__(11).getIteratorMethod = function(it){
      if(it != undefined)return it[ITERATOR]
        || it['@@iterator']
        || Iterators[classof(it)];
    };

/***/ },
/* 52 */
/***/ function(module, exports, __webpack_require__) {

    // getting tag from 19.1.3.6 Object.prototype.toString()
    var cof = __webpack_require__(34)
      , TAG = __webpack_require__(44)('toStringTag')
      // ES3 wrong here
      , ARG = cof(function(){ return arguments; }()) == 'Arguments';
    
    // fallback for IE11 Script Access Denied error
    var tryGet = function(it, key){
      try {
        return it[key];
      } catch(e){ /* empty */ }
    };
    
    module.exports = function(it){
      var O, T, B;
      return it === undefined ? 'Undefined' : it === null ? 'Null'
        // @@toStringTag case
        : typeof (T = tryGet(O = Object(it), TAG)) == 'string' ? T
        // builtinTag case
        : ARG ? cof(O)
        // ES3 arguments fallback
        : (B = cof(O)) == 'Object' && typeof O.callee == 'function' ? 'Arguments' : B;
    };

/***/ },
/* 53 */
/***/ function(module, exports, __webpack_require__) {

    var ITERATOR     = __webpack_require__(44)('iterator')
      , SAFE_CLOSING = false;
    
    try {
      var riter = [7][ITERATOR]();
      riter['return'] = function(){ SAFE_CLOSING = true; };
      Array.from(riter, function(){ throw 2; });
    } catch(e){ /* empty */ }
    
    module.exports = function(exec, skipClosing){
      if(!skipClosing && !SAFE_CLOSING)return false;
      var safe = false;
      try {
        var arr  = [7]
          , iter = arr[ITERATOR]();
        iter.next = function(){ return {done: safe = true}; };
        arr[ITERATOR] = function(){ return iter; };
        exec(arr);
      } catch(e){ /* empty */ }
      return safe;
    };

/***/ },
/* 54 */
/***/ function(module, exports, __webpack_require__) {

    module.exports = { "default": __webpack_require__(55), __esModule: true };

/***/ },
/* 55 */
/***/ function(module, exports, __webpack_require__) {

    __webpack_require__(56);
    module.exports = __webpack_require__(11).Object.keys;

/***/ },
/* 56 */
/***/ function(module, exports, __webpack_require__) {

    // 19.1.2.14 Object.keys(O)
    var toObject = __webpack_require__(46)
      , $keys    = __webpack_require__(30);
    
    __webpack_require__(57)('keys', function(){
      return function keys(it){
        return $keys(toObject(it));
      };
    });

/***/ },
/* 57 */
/***/ function(module, exports, __webpack_require__) {

    // most Object methods by ES6 should accept primitives
    var $export = __webpack_require__(9)
      , core    = __webpack_require__(11)
      , fails   = __webpack_require__(20);
    module.exports = function(KEY, exec){
      var fn  = (core.Object || {})[KEY] || Object[KEY]
        , exp = {};
      exp[KEY] = exec(fn);
      $export($export.S + $export.F * fails(function(){ fn(1); }), 'Object', exp);
    };

/***/ },
/* 58 */
/***/ function(module, exports, __webpack_require__) {

    module.exports = { "default": __webpack_require__(59), __esModule: true };

/***/ },
/* 59 */
/***/ function(module, exports, __webpack_require__) {

    __webpack_require__(60);
    module.exports = __webpack_require__(11).Object.assign;

/***/ },
/* 60 */
/***/ function(module, exports, __webpack_require__) {

    // 19.1.3.1 Object.assign(target, source)
    var $export = __webpack_require__(9);
    
    $export($export.S + $export.F, 'Object', {assign: __webpack_require__(61)});

/***/ },
/* 61 */
/***/ function(module, exports, __webpack_require__) {

    'use strict';
    // 19.1.2.1 Object.assign(target, source, ...)
    var getKeys  = __webpack_require__(30)
      , gOPS     = __webpack_require__(62)
      , pIE      = __webpack_require__(63)
      , toObject = __webpack_require__(46)
      , IObject  = __webpack_require__(33)
      , $assign  = Object.assign;
    
    // should work with symbols and should have deterministic property order (V8 bug)
    module.exports = !$assign || __webpack_require__(20)(function(){
      var A = {}
        , B = {}
        , S = Symbol()
        , K = 'abcdefghijklmnopqrst';
      A[S] = 7;
      K.split('').forEach(function(k){ B[k] = k; });
      return $assign({}, A)[S] != 7 || Object.keys($assign({}, B)).join('') != K;
    }) ? function assign(target, source){ // eslint-disable-line no-unused-vars
      var T     = toObject(target)
        , aLen  = arguments.length
        , index = 1
        , getSymbols = gOPS.f
        , isEnum     = pIE.f;
      while(aLen > index){
        var S      = IObject(arguments[index++])
          , keys   = getSymbols ? getKeys(S).concat(getSymbols(S)) : getKeys(S)
          , length = keys.length
          , j      = 0
          , key;
        while(length > j)if(isEnum.call(S, key = keys[j++]))T[key] = S[key];
      } return T;
    } : $assign;

/***/ },
/* 62 */
/***/ function(module, exports) {

    exports.f = Object.getOwnPropertySymbols;

/***/ },
/* 63 */
/***/ function(module, exports) {

    exports.f = {}.propertyIsEnumerable;

/***/ },
/* 64 */
/***/ function(module, exports) {

    "use strict";
    
    exports.__esModule = true;
    
    exports.default = function (instance, Constructor) {
      if (!(instance instanceof Constructor)) {
        throw new TypeError("Cannot call a class as a function");
      }
    };

/***/ },
/* 65 */
/***/ function(module, exports, __webpack_require__) {

    "use strict";
    
    exports.__esModule = true;
    
    var _defineProperty = __webpack_require__(66);
    
    var _defineProperty2 = _interopRequireDefault(_defineProperty);
    
    function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
    
    exports.default = function () {
      function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
          var descriptor = props[i];
          descriptor.enumerable = descriptor.enumerable || false;
          descriptor.configurable = true;
          if ("value" in descriptor) descriptor.writable = true;
          (0, _defineProperty2.default)(target, descriptor.key, descriptor);
        }
      }
    
      return function (Constructor, protoProps, staticProps) {
        if (protoProps) defineProperties(Constructor.prototype, protoProps);
        if (staticProps) defineProperties(Constructor, staticProps);
        return Constructor;
      };
    }();

/***/ },
/* 66 */
/***/ function(module, exports, __webpack_require__) {

    module.exports = { "default": __webpack_require__(67), __esModule: true };

/***/ },
/* 67 */
/***/ function(module, exports, __webpack_require__) {

    __webpack_require__(68);
    var $Object = __webpack_require__(11).Object;
    module.exports = function defineProperty(it, key, desc){
      return $Object.defineProperty(it, key, desc);
    };

/***/ },
/* 68 */
/***/ function(module, exports, __webpack_require__) {

    var $export = __webpack_require__(9);
    // 19.1.2.4 / 15.2.3.6 Object.defineProperty(O, P, Attributes)
    $export($export.S + $export.F * !__webpack_require__(19), 'Object', {defineProperty: __webpack_require__(15).f});

/***/ },
/* 69 */
/***/ function(module, exports, __webpack_require__) {

    var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*! scrollbarWidth.js v0.1.0 | felixexter | MIT | https://github.com/felixexter/scrollbarWidth */
    (function (root, factory) {
        if (true) {
            !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory), __WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ? (__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
        } else if (typeof exports === 'object') {
            module.exports = factory();
        } else {
            (root.jQuery || root).scrollbarWidth = factory();
        }
    }(this, function () {
        'use strict';
    
        function scrollbarWidth() {
            var
                body = document.body,
                box = document.createElement('div'),
                boxStyle = box.style,
                width;
    
            boxStyle.position = 'absolute';
            boxStyle.top = boxStyle.left = '-9999px';
            boxStyle.width = boxStyle.height = '100px';
            boxStyle.overflow = 'scroll';
    
            body.appendChild(box);
    
            width = box.offsetWidth - box.clientWidth;
    
            body.removeChild(box);
    
            return width;
        }
    
        return scrollbarWidth;
    }));


/***/ },
/* 70 */
/***/ function(module, exports, __webpack_require__) {

    // style-loader: Adds some css to the DOM by adding a <style> tag
    
    // load the styles
    var content = __webpack_require__(71);
    if(typeof content === 'string') content = [[module.id, content, '']];
    // add the styles to the DOM
    var update = __webpack_require__(73)(content, {});
    if(content.locals) module.exports = content.locals;
    // Hot Module Replacement
    if(false) {
        // When the styles change, update the <style> tags
        if(!content.locals) {
            module.hot.accept("!!./../node_modules/css-loader/index.js!./../node_modules/postcss-loader/index.js!./simplebar.css", function() {
                var newContent = require("!!./../node_modules/css-loader/index.js!./../node_modules/postcss-loader/index.js!./simplebar.css");
                if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
                update(newContent);
            });
        }
        // When the module is disposed, remove the <style> tags
        module.hot.dispose(function() { update(); });
    }

/***/ },
/* 71 */
/***/ function(module, exports, __webpack_require__) {

    exports = module.exports = __webpack_require__(72)();
    // imports
    
    
    // module
    exports.push([module.id, "[data-simplebar] {\n    position: relative;\n    z-index: 0;\n    overflow: hidden;\n    -webkit-overflow-scrolling: touch; /* Trigger native scrolling for mobile, if not supported, plugin is used. */\n}\n\n[data-simplebar] .simplebar-scroll-content {\n    overflow: scroll;\n    position: relative;\n    z-index: 0;\n}\n\n.simplebar-track {\n    z-index: 1;\n    position: absolute;\n    top: 0;\n    right: 0;\n    bottom: 0;\n    width: 11px;\n}\n\n.simplebar-track .simplebar-scrollbar {\n    position: absolute;\n    right: 2px;\n    border-radius: 7px;\n    min-height: 10px;\n    width: 7px;\n    opacity: 0;\n    -webkit-transition: opacity 0.2s linear;\n    transition: opacity 0.2s linear;\n    background: #6c6e71;\n    background-clip: padding-box;\n}\n\n.simplebar-track:hover .simplebar-scrollbar {\n    /* When hovered, remove all transitions from drag handle */\n    opacity: 0.7;\n    -webkit-transition: opacity 0 linear;\n    transition: opacity 0 linear;\n}\n\n.simplebar-track .simplebar-scrollbar.visible {\n    opacity: 0.7;\n}\n\n.horizontal.simplebar-track {\n    top: auto;\n    left: 0;\n    width: auto;\n    height: 11px;\n}\n\n.horizontal.simplebar-track .simplebar-scrollbar {\n    right: auto;\n    top: 2px;\n    height: 7px;\n    min-height: 0;\n    min-width: 10px;\n    width: auto;\n}\n", ""]);
    
    // exports


/***/ },
/* 72 */
/***/ function(module, exports) {

    /*
        MIT License http://www.opensource.org/licenses/mit-license.php
        Author Tobias Koppers @sokra
    */
    // css base code, injected by the css-loader
    module.exports = function() {
        var list = [];
    
        // return the list of modules as css string
        list.toString = function toString() {
            var result = [];
            for(var i = 0; i < this.length; i++) {
                var item = this[i];
                if(item[2]) {
                    result.push("@media " + item[2] + "{" + item[1] + "}");
                } else {
                    result.push(item[1]);
                }
            }
            return result.join("");
        };
    
        // import a list of modules into the list
        list.i = function(modules, mediaQuery) {
            if(typeof modules === "string")
                modules = [[null, modules, ""]];
            var alreadyImportedModules = {};
            for(var i = 0; i < this.length; i++) {
                var id = this[i][0];
                if(typeof id === "number")
                    alreadyImportedModules[id] = true;
            }
            for(i = 0; i < modules.length; i++) {
                var item = modules[i];
                // skip already imported module
                // this implementation is not 100% perfect for weird media query combinations
                //  when a module is imported multiple times with different media queries.
                //  I hope this will never occur (Hey this way we have smaller bundles)
                if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
                    if(mediaQuery && !item[2]) {
                        item[2] = mediaQuery;
                    } else if(mediaQuery) {
                        item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
                    }
                    list.push(item);
                }
            }
        };
        return list;
    };


/***/ },
/* 73 */
/***/ function(module, exports, __webpack_require__) {

    /*
        MIT License http://www.opensource.org/licenses/mit-license.php
        Author Tobias Koppers @sokra
    */
    var stylesInDom = {},
        memoize = function(fn) {
            var memo;
            return function () {
                if (typeof memo === "undefined") memo = fn.apply(this, arguments);
                return memo;
            };
        },
        isOldIE = memoize(function() {
            return /msie [6-9]\b/.test(window.navigator.userAgent.toLowerCase());
        }),
        getHeadElement = memoize(function () {
            return document.head || document.getElementsByTagName("head")[0];
        }),
        singletonElement = null,
        singletonCounter = 0,
        styleElementsInsertedAtTop = [];
    
    module.exports = function(list, options) {
        if(true) {
            if(typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
        }
    
        options = options || {};
        // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
        // tags it will allow on a page
        if (typeof options.singleton === "undefined") options.singleton = isOldIE();
    
        // By default, add <style> tags to the bottom of <head>.
        if (typeof options.insertAt === "undefined") options.insertAt = "bottom";
    
        var styles = listToStyles(list);
        addStylesToDom(styles, options);
    
        return function update(newList) {
            var mayRemove = [];
            for(var i = 0; i < styles.length; i++) {
                var item = styles[i];
                var domStyle = stylesInDom[item.id];
                domStyle.refs--;
                mayRemove.push(domStyle);
            }
            if(newList) {
                var newStyles = listToStyles(newList);
                addStylesToDom(newStyles, options);
            }
            for(var i = 0; i < mayRemove.length; i++) {
                var domStyle = mayRemove[i];
                if(domStyle.refs === 0) {
                    for(var j = 0; j < domStyle.parts.length; j++)
                        domStyle.parts[j]();
                    delete stylesInDom[domStyle.id];
                }
            }
        };
    }
    
    function addStylesToDom(styles, options) {
        for(var i = 0; i < styles.length; i++) {
            var item = styles[i];
            var domStyle = stylesInDom[item.id];
            if(domStyle) {
                domStyle.refs++;
                for(var j = 0; j < domStyle.parts.length; j++) {
                    domStyle.parts[j](item.parts[j]);
                }
                for(; j < item.parts.length; j++) {
                    domStyle.parts.push(addStyle(item.parts[j], options));
                }
            } else {
                var parts = [];
                for(var j = 0; j < item.parts.length; j++) {
                    parts.push(addStyle(item.parts[j], options));
                }
                stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
            }
        }
    }
    
    function listToStyles(list) {
        var styles = [];
        var newStyles = {};
        for(var i = 0; i < list.length; i++) {
            var item = list[i];
            var id = item[0];
            var css = item[1];
            var media = item[2];
            var sourceMap = item[3];
            var part = {css: css, media: media, sourceMap: sourceMap};
            if(!newStyles[id])
                styles.push(newStyles[id] = {id: id, parts: [part]});
            else
                newStyles[id].parts.push(part);
        }
        return styles;
    }
    
    function insertStyleElement(options, styleElement) {
        var head = getHeadElement();
        var lastStyleElementInsertedAtTop = styleElementsInsertedAtTop[styleElementsInsertedAtTop.length - 1];
        if (options.insertAt === "top") {
            if(!lastStyleElementInsertedAtTop) {
                head.insertBefore(styleElement, head.firstChild);
            } else if(lastStyleElementInsertedAtTop.nextSibling) {
                head.insertBefore(styleElement, lastStyleElementInsertedAtTop.nextSibling);
            } else {
                head.appendChild(styleElement);
            }
            styleElementsInsertedAtTop.push(styleElement);
        } else if (options.insertAt === "bottom") {
            head.appendChild(styleElement);
        } else {
            throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");
        }
    }
    
    function removeStyleElement(styleElement) {
        styleElement.parentNode.removeChild(styleElement);
        var idx = styleElementsInsertedAtTop.indexOf(styleElement);
        if(idx >= 0) {
            styleElementsInsertedAtTop.splice(idx, 1);
        }
    }
    
    function createStyleElement(options) {
        var styleElement = document.createElement("style");
        styleElement.type = "text/css";
        insertStyleElement(options, styleElement);
        return styleElement;
    }
    
    function createLinkElement(options) {
        var linkElement = document.createElement("link");
        linkElement.rel = "stylesheet";
        insertStyleElement(options, linkElement);
        return linkElement;
    }
    
    function addStyle(obj, options) {
        var styleElement, update, remove;
    
        if (options.singleton) {
            var styleIndex = singletonCounter++;
            styleElement = singletonElement || (singletonElement = createStyleElement(options));
            update = applyToSingletonTag.bind(null, styleElement, styleIndex, false);
            remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true);
        } else if(obj.sourceMap &&
            typeof URL === "function" &&
            typeof URL.createObjectURL === "function" &&
            typeof URL.revokeObjectURL === "function" &&
            typeof Blob === "function" &&
            typeof btoa === "function") {
            styleElement = createLinkElement(options);
            update = updateLink.bind(null, styleElement);
            remove = function() {
                removeStyleElement(styleElement);
                if(styleElement.href)
                    URL.revokeObjectURL(styleElement.href);
            };
        } else {
            styleElement = createStyleElement(options);
            update = applyToTag.bind(null, styleElement);
            remove = function() {
                removeStyleElement(styleElement);
            };
        }
    
        update(obj);
    
        return function updateStyle(newObj) {
            if(newObj) {
                if(newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap)
                    return;
                update(obj = newObj);
            } else {
                remove();
            }
        };
    }
    
    var replaceText = (function () {
        var textStore = [];
    
        return function (index, replacement) {
            textStore[index] = replacement;
            return textStore.filter(Boolean).join('\n');
        };
    })();
    
    function applyToSingletonTag(styleElement, index, remove, obj) {
        var css = remove ? "" : obj.css;
    
        if (styleElement.styleSheet) {
            styleElement.styleSheet.cssText = replaceText(index, css);
        } else {
            var cssNode = document.createTextNode(css);
            var childNodes = styleElement.childNodes;
            if (childNodes[index]) styleElement.removeChild(childNodes[index]);
            if (childNodes.length) {
                styleElement.insertBefore(cssNode, childNodes[index]);
            } else {
                styleElement.appendChild(cssNode);
            }
        }
    }
    
    function applyToTag(styleElement, obj) {
        var css = obj.css;
        var media = obj.media;
    
        if(media) {
            styleElement.setAttribute("media", media)
        }
    
        if(styleElement.styleSheet) {
            styleElement.styleSheet.cssText = css;
        } else {
            while(styleElement.firstChild) {
                styleElement.removeChild(styleElement.firstChild);
            }
            styleElement.appendChild(document.createTextNode(css));
        }
    }
    
    function updateLink(linkElement, obj) {
        var css = obj.css;
        var sourceMap = obj.sourceMap;
    
        if(sourceMap) {
            // http://stackoverflow.com/a/26603875
            css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
        }
    
        var blob = new Blob([css], { type: "text/css" });
    
        var oldSrc = linkElement.href;
    
        linkElement.href = URL.createObjectURL(blob);
    
        if(oldSrc)
            URL.revokeObjectURL(oldSrc);
    }


/***/ }
/******/ ])
});
;
//# sourceMappingURL=simplebar.js.map