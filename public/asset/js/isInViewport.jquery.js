/* ====================================================
 * jQuery Is In Viewport.
 * https://github.com/frontid/jQueryIsInViewport
 * Marcelo Iván Tosco (capynet)
 * Inspired on https://stackoverflow.com/a/40658647/1413049
 * ==================================================== */
!function ($) {
  'use strict'

  var Class = function (el, cb) {
    this.$el = $(el);
    this.cb = cb;
    this.watch();
    return this;
  };

  Class.prototype = {

    /**
     * Checks if the element is in.
     *
     * @returns {boolean}
     */
    isIn: function isIn() {
      var _self = this;
      var $win = $(window);
      var elementTop = _self.$el.offset().top;
      var elementBottom = elementTop + _self.$el.outerHeight();
      var viewportTop = $win.scrollTop();
      var viewportBottom = viewportTop + $win.height();
      return elementBottom > viewportTop && elementTop < viewportBottom;
    },

    /**
     * Launch a callback indicating when the element is in and when is out.
     */
    watch: function () {
      var _self = this;
      var _isIn = false;

      $(window).on('resize scroll', function () {

        if (_self.isIn() && _isIn === false) {
          _self.cb.call(_self.$el, 'entered');
          _isIn = true;
        }

        if (_isIn === true && !_self.isIn()) {
          _self.cb.call(_self.$el, 'leaved');
          _isIn = false;
        }

      })
    }


  };

  // jQuery plugin.
  //-----------------------------------------------------------
  $.fn.isInViewport = function (cb) {
    return this.each(function () {
      var $element = $(this);
      var data = $element.data('isInViewport');
      if (!data) {
        $element.data('isInViewport', (new Class(this, cb)));
      }
    })
  }

}(window.jQuery);
