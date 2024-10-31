!(function ($) {
  "use strict";
  var _R = jQuery.fn.revolution,
    _ISM = _R.is_mobile(),
    extension = {
      alias: "Actions Min JS",
      name: "revolution.extensions.actions.min.js",
      min_core: "5.3",
      version: "2.0.2",
    };
  jQuery.extend(!0, _R, {
    checkActions: function (e, t, a) {
      return (
        "stop" !== _R.compare_version(extension).check &&
        void checkActions_intern(e, t, a)
      );
    },
  });
  var checkActions_intern = function (e, t, a) {
      a &&
        jQuery.each(a, function (a, i) {
          (i.delay = parseInt(i.delay, 0) / 1e3),
            e.addClass("noSwipe"),
            t.fullscreen_esclistener ||
              ("exitfullscreen" != i.action &&
                "togglefullscreen" != i.action) ||
              (jQuery(document).keyup(function (t) {
                27 == t.keyCode &&
                  jQuery("#rs-go-fullscreen").length > 0 &&
                  e.trigger(i.event);
              }),
              (t.fullscreen_esclistener = !0));
          var o =
            "backgroundvideo" == i.layer
              ? jQuery(".rs-background-video-layer")
              : "firstvideo" == i.layer
              ? jQuery(".tp-revslider-slidesli").find(".tp-videolayer")
              : jQuery("#" + i.layer);
          switch (
            (-1 !=
              jQuery.inArray(i.action, [
                "toggleslider",
                "toggle_mute_video",
                "toggle_global_mute_video",
                "togglefullscreen",
              ]) && e.data("togglelisteners", !0),
            i.action)
          ) {
            case "togglevideo":
              jQuery.each(o, function (t, a) {
                a = jQuery(a);
                var i = a.data("videotoggledby");
                void 0 == i && (i = new Array()),
                  i.push(e),
                  a.data("videotoggledby", i);
              });
              break;
            case "togglelayer":
              jQuery.each(o, function (t, a) {
                a = jQuery(a);
                var o = a.data("layertoggledby");
                void 0 == o && (o = new Array()),
                  o.push(e),
                  a.data("layertoggledby", o),
                  a.data("triggered_startstatus", i.layerstatus);
              });
              break;
            case "toggle_mute_video":
            case "toggle_global_mute_video":
              jQuery.each(o, function (t, a) {
                a = jQuery(a);
                var i = a.data("videomutetoggledby");
                void 0 == i && (i = new Array()),
                  i.push(e),
                  a.data("videomutetoggledby", i);
              });
              break;
            case "toggleslider":
              void 0 == t.slidertoggledby && (t.slidertoggledby = new Array()),
                t.slidertoggledby.push(e);
              break;
            case "togglefullscreen":
              void 0 == t.fullscreentoggledby &&
                (t.fullscreentoggledby = new Array()),
                t.fullscreentoggledby.push(e);
          }
          switch (
            (e.on(i.event, function () {
              var a =
                "backgroundvideo" == i.layer
                  ? jQuery(
                      ".active-revslide .slotholder .rs-background-video-layer"
                    )
                  : "firstvideo" == i.layer
                  ? jQuery(".active-revslide .tp-videolayer").first()
                  : jQuery("#" + i.layer);
              if (
                "stoplayer" == i.action ||
                "togglelayer" == i.action ||
                "startlayer" == i.action
              ) {
                if (a.length > 0) {
                  var o = a.data();
                  "startlayer" == i.action ||
                  ("togglelayer" == i.action && "in" != a.data("animdirection"))
                    ? ((o.animdirection = "in"),
                      (o.triggerstate = "on"),
                      _R.toggleState(o.layertoggledby),
                      _R.playAnimationFrame &&
                        (clearTimeout(o.triggerdelay),
                        (o.triggerdelay = setTimeout(function () {
                          _R.playAnimationFrame({
                            caption: a,
                            opt: t,
                            frame: "frame_0",
                            triggerdirection: "in",
                            triggerframein: "frame_0",
                            triggerframeout: "frame_999",
                          });
                        }, 1e3 * i.delay))))
                    : ("stoplayer" == i.action ||
                        ("togglelayer" == i.action &&
                          "out" != a.data("animdirection"))) &&
                      ((o.animdirection = "out"),
                      (o.triggered = !0),
                      (o.triggerstate = "off"),
                      _R.stopVideo && _R.stopVideo(a, t),
                      _R.unToggleState(o.layertoggledby),
                      _R.endMoveCaption &&
                        (clearTimeout(o.triggerdelay),
                        (o.triggerdelay = setTimeout(function () {
                          _R.playAnimationFrame({
                            caption: a,
                            opt: t,
                            frame: "frame_999",
                            triggerdirection: "out",
                            triggerframein: "frame_0",
                            triggerframeout: "frame_999",
                          });
                        }, 1e3 * i.delay))));
                }
              } else
                !_ISM ||
                ("playvideo" != i.action &&
                  "stopvideo" != i.action &&
                  "togglevideo" != i.action &&
                  "mutevideo" != i.action &&
                  "unmutevideo" != i.action &&
                  "toggle_mute_video" != i.action &&
                  "toggle_global_mute_video" != i.action)
                  ? ((i.delay =
                      "NaN" === i.delay || NaN === i.delay ? 0 : i.delay),
                    punchgs.TweenLite.delayedCall(
                      i.delay,
                      function () {
                        actionSwitches(a, t, i, e);
                      },
                      [a, t, i, e]
                    ))
                  : actionSwitches(a, t, i, e);
            }),
            i.action)
          ) {
            case "togglelayer":
            case "startlayer":
            case "playlayer":
            case "stoplayer":
              var o = jQuery("#" + i.layer),
                r = o.data();
              o.length > 0 &&
                void 0 !== r &&
                ((void 0 !== r.frames && "bytrigger" != r.frames[0].delay) ||
                  (void 0 === r.frames && "bytrigger" !== r.start)) &&
                (r.triggerstate = "on");
          }
        });
    },
    actionSwitches = function (tnc, opt, a, _nc) {
      switch (a.action) {
        case "scrollbelow":
          _nc.addClass("tp-scrollbelowslider"),
            _nc.data("scrolloffset", a.offset),
            _nc.data("scrolldelay", a.delay);
          var off = getOffContH(opt.fullScreenOffsetContainer) || 0,
            aof = parseInt(a.offset, 0) || 0;
          (off = off - aof || 0),
            jQuery("body,html").animate(
              {
                scrollTop:
                  opt.c.offset().top + jQuery(opt.li[0]).height() - off + "px",
              },
              { duration: 400 }
            );
          break;
        case "callback":
          eval(a.callback);
          break;
        case "jumptoslide":
          switch (a.slide.toLowerCase()) {
            case "+1":
            case "next":
              (opt.sc_indicator = "arrow"), _R.callingNewSlide(opt.c, 1);
              break;
            case "previous":
            case "prev":
            case "-1":
              (opt.sc_indicator = "arrow"), _R.callingNewSlide(opt.c, -1);
              break;
            default:
              var ts = jQuery.isNumeric(a.slide)
                ? parseInt(a.slide, 0)
                : a.slide;
              _R.callingNewSlide(opt.c, ts);
          }
          break;
        case "simplelink":
          window.open(a.url, a.target);
          break;
        case "toggleslider":
          (opt.noloopanymore = 0),
            "playing" == opt.sliderstatus
              ? (opt.c.revpause(),
                (opt.forcepause_viatoggle = !0),
                _R.unToggleState(opt.slidertoggledby))
              : ((opt.forcepause_viatoggle = !1),
                opt.c.revresume(),
                _R.toggleState(opt.slidertoggledby));
          break;
        case "pauseslider":
          opt.c.revpause(), _R.unToggleState(opt.slidertoggledby);
          break;
        case "playslider":
          (opt.noloopanymore = 0),
            opt.c.revresume(),
            _R.toggleState(opt.slidertoggledby);
          break;
        case "playvideo":
          tnc.length > 0 && _R.playVideo(tnc, opt);
          break;
        case "stopvideo":
          tnc.length > 0 && _R.stopVideo && _R.stopVideo(tnc, opt);
          break;
        case "togglevideo":
          tnc.length > 0 &&
            (_R.isVideoPlaying(tnc, opt)
              ? _R.stopVideo && _R.stopVideo(tnc, opt)
              : _R.playVideo(tnc, opt));
          break;
        case "mutevideo":
          tnc.length > 0 && _R.muteVideo(tnc, opt);
          break;
        case "unmutevideo":
          tnc.length > 0 && _R.unMuteVideo && _R.unMuteVideo(tnc, opt);
          break;
        case "toggle_mute_video":
          tnc.length > 0 &&
            (_R.isVideoMuted(tnc, opt)
              ? _R.unMuteVideo(tnc, opt)
              : _R.muteVideo && _R.muteVideo(tnc, opt)),
            _nc.toggleClass("rs-toggle-content-active");
          break;
        case "toggle_global_mute_video":
          _nc.hasClass("rs-toggle-content-active")
            ? ((opt.globalmute = !0),
              void 0 != opt.playingvideos &&
                opt.playingvideos.length > 0 &&
                jQuery.each(opt.playingvideos, function (e, t) {
                  _R.muteVideo && _R.muteVideo(t, opt);
                }))
            : ((opt.globalmute = !1),
              void 0 != opt.playingvideos &&
                opt.playingvideos.length > 0 &&
                jQuery.each(opt.playingvideos, function (e, t) {
                  _R.unMuteVideo && _R.unMuteVideo(t, opt);
                })),
            _nc.toggleClass("rs-toggle-content-active");
          break;
        case "simulateclick":
          tnc.length > 0 && tnc.click();
          break;
        case "toggleclass":
          tnc.length > 0 &&
            (tnc.hasClass(a.classname)
              ? tnc.removeClass(a.classname)
              : tnc.addClass(a.classname));
          break;
        case "gofullscreen":
        case "exitfullscreen":
        case "togglefullscreen":
          if (
            jQuery("#rs-go-fullscreen").length > 0 &&
            ("togglefullscreen" == a.action || "exitfullscreen" == a.action)
          ) {
            jQuery("#rs-go-fullscreen").appendTo(jQuery("#rs-was-here"));
            var paw =
              opt.c.closest(".forcefullwidth_wrapper_tp_banner").length > 0
                ? opt.c.closest(".forcefullwidth_wrapper_tp_banner")
                : opt.c.closest(".rev_slider_wrapper");
            paw.unwrap(),
              paw.unwrap(),
              (opt.minHeight = opt.oldminheight),
              (opt.infullscreenmode = !1),
              opt.c.revredraw(),
              void 0 != opt.playingvideos &&
                opt.playingvideos.length > 0 &&
                jQuery.each(opt.playingvideos, function (e, t) {
                  _R.playVideo(t, opt);
                }),
              _R.unToggleState(opt.fullscreentoggledby);
          } else if (
            0 == jQuery("#rs-go-fullscreen").length &&
            ("togglefullscreen" == a.action || "gofullscreen" == a.action)
          ) {
            var paw =
              opt.c.closest(".forcefullwidth_wrapper_tp_banner").length > 0
                ? opt.c.closest(".forcefullwidth_wrapper_tp_banner")
                : opt.c.closest(".rev_slider_wrapper");
            paw.wrap(
              '<div id="rs-was-here"><div id="rs-go-fullscreen"></div></div>'
            );
            var gf = jQuery("#rs-go-fullscreen");
            gf.appendTo(jQuery("body")),
              gf.css({
                position: "fixed",
                width: "100%",
                height: "100%",
                top: "0px",
                left: "0px",
                zIndex: "9999999",
                background: "#ffffff",
              }),
              (opt.oldminheight = opt.minHeight),
              (opt.minHeight = jQuery(window).height()),
              (opt.infullscreenmode = !0),
              opt.c.revredraw(),
              void 0 != opt.playingvideos &&
                opt.playingvideos.length > 0 &&
                jQuery.each(opt.playingvideos, function (e, t) {
                  _R.playVideo(t, opt);
                }),
              _R.toggleState(opt.fullscreentoggledby);
          }
          break;
        default:
          var obj = {};
          (obj.event = a),
            (obj.layer = _nc),
            opt.c.trigger("layeraction", [obj]);
      }
    },
    getOffContH = function (e) {
      if (void 0 == e) return 0;
      if (e.split(",").length > 1) {
        var t = e.split(","),
          a = 0;
        return (
          t &&
            jQuery.each(t, function (e, t) {
              jQuery(t).length > 0 && (a += jQuery(t).outerHeight(!0));
            }),
          a
        );
      }
      return jQuery(e).height();
    };
})(jQuery),
  (function (e) {
    "use strict";
    var t = jQuery.fn.revolution,
      a = {
        alias: "Carousel Min JS",
        name: "revolution.extensions.carousel.min.js",
        min_core: "5.0",
        version: "1.1.0",
      };
    jQuery.extend(!0, t, {
      prepareCarousel: function (e, i, s) {
        return (
          "stop" !== t.compare_version(a).check &&
          ((s = e.carousel.lastdirection = r(s, e.carousel.lastdirection)),
          o(e),
          (e.carousel.slide_offset_target = l(e)),
          void (void 0 == i ? t.carouselToEvalPosition(e, s) : n(e, s, !1)))
        );
      },
      carouselToEvalPosition: function (e, a) {
        var i = e.carousel;
        a = i.lastdirection = r(a, i.lastdirection);
        var o =
            "center" === i.horizontal_align
              ? (i.wrapwidth / 2 - i.slide_width / 2 - i.slide_globaloffset) /
                i.slide_width
              : (0 - i.slide_globaloffset) / i.slide_width,
          s = t.simp(o, e.slideamount, !1),
          d = s - Math.floor(s),
          l = 0,
          p = -1 * (Math.ceil(s) - s),
          c = -1 * (Math.floor(s) - s);
        (l =
          (d >= 0.3 && "left" === a) || (d >= 0.7 && "right" === a)
            ? p
            : (d < 0.3 && "left" === a) || (d < 0.7 && "right" === a)
            ? c
            : l),
          (l =
            "off" === i.infinity
              ? s < 0
                ? s
                : o > e.slideamount - 1
                ? o - (e.slideamount - 1)
                : l
              : l),
          (i.slide_offset_target = l * i.slide_width),
          0 !== Math.abs(i.slide_offset_target)
            ? n(e, a, !0)
            : t.organiseCarousel(e, a);
      },
      organiseCarousel: function (e, t, a, i) {
        t =
          void 0 === t ||
          "down" == t ||
          "up" == t ||
          null === t ||
          jQuery.isEmptyObject(t)
            ? "left"
            : t;
        for (
          var o = e.carousel,
            r = new Array(),
            n = o.slides.length,
            s = ("right" === o.horizontal_align && e.width, 0);
          s < n;
          s++
        ) {
          var d = s * o.slide_width + o.slide_offset;
          "on" === o.infinity &&
            ((d =
              d > o.wrapwidth - o.inneroffset && "right" == t
                ? o.slide_offset - (o.slides.length - s) * o.slide_width
                : d),
            (d =
              d < 0 - o.inneroffset - o.slide_width && "left" == t
                ? d + o.maxwidth
                : d)),
            (r[s] = d);
        }
        var l = 999;
        o.slides &&
          jQuery.each(o.slides, function (i, s) {
            var d = r[i];
            "on" === o.infinity &&
              ((d =
                d > o.wrapwidth - o.inneroffset && "left" === t
                  ? r[0] - (n - i) * o.slide_width
                  : d),
              (d =
                d < 0 - o.inneroffset - o.slide_width
                  ? "left" == t
                    ? d + o.maxwidth
                    : "right" === t
                    ? r[n - 1] + (i + 1) * o.slide_width
                    : d
                  : d));
            var p = new Object();
            p.left = d + o.inneroffset;
            var c =
                "center" === o.horizontal_align
                  ? (Math.abs(o.wrapwidth / 2) - (p.left + o.slide_width / 2)) /
                    o.slide_width
                  : (o.inneroffset - p.left) / o.slide_width,
              u = "center" === o.horizontal_align ? 2 : 1;
            if (
              (((a && Math.abs(c) < l) || 0 === c) &&
                ((l = Math.abs(c)), (o.focused = i)),
              (p.width = o.slide_width),
              (p.x = 0),
              (p.transformPerspective = 1200),
              (p.transformOrigin = "50% " + o.vertical_align),
              "on" === o.fadeout)
            )
              if ("on" === o.vary_fade)
                p.autoAlpha =
                  1 - Math.abs((1 / Math.ceil(o.maxVisibleItems / u)) * c);
              else
                switch (o.horizontal_align) {
                  case "center":
                    p.autoAlpha =
                      Math.abs(c) < Math.ceil(o.maxVisibleItems / u - 1)
                        ? 1
                        : 1 - (Math.abs(c) - Math.floor(Math.abs(c)));
                    break;
                  case "left":
                    p.autoAlpha =
                      c < 1 && c > 0
                        ? 1 - c
                        : Math.abs(c) > o.maxVisibleItems - 1
                        ? 1 - (Math.abs(c) - (o.maxVisibleItems - 1))
                        : 1;
                    break;
                  case "right":
                    p.autoAlpha =
                      c > -1 && c < 0
                        ? 1 - Math.abs(c)
                        : c > o.maxVisibleItems - 1
                        ? 1 - (Math.abs(c) - (o.maxVisibleItems - 1))
                        : 1;
                }
            else
              p.autoAlpha =
                Math.abs(c) < Math.ceil(o.maxVisibleItems / u) ? 1 : 0;
            if (void 0 !== o.minScale && o.minScale > 0)
              if ("on" === o.vary_scale) {
                p.scale =
                  1 -
                  Math.abs(
                    (o.minScale / 100 / Math.ceil(o.maxVisibleItems / u)) * c
                  );
                o.slide_width, o.slide_width, p.scale, Math.abs(c);
              } else {
                p.scale =
                  c >= 1 || c <= -1
                    ? 1 - o.minScale / 100
                    : (100 - o.minScale * Math.abs(c)) / 100;
                o.slide_width, o.slide_width, o.minScale, Math.abs(c);
              }
            void 0 !== o.maxRotation &&
              0 != Math.abs(o.maxRotation) &&
              ("on" === o.vary_rotation
                ? ((p.rotationY =
                    Math.abs(o.maxRotation) -
                    Math.abs(
                      (1 -
                        Math.abs((1 / Math.ceil(o.maxVisibleItems / u)) * c)) *
                        o.maxRotation
                    )),
                  (p.autoAlpha = Math.abs(p.rotationY) > 90 ? 0 : p.autoAlpha))
                : (p.rotationY =
                    c >= 1 || c <= -1
                      ? o.maxRotation
                      : Math.abs(c) * o.maxRotation),
              (p.rotationY = c < 0 ? -1 * p.rotationY : p.rotationY)),
              (p.x = -1 * o.space * c),
              (p.left = Math.floor(p.left)),
              (p.x = Math.floor(p.x)),
              void 0 !== p.scale ? (c < 0 ? p.x : p.x) : p.x,
              (p.zIndex = Math.round(100 - Math.abs(5 * c))),
              (p.transformStyle =
                "3D" != e.parallax.type && "3d" != e.parallax.type
                  ? "flat"
                  : "preserve-3d"),
              punchgs.TweenLite.set(s, p);
          }),
          i &&
            (e.c.find(".next-revslide").removeClass("next-revslide"),
            jQuery(o.slides[o.focused]).addClass("next-revslide"),
            e.c.trigger("revolution.nextslide.waiting")),
          o.wrapwidth,
          o.slide_offset,
          o.maxwidth,
          o.slide_offset,
          o.wrapwidth;
      },
    });
    var i = function (e) {
        var t = e.carousel;
        (t.infbackup = t.infinity),
          (t.maxVisiblebackup = t.maxVisibleItems),
          (t.slide_globaloffset = "none"),
          (t.slide_offset = 0),
          (t.wrap = e.c.find(".tp-carousel-wrapper")),
          (t.slides = e.c.find(".tp-revslider-slidesli")),
          0 !== t.maxRotation &&
            ("3D" != e.parallax.type && "3d" != e.parallax.type
              ? punchgs.TweenLite.set(t.wrap, {
                  perspective: 1200,
                  transformStyle: "flat",
                })
              : punchgs.TweenLite.set(t.wrap, {
                  perspective: 1600,
                  transformStyle: "preserve-3d",
                })),
          void 0 !== t.border_radius &&
            parseInt(t.border_radius, 0) > 0 &&
            punchgs.TweenLite.set(e.c.find(".tp-revslider-slidesli"), {
              borderRadius: t.border_radius,
            });
      },
      o = function (e) {
        void 0 === e.bw && t.setSize(e);
        var a = e.carousel,
          o = t.getHorizontalOffset(e.c, "left"),
          r = t.getHorizontalOffset(e.c, "right");
        void 0 === a.wrap && i(e),
          (a.slide_width =
            "on" !== a.stretch
              ? e.gridwidth[e.curWinRange] * e.bw
              : e.c.width()),
          (a.maxwidth = e.slideamount * a.slide_width),
          a.maxVisiblebackup > a.slides.length + 1 &&
            (a.maxVisibleItems = a.slides.length + 2),
          (a.wrapwidth =
            a.maxVisibleItems * a.slide_width +
            (a.maxVisibleItems - 1) * a.space),
          (a.wrapwidth =
            "auto" != e.sliderLayout
              ? a.wrapwidth > e.c.closest(".tp-simpleresponsive").width()
                ? e.c.closest(".tp-simpleresponsive").width()
                : a.wrapwidth
              : a.wrapwidth > e.ul.width()
              ? e.ul.width()
              : a.wrapwidth),
          (a.infinity = a.wrapwidth >= a.maxwidth ? "off" : a.infbackup),
          (a.wrapoffset =
            "center" === a.horizontal_align
              ? (e.c.width() - r - o - a.wrapwidth) / 2
              : 0),
          (a.wrapoffset =
            "auto" != e.sliderLayout && e.outernav
              ? 0
              : a.wrapoffset < o
              ? o
              : a.wrapoffset);
        var n = "hidden";
        ("3D" != e.parallax.type && "3d" != e.parallax.type) || (n = "visible"),
          "right" === a.horizontal_align
            ? punchgs.TweenLite.set(a.wrap, {
                left: "auto",
                right: a.wrapoffset + "px",
                width: a.wrapwidth,
                overflow: n,
              })
            : punchgs.TweenLite.set(a.wrap, {
                right: "auto",
                left: a.wrapoffset + "px",
                width: a.wrapwidth,
                overflow: n,
              }),
          (a.inneroffset =
            "right" === a.horizontal_align ? a.wrapwidth - a.slide_width : 0),
          (a.realoffset = Math.abs(a.wrap.position().left)),
          (a.windhalf = jQuery(window).width() / 2);
      },
      r = function (e, t) {
        return null === e || jQuery.isEmptyObject(e)
          ? t
          : void 0 === e
          ? "right"
          : e;
      },
      n = function (e, a, i) {
        var o = e.carousel;
        a = o.lastdirection = r(a, o.lastdirection);
        var n = new Object();
        (n.from = 0),
          (n.to = o.slide_offset_target),
          void 0 !== o.positionanim && o.positionanim.pause(),
          (o.positionanim = punchgs.TweenLite.to(n, 1.2, {
            from: n.to,
            onUpdate: function () {
              (o.slide_offset = o.slide_globaloffset + n.from),
                (o.slide_offset = t.simp(o.slide_offset, o.maxwidth)),
                t.organiseCarousel(e, a, !1, !1);
            },
            onComplete: function () {
              (o.slide_globaloffset =
                "off" === o.infinity
                  ? o.slide_globaloffset + o.slide_offset_target
                  : t.simp(
                      o.slide_globaloffset + o.slide_offset_target,
                      o.maxwidth
                    )),
                (o.slide_offset = t.simp(o.slide_offset, o.maxwidth)),
                t.organiseCarousel(e, a, !1, !0);
              var r = jQuery(e.li[o.focused]);
              e.c.find(".next-revslide").removeClass("next-revslide"),
                i && t.callingNewSlide(e.c, r.data("index"));
            },
            ease: punchgs.Expo.easeOut,
          }));
      },
      s = function (e, t) {
        return Math.abs(e) > Math.abs(t)
          ? e > 0
            ? e - Math.abs(Math.floor(e / t) * t)
            : e + Math.abs(Math.floor(e / t) * t)
          : e;
      },
      d = function (e, t, a) {
        var a,
          a,
          i = t - e,
          o = t - a - e;
        return (i = s(i, a)), (o = s(o, a)), Math.abs(i) > Math.abs(o) ? o : i;
      },
      l = function (e) {
        var a = 0,
          i = e.carousel;
        if (
          (void 0 !== i.positionanim && i.positionanim.kill(),
          "none" == i.slide_globaloffset)
        )
          i.slide_globaloffset = a =
            "center" === i.horizontal_align
              ? i.wrapwidth / 2 - i.slide_width / 2
              : 0;
        else {
          (i.slide_globaloffset = i.slide_offset), (i.slide_offset = 0);
          var o = e.c.find(".processing-revslide").index(),
            r =
              "center" === i.horizontal_align
                ? (i.wrapwidth / 2 - i.slide_width / 2 - i.slide_globaloffset) /
                  i.slide_width
                : (0 - i.slide_globaloffset) / i.slide_width;
          (r = t.simp(r, e.slideamount, !1)),
            (o = o >= 0 ? o : e.c.find(".active-revslide").index()),
            (o = o >= 0 ? o : 0),
            (a = "off" === i.infinity ? r - o : -d(r, o, e.slideamount)),
            (a *= i.slide_width);
        }
        return a;
      };
  })(jQuery),
  (function (e) {
    "use strict";
    var t = jQuery.fn.revolution,
      a = {
        alias: "KenBurns Min JS",
        name: "revolution.extensions.kenburn.min.js",
        min_core: "5.0",
        version: "1.1.0",
      };
    jQuery.extend(!0, t, {
      stopKenBurn: function (e) {
        return (
          "stop" !== t.compare_version(a).check &&
          void (void 0 != e.data("kbtl") && e.data("kbtl").pause())
        );
      },
      startKenBurn: function (e, i, o) {
        if ("stop" === t.compare_version(a).check) return !1;
        var r = e.data(),
          n = e.find(".defaultimg"),
          s = n.data("lazyload") || n.data("src"),
          d =
            (r.owidth,
            r.oheight,
            "carousel" === i.sliderType
              ? i.carousel.slide_width
              : i.ul.width()),
          l = i.ul.height();
        e.data("kbtl") && e.data("kbtl").kill(),
          (o = o || 0),
          0 == e.find(".tp-kbimg").length &&
            (e.append(
              '<div class="tp-kbimg-wrap" style="z-index:2;width:100%;height:100%;top:0px;left:0px;position:absolute;"><img class="tp-kbimg" src="' +
                s +
                '" style="position:absolute;" width="' +
                r.owidth +
                '" height="' +
                r.oheight +
                '"></div>'
            ),
            e.data("kenburn", e.find(".tp-kbimg")));
        var p = function (e, t, a, i, o, r, n) {
            var s = e * a,
              d = t * a,
              l = Math.abs(i - s),
              p = Math.abs(o - d),
              c = new Object();
            return (
              (c.l = (0 - r) * l),
              (c.r = c.l + s),
              (c.t = (0 - n) * p),
              (c.b = c.t + d),
              (c.h = r),
              (c.v = n),
              c
            );
          },
          c = function (e, t, a, i, o) {
            var r = e.bgposition.split(" ") || "center center",
              n =
                "center" == r[0]
                  ? "50%"
                  : "left" == r[0] || "left" == r[1]
                  ? "0%"
                  : "right" == r[0] || "right" == r[1]
                  ? "100%"
                  : r[0],
              s =
                "center" == r[1]
                  ? "50%"
                  : "top" == r[0] || "top" == r[1]
                  ? "0%"
                  : "bottom" == r[0] || "bottom" == r[1]
                  ? "100%"
                  : r[1];
            (n = parseInt(n, 0) / 100 || 0), (s = parseInt(s, 0) / 100 || 0);
            var d = new Object();
            return (
              (d.start = p(
                o.start.width,
                o.start.height,
                o.start.scale,
                t,
                a,
                n,
                s
              )),
              (d.end = p(
                o.start.width,
                o.start.height,
                o.end.scale,
                t,
                a,
                n,
                s
              )),
              d
            );
          };
        void 0 != e.data("kbtl") &&
          (e.data("kbtl").kill(), e.removeData("kbtl"));
        var u = e.data("kenburn"),
          h = u.parent(),
          f = (function (e, t, a) {
            var i = a.scalestart / 100,
              o = a.scaleend / 100,
              r =
                void 0 != a.offsetstart
                  ? a.offsetstart.split(" ") || [0, 0]
                  : [0, 0],
              n =
                void 0 != a.offsetend
                  ? a.offsetend.split(" ") || [0, 0]
                  : [0, 0];
            a.bgposition =
              "center center" == a.bgposition ? "50% 50%" : a.bgposition;
            var s = new Object();
            a.owidth, a.oheight;
            if (
              (a.owidth,
              a.oheight,
              (s.start = new Object()),
              (s.starto = new Object()),
              (s.end = new Object()),
              (s.endo = new Object()),
              (s.start.width = e),
              (s.start.height = (s.start.width / a.owidth) * a.oheight),
              s.start.height < t)
            ) {
              var d = t / s.start.height;
              (s.start.height = t), (s.start.width = s.start.width * d);
            }
            (s.start.transformOrigin = a.bgposition),
              (s.start.scale = i),
              (s.end.scale = o),
              (s.start.rotation = a.rotatestart + "deg"),
              (s.end.rotation = a.rotateend + "deg");
            var l = c(a, e, t, 0, s);
            (r[0] = parseFloat(r[0]) + l.start.l),
              (n[0] = parseFloat(n[0]) + l.end.l),
              (r[1] = parseFloat(r[1]) + l.start.t),
              (n[1] = parseFloat(n[1]) + l.end.t);
            var p = l.start.r - l.start.l,
              u = l.start.b - l.start.t,
              h = l.end.r - l.end.l,
              f = l.end.b - l.end.t;
            return (
              (r[0] = r[0] > 0 ? 0 : p + r[0] < e ? e - p : r[0]),
              (n[0] = n[0] > 0 ? 0 : h + n[0] < e ? e - h : n[0]),
              (r[1] = r[1] > 0 ? 0 : u + r[1] < t ? t - u : r[1]),
              (n[1] = n[1] > 0 ? 0 : f + n[1] < t ? t - f : n[1]),
              (s.starto.x = r[0] + "px"),
              (s.starto.y = r[1] + "px"),
              (s.endo.x = n[0] + "px"),
              (s.endo.y = n[1] + "px"),
              (s.end.ease = s.endo.ease = a.ease),
              (s.end.force3D = s.endo.force3D = !0),
              s
            );
          })(d, l, r),
          g = new punchgs.TimelineLite();
        g.pause(),
          (f.start.transformOrigin = "0% 0%"),
          (f.starto.transformOrigin = "0% 0%"),
          g.add(
            punchgs.TweenLite.fromTo(u, r.duration / 1e3, f.start, f.end),
            0
          ),
          g.add(
            punchgs.TweenLite.fromTo(h, r.duration / 1e3, f.starto, f.endo),
            0
          ),
          g.progress(o),
          g.play(),
          e.data("kbtl", g);
      },
    });
  })(jQuery),
  (function (e) {
    "use strict";
    function t(e, t, a, i, o, r, n) {
      var s = e.find(t);
      s.css("borderWidth", r + "px"),
        s.css(a, 0 - r + "px"),
        s.css(i, "0px solid transparent"),
        s.css(o, n);
    }
    var a = jQuery.fn.revolution,
      i =
        (a.is_mobile(),
        {
          alias: "LayerAnimation Min JS",
          name: "revolution.extensions.layeranimation.min.js",
          min_core: "5.3.0",
          version: "3.0.6",
        });
    jQuery.extend(!0, a, {
      updateMarkup: function (e, t) {
        var a = jQuery(e).data();
        if (void 0 !== a.start && !a.frames_added && void 0 === a.frames) {
          var i = new Array(),
            o = u(r(), a.transform_in, void 0, !1),
            n = u(r(), a.transform_out, void 0, !1),
            s = u(r(), a.transform_hover, void 0, !1);
          jQuery.isNumeric(a.end) &&
            jQuery.isNumeric(a.start) &&
            jQuery.isNumeric(o.speed) &&
            (a.end =
              parseInt(a.end, 0) -
              (parseInt(a.start, 0) + parseFloat(o.speed, 0))),
            i.push({
              frame: "0",
              delay: a.start,
              from: a.transform_in,
              to: a.transform_idle,
              split: a.splitin,
              speed: o.speed,
              ease: o.anim.ease,
              mask: a.mask_in,
              splitdelay: a.elementdelay,
            }),
            i.push({
              frame: "5",
              delay: a.end,
              to: a.transform_out,
              split: a.splitout,
              speed: n.speed,
              ease: n.anim.ease,
              mask: a.mask_out,
              splitdelay: a.elementdelay,
            }),
            a.transform_hover &&
              i.push({
                frame: "hover",
                to: a.transform_hover,
                style: a.style_hover,
                speed: s.speed,
                ease: s.anim.ease,
                splitdelay: a.elementdelay,
              }),
            (a.frames = i);
        }
        if (!a.frames_added) {
          (a.inframeindex = 0),
            (a.outframeindex = -1),
            (a.hoverframeindex = -1);
          for (var d = 0; d < a.frames.length; d++)
            void 0 === a.frames[0].from && (a.frames[0].from = "o:inherit"),
              0 === a.frames[0].delay && (a.frames[0].delay = 20),
              "hover" === a.frames[d].frame
                ? (a.hoverframeindex = d)
                : ("frame_999" !== a.frames[d].frame &&
                    "frame_out" !== a.frames[d].frame &&
                    "last" !== a.frames[d].frame &&
                    "end" !== a.frames[d].frame) ||
                  (a.outframeindex = d),
              void 0 !== a.frames[d].split &&
                a.frames[d].split.match(/chars|words|lines/g) &&
                (a.splittext = !0);
          (a.outframeindex =
            -1 === a.outframeindex
              ? -1 === a.hoverframeindex
                ? a.frames.length - 1
                : a.frames.length - 2
              : a.outframeindex),
            (a.frames_added = !0);
        }
      },
      animcompleted: function (e, t) {
        var i = e.data(),
          o = i.videotype,
          r = i.autoplay,
          n = i.autoplayonlyfirsttime;
        void 0 != o &&
          "none" != o &&
          (1 == r || "true" == r || "on" == r || "1sttime" == r || n
            ? (a.playVideo(e, t),
              a.toggleState(e.data("videotoggledby")),
              (n || "1sttime" == r) &&
                ((i.autoplayonlyfirsttime = !1), (i.autoplay = "off")))
            : ("no1sttime" == r && (i.datasetautoplay = "on"),
              a.unToggleState(e.data("videotoggledby"))));
      },
      handleStaticLayers: function (e, t) {
        var a = parseInt(e.data("startslide"), 0),
          i = parseInt(e.data("endslide"), 0);
        a < 0 && (a = 0),
          i < 0 && (i = t.slideamount),
          0 === a && i === t.slideamount - 1 && (i = t.slideamount + 1),
          e.data("startslide", a),
          e.data("endslide", i);
      },
      animateTheCaptions: function (e) {
        if ("stop" === a.compare_version(i).check) return !1;
        var t = e.opt,
          o = e.slide,
          r = e.recall,
          n = e.maintimeline,
          s = e.preset,
          d = e.startslideanimat,
          l =
            "carousel" === t.sliderType
              ? 0
              : t.width / 2 - (t.gridwidth[t.curWinRange] * t.bw) / 2,
          p = o.data("index");
        if (
          ((t.layers = t.layers || new Object()),
          (t.layers[p] = t.layers[p] || o.find(".tp-caption")),
          (t.layers.static =
            t.layers.static ||
            t.c.find(".tp-static-layers").find(".tp-caption")),
          void 0 === t.timelines && a.createTimelineStructure(t),
          (t.conh = t.c.height()),
          (t.conw = t.c.width()),
          (t.ulw = t.ul.width()),
          (t.ulh = t.ul.height()),
          t.debugMode)
        ) {
          o.addClass("indebugmode"),
            o.find(".helpgrid").remove(),
            t.c.find(".hglayerinfo").remove(),
            o.append(
              '<div class="helpgrid" style="width:' +
                t.gridwidth[t.curWinRange] * t.bw +
                "px;height:" +
                t.gridheight[t.curWinRange] * t.bw +
                'px;"></div>'
            );
          var c = o.find(".helpgrid");
          c.append(
            '<div class="hginfo">Zoom:' +
              Math.round(100 * t.bw) +
              "% &nbsp;&nbsp;&nbsp; Device Level:" +
              t.curWinRange +
              "&nbsp;&nbsp;&nbsp; Grid Preset:" +
              t.gridwidth[t.curWinRange] +
              "x" +
              t.gridheight[t.curWinRange] +
              "</div>"
          ),
            t.c.append('<div class="hglayerinfo"></div>'),
            c.append('<div class="tlhg"></div>');
        }
        t.layers[p] &&
          jQuery.each(t.layers[p], function (e, i) {
            a.updateMarkup(this, t),
              a.prepareSingleCaption({
                caption: jQuery(this),
                opt: t,
                offsetx: l,
                offsety: 0,
                index: e,
                recall: r,
                preset: s,
              }),
              (s && 0 !== d) ||
                a.buildFullTimeLine({
                  caption: jQuery(this),
                  opt: t,
                  offsetx: l,
                  offsety: 0,
                  index: e,
                  recall: r,
                  preset: s,
                  regenerate: 0 === d,
                });
          }),
          t.layers.static &&
            jQuery.each(t.layers.static, function (e, i) {
              a.updateMarkup(this, t),
                a.prepareSingleCaption({
                  caption: jQuery(this),
                  opt: t,
                  offsetx: l,
                  offsety: 0,
                  index: e,
                  recall: r,
                  preset: s,
                }),
                (s && 0 !== d) ||
                  a.buildFullTimeLine({
                    caption: jQuery(this),
                    opt: t,
                    offsetx: l,
                    offsety: 0,
                    index: e,
                    recall: r,
                    preset: s,
                    regenerate: 0 === d,
                  });
            });
        var u = -1 === t.nextSlide || void 0 === t.nextSlide ? 0 : t.nextSlide;
        (u = u > t.rowzones.length ? t.rowzones.length : u),
          void 0 != t.rowzones &&
            t.rowzones.length > 0 &&
            void 0 != t.rowzones[u] &&
            u >= 0 &&
            u <= t.rowzones.length &&
            t.rowzones[u].length > 0 &&
            a.setSize(t),
          s ||
            (void 0 !== d &&
              (jQuery.each(t.timelines[p].layers, function (e, i) {
                var o = i.layer.data();
                ("none" !== i.wrapper && void 0 !== i.wrapper) ||
                  ("keep" == i.triggerstate && "on" === o.triggerstate
                    ? a.playAnimationFrame({
                        caption: i.layer,
                        opt: t,
                        frame: "frame_0",
                        triggerdirection: "in",
                        triggerframein: "frame_0",
                        triggerframeout: "frame_999",
                      })
                    : i.timeline.restart(0));
              }),
              t.timelines.staticlayers &&
                jQuery.each(t.timelines.staticlayers.layers, function (e, i) {
                  var o = i.layer.data(),
                    r = u >= i.firstslide && u <= i.lastslide,
                    n = u < i.firstslide || u > i.lastslide,
                    s = i.timeline.getLabelTime("slide_" + i.firstslide),
                    d = i.timeline.getLabelTime("slide_" + i.lastslide),
                    l = o.static_layer_timeline_time,
                    p =
                      "in" === o.animdirection ||
                      ("out" !== o.animdirection && void 0),
                    c = "bytrigger" === o.frames[0].delay,
                    h =
                      (o.frames[o.frames.length - 1].delay,
                      o.triggered_startstatus),
                    f = o.lasttriggerstate;
                  void 0 !== l &&
                    p &&
                    ("keep" == f
                      ? (a.playAnimationFrame({
                          caption: i.layer,
                          opt: t,
                          frame: "frame_0",
                          triggerdirection: "in",
                          triggerframein: "frame_0",
                          triggerframeout: "frame_999",
                        }),
                        o.triggeredtimeline.time(l))
                      : i.timeline.time(l)),
                    "reset" === f &&
                      "hidden" === h &&
                      (i.timeline.time(0), (o.animdirection = "out")),
                    r
                      ? p
                        ? u === i.lastslide &&
                          (i.timeline.play(d), (o.animdirection = "in"))
                        : (c || "out" === o.animdirection || i.timeline.play(s),
                          (("visible" == h && "keep" !== f) ||
                            ("keep" === f && !0 === p) ||
                            ("visible" == h && void 0 === p)) &&
                            (i.timeline.play(s + 0.01),
                            (o.animdirection = "in")))
                      : n && p && i.timeline.play("frame_999");
                }))),
          void 0 != n &&
            setTimeout(function () {
              n.resume();
            }, 30);
      },
      prepareSingleCaption: function (e) {
        var i = e.caption,
          o = i.data(),
          r = e.opt,
          n = e.recall,
          s = e.recall,
          d = (e.preset, jQuery("body").hasClass("rtl"));
        if (
          ((o._pw = void 0 === o._pw ? i.closest(".tp-parallax-wrap") : o._pw),
          (o._lw = void 0 === o._lw ? i.closest(".tp-loop-wrap") : o._lw),
          (o._mw = void 0 === o._mw ? i.closest(".tp-mask-wrap") : o._mw),
          (o._responsive = o.responsive || "on"),
          (o._respoffset = o.responsive_offset || "on"),
          (o._ba = o.basealign || "grid"),
          (o._gw = "grid" === o._ba ? r.width : r.ulw),
          (o._gh = "grid" === o._ba ? r.height : r.ulh),
          (o._lig =
            void 0 === o._lig
              ? i.hasClass("rev_layer_in_group")
                ? i.closest(".rev_group")
                : i.hasClass("rev_layer_in_column")
                ? i.closest(".rev_column_inner")
                : i.hasClass("rev_column_inner")
                ? i.closest(".rev_row")
                : "none"
              : o._lig),
          (o._nctype = o.type || "none"),
          (o._cbgc_auto =
            void 0 === o._cbgc_auto
              ? "column" === o._nctype &&
                o._pw.find(".rev_column_bg_auto_sized")
              : o._cbgc_auto),
          (o._cbgc_man =
            void 0 === o._cbgc_man
              ? "column" === o._nctype && o._pw.find(".rev_column_bg_man_sized")
              : o._cbgc_man),
          (o._slideid =
            o._slideid || i.closest(".tp-revslider-slidesli").data("index")),
          (o._id = void 0 === o._id ? i.data("id") || i.attr("id") : o._id),
          (o._slidelink = o._slidelink || i.hasClass("slidelink")),
          void 0 === o._li &&
            (i.hasClass("tp-static-layer")
              ? ((o._li = i.closest(".tp-static-layers")),
                (o._slideid = "staticlayers"))
              : (o._li = i.closest(".tp-revslider-slidesli"))),
          (o._row =
            void 0 === o._row
              ? "column" === o._nctype && o._pw.closest(".rev_row")
              : o._row),
          void 0 === o._togglelisteners && i.find(".rs-toggled-content")
            ? (o._togglelisteners = !0)
            : (o._togglelisteners = !1),
          "fullscreen" == r.sliderLayout &&
            (e.offsety = o._gh / 2 - (r.gridheight[r.curWinRange] * r.bh) / 2),
          ("on" == r.autoHeight ||
            (void 0 != r.minHeight && r.minHeight > 0)) &&
            (e.offsety = r.conh / 2 - (r.gridheight[r.curWinRange] * r.bh) / 2),
          e.offsety < 0 && (e.offsety = 0),
          r.debugMode)
        ) {
          i.closest("li")
            .find(".helpgrid")
            .css({ top: e.offsety + "px", left: e.offsetx + "px" });
          var l = r.c.find(".hglayerinfo");
          i.on("hover, mouseenter", function () {
            var e = "";
            i.data() &&
              jQuery.each(i.data(), function (t, a) {
                "object" != typeof a &&
                  (e =
                    e +
                    '<span style="white-space:nowrap"><span style="color:#27ae60">' +
                    t +
                    ":</span>" +
                    a +
                    "</span>&nbsp; &nbsp; ");
              }),
              l.html(e);
          });
        }
        if (
          ("off" ===
            (void 0 === o.visibility
              ? "oon"
              : f(o.visibility, r)[r.forcedWinRange] ||
                f(o.visibility, r) ||
                "ooon") ||
          (o._gw < r.hideCaptionAtLimit && "on" == o.captionhidden) ||
          o._gw < r.hideAllCaptionAtLimit
            ? o._pw.addClass("tp-hidden-caption")
            : o._pw.removeClass("tp-hidden-caption"),
          (o.layertype = "html"),
          e.offsetx < 0 && (e.offsetx = 0),
          void 0 != o.thumbimage &&
            void 0 == o.videoposter &&
            (o.videoposter = o.thumbimage),
          i.find("img").length > 0)
        ) {
          var p = i.find("img");
          (o.layertype = "image"),
            0 == p.width() && p.css({ width: "auto" }),
            0 == p.height() && p.css({ height: "auto" }),
            void 0 == p.data("ww") && p.width() > 0 && p.data("ww", p.width()),
            void 0 == p.data("hh") &&
              p.height() > 0 &&
              p.data("hh", p.height());
          var c = p.data("ww"),
            u = p.data("hh"),
            h = "slide" == o._ba ? r.ulw : r.gridwidth[r.curWinRange],
            g = "slide" == o._ba ? r.ulh : r.gridheight[r.curWinRange];
          (c =
            f(p.data("ww"), r)[r.curWinRange] || f(p.data("ww"), r) || "auto"),
            (u =
              f(p.data("hh"), r)[r.curWinRange] ||
              f(p.data("hh"), r) ||
              "auto");
          var w = "full" === c || "full-proportional" === c,
            y = "full" === u || "full-proportional" === u;
          if ("full-proportional" === c) {
            var _ = p.data("owidth"),
              x = p.data("oheight");
            _ / h < x / g
              ? ((c = h), (u = x * (h / _)))
              : ((u = g), (c = _ * (g / x)));
          } else
            (c = w
              ? h
              : !jQuery.isNumeric(c) && c.indexOf("%") > 0
              ? c
              : parseFloat(c)),
              (u = y
                ? g
                : !jQuery.isNumeric(u) && u.indexOf("%") > 0
                ? u
                : parseFloat(u));
          (c = void 0 === c ? 0 : c),
            (u = void 0 === u ? 0 : u),
            "off" !== o._responsive
              ? ("grid" != o._ba && w
                  ? jQuery.isNumeric(c)
                    ? p.css({ width: c + "px" })
                    : p.css({ width: c })
                  : jQuery.isNumeric(c)
                  ? p.css({ width: c * r.bw + "px" })
                  : p.css({ width: c }),
                "grid" != o._ba && y
                  ? jQuery.isNumeric(u)
                    ? p.css({ height: u + "px" })
                    : p.css({ height: u })
                  : jQuery.isNumeric(u)
                  ? p.css({ height: u * r.bh + "px" })
                  : p.css({ height: u }))
              : p.css({ width: c, height: u });
        }
        "slide" === o._ba && ((e.offsetx = 0), (e.offsety = 0));
        var T = "html5" == o.audio ? "audio" : "video";
        if (
          i.hasClass("tp-videolayer") ||
          i.hasClass("tp-audiolayer") ||
          i.find("iframe").length > 0 ||
          i.find(T).length > 0
        ) {
          (o.layertype = "video"),
            a.manageVideoLayer && a.manageVideoLayer(i, r, n, s),
            n || s || (o.videotype, a.resetVideo && a.resetVideo(i, r));
          var L = o.aspectratio;
          void 0 != L &&
            L.split(":").length > 1 &&
            a.prepareCoveredVideo(L, r, i);
          var p = i.find("iframe") ? i.find("iframe") : (p = i.find(T)),
            k = !i.find("iframe"),
            j = i.hasClass("coverscreenvideo");
          p.css({ display: "block" }),
            void 0 == i.data("videowidth") &&
              (i.data("videowidth", p.width()),
              i.data("videoheight", p.height()));
          var c =
              f(i.data("videowidth"), r)[r.curWinRange] ||
              f(i.data("videowidth"), r) ||
              "auto",
            u =
              f(i.data("videoheight"), r)[r.curWinRange] ||
              f(i.data("videoheight"), r) ||
              "auto";
          !jQuery.isNumeric(c) && c.indexOf("%") > 0
            ? (u = parseFloat(u) * r.bh + "px")
            : ((c = parseFloat(c) * r.bw + "px"),
              (u = parseFloat(u) * r.bh + "px")),
            (o.cssobj = void 0 === o.cssobj ? m(i, 0) : o.cssobj);
          var z = v(o.cssobj, r);
          if (
            ("auto" == z.lineHeight && (z.lineHeight = z.fontSize + 4),
            i.hasClass("fullscreenvideo") || j)
          ) {
            (e.offsetx = 0), (e.offsety = 0), i.data("x", 0), i.data("y", 0);
            var Q = o._gh;
            "on" == r.autoHeight && (Q = r.conh),
              i.css({ width: o._gw, height: Q });
          } else
            punchgs.TweenLite.set(i, {
              paddingTop: Math.round(z.paddingTop * r.bh) + "px",
              paddingBottom: Math.round(z.paddingBottom * r.bh) + "px",
              paddingLeft: Math.round(z.paddingLeft * r.bw) + "px",
              paddingRight: Math.round(z.paddingRight * r.bw) + "px",
              marginTop: z.marginTop * r.bh + "px",
              marginBottom: z.marginBottom * r.bh + "px",
              marginLeft: z.marginLeft * r.bw + "px",
              marginRight: z.marginRight * r.bw + "px",
              borderTopWidth: Math.round(z.borderTopWidth * r.bh) + "px",
              borderBottomWidth: Math.round(z.borderBottomWidth * r.bh) + "px",
              borderLeftWidth: Math.round(z.borderLeftWidth * r.bw) + "px",
              borderRightWidth: Math.round(z.borderRightWidth * r.bw) + "px",
              width: c,
              height: u,
            });
          ((0 == k && !j) ||
            (1 != o.forcecover && !i.hasClass("fullscreenvideo") && !j)) &&
            (p.width(c), p.height(u));
        }
        b(i, r, 0, o._responsive),
          i.hasClass("tp-resizeme") &&
            i.find("*").each(function () {
              b(jQuery(this), r, "rekursive", o._responsive);
            });
        var I = i.outerHeight(),
          M = i.css("backgroundColor");
        t(i, ".frontcorner", "left", "borderRight", "borderTopColor", I, M),
          t(
            i,
            ".frontcornertop",
            "left",
            "borderRight",
            "borderBottomColor",
            I,
            M
          ),
          t(i, ".backcorner", "right", "borderLeft", "borderBottomColor", I, M),
          t(i, ".backcornertop", "right", "borderLeft", "borderTopColor", I, M),
          "on" == r.fullScreenAlignForce && ((e.offsetx = 0), (e.offsety = 0)),
          (o.arrobj = new Object()),
          (o.arrobj.voa = f(o.voffset, r)[r.curWinRange] || f(o.voffset, r)[0]),
          (o.arrobj.hoa = f(o.hoffset, r)[r.curWinRange] || f(o.hoffset, r)[0]),
          (o.arrobj.elx = f(o.x, r)[r.curWinRange] || f(o.x, r)[0]),
          (o.arrobj.ely = f(o.y, r)[r.curWinRange] || f(o.y, r)[0]);
        var O = 0 == o.arrobj.voa.length ? 0 : o.arrobj.voa,
          C = 0 == o.arrobj.hoa.length ? 0 : o.arrobj.hoa,
          S = 0 == o.arrobj.elx.length ? 0 : o.arrobj.elx,
          A = 0 == o.arrobj.ely.length ? 0 : o.arrobj.ely;
        (o.eow = i.outerWidth(!0)),
          (o.eoh = i.outerHeight(!0)),
          0 == o.eow && 0 == o.eoh && ((o.eow = r.ulw), (o.eoh = r.ulh));
        var R =
            "off" !== o._respoffset ? parseInt(O, 0) * r.bw : parseInt(O, 0),
          P = "off" !== o._respoffset ? parseInt(C, 0) * r.bw : parseInt(C, 0),
          D = "grid" === o._ba ? r.gridwidth[r.curWinRange] * r.bw : o._gw,
          W = "grid" === o._ba ? r.gridheight[r.curWinRange] * r.bw : o._gh;
        "on" == r.fullScreenAlignForce && ((D = r.ulw), (W = r.ulh)),
          "none" !== o._lig &&
            void 0 != o._lig &&
            ((D = o._lig.width()),
            (W = o._lig.height()),
            (e.offsetx = 0),
            (e.offsety = 0)),
          (S =
            "center" === S || "middle" === S
              ? D / 2 - o.eow / 2 + P
              : "left" === S
              ? P
              : "right" === S
              ? D - o.eow - P
              : "off" !== o._respoffset
              ? S * r.bw
              : S),
          (A =
            "center" == A || "middle" == A
              ? W / 2 - o.eoh / 2 + R
              : "top" == A
              ? R
              : "bottom" == A
              ? W - o.eoh - R
              : "off" !== o._respoffset
              ? A * r.bw
              : A),
          d && !o.slidelink && (S += o.eow),
          o.slidelink && (S = 0),
          (o.calcx = parseInt(S, 0) + e.offsetx),
          (o.calcy = parseInt(A, 0) + e.offsety);
        var V = i.css("z-Index");
        if ("row" !== o._nctype && "column" !== o._nctype)
          punchgs.TweenLite.set(o._pw, {
            zIndex: V,
            top: o.calcy,
            left: o.calcx,
            overwrite: "auto",
          });
        else if ("row" !== o._nctype)
          punchgs.TweenLite.set(o._pw, {
            zIndex: V,
            width: o.columnwidth,
            top: 0,
            left: 0,
            overwrite: "auto",
          });
        else if ("row" === o._nctype) {
          var H = "grid" === o._ba ? D + "px" : "100%";
          punchgs.TweenLite.set(o._pw, {
            zIndex: V,
            width: H,
            top: 0,
            left: e.offsetx,
            overwrite: "auto",
          });
        }
        void 0 !== o.blendmode &&
          punchgs.TweenLite.set(o._pw, { mixBlendMode: o.blendmode }),
          "row" === o._nctype &&
            (o.columnbreak <= r.curWinRange
              ? i.addClass("rev_break_columns")
              : i.removeClass("rev_break_columns")),
          "on" == o.loopanimation &&
            punchgs.TweenLite.set(o._lw, { minWidth: o.eow, minHeight: o.eoh });
      },
      createTimelineStructure: function (e) {
        function t(e, t, a, i) {
          var o,
            r = new punchgs.TimelineLite({ paused: !0 });
          (a = a || new Object()),
            (a[e.attr("id")] = a[e.attr("id")] || new Object()),
            "staticlayers" === i &&
              ((a[e.attr("id")].firstslide = e.data("startslide")),
              (a[e.attr("id")].lastslide = e.data("endslide"))),
            e.data("slideid", i),
            (a[e.attr("id")].defclasses = o = e[0].className),
            (a[e.attr("id")].wrapper =
              o.indexOf("rev_layer_in_column") >= 0
                ? e.closest(".rev_column_inner")
                : o.indexOf("rev_column_inner") >= 0
                ? e.closest(".rev_row")
                : o.indexOf("rev_layer_in_group") >= 0
                ? e.closest(".rev_group")
                : "none"),
            (a[e.attr("id")].timeline = r),
            (a[e.attr("id")].layer = e),
            (a[e.attr("id")].triggerstate = e.data("lasttriggerstate")),
            (a[e.attr("id")].dchildren =
              o.indexOf("rev_row") >= 0
                ? e[0].getElementsByClassName("rev_column_inner")
                : o.indexOf("rev_column_inner") >= 0
                ? e[0].getElementsByClassName("tp-caption")
                : o.indexOf("rev_group") >= 0
                ? e[0].getElementsByClassName("rev_layer_in_group")
                : "none"),
            e.data("timeline", r);
        }
        (e.timelines = e.timelines || new Object()),
          e.c
            .find(".tp-revslider-slidesli, .tp-static-layers")
            .each(function () {
              var a = jQuery(this),
                i = a.data("index");
              (e.timelines[i] = e.timelines[i] || {}),
                (e.timelines[i].layers = e.timelines[i].layers || new Object()),
                a.find(".tp-caption").each(function (a) {
                  t(jQuery(this), e, e.timelines[i].layers, i);
                });
            });
      },
      buildFullTimeLine: function (e) {
        var t,
          i,
          r = e.caption,
          d = r.data(),
          p = e.opt,
          c = {},
          h = l();
        if (
          ((t = p.timelines[d._slideid].layers[d._id]),
          !t.generated || !0 === e.regenerate)
        ) {
          if (
            ((i = t.timeline),
            (t.generated = !0),
            void 0 !== d.current_timeline && !0 !== e.regenerate
              ? ((d.current_timeline_pause = d.current_timeline.paused()),
                (d.current_timeline_time = d.current_timeline.time()),
                (d.current_is_nc_timeline = i === d.current_timeline),
                (d.static_layer_timeline_time = d.current_timeline_time))
              : ((d.static_layer_timeline_time = d.current_timeline_time),
                (d.current_timeline_time = 0),
                d.current_timeline && d.current_timeline.clear()),
            i.clear(),
            (c.svg = void 0 != d.svg_src && r.find("svg")),
            c.svg && (d.idlesvg = s(d.svg_idle, n())),
            -1 !== d.hoverframeindex &&
              void 0 !== d.hoverframeindex &&
              !r.hasClass("rs-hover-ready"))
          ) {
            if (
              (r.addClass("rs-hover-ready"),
              (d.hovertimelines = {}),
              (d.hoveranim = u(h, d.frames[d.hoverframeindex].to)),
              (d.hoveranim = g(d.hoveranim, d.frames[d.hoverframeindex].style)),
              c.svg)
            ) {
              var f = s(d.svg_hover, n());
              void 0 != h.anim.color && (f.anim.fill = h.anim.color),
                (d.hoversvg = f);
            }
            r.hover(
              function (e) {
                var t = {
                    caption: jQuery(e.currentTarget),
                    opt: p,
                    firstframe: "frame_0",
                    lastframe: "frame_999",
                  },
                  a = (o(t), t.caption),
                  i = a.data(),
                  r = i.frames[i.hoverframeindex];
                (i.forcehover = r.force),
                  (i.hovertimelines.item = punchgs.TweenLite.to(
                    a,
                    r.speed / 1e3,
                    i.hoveranim.anim
                  )),
                  (i.hoverzIndex ||
                    (i.hoveranim.anim && i.hoveranim.anim.zIndex)) &&
                    ((i.basiczindex =
                      void 0 === i.basiczindex
                        ? i.cssobj.zIndex
                        : i.basiczindex),
                    (i.hoverzIndex =
                      void 0 === i.hoverzIndex
                        ? i.hoveranim.anim.zIndex
                        : i.hoverzIndex),
                    (i.hovertimelines.pwhoveranim = punchgs.TweenLite.to(
                      i._pw,
                      r.speed / 1e3,
                      { overwrite: "auto", zIndex: i.hoverzIndex }
                    ))),
                  c.svg &&
                    (i.hovertimelines.svghoveranim = punchgs.TweenLite.to(
                      c.svg,
                      r.speed / 1e3,
                      i.hoversvg.anim
                    )),
                  (i.hoveredstatus = !0);
              },
              function (e) {
                var t = {
                    caption: jQuery(e.currentTarget),
                    opt: p,
                    firstframe: "frame_0",
                    lastframe: "frame_999",
                  },
                  a = (o(t), t.caption),
                  i = a.data(),
                  r = i.frames[i.hoverframeindex];
                (i.hoveredstatus = !1),
                  (i.hovertimelines.item = punchgs.TweenLite.to(
                    a,
                    r.speed / 1e3,
                    jQuery.extend(!0, {}, i._gsTransformTo)
                  )),
                  void 0 !== i.hovertimelines.pwhoveranim &&
                    (i.hovertimelines.pwhoveranim = punchgs.TweenLite.to(
                      i._pw,
                      r.speed / 1e3,
                      { overwrite: "auto", zIndex: i.basiczindex }
                    )),
                  c.svg &&
                    punchgs.TweenLite.to(c.svg, r.speed / 1e3, i.idlesvg.anim);
              }
            );
          }
          for (var m = 0; m < d.frames.length; m++)
            if (m !== d.hoverframeindex) {
              var v =
                m === d.inframeindex
                  ? "frame_0"
                  : m === d.outframeindex || "frame_999" === d.frames[m].frame
                  ? "frame_999"
                  : "frame_" + m;
              (d.frames[m].framename = v),
                (t[v] = {}),
                (t[v].timeline = new punchgs.TimelineLite({ align: "normal" }));
              var w = d.frames[m].delay,
                b =
                  (d.triggered_startstatus,
                  void 0 !== w
                    ? jQuery.inArray(w, ["slideenter", "bytrigger", "wait"]) >=
                      0
                      ? w
                      : parseInt(w, 0) / 1e3
                    : "wait");
              void 0 !== t.firstslide &&
                "frame_0" === v &&
                (i.addLabel("slide_" + t.firstslide + "_pause", 0),
                i.addPause("slide_" + t.firstslide + "_pause"),
                i.addLabel("slide_" + t.firstslide, "+=0.005")),
                void 0 !== t.lastslide &&
                  "frame_999" === v &&
                  (i.addLabel("slide_" + t.lastslide + "_pause", "+=0.01"),
                  i.addPause("slide_" + t.lastslide + "_pause"),
                  i.addLabel("slide_" + t.lastslide, "+=0.005")),
                jQuery.isNumeric(b)
                  ? i.addLabel(v, "+=" + b)
                  : (i.addLabel("pause_" + m, "+=0.01"),
                    i.addPause("pause_" + m),
                    i.addLabel(v, "+=0.01")),
                (i = a.createFrameOnTimeline({
                  caption: e.caption,
                  timeline: i,
                  label: v,
                  frameindex: m,
                  opt: p,
                }));
            }
          e.regenerate ||
            (d.current_is_nc_timeline && (d.current_timeline = i),
            d.current_timeline_pause
              ? i.pause(d.current_timeline_time)
              : i.time(d.current_timeline_time));
        }
      },
      createFrameOnTimeline: function (e) {
        var t = e.caption,
          i = t.data(),
          o = e.label,
          n = e.timeline,
          s = e.frameindex,
          l = e.opt,
          p = t,
          f = {},
          g = l.timelines[i._slideid].layers[i._id],
          m = i.frames.length - 1,
          v = i.frames[s].split;
        if (
          (-1 !== i.hoverframeindex && i.hoverframeindex == m && (m -= 1),
          (f.content = new punchgs.TimelineLite({ align: "normal" })),
          (f.mask = new punchgs.TimelineLite({ align: "normal" })),
          void 0 === n.vars.id && (n.vars.id = Math.round(1e5 * Math.random())),
          "column" === i._nctype &&
            (n.add(punchgs.TweenLite.set(i._cbgc_man, { display: "block" }), o),
            n.add(punchgs.TweenLite.set(i._cbgc_auto, { display: "none" }), o)),
          void 0 === i.mySplitText && i.splittext)
        ) {
          var w = t.find("a").length > 0 ? t.find("a") : t;
          (i.mySplitText = new punchgs.SplitText(w, {
            type: "chars,words,lines",
            charsClass: "tp-splitted tp-charsplit",
            wordsClass: "tp-splitted tp-wordsplit",
            linesClass: "tp-splitted tp-linesplit",
          })),
            t.addClass("splitted");
        }
        void 0 !== i.mySplitText &&
          v &&
          v.match(/chars|words|lines/g) &&
          (p = i.mySplitText[v]);
        var b,
          x,
          T =
            s !== i.outframeindex
              ? u(r(), i.frames[s].to)
              : void 0 !== i.frames[s].to &&
                null === i.frames[s].to.match(/auto:auto/g)
              ? u(d(), i.frames[s].to, 1 == l.sdir)
              : u(d(), i.frames[i.inframeindex].from, 0 == l.sdir),
          L =
            void 0 !== i.frames[s].from
              ? u(T, i.frames[i.inframeindex].from, 1 == l.sdir)
              : void 0,
          k = i.frames[s].splitdelay;
        if (
          (0 !== s || e.fromcurrentstate
            ? (x = h(i.frames[s].mask))
            : (b = h(i.frames[s].mask)),
          (T.anim.ease =
            void 0 === i.frames[s].ease
              ? punchgs.Power1.easeInOut
              : i.frames[s].ease),
          void 0 !== L &&
            ((L.anim.ease =
              void 0 === i.frames[s].ease
                ? punchgs.Power1.easeInOut
                : i.frames[s].ease),
            (L.speed =
              void 0 === i.frames[s].speed ? L.speed : i.frames[s].speed),
            (L.anim.x =
              L.anim.x * l.bw ||
              c(L.anim.x, l, i.eow, i.eoh, i.calcy, i.calcx, "horizontal")),
            (L.anim.y =
              L.anim.y * l.bw ||
              c(L.anim.y, l, i.eow, i.eoh, i.calcy, i.calcx, "vertical"))),
          void 0 !== T &&
            ((T.anim.ease =
              void 0 === i.frames[s].ease
                ? punchgs.Power1.easeInOut
                : i.frames[s].ease),
            (T.speed =
              void 0 === i.frames[s].speed ? T.speed : i.frames[s].speed),
            (T.anim.x =
              T.anim.x * l.bw ||
              c(T.anim.x, l, i.eow, i.eoh, i.calcy, i.calcx, "horizontal")),
            (T.anim.y =
              T.anim.y * l.bw ||
              c(T.anim.y, l, i.eow, i.eoh, i.calcy, i.calcx, "vertical"))),
          t.data("iframes") &&
            n.add(
              punchgs.TweenLite.set(t.find("iframe"), { autoAlpha: 1 }),
              o + "+=0.001"
            ),
          s === i.outframeindex &&
            (i.frames[s].to && i.frames[s].to.match(/auto:auto/g),
            (T.speed =
              void 0 === i.frames[s].speed || "inherit" === i.frames[s].speed
                ? i.frames[i.inframeindex].speed
                : i.frames[s].speed),
            (T.anim.ease =
              void 0 === i.frames[s].ease || "inherit" === i.frames[s].ease
                ? i.frames[i.inframeindex].ease
                : i.frames[s].ease),
            (T.anim.overwrite = "auto")),
          0 !== s || e.fromcurrentstate)
        )
          0 === s && e.fromcurrentstate && (T.speed = L.speed);
        else {
          if (p != t) {
            var j = T.anim.ease;
            n.add(punchgs.TweenLite.set(t, T.anim), o), (T = r()), (T.ease = j);
          }
          (L.anim.visibility = "hidden"),
            (L.anim.immediateRender = !0),
            (T.anim.visibility = "visible");
        }
        return (
          e.fromcurrentstate && (T.anim.immediateRender = !0),
          0 !== s || e.fromcurrentstate
            ? n.add(f.content.staggerTo(p, T.speed / 1e3, T.anim, k), o)
            : n.add(
                f.content.staggerFromTo(p, L.speed / 1e3, L.anim, T.anim, k),
                o
              ),
          void 0 !== x &&
            !1 !== x &&
            ((x.anim.ease =
              void 0 === x.anim.ease || "inherit" === x.anim.ease
                ? i.frames[0].ease
                : x.anim.ease),
            (x.anim.overflow = "hidden"),
            (x.anim.x =
              x.anim.x * l.bw ||
              c(x.anim.x, l, i.eow, i.eoh, i.calcy, i.calcx, "horizontal")),
            (x.anim.y =
              x.anim.y * l.bw ||
              c(x.anim.y, l, i.eow, i.eoh, i.calcy, i.calcx, "vertical"))),
          0 === s && b && !1 !== b && !e.fromcurrentstate
            ? ((x = new Object()),
              (x.anim = new Object()),
              (x.anim.overwrite = "auto"),
              (x.anim.ease = T.anim.ease),
              (x.anim.x = x.anim.y = 0),
              (b.anim.x =
                b.anim.x * l.bw ||
                c(b.anim.x, l, i.eow, i.eoh, i.calcy, i.calcx, "horizontal")),
              (b.anim.y =
                b.anim.y * l.bw ||
                c(b.anim.y, l, i.eow, i.eoh, i.calcy, i.calcx, "vertical")),
              (b.anim.overflow = "hidden"))
            : 0 === s && n.add(f.mask.set(i._mw, { overflow: "visible" }), o),
          void 0 !== b && void 0 !== x && !1 !== b && !1 !== x
            ? n.add(f.mask.fromTo(i._mw, L.speed / 1e3, b.anim, x.anim, k), o)
            : void 0 !== x &&
              !1 !== x &&
              n.add(f.mask.to(i._mw, T.speed / 1e3, x.anim, k), o),
          n.addLabel(o + "_end"),
          i._gsTransformTo &&
            s === m &&
            i.hoveredstatus &&
            (i.hovertimelines.item = punchgs.TweenLite.to(
              t,
              0,
              i._gsTransformTo
            )),
          (i._gsTransformTo = !1),
          f.content.eventCallback(
            "onStart",
            function (e, t, i, o, r, n, s, d) {
              var p = {};
              if (
                ((p.layer = s),
                (p.eventtype =
                  0 === e
                    ? "enterstage"
                    : e === o.outframeindex
                    ? "leavestage"
                    : "framestarted"),
                (p.layertype = s.data("layertype")),
                s.data("active", !0),
                (p.frame_index = e),
                (p.layersettings = s.data()),
                l.c.trigger("revolution.layeraction", [p]),
                "on" == o.loopanimation && _(o._lw, l.bw),
                "enterstage" === p.eventtype &&
                  ((o.animdirection = "in"),
                  (o.visibleelement = !0),
                  a.toggleState(o.layertoggledby)),
                "none" !== t.dchildren &&
                  void 0 !== t.dchildren &&
                  t.dchildren.length > 0)
              )
                if (0 === e)
                  for (var c = 0; c < t.dchildren.length; c++)
                    jQuery(t.dchildren[c]).data("timeline").play(0);
                else if (e === o.outframeindex)
                  for (var c = 0; c < t.dchildren.length; c++)
                    a.endMoveCaption({
                      caption: jQuery(t.dchildren[c]),
                      opt: l,
                      checkchildrens: !0,
                    });
              punchgs.TweenLite.set(i, { visibility: "visible" }),
                (o.current_frame = e),
                (o.current_timeline = r),
                (o.current_timeline_time = r.time()),
                d && (o.static_layer_timeline_time = o.current_timeline_time),
                (o.last_frame_started = e);
            },
            [s, g, i._pw, i, n, T.anim, t, e.updateStaticTimeline]
          ),
          f.content.eventCallback(
            "onUpdate",
            function (e, a, i, o, r, n, s, d) {
              "column" === o._nctype && y(t, l),
                punchgs.TweenLite.set(i, { visibility: "visible" }),
                (o.current_frame = n),
                (o.current_timeline = r),
                (o.current_timeline_time = r.time()),
                d && (o.static_layer_timeline_time = o.current_timeline_time),
                void 0 !== o.hoveranim &&
                  !1 === o._gsTransformTo &&
                  ((o._gsTransformTo = s),
                  o._gsTransformTo &&
                    o._gsTransformTo.startAt &&
                    delete o._gsTransformTo.startAt,
                  void 0 === o.cssobj.styleProps.css
                    ? (o._gsTransformTo = jQuery.extend(
                        !0,
                        {},
                        o.cssobj.styleProps,
                        o._gsTransformTo
                      ))
                    : (o._gsTransformTo = jQuery.extend(
                        !0,
                        {},
                        o.cssobj.styleProps.css,
                        o._gsTransformTo
                      ))),
                (o.visibleelement = !0);
            },
            [
              o,
              i._id,
              i._pw,
              i,
              n,
              s,
              jQuery.extend(!0, {}, T.anim),
              e.updateStaticTimeline,
            ]
          ),
          f.content.eventCallback(
            "onComplete",
            function (e, i, o, r, n, s, d) {
              var p = {};
              (p.layer = t),
                (p.eventtype =
                  0 === e
                    ? "enteredstage"
                    : e === i - 1 || e === o
                    ? "leftstage"
                    : "frameended"),
                (p.layertype = t.data("layertype")),
                (p.layersettings = t.data()),
                l.c.trigger("revolution.layeraction", [p]),
                "leftstage" !== p.eventtype && a.animcompleted(t, l),
                "leftstage" === p.eventtype && a.stopVideo && a.stopVideo(t, l),
                "column" === n._nctype &&
                  (punchgs.TweenLite.set(n._cbgc_man, { display: "none" }),
                  punchgs.TweenLite.set(n._cbgc_auto, { display: "block" })),
                "leftstage" === p.eventtype &&
                  (punchgs.TweenLite.set(r, { visibility: "hidden" }),
                  (n.animdirection = "out"),
                  (n.visibleelement = !1),
                  a.unToggleState(n.layertoggledby)),
                (n.current_frame = e),
                (n.current_timeline = s),
                (n.current_timeline_time = s.time()),
                d && (n.static_layer_timeline_time = n.current_timeline_time);
            },
            [s, i.frames.length, m, i._pw, i, n, e.updateStaticTimeline]
          ),
          n
        );
      },
      endMoveCaption: function (e) {
        (e.firstframe = "frame_0"), (e.lastframe = "frame_999");
        var t = o(e),
          i = e.caption.data();
        if (
          (void 0 !== e.frame
            ? t.timeline.play(e.frame)
            : (!t.static ||
                e.currentslide >= t.removeonslide ||
                e.currentslide < t.showonslide) &&
              ((t.outnow = new punchgs.TimelineLite()),
              t.timeline.pause(),
              !0 === i.visibleelement &&
                a
                  .createFrameOnTimeline({
                    caption: e.caption,
                    timeline: t.outnow,
                    label: "outnow",
                    frameindex: e.caption.data("outframeindex"),
                    opt: e.opt,
                    fromcurrentstate: !0,
                  })
                  .play()),
          e.checkchildrens &&
            t.timeline_obj &&
            t.timeline_obj.dchildren &&
            "none" !== t.timeline_obj.dchildren &&
            t.timeline_obj.dchildren.length > 0)
        )
          for (var r = 0; r < t.timeline_obj.dchildren.length; r++)
            a.endMoveCaption({
              caption: jQuery(t.timeline_obj.dchildren[r]),
              opt: e.opt,
            });
      },
      playAnimationFrame: function (e) {
        (e.firstframe = e.triggerframein), (e.lastframe = e.triggerframeout);
        var t,
          i = o(e),
          r = e.caption.data(),
          n = 0;
        for (var s in r.frames)
          r.frames[s].framename === e.frame && (t = n), n++;
        (r.triggeredtimeline = new punchgs.TimelineLite()), i.timeline.pause();
        var d = !0 === r.visibleelement;
        r.triggeredtimeline = a
          .createFrameOnTimeline({
            caption: e.caption,
            timeline: r.triggeredtimeline,
            label: "triggered",
            frameindex: t,
            updateStaticTimeline: !0,
            opt: e.opt,
            fromcurrentstate: d,
          })
          .play();
      },
      removeTheCaptions: function (e, t) {
        if ("stop" === a.compare_version(i).check) return !1;
        var o = e.data("index"),
          r = new Array();
        t.layers[o] &&
          jQuery.each(t.layers[o], function (e, t) {
            r.push(t);
          });
        var n = a.currentSlideIndex(t);
        r &&
          jQuery.each(r, function (e) {
            var i = jQuery(this);
            x(i),
              clearTimeout(i.data("videoplaywait")),
              a.endMoveCaption({ caption: i, opt: t, currentslide: n }),
              a.removeMediaFromList && a.removeMediaFromList(i, t),
              (t.lastplayedvideos = []);
          });
      },
    });
    var o = function (e) {
        var t = {};
        return (
          (e.firstframe = void 0 === e.firstframe ? "frame_0" : e.firstframe),
          (e.lastframe = void 0 === e.lastframe ? "frame_999" : e.lastframe),
          (t.id = e.caption.data("id") || e.caption.attr("id")),
          (t.slideid =
            e.caption.data("slideid") ||
            e.caption.closest(".tp-revslider-slidesli").data("index")),
          (t.timeline_obj = e.opt.timelines[t.slideid].layers[t.id]),
          (t.timeline = t.timeline_obj.timeline),
          (t.ffs = t.timeline.getLabelTime(e.firstframe)),
          (t.ffe = t.timeline.getLabelTime(e.firstframe + "_end")),
          (t.lfs = t.timeline.getLabelTime(e.lastframe)),
          (t.lfe = t.timeline.getLabelTime(e.lastframe + "_end")),
          (t.ct = t.timeline.time()),
          (t.static =
            void 0 != t.timeline_obj.firstslide ||
            void 0 != t.timeline_obj.lastslide),
          t.static &&
            ((t.showonslide = t.timeline_obj.firstslide),
            (t.removeonslide = t.timeline_obj.lastslide)),
          t
        );
      },
      r = function (e) {
        return (
          (e = void 0 === e ? new Object() : e),
          (e.anim = void 0 === e.anim ? new Object() : e.anim),
          (e.anim.x = void 0 === e.anim.x ? 0 : e.anim.x),
          (e.anim.y = void 0 === e.anim.y ? 0 : e.anim.y),
          (e.anim.z = void 0 === e.anim.z ? 0 : e.anim.z),
          (e.anim.rotationX =
            void 0 === e.anim.rotationX ? 0 : e.anim.rotationX),
          (e.anim.rotationY =
            void 0 === e.anim.rotationY ? 0 : e.anim.rotationY),
          (e.anim.rotationZ =
            void 0 === e.anim.rotationZ ? 0 : e.anim.rotationZ),
          (e.anim.scaleX = void 0 === e.anim.scaleX ? 1 : e.anim.scaleX),
          (e.anim.scaleY = void 0 === e.anim.scaleY ? 1 : e.anim.scaleY),
          (e.anim.skewX = void 0 === e.anim.skewX ? 0 : e.anim.skewX),
          (e.anim.skewY = void 0 === e.anim.skewY ? 0 : e.anim.skewY),
          (e.anim.opacity = void 0 === e.anim.opacity ? 1 : e.anim.opacity),
          (e.anim.transformOrigin =
            void 0 === e.anim.transformOrigin
              ? "50% 50%"
              : e.anim.transformOrigin),
          (e.anim.transformPerspective =
            void 0 === e.anim.transformPerspective
              ? 600
              : e.anim.transformPerspective),
          (e.anim.rotation = void 0 === e.anim.rotation ? 0 : e.anim.rotation),
          (e.anim.force3D =
            void 0 === e.anim.force3D ? "auto" : e.anim.force3D),
          (e.anim.autoAlpha =
            void 0 === e.anim.autoAlpha ? 1 : e.anim.autoAlpha),
          (e.anim.visibility =
            void 0 === e.anim.visibility ? "visible" : e.anim.visibility),
          (e.anim.overwrite =
            void 0 === e.anim.overwrite ? "auto" : e.anim.overwrite),
          (e.speed = void 0 === e.speed ? 0.3 : e.speed),
          e
        );
      },
      n = function () {
        var e = new Object();
        return (
          (e.anim = new Object()),
          (e.anim.stroke = "none"),
          (e.anim.strokeWidth = 0),
          (e.anim.strokeDasharray = "none"),
          (e.anim.strokeDashoffset = "0"),
          e
        );
      },
      s = function (e, t) {
        var a = e.split(";");
        return (
          a &&
            jQuery.each(a, function (e, a) {
              var i = a.split(":"),
                o = i[0],
                r = i[1];
              "sc" == o && (t.anim.stroke = r),
                "sw" == o && (t.anim.strokeWidth = r),
                "sda" == o && (t.anim.strokeDasharray = r),
                "sdo" == o && (t.anim.strokeDashoffset = r);
            }),
          t
        );
      },
      d = function () {
        var e = new Object();
        return (
          (e.anim = new Object()),
          (e.anim.x = 0),
          (e.anim.y = 0),
          (e.anim.z = 0),
          e
        );
      },
      l = function () {
        var e = new Object();
        return (e.anim = new Object()), (e.speed = 0.2), e;
      },
      p = function (e, t) {
        if (jQuery.isNumeric(parseFloat(e))) return parseFloat(e);
        if (void 0 === e || "inherit" === e) return t;
        if (e.split("{").length > 1) {
          var a = e.split(","),
            i = parseFloat(a[1].split("}")[0]);
          (a = parseFloat(a[0].split("{")[1])),
            (e = Math.random() * (i - a) + a);
        }
        return e;
      },
      c = function (e, t, a, i, o, r, n) {
        return (
          !jQuery.isNumeric(e) && e.match(/%]/g)
            ? ((e = e.split("[")[1].split("]")[0]),
              "horizontal" == n
                ? (e = ((a + 2) * parseInt(e, 0)) / 100)
                : "vertical" == n && (e = ((i + 2) * parseInt(e, 0)) / 100))
            : ((e = "layer_left" === e ? 0 - a : "layer_right" === e ? a : e),
              (e = "layer_top" === e ? 0 - i : "layer_bottom" === e ? i : e),
              (e =
                "left" === e || "stage_left" === e
                  ? 0 - a - r
                  : "right" === e || "stage_right" === e
                  ? t.conw - r
                  : "center" === e || "stage_center" === e
                  ? t.conw / 2 - a / 2 - r
                  : e),
              (e =
                "top" === e || "stage_top" === e
                  ? 0 - i - o
                  : "bottom" === e || "stage_bottom" === e
                  ? t.conh - o
                  : "middle" === e || "stage_middle" === e
                  ? t.conh / 2 - i / 2 - o
                  : e)),
          e
        );
      },
      u = function (e, t, a) {
        var i = new Object();
        if (((i = jQuery.extend(!0, {}, i, e)), void 0 === t)) return i;
        var o = t.split(";");
        return (
          o &&
            jQuery.each(o, function (e, t) {
              var o = t.split(":"),
                r = o[0],
                n = o[1];
              a &&
                void 0 != n &&
                n.length > 0 &&
                n.match(/\(R\)/) &&
                ((n = n.replace("(R)", "")),
                (n =
                  "right" === n
                    ? "left"
                    : "left" === n
                    ? "right"
                    : "top" === n
                    ? "bottom"
                    : "bottom" === n
                    ? "top"
                    : n),
                "[" === n[0] && "-" === n[1]
                  ? (n = n.replace("[-", "["))
                  : "[" === n[0] && "-" !== n[1]
                  ? (n = n.replace("[", "[-"))
                  : "-" === n[0]
                  ? (n = n.replace("-", ""))
                  : n[0].match(/[1-9]/) && (n = "-" + n)),
                void 0 != n &&
                  ((n = n.replace(/\(R\)/, "")),
                  ("rotationX" != r && "rX" != r) ||
                    (i.anim.rotationX = p(n, i.anim.rotationX) + "deg"),
                  ("rotationY" != r && "rY" != r) ||
                    (i.anim.rotationY = p(n, i.anim.rotationY) + "deg"),
                  ("rotationZ" != r && "rZ" != r) ||
                    (i.anim.rotation = p(n, i.anim.rotationZ) + "deg"),
                  ("scaleX" != r && "sX" != r) ||
                    (i.anim.scaleX = p(n, i.anim.scaleX)),
                  ("scaleY" != r && "sY" != r) ||
                    (i.anim.scaleY = p(n, i.anim.scaleY)),
                  ("opacity" != r && "o" != r) ||
                    (i.anim.opacity = p(n, i.anim.opacity)),
                  0 === i.anim.opacity && (i.anim.autoAlpha = 0),
                  (i.anim.opacity =
                    0 == i.anim.opacity ? 1e-4 : i.anim.opacity),
                  ("skewX" != r && "skX" != r) ||
                    (i.anim.skewX = p(n, i.anim.skewX)),
                  ("skewY" != r && "skY" != r) ||
                    (i.anim.skewY = p(n, i.anim.skewY)),
                  "x" == r && (i.anim.x = p(n, i.anim.x)),
                  "y" == r && (i.anim.y = p(n, i.anim.y)),
                  "z" == r && (i.anim.z = p(n, i.anim.z)),
                  ("transformOrigin" != r && "tO" != r) ||
                    (i.anim.transformOrigin = n.toString()),
                  ("transformPerspective" != r && "tP" != r) ||
                    (i.anim.transformPerspective = parseInt(n, 0)),
                  ("speed" != r && "s" != r) || (i.speed = parseFloat(n)));
            }),
          i
        );
      },
      h = function (e) {
        if (void 0 === e) return !1;
        var t = new Object();
        t.anim = new Object();
        var a = e.split(";");
        return (
          a &&
            jQuery.each(a, function (e, a) {
              a = a.split(":");
              var i = a[0],
                o = a[1];
              "x" == i && (t.anim.x = o),
                "y" == i && (t.anim.y = o),
                "s" == i && (t.speed = parseFloat(o)),
                ("e" != i && "ease" != i) || (t.anim.ease = o);
            }),
          t
        );
      },
      f = function (e, t, a) {
        if (
          (void 0 == e && (e = 0),
          !jQuery.isArray(e) &&
            "string" === jQuery.type(e) &&
            (e.split(",").length > 1 || e.split("[").length > 1))
        ) {
          (e = e.replace("[", "")), (e = e.replace("]", ""));
          var i = e.match(/'/g) ? e.split("',") : e.split(",");
          (e = new Array()),
            i &&
              jQuery.each(i, function (t, a) {
                (a = a.replace("'", "")), (a = a.replace("'", "")), e.push(a);
              });
        } else {
          var o = e;
          jQuery.isArray(e) || ((e = new Array()), e.push(o));
        }
        var o = e[e.length - 1];
        if (e.length < t.rle)
          for (var r = 1; r <= t.curWinRange; r++) e.push(o);
        return e;
      },
      g = function (e, t) {
        if (void 0 === t) return e;
        (t = t.replace("c:", "color:")),
          (t = t.replace("bg:", "background-color:")),
          (t = t.replace("bw:", "border-width:")),
          (t = t.replace("bc:", "border-color:")),
          (t = t.replace("br:", "borderRadius:")),
          (t = t.replace("bs:", "border-style:")),
          (t = t.replace("td:", "text-decoration:")),
          (t = t.replace("zi:", "zIndex:"));
        var a = t.split(";");
        return (
          a &&
            jQuery.each(a, function (t, a) {
              var i = a.split(":");
              i[0].length > 0 && (e.anim[i[0]] = i[1]);
            }),
          e
        );
      },
      m = function (e, t) {
        var a,
          i = new Object(),
          o = !1;
        if (
          ("rekursive" == t &&
            (a = e.closest(".tp-caption")) &&
            e.css("fontSize") === a.css("fontSize") &&
            (o = !0),
          (i.basealign = e.data("basealign") || "grid"),
          (i.fontSize = o
            ? void 0 === a.data("fontsize")
              ? parseInt(a.css("fontSize"), 0) || 0
              : a.data("fontsize")
            : void 0 === e.data("fontsize")
            ? parseInt(e.css("fontSize"), 0) || 0
            : e.data("fontsize")),
          (i.fontWeight = o
            ? void 0 === a.data("fontweight")
              ? parseInt(a.css("fontWeight"), 0) || 0
              : a.data("fontweight")
            : void 0 === e.data("fontweight")
            ? parseInt(e.css("fontWeight"), 0) || 0
            : e.data("fontweight")),
          (i.whiteSpace = o
            ? void 0 === a.data("whitespace")
              ? a.css("whitespace") || "normal"
              : a.data("whitespace")
            : void 0 === e.data("whitespace")
            ? e.css("whitespace") || "normal"
            : e.data("whitespace")),
          (i.textAlign = o
            ? void 0 === a.data("textalign")
              ? a.css("textalign") || "inherit"
              : a.data("textalign")
            : void 0 === e.data("textalign")
            ? e.css("textalign") || "inherit"
            : e.data("textalign")),
          (i.zIndex = o
            ? void 0 === a.data("zIndex")
              ? a.css("zIndex") || "inherit"
              : a.data("zIndex")
            : void 0 === e.data("zIndex")
            ? e.css("zIndex") || "inherit"
            : e.data("zIndex")),
          -1 !==
            jQuery.inArray(e.data("layertype"), ["video", "image", "audio"]) ||
          e.is("img")
            ? (i.lineHeight = 0)
            : (i.lineHeight = o
                ? void 0 === a.data("lineheight")
                  ? parseInt(a.css("lineHeight"), 0) || 0
                  : a.data("lineheight")
                : void 0 === e.data("lineheight")
                ? parseInt(e.css("lineHeight"), 0) || 0
                : e.data("lineheight")),
          (i.letterSpacing = o
            ? void 0 === a.data("letterspacing")
              ? parseFloat(a.css("letterSpacing"), 0) || 0
              : a.data("letterspacing")
            : void 0 === e.data("letterspacing")
            ? parseFloat(e.css("letterSpacing")) || 0
            : e.data("letterspacing")),
          (i.paddingTop =
            void 0 === e.data("paddingtop")
              ? parseInt(e.css("paddingTop"), 0) || 0
              : e.data("paddingtop")),
          (i.paddingBottom =
            void 0 === e.data("paddingbottom")
              ? parseInt(e.css("paddingBottom"), 0) || 0
              : e.data("paddingbottom")),
          (i.paddingLeft =
            void 0 === e.data("paddingleft")
              ? parseInt(e.css("paddingLeft"), 0) || 0
              : e.data("paddingleft")),
          (i.paddingRight =
            void 0 === e.data("paddingright")
              ? parseInt(e.css("paddingRight"), 0) || 0
              : e.data("paddingright")),
          (i.marginTop =
            void 0 === e.data("margintop")
              ? parseInt(e.css("marginTop"), 0) || 0
              : e.data("margintop")),
          (i.marginBottom =
            void 0 === e.data("marginbottom")
              ? parseInt(e.css("marginBottom"), 0) || 0
              : e.data("marginbottom")),
          (i.marginLeft =
            void 0 === e.data("marginleft")
              ? parseInt(e.css("marginLeft"), 0) || 0
              : e.data("marginleft")),
          (i.marginRight =
            void 0 === e.data("marginright")
              ? parseInt(e.css("marginRight"), 0) || 0
              : e.data("marginright")),
          (i.borderTopWidth =
            void 0 === e.data("bordertopwidth")
              ? parseInt(e.css("borderTopWidth"), 0) || 0
              : e.data("bordertopwidth")),
          (i.borderBottomWidth =
            void 0 === e.data("borderbottomwidth")
              ? parseInt(e.css("borderBottomWidth"), 0) || 0
              : e.data("borderbottomwidth")),
          (i.borderLeftWidth =
            void 0 === e.data("borderleftwidth")
              ? parseInt(e.css("borderLeftWidth"), 0) || 0
              : e.data("borderleftwidth")),
          (i.borderRightWidth =
            void 0 === e.data("borderrightwidth")
              ? parseInt(e.css("borderRightWidth"), 0) || 0
              : e.data("borderrightwidth")),
          "rekursive" != t)
        ) {
          if (
            ((i.color =
              void 0 === e.data("color")
                ? "nopredefinedcolor"
                : e.data("color")),
            (i.whiteSpace = o
              ? void 0 === a.data("whitespace")
                ? a.css("whiteSpace") || "nowrap"
                : a.data("whitespace")
              : void 0 === e.data("whitespace")
              ? e.css("whiteSpace") || "nowrap"
              : e.data("whitespace")),
            (i.textAlign = o
              ? void 0 === a.data("textalign")
                ? a.css("textalign") || "inherit"
                : a.data("textalign")
              : void 0 === e.data("textalign")
              ? e.css("textalign") || "inherit"
              : e.data("textalign")),
            (i.minWidth =
              void 0 === e.data("width")
                ? parseInt(e.css("minWidth"), 0) || 0
                : e.data("width")),
            (i.minHeight =
              void 0 === e.data("height")
                ? parseInt(e.css("minHeight"), 0) || 0
                : e.data("height")),
            void 0 != e.data("videowidth") && void 0 != e.data("videoheight"))
          ) {
            var r = e.data("videowidth"),
              n = e.data("videoheight");
            (r = "100%" === r ? "none" : r),
              (n = "100%" === n ? "none" : n),
              e.data("width", r),
              e.data("height", n);
          }
          (i.maxWidth =
            void 0 === e.data("width")
              ? parseInt(e.css("maxWidth"), 0) || "none"
              : e.data("width")),
            (i.maxHeight =
              void 0 === e.data("height")
                ? parseInt(e.css("maxHeight"), 0) || "none"
                : e.data("height")),
            (i.wan =
              void 0 === e.data("wan")
                ? parseInt(e.css("-webkit-transition"), 0) || "none"
                : e.data("wan")),
            (i.moan =
              void 0 === e.data("moan")
                ? parseInt(e.css("-moz-animation-transition"), 0) || "none"
                : e.data("moan")),
            (i.man =
              void 0 === e.data("man")
                ? parseInt(e.css("-ms-animation-transition"), 0) || "none"
                : e.data("man")),
            (i.ani =
              void 0 === e.data("ani")
                ? parseInt(e.css("transition"), 0) || "none"
                : e.data("ani"));
        }
        return (
          (i.styleProps = e.css([
            "background-color",
            "border-top-color",
            "border-bottom-color",
            "border-right-color",
            "border-left-color",
            "border-top-style",
            "border-bottom-style",
            "border-left-style",
            "border-right-style",
            "border-left-width",
            "border-right-width",
            "border-bottom-width",
            "border-top-width",
            "color",
            "text-decoration",
            "font-style",
            "borderTopLeftRadius",
            "borderTopRightRadius",
            "borderBottomLeftRadius",
            "borderBottomRightRadius",
          ])),
          i
        );
      },
      v = function (e, t) {
        var a = new Object();
        return (
          e &&
            jQuery.each(e, function (i, o) {
              var r = f(o, t)[t.curWinRange];
              a[i] = void 0 !== r ? r : e[i];
            }),
          a
        );
      },
      w = function (e, t, a, i) {
        return (
          (e = jQuery.isNumeric(e) ? e * t + "px" : e),
          (e = "full" === e ? i : "auto" === e || "none" === e ? a : e)
        );
      },
      b = function (e, t, a, i) {
        var o = e.data();
        try {
          if ("BR" == e[0].nodeName || "br" == e[0].tagName) return !1;
        } catch (e) {}
        o.cssobj = void 0 === o.cssobj ? m(e, a) : o.cssobj;
        var r = v(o.cssobj, t),
          n = t.bw,
          s = t.bh;
        if (
          ("off" === i && ((n = 1), (s = 1)),
          "auto" == r.lineHeight && (r.lineHeight = r.fontSize + 4),
          !e.hasClass("tp-splitted"))
        ) {
          e.css("-webkit-transition", "none"),
            e.css("-moz-transition", "none"),
            e.css("-ms-transition", "none"),
            e.css("transition", "none");
          if (
            ((void 0 !== e.data("transform_hover") ||
              void 0 !== e.data("style_hover")) &&
              punchgs.TweenLite.set(e, r.styleProps),
            punchgs.TweenLite.set(e, {
              fontSize: Math.round(r.fontSize * n) + "px",
              fontWeight: r.fontWeight,
              letterSpacing: Math.floor(r.letterSpacing * n) + "px",
              paddingTop: Math.round(r.paddingTop * s) + "px",
              paddingBottom: Math.round(r.paddingBottom * s) + "px",
              paddingLeft: Math.round(r.paddingLeft * n) + "px",
              paddingRight: Math.round(r.paddingRight * n) + "px",
              marginTop: r.marginTop * s + "px",
              marginBottom: r.marginBottom * s + "px",
              marginLeft: r.marginLeft * n + "px",
              marginRight: r.marginRight * n + "px",
              borderTopWidth: Math.round(r.borderTopWidth * s) + "px",
              borderBottomWidth: Math.round(r.borderBottomWidth * s) + "px",
              borderLeftWidth: Math.round(r.borderLeftWidth * n) + "px",
              borderRightWidth: Math.round(r.borderRightWidth * n) + "px",
              lineHeight: Math.round(r.lineHeight * s) + "px",
              textAlign: r.textAlign,
              overwrite: "auto",
            }),
            "rekursive" != a)
          ) {
            var d = "slide" == r.basealign ? t.ulw : t.gridwidth[t.curWinRange],
              l = "slide" == r.basealign ? t.ulh : t.gridheight[t.curWinRange],
              p = w(r.maxWidth, n, "none", d),
              c = w(r.maxHeight, s, "none", l),
              u = w(r.minWidth, n, "0px", d),
              h = w(r.minHeight, s, "0px", l);
            if (
              ((u = void 0 === u ? 0 : u),
              (h = void 0 === h ? 0 : h),
              (p = void 0 === p ? "none" : p),
              (c = void 0 === c ? "none" : c),
              punchgs.TweenLite.set(e, {
                maxWidth: p,
                maxHeight: c,
                minWidth: u,
                minHeight: h,
                whiteSpace: r.whiteSpace,
                textAlign: r.textAlign,
                overwrite: "auto",
              }),
              "nopredefinedcolor" != r.color &&
                punchgs.TweenLite.set(e, { color: r.color, overwrite: "auto" }),
              void 0 != o.svg_src)
            ) {
              var f =
                "nopredefinedcolor" != r.color && void 0 != r.color
                  ? r.color
                  : void 0 != r.css &&
                    "nopredefinedcolor" != r.css.color &&
                    void 0 != r.css.color
                  ? r.css.color
                  : void 0 != r.styleProps.color
                  ? r.styleProps.color
                  : void 0 != r.styleProps.css &&
                    void 0 != r.styleProps.css.color &&
                    r.styleProps.css.color;
              0 != f &&
                (punchgs.TweenLite.set(e.find("svg"), {
                  fill: f,
                  overwrite: "auto",
                }),
                punchgs.TweenLite.set(e.find("svg path"), {
                  fill: f,
                  overwrite: "auto",
                }));
            }
          }
          "column" === o._nctype &&
            (void 0 === o._column_bg_set &&
              ((o._column_bg_set = e.css("backgroundColor")),
              (o._column_bg_image = e.css("backgroundImage")),
              (o._column_bg_image_repeat = e.css("backgroundRepeat")),
              (o._column_bg_image_position = e.css("backgroundPosition")),
              (o._column_bg_image_size = e.css("backgroundSize")),
              (o._column_bg_opacity = e.data("bgopacity")),
              (o._column_bg_opacity =
                void 0 === o._column_bg_opacity ? 1 : o._column_bg_opacity),
              punchgs.TweenLite.set(e, {
                backgroundColor: "transparent",
                backgroundImage: "",
              })),
            setTimeout(function () {
              y(e, t);
            }, 1),
            o._cbgc_auto &&
              ((o._cbgc_auto[0].style.backgroundSize = o._column_bg_image_size),
              jQuery.isArray(r.marginLeft)
                ? punchgs.TweenLite.set(o._cbgc_auto, {
                    borderTopWidth: r.marginTop[t.curWinRange] * s + "px",
                    borderLeftWidth: r.marginLeft[t.curWinRange] * n + "px",
                    borderRightWidth: r.marginRight[t.curWinRange] * n + "px",
                    borderBottomWidth: r.marginBottom[t.curWinRange] * s + "px",
                    backgroundColor: o._column_bg_set,
                    backgroundImage: o._column_bg_image,
                    backgroundRepeat: o._column_bg_image_repeat,
                    backgroundPosition: o._column_bg_image_position,
                    opacity: o._column_bg_opacity,
                  })
                : punchgs.TweenLite.set(o._cbgc_auto, {
                    borderTopWidth: r.marginTop * s + "px",
                    borderLeftWidth: r.marginLeft * n + "px",
                    borderRightWidth: r.marginRight * n + "px",
                    borderBottomWidth: r.marginBottom * s + "px",
                    backgroundColor: o._column_bg_set,
                    backgroundImage: o._column_bg_image,
                    backgroundRepeat: o._column_bg_image_repeat,
                    backgroundPosition: o._column_bg_image_position,
                    opacity: o._column_bg_opacity,
                  }))),
            setTimeout(function () {
              e.css("-webkit-transition", e.data("wan")),
                e.css("-moz-transition", e.data("moan")),
                e.css("-ms-transition", e.data("man")),
                e.css("transition", e.data("ani"));
            }, 30);
        }
      },
      y = function (e, t) {
        var a = e.data();
        if (a._cbgc_man) {
          var i, o, r;
          jQuery.isArray(a.cssobj.marginLeft)
            ? (a.cssobj.marginLeft[t.curWinRange] * t.bw,
              (i = a.cssobj.marginTop[t.curWinRange] * t.bh),
              (o = a.cssobj.marginBottom[t.curWinRange] * t.bh),
              a.cssobj.marginRight[t.curWinRange] * t.bw)
            : (a.cssobj.marginLeft * t.bw,
              (i = a.cssobj.marginTop * t.bh),
              (o = a.cssobj.marginBottom * t.bh),
              a.cssobj.marginRight * t.bw),
            (r = a._row.hasClass("rev_break_columns")
              ? "100%"
              : a._row.outerHeight() - (i + o) + "px"),
            (a._cbgc_man[0].style.backgroundSize = a._column_bg_image_size),
            punchgs.TweenLite.set(a._cbgc_man, {
              width: "100%",
              height: r,
              backgroundColor: a._column_bg_set,
              backgroundImage: a._column_bg_image,
              backgroundRepeat: a._column_bg_image_repeat,
              backgroundPosition: a._column_bg_image_position,
              overwrite: "auto",
              opacity: a._column_bg_opacity,
            });
        }
      },
      _ = function (e, t) {
        var a = e.data();
        if (e.hasClass("rs-pendulum") && void 0 == a._loop_timeline) {
          a._loop_timeline = new punchgs.TimelineLite();
          var i = void 0 == e.data("startdeg") ? -20 : e.data("startdeg"),
            o = void 0 == e.data("enddeg") ? 20 : e.data("enddeg"),
            r = void 0 == e.data("speed") ? 2 : e.data("speed"),
            n = void 0 == e.data("origin") ? "50% 50%" : e.data("origin"),
            s =
              void 0 == e.data("easing")
                ? punchgs.Power2.easeInOut
                : e.data("easing");
          (i *= t),
            (o *= t),
            a._loop_timeline.append(
              new punchgs.TweenLite.fromTo(
                e,
                r,
                { force3D: "auto", rotation: i, transformOrigin: n },
                { rotation: o, ease: s }
              )
            ),
            a._loop_timeline.append(
              new punchgs.TweenLite.fromTo(
                e,
                r,
                { force3D: "auto", rotation: o, transformOrigin: n },
                {
                  rotation: i,
                  ease: s,
                  onComplete: function () {
                    a._loop_timeline.restart();
                  },
                }
              )
            );
        }
        if (e.hasClass("rs-rotate") && void 0 == a._loop_timeline) {
          a._loop_timeline = new punchgs.TimelineLite();
          var i = void 0 == e.data("startdeg") ? 0 : e.data("startdeg"),
            o = void 0 == e.data("enddeg") ? 360 : e.data("enddeg"),
            r = void 0 == e.data("speed") ? 2 : e.data("speed"),
            n = void 0 == e.data("origin") ? "50% 50%" : e.data("origin"),
            s =
              void 0 == e.data("easing")
                ? punchgs.Power2.easeInOut
                : e.data("easing");
          (i *= t),
            (o *= t),
            a._loop_timeline.append(
              new punchgs.TweenLite.fromTo(
                e,
                r,
                { force3D: "auto", rotation: i, transformOrigin: n },
                {
                  rotation: o,
                  ease: s,
                  onComplete: function () {
                    a._loop_timeline.restart();
                  },
                }
              )
            );
        }
        if (e.hasClass("rs-slideloop") && void 0 == a._loop_timeline) {
          a._loop_timeline = new punchgs.TimelineLite();
          var d = void 0 == e.data("xs") ? 0 : e.data("xs"),
            l = void 0 == e.data("ys") ? 0 : e.data("ys"),
            p = void 0 == e.data("xe") ? 0 : e.data("xe"),
            c = void 0 == e.data("ye") ? 0 : e.data("ye"),
            r = void 0 == e.data("speed") ? 2 : e.data("speed"),
            s =
              void 0 == e.data("easing")
                ? punchgs.Power2.easeInOut
                : e.data("easing");
          (d *= t),
            (l *= t),
            (p *= t),
            (c *= t),
            a._loop_timeline.append(
              new punchgs.TweenLite.fromTo(
                e,
                r,
                { force3D: "auto", x: d, y: l },
                { x: p, y: c, ease: s }
              )
            ),
            a._loop_timeline.append(
              new punchgs.TweenLite.fromTo(
                e,
                r,
                { force3D: "auto", x: p, y: c },
                {
                  x: d,
                  y: l,
                  onComplete: function () {
                    a._loop_timeline.restart();
                  },
                }
              )
            );
        }
        if (e.hasClass("rs-pulse") && void 0 == a._loop_timeline) {
          a._loop_timeline = new punchgs.TimelineLite();
          var u = void 0 == e.data("zoomstart") ? 0 : e.data("zoomstart"),
            h = void 0 == e.data("zoomend") ? 0 : e.data("zoomend"),
            r = void 0 == e.data("speed") ? 2 : e.data("speed"),
            s =
              void 0 == e.data("easing")
                ? punchgs.Power2.easeInOut
                : e.data("easing");
          a._loop_timeline.append(
            new punchgs.TweenLite.fromTo(
              e,
              r,
              { force3D: "auto", scale: u },
              { scale: h, ease: s }
            )
          ),
            a._loop_timeline.append(
              new punchgs.TweenLite.fromTo(
                e,
                r,
                { force3D: "auto", scale: h },
                {
                  scale: u,
                  onComplete: function () {
                    a._loop_timeline.restart();
                  },
                }
              )
            );
        }
        if (e.hasClass("rs-wave") && void 0 == a._loop_timeline) {
          a._loop_timeline = new punchgs.TimelineLite();
          var f = void 0 == e.data("angle") ? 10 : parseInt(e.data("angle"), 0),
            g = void 0 == e.data("radius") ? 10 : parseInt(e.data("radius"), 0),
            r = void 0 == e.data("speed") ? -20 : e.data("speed"),
            n = void 0 == e.data("origin") ? "50% 50%" : e.data("origin"),
            m = n.split(" "),
            v = new Object();
          m.length >= 1
            ? ((v.x = m[0]), (v.y = m[1]))
            : ((v.x = "50%"), (v.y = "50%")),
            (g *= t);
          var w = (parseInt(v.x, 0) / 100 - 0.5) * e.width(),
            b = (parseInt(v.y, 0) / 100 - 0.5) * e.height(),
            y = -1 * g + b,
            _ = 0 + w,
            x = { a: 0, ang: f, element: e, unit: g, xoffset: _, yoffset: y },
            T = parseInt(f, 0),
            L = new punchgs.TweenLite.fromTo(
              x,
              r,
              { a: 0 + T },
              { a: 360 + T, force3D: "auto", ease: punchgs.Linear.easeNone }
            );
          L.eventCallback(
            "onUpdate",
            function (e) {
              var t = e.a * (Math.PI / 180),
                a = e.yoffset + e.unit * (1 - Math.sin(t)),
                i = e.xoffset + Math.cos(t) * e.unit;
              punchgs.TweenLite.to(e.element, 0.1, {
                force3D: "auto",
                x: i,
                y: a,
              });
            },
            [x]
          ),
            L.eventCallback(
              "onComplete",
              function (e) {
                e._loop_timeline.restart();
              },
              [a]
            ),
            a._loop_timeline.append(L);
        }
      },
      x = function (e) {
        e.closest(".rs-pendulum, .rs-slideloop, .rs-pulse, .rs-wave").each(
          function () {
            var e = this;
            void 0 != e._loop_timeline &&
              (e._loop_timeline.pause(), (e._loop_timeline = null));
          }
        );
      };
  })(jQuery),
  (function (e) {
    var t = jQuery.fn.revolution;
    jQuery.extend(!0, t, {
      migration: function (e, t) {
        return (t = a(t)), i(e, t), t;
      },
    });
    var a = function (e) {
        if (e.parallaxLevels || e.parallaxBgFreeze) {
          var t = new Object();
          (t.type = e.parallax),
            (t.levels = e.parallaxLevels),
            (t.bgparallax = "on" == e.parallaxBgFreeze ? "off" : "on"),
            (t.disable_onmobile = e.parallaxDisableOnMobile),
            (e.parallax = t);
        }
        if (
          (void 0 === e.disableProgressBar &&
            (e.disableProgressBar = e.hideTimerBar || "off"),
          (e.startwidth || e.startheight) &&
            ((e.gridwidth = e.startwidth), (e.gridheight = e.startheight)),
          void 0 === e.sliderType && (e.sliderType = "standard"),
          "on" === e.fullScreen && (e.sliderLayout = "fullscreen"),
          "on" === e.fullWidth && (e.sliderLayout = "fullwidth"),
          void 0 === e.sliderLayout && (e.sliderLayout = "auto"),
          void 0 === e.navigation)
        ) {
          var a = new Object();
          if ("solo" == e.navigationArrows || "nextto" == e.navigationArrows) {
            var i = new Object();
            (i.enable = !0),
              (i.style = e.navigationStyle || ""),
              (i.hide_onmobile = "on" === e.hideArrowsOnMobile),
              (i.hide_onleave = e.hideThumbs > 0),
              (i.hide_delay = e.hideThumbs > 0 ? e.hideThumbs : 200),
              (i.hide_delay_mobile = e.hideNavDelayOnMobile || 1500),
              (i.hide_under = 0),
              (i.tmp = ""),
              (i.left = {
                h_align: e.soloArrowLeftHalign,
                v_align: e.soloArrowLeftValign,
                h_offset: e.soloArrowLeftHOffset,
                v_offset: e.soloArrowLeftVOffset,
              }),
              (i.right = {
                h_align: e.soloArrowRightHalign,
                v_align: e.soloArrowRightValign,
                h_offset: e.soloArrowRightHOffset,
                v_offset: e.soloArrowRightVOffset,
              }),
              (a.arrows = i);
          }
          if ("bullet" == e.navigationType) {
            var o = new Object();
            (o.style = e.navigationStyle || ""),
              (o.enable = !0),
              (o.hide_onmobile = "on" === e.hideArrowsOnMobile),
              (o.hide_onleave = e.hideThumbs > 0),
              (o.hide_delay = e.hideThumbs > 0 ? e.hideThumbs : 200),
              (o.hide_delay_mobile = e.hideNavDelayOnMobile || 1500),
              (o.hide_under = 0),
              (o.direction = "horizontal"),
              (o.h_align = e.navigationHAlign || "center"),
              (o.v_align = e.navigationVAlign || "bottom"),
              (o.space = 5),
              (o.h_offset = e.navigationHOffset || 0),
              (o.v_offset = e.navigationVOffset || 20),
              (o.tmp =
                '<span class="tp-bullet-image"></span><span class="tp-bullet-title"></span>'),
              (a.bullets = o);
          }
          if ("thumb" == e.navigationType) {
            var r = new Object();
            (r.style = e.navigationStyle || ""),
              (r.enable = !0),
              (r.width = e.thumbWidth || 100),
              (r.height = e.thumbHeight || 50),
              (r.min_width = e.thumbWidth || 100),
              (r.wrapper_padding = 2),
              (r.wrapper_color = "#f5f5f5"),
              (r.wrapper_opacity = 1),
              (r.visibleAmount = e.thumbAmount || 3),
              (r.hide_onmobile = "on" === e.hideArrowsOnMobile),
              (r.hide_onleave = e.hideThumbs > 0),
              (r.hide_delay = e.hideThumbs > 0 ? e.hideThumbs : 200),
              (r.hide_delay_mobile = e.hideNavDelayOnMobile || 1500),
              (r.hide_under = 0),
              (r.direction = "horizontal"),
              (r.span = !1),
              (r.position = "inner"),
              (r.space = 2),
              (r.h_align = e.navigationHAlign || "center"),
              (r.v_align = e.navigationVAlign || "bottom"),
              (r.h_offset = e.navigationHOffset || 0),
              (r.v_offset = e.navigationVOffset || 20),
              (r.tmp =
                '<span class="tp-thumb-image"></span><span class="tp-thumb-title"></span>'),
              (a.thumbnails = r);
          }
          (e.navigation = a),
            (e.navigation.keyboardNavigation = e.keyboardNavigation || "on"),
            (e.navigation.onHoverStop = e.onHoverStop || "on"),
            (e.navigation.touch = {
              touchenabled: e.touchenabled || "on",
              swipe_treshold: e.swipe_treshold || 75,
              swipe_min_touches: e.swipe_min_touches || 1,
              drag_block_vertical: e.drag_block_vertical || !1,
            });
        }
        return (
          void 0 == e.fallbacks &&
            (e.fallbacks = {
              isJoomla: e.isJoomla || !1,
              panZoomDisableOnMobile: e.parallaxDisableOnMobile || "off",
              simplifyAll: e.simplifyAll || "on",
              nextSlideOnWindowFocus: e.nextSlideOnWindowFocus || "off",
              disableFocusListener: e.disableFocusListener || !0,
            }),
          e
        );
      },
      i = function (e, t) {
        var a = new Object();
        e.width(), e.height();
        (a.skewfromleftshort = "x:-50;skX:85;o:0"),
          (a.skewfromrightshort = "x:50;skX:-85;o:0"),
          (a.sfl = "x:-50;o:0"),
          (a.sfr = "x:50;o:0"),
          (a.sft = "y:-50;o:0"),
          (a.sfb = "y:50;o:0"),
          (a.skewfromleft = "x:top;skX:85;o:0"),
          (a.skewfromright = "x:bottom;skX:-85;o:0"),
          (a.lfl = "x:top;o:0"),
          (a.lfr = "x:bottom;o:0"),
          (a.lft = "y:left;o:0"),
          (a.lfb = "y:right;o:0"),
          (a.fade = "o:0"),
          Math.random(),
          e.find(".tp-caption").each(function () {
            var e = jQuery(this),
              t =
                (Math.random(),
                Math.random(),
                Math.random(),
                Math.random(),
                Math.random(),
                Math.random(),
                e.attr("class"));
            (a.randomrotate =
              "x:{-400,400};y:{-400,400};sX:{0,2};sY:{0,2};rZ:{-180,180};rX:{-180,180};rY:{-180,180};o:0;"),
              t.match("randomrotate")
                ? e.data("transform_in", a.randomrotate)
                : t.match(/\blfl\b/)
                ? e.data("transform_in", a.lfl)
                : t.match(/\blfr\b/)
                ? e.data("transform_in", a.lfr)
                : t.match(/\blft\b/)
                ? e.data("transform_in", a.lft)
                : t.match(/\blfb\b/)
                ? e.data("transform_in", a.lfb)
                : t.match(/\bsfl\b/)
                ? e.data("transform_in", a.sfl)
                : t.match(/\bsfr\b/)
                ? e.data("transform_in", a.sfr)
                : t.match(/\bsft\b/)
                ? e.data("transform_in", a.sft)
                : t.match(/\bsfb\b/)
                ? e.data("transform_in", a.sfb)
                : t.match(/\bskewfromleftshort\b/)
                ? e.data("transform_in", a.skewfromleftshort)
                : t.match(/\bskewfromrightshort\b/)
                ? e.data("transform_in", a.skewfromrightshort)
                : t.match(/\bskewfromleft\b/)
                ? e.data("transform_in", a.skewfromleft)
                : t.match(/\bskewfromright\b/)
                ? e.data("transform_in", a.skewfromright)
                : t.match(/\bfade\b/) && e.data("transform_in", a.fade),
              t.match(/\brandomrotateout\b/)
                ? e.data("transform_out", a.randomrotate)
                : t.match(/\bltl\b/)
                ? e.data("transform_out", a.lfl)
                : t.match(/\bltr\b/)
                ? e.data("transform_out", a.lfr)
                : t.match(/\bltt\b/)
                ? e.data("transform_out", a.lft)
                : t.match(/\bltb\b/)
                ? e.data("transform_out", a.lfb)
                : t.match(/\bstl\b/)
                ? e.data("transform_out", a.sfl)
                : t.match(/\bstr\b/)
                ? e.data("transform_out", a.sfr)
                : t.match(/\bstt\b/)
                ? e.data("transform_out", a.sft)
                : t.match(/\bstb\b/)
                ? e.data("transform_out", a.sfb)
                : t.match(/\bskewtoleftshortout\b/)
                ? e.data("transform_out", a.skewfromleftshort)
                : t.match(/\bskewtorightshortout\b/)
                ? e.data("transform_out", a.skewfromrightshort)
                : t.match(/\bskewtoleftout\b/)
                ? e.data("transform_out", a.skewfromleft)
                : t.match(/\bskewtorightout\b/)
                ? e.data("transform_out", a.skewfromright)
                : t.match(/\bfadeout\b/) && e.data("transform_out", a.fade),
              void 0 != e.data("customin") &&
                e.data("transform_in", e.data("customin")),
              void 0 != e.data("customout") &&
                e.data("transform_out", e.data("customout"));
          });
      };
  })(jQuery),
  (function (e) {
    "use strict";
    var t = jQuery.fn.revolution,
      a = t.is_mobile(),
      i = {
        alias: "Navigation Min JS",
        name: "revolution.extensions.navigation.min.js",
        min_core: "5.3",
        version: "1.3.1",
      };
    jQuery.extend(!0, t, {
      hideUnHideNav: function (e) {
        var t = e.c.width(),
          a = e.navigation.arrows,
          i = e.navigation.bullets,
          o = e.navigation.thumbnails,
          r = e.navigation.tabs;
        u(a) && L(e.c.find(".tparrows"), a.hide_under, t, a.hide_over),
          u(i) && L(e.c.find(".tp-bullets"), i.hide_under, t, i.hide_over),
          u(o) &&
            L(e.c.parent().find(".tp-thumbs"), o.hide_under, t, o.hide_over),
          u(r) &&
            L(e.c.parent().find(".tp-tabs"), r.hide_under, t, r.hide_over),
          T(e);
      },
      resizeThumbsTabs: function (e, t) {
        if (
          (e.navigation && e.navigation.tabs.enable) ||
          (e.navigation && e.navigation.thumbnails.enable)
        ) {
          var a = (jQuery(window).width() - 480) / 500,
            i = new punchgs.TimelineLite(),
            o = e.navigation.tabs,
            n = e.navigation.thumbnails,
            s = e.navigation.bullets;
          if (
            (i.pause(),
            (a = a > 1 ? 1 : a < 0 ? 0 : a),
            u(o) &&
              (t || o.width > o.min_width) &&
              r(a, i, e.c, o, e.slideamount, "tab"),
            u(n) &&
              (t || n.width > n.min_width) &&
              r(a, i, e.c, n, e.slideamount, "thumb"),
            u(s) && t)
          ) {
            var d = e.c.find(".tp-bullets");
            d.find(".tp-bullet").each(function (e) {
              var t = jQuery(this),
                a = e + 1,
                i =
                  t.outerWidth() +
                  parseInt(void 0 === s.space ? 0 : s.space, 0),
                o =
                  t.outerHeight() +
                  parseInt(void 0 === s.space ? 0 : s.space, 0);
              "vertical" === s.direction
                ? (t.css({ top: (a - 1) * o + "px", left: "0px" }),
                  d.css({
                    height: (a - 1) * o + t.outerHeight(),
                    width: t.outerWidth(),
                  }))
                : (t.css({ left: (a - 1) * i + "px", top: "0px" }),
                  d.css({
                    width: (a - 1) * i + t.outerWidth(),
                    height: t.outerHeight(),
                  }));
            });
          }
          i.play(), T(e);
        }
        return !0;
      },
      updateNavIndexes: function (e) {
        function a(e) {
          i.find(e).lenght > 0 &&
            i.find(e).each(function (e) {
              jQuery(this).data("liindex", e);
            });
        }
        var i = e.c;
        a(".tp-tab"),
          a(".tp-bullet"),
          a(".tp-thumb"),
          t.resizeThumbsTabs(e, !0),
          t.manageNavigation(e);
      },
      manageNavigation: function (e) {
        var a = t.getHorizontalOffset(e.c.parent(), "left"),
          i = t.getHorizontalOffset(e.c.parent(), "right");
        u(e.navigation.bullets) &&
          ("fullscreen" != e.sliderLayout &&
            "fullwidth" != e.sliderLayout &&
            ((e.navigation.bullets.h_offset_old =
              void 0 === e.navigation.bullets.h_offset_old
                ? e.navigation.bullets.h_offset
                : e.navigation.bullets.h_offset_old),
            (e.navigation.bullets.h_offset =
              "center" === e.navigation.bullets.h_align
                ? e.navigation.bullets.h_offset_old + a / 2 - i / 2
                : e.navigation.bullets.h_offset_old + a - i)),
          b(e.c.find(".tp-bullets"), e.navigation.bullets, e)),
          u(e.navigation.thumbnails) &&
            b(e.c.parent().find(".tp-thumbs"), e.navigation.thumbnails, e),
          u(e.navigation.tabs) &&
            b(e.c.parent().find(".tp-tabs"), e.navigation.tabs, e),
          u(e.navigation.arrows) &&
            ("fullscreen" != e.sliderLayout &&
              "fullwidth" != e.sliderLayout &&
              ((e.navigation.arrows.left.h_offset_old =
                void 0 === e.navigation.arrows.left.h_offset_old
                  ? e.navigation.arrows.left.h_offset
                  : e.navigation.arrows.left.h_offset_old),
              (e.navigation.arrows.left.h_offset =
                "right" === e.navigation.arrows.left.h_align
                  ? e.navigation.arrows.left.h_offset_old + i
                  : e.navigation.arrows.left.h_offset_old + a),
              (e.navigation.arrows.right.h_offset_old =
                void 0 === e.navigation.arrows.right.h_offset_old
                  ? e.navigation.arrows.right.h_offset
                  : e.navigation.arrows.right.h_offset_old),
              (e.navigation.arrows.right.h_offset =
                "right" === e.navigation.arrows.right.h_align
                  ? e.navigation.arrows.right.h_offset_old + i
                  : e.navigation.arrows.right.h_offset_old + a)),
            b(e.c.find(".tp-leftarrow.tparrows"), e.navigation.arrows.left, e),
            b(
              e.c.find(".tp-rightarrow.tparrows"),
              e.navigation.arrows.right,
              e
            )),
          u(e.navigation.thumbnails) &&
            o(e.c.parent().find(".tp-thumbs"), e.navigation.thumbnails),
          u(e.navigation.tabs) &&
            o(e.c.parent().find(".tp-tabs"), e.navigation.tabs);
      },
      createNavigation: function (e, r) {
        if ("stop" === t.compare_version(i).check) return !1;
        var n = e.parent(),
          l = r.navigation.arrows,
          h = r.navigation.bullets,
          v = r.navigation.thumbnails,
          w = r.navigation.tabs,
          b = u(l),
          _ = u(h),
          T = u(v),
          L = u(w);
        s(e, r),
          d(e, r),
          b && m(e, l, r),
          r.li.each(function (t) {
            var a = jQuery(r.li[r.li.length - 1 - t]),
              i = jQuery(this);
            _ && (r.navigation.bullets.rtl ? y(e, h, a, r) : y(e, h, i, r)),
              T &&
                (r.navigation.thumbnails.rtl
                  ? x(e, v, a, "tp-thumb", r)
                  : x(e, v, i, "tp-thumb", r)),
              L &&
                (r.navigation.tabs.rtl
                  ? x(e, w, a, "tp-tab", r)
                  : x(e, w, i, "tp-tab", r));
          }),
          e.bind(
            "revolution.slide.onafterswap revolution.nextslide.waiting",
            function () {
              var t =
                0 == e.find(".next-revslide").length
                  ? e.find(".active-revslide").data("index")
                  : e.find(".next-revslide").data("index");
              e.find(".tp-bullet").each(function () {
                var e = jQuery(this);
                e.data("liref") === t
                  ? e.addClass("selected")
                  : e.removeClass("selected");
              }),
                n.find(".tp-thumb, .tp-tab").each(function () {
                  var e = jQuery(this);
                  e.data("liref") === t
                    ? (e.addClass("selected"),
                      e.hasClass("tp-tab")
                        ? o(n.find(".tp-tabs"), w)
                        : o(n.find(".tp-thumbs"), v))
                    : e.removeClass("selected");
                });
              var a = 0,
                i = !1;
              r.thumbs &&
                jQuery.each(r.thumbs, function (e, o) {
                  (a = !1 === i ? e : a), (i = o.id === t || e === t || i);
                });
              var s = a > 0 ? a - 1 : r.slideamount - 1,
                d = a + 1 == r.slideamount ? 0 : a + 1;
              if (!0 === l.enable) {
                var p = l.tmp;
                if (
                  (void 0 != r.thumbs[s] &&
                    jQuery.each(r.thumbs[s].params, function (e, t) {
                      p = p.replace(t.from, t.to);
                    }),
                  l.left.j.html(p),
                  (p = l.tmp),
                  d > r.slideamount)
                )
                  return;
                jQuery.each(r.thumbs[d].params, function (e, t) {
                  p = p.replace(t.from, t.to);
                }),
                  l.right.j.html(p),
                  punchgs.TweenLite.set(l.left.j.find(".tp-arr-imgholder"), {
                    backgroundImage: "url(" + r.thumbs[s].src + ")",
                  }),
                  punchgs.TweenLite.set(l.right.j.find(".tp-arr-imgholder"), {
                    backgroundImage: "url(" + r.thumbs[d].src + ")",
                  });
              }
            }
          ),
          c(l),
          c(h),
          c(v),
          c(w),
          n.on("mouseenter mousemove", function () {
            n.hasClass("tp-mouseover") ||
              (n.addClass("tp-mouseover"),
              punchgs.TweenLite.killDelayedCallsTo(g),
              b && l.hide_onleave && g(n.find(".tparrows"), l, "show"),
              _ && h.hide_onleave && g(n.find(".tp-bullets"), h, "show"),
              T && v.hide_onleave && g(n.find(".tp-thumbs"), v, "show"),
              L && w.hide_onleave && g(n.find(".tp-tabs"), w, "show"),
              a && (n.removeClass("tp-mouseover"), f(e, r)));
          }),
          n.on("mouseleave", function () {
            n.removeClass("tp-mouseover"), f(e, r);
          }),
          b && l.hide_onleave && g(n.find(".tparrows"), l, "hide", 0),
          _ && h.hide_onleave && g(n.find(".tp-bullets"), h, "hide", 0),
          T && v.hide_onleave && g(n.find(".tp-thumbs"), v, "hide", 0),
          L && w.hide_onleave && g(n.find(".tp-tabs"), w, "hide", 0),
          T && p(n.find(".tp-thumbs"), r),
          L && p(n.find(".tp-tabs"), r),
          "carousel" === r.sliderType && p(e, r, !0),
          "on" == r.navigation.touch.touchenabled && p(e, r, "swipebased");
      },
    });
    var o = function (e, t) {
        var a =
            (e.hasClass("tp-thumbs"),
            e.hasClass("tp-thumbs") ? ".tp-thumb-mask" : ".tp-tab-mask"),
          i = e.hasClass("tp-thumbs")
            ? ".tp-thumbs-inner-wrapper"
            : ".tp-tabs-inner-wrapper",
          o = e.hasClass("tp-thumbs") ? ".tp-thumb" : ".tp-tab",
          r = e.find(a),
          n = r.find(i),
          s = t.direction,
          d =
            "vertical" === s
              ? r.find(o).first().outerHeight(!0) + t.space
              : r.find(o).first().outerWidth(!0) + t.space,
          l = "vertical" === s ? r.height() : r.width(),
          p = parseInt(r.find(o + ".selected").data("liindex"), 0),
          c = l / d,
          u = "vertical" === s ? r.height() : r.width(),
          h = 0 - p * d,
          f = "vertical" === s ? n.height() : n.width(),
          g = h < 0 - (f - u) ? 0 - (f - u) : g > 0 ? 0 : h,
          m = n.data("offset");
        c > 2 &&
          ((g = h - (m + d) <= 0 ? (h - (m + d) < 0 - d ? m : g + d) : g),
          (g =
            h - d + m + l < d && h + (Math.round(c) - 2) * d < m
              ? h + (Math.round(c) - 2) * d
              : g)),
          (g = g < 0 - (f - u) ? 0 - (f - u) : g > 0 ? 0 : g),
          "vertical" !== s && r.width() >= n.width() && (g = 0),
          "vertical" === s && r.height() >= n.height() && (g = 0),
          e.hasClass("dragged") ||
            ("vertical" === s
              ? n.data(
                  "tmmove",
                  punchgs.TweenLite.to(n, 0.5, {
                    top: g + "px",
                    ease: punchgs.Power3.easeInOut,
                  })
                )
              : n.data(
                  "tmmove",
                  punchgs.TweenLite.to(n, 0.5, {
                    left: g + "px",
                    ease: punchgs.Power3.easeInOut,
                  })
                ),
            n.data("offset", g));
      },
      r = function (e, t, a, i, o, r) {
        var n = a.parent().find(".tp-" + r + "s"),
          s = n.find(".tp-" + r + "s-inner-wrapper"),
          d = n.find(".tp-" + r + "-mask"),
          l = i.width * e < i.min_width ? i.min_width : Math.round(i.width * e),
          p = Math.round((l / i.width) * i.height),
          c = "vertical" === i.direction ? l : l * o + i.space * (o - 1),
          u = "vertical" === i.direction ? p * o + i.space * (o - 1) : p,
          h =
            "vertical" === i.direction
              ? { width: l + "px" }
              : { height: p + "px" };
        t.add(punchgs.TweenLite.set(n, h)),
          t.add(
            punchgs.TweenLite.set(s, { width: c + "px", height: u + "px" })
          ),
          t.add(
            punchgs.TweenLite.set(d, { width: c + "px", height: u + "px" })
          );
        var f = s.find(".tp-" + r);
        return (
          f &&
            jQuery.each(f, function (e, a) {
              "vertical" === i.direction
                ? t.add(
                    punchgs.TweenLite.set(a, {
                      top:
                        e * (p + parseInt(void 0 === i.space ? 0 : i.space, 0)),
                      width: l + "px",
                      height: p + "px",
                    })
                  )
                : "horizontal" === i.direction &&
                  t.add(
                    punchgs.TweenLite.set(a, {
                      left:
                        e * (l + parseInt(void 0 === i.space ? 0 : i.space, 0)),
                      width: l + "px",
                      height: p + "px",
                    })
                  );
            }),
          t
        );
      },
      n = function (e) {
        var t = 0,
          a = 0,
          i = 0,
          o = 0;
        return (
          "detail" in e && (a = e.detail),
          "wheelDelta" in e && (a = -e.wheelDelta / 120),
          "wheelDeltaY" in e && (a = -e.wheelDeltaY / 120),
          "wheelDeltaX" in e && (t = -e.wheelDeltaX / 120),
          "axis" in e && e.axis === e.HORIZONTAL_AXIS && ((t = a), (a = 0)),
          (i = 1 * t),
          (o = 1 * a),
          "deltaY" in e && (o = e.deltaY),
          "deltaX" in e && (i = e.deltaX),
          (i || o) && e.deltaMode && (e.deltaMode, (i *= 1), (o *= 1)),
          i && !t && (t = i < 1 ? -1 : 1),
          o && !a && (a = o < 1 ? -1 : 1),
          (o = navigator.userAgent.match(/mozilla/i) ? 10 * o : o),
          (o > 300 || o < -300) && (o /= 10),
          { spinX: t, spinY: a, pixelX: i, pixelY: o }
        );
      },
      s = function (e, a) {
        "on" === a.navigation.keyboardNavigation &&
          jQuery(document).keydown(function (i) {
            (("horizontal" == a.navigation.keyboard_direction &&
              39 == i.keyCode) ||
              ("vertical" == a.navigation.keyboard_direction &&
                40 == i.keyCode)) &&
              ((a.sc_indicator = "arrow"),
              (a.sc_indicator_dir = 0),
              t.callingNewSlide(e, 1)),
              (("horizontal" == a.navigation.keyboard_direction &&
                37 == i.keyCode) ||
                ("vertical" == a.navigation.keyboard_direction &&
                  38 == i.keyCode)) &&
                ((a.sc_indicator = "arrow"),
                (a.sc_indicator_dir = 1),
                t.callingNewSlide(e, -1));
          });
      },
      d = function (e, a) {
        if (
          "on" === a.navigation.mouseScrollNavigation ||
          "carousel" === a.navigation.mouseScrollNavigation
        ) {
          (a.isIEEleven = !!navigator.userAgent.match(/Trident.*rv\:11\./)),
            (a.isSafari = !!navigator.userAgent.match(/safari/i)),
            (a.ischrome = !!navigator.userAgent.match(/chrome/i));
          var i = a.ischrome
              ? -49
              : a.isIEEleven || a.isSafari
              ? -9
              : navigator.userAgent.match(/mozilla/i)
              ? -29
              : -49,
            o = a.ischrome
              ? 49
              : a.isIEEleven || a.isSafari
              ? 9
              : navigator.userAgent.match(/mozilla/i)
              ? 29
              : 49;
          e.on("mousewheel DOMMouseScroll", function (r) {
            var s = n(r.originalEvent),
              d = e.find(".tp-revslider-slidesli.active-revslide").index(),
              l = e.find(".tp-revslider-slidesli.processing-revslide").index(),
              p = (-1 != d && 0 == d) || (-1 != l && 0 == l),
              c =
                (-1 != d && d == a.slideamount - 1) ||
                (1 != l && l == a.slideamount - 1),
              u = !0;
            "carousel" == a.navigation.mouseScrollNavigation && (p = c = !1),
              -1 == l
                ? s.pixelY < i
                  ? (p ||
                      ((a.sc_indicator = "arrow"),
                      "reverse" !== a.navigation.mouseScrollReverse &&
                        ((a.sc_indicator_dir = 1), t.callingNewSlide(e, -1)),
                      (u = !1)),
                    c ||
                      ((a.sc_indicator = "arrow"),
                      "reverse" === a.navigation.mouseScrollReverse &&
                        ((a.sc_indicator_dir = 0), t.callingNewSlide(e, 1)),
                      (u = !1)))
                  : s.pixelY > o &&
                    (c ||
                      ((a.sc_indicator = "arrow"),
                      "reverse" !== a.navigation.mouseScrollReverse &&
                        ((a.sc_indicator_dir = 0), t.callingNewSlide(e, 1)),
                      (u = !1)),
                    p ||
                      ((a.sc_indicator = "arrow"),
                      "reverse" === a.navigation.mouseScrollReverse &&
                        ((a.sc_indicator_dir = 1), t.callingNewSlide(e, -1)),
                      (u = !1)))
                : (u = !1);
            var h = a.c.offset().top - jQuery("body").scrollTop(),
              f = h + a.c.height();
            return (
              "carousel" != a.navigation.mouseScrollNavigation
                ? ("reverse" !== a.navigation.mouseScrollReverse &&
                    ((h > 0 && s.pixelY > 0) ||
                      (f < jQuery(window).height() && s.pixelY < 0)) &&
                    (u = !0),
                  "reverse" === a.navigation.mouseScrollReverse &&
                    ((h < 0 && s.pixelY < 0) ||
                      (f > jQuery(window).height() && s.pixelY > 0)) &&
                    (u = !0))
                : (u = !1),
              0 == u ? (r.preventDefault(r), !1) : void 0
            );
          });
        }
      },
      l = function (e, t, i) {
        return (
          (e = a
            ? jQuery(i.target).closest("." + e).length ||
              jQuery(i.srcElement).closest("." + e).length
            : jQuery(i.toElement).closest("." + e).length ||
              jQuery(i.originalTarget).closest("." + e).length),
          !0 === e || 1 === e ? 1 : 0
        );
      },
      p = function (e, i, o) {
        var r = i.carousel;
        jQuery(".bullet, .bullets, .tp-bullets, .tparrows").addClass("noSwipe"),
          (r.Limit = "endless");
        var n = (a || t.get_browser(), e),
          s =
            "vertical" === i.navigation.thumbnails.direction ||
            "vertical" === i.navigation.tabs.direction
              ? "none"
              : "vertical",
          d = i.navigation.touch.swipe_direction || "horizontal";
        (s =
          "swipebased" == o && "vertical" == d ? "none" : o ? "vertical" : s),
          jQuery.fn.swipetp || (jQuery.fn.swipetp = jQuery.fn.swipe),
          (jQuery.fn.swipetp.defaults &&
            jQuery.fn.swipetp.defaults.excludedElements) ||
            jQuery.fn.swipetp.defaults ||
            (jQuery.fn.swipetp.defaults = new Object()),
          (jQuery.fn.swipetp.defaults.excludedElements =
            "label, button, input, select, textarea, .noSwipe"),
          n.swipetp({
            allowPageScroll: s,
            triggerOnTouchLeave: !0,
            treshold: i.navigation.touch.swipe_treshold,
            fingers: i.navigation.touch.swipe_min_touches,
            excludeElements: jQuery.fn.swipetp.defaults.excludedElements,
            swipeStatus: function (a, o, n, s, p, c, u) {
              var h = l("rev_slider_wrapper", 0, a),
                f = l("tp-thumbs", 0, a),
                g = l("tp-tabs", 0, a),
                m = jQuery(this).attr("class"),
                v = !!m.match(/tp-tabs|tp-thumb/gi);
              if (
                "carousel" === i.sliderType &&
                ((("move" === o || "end" === o || "cancel" == o) &&
                  i.dragStartedOverSlider &&
                  !i.dragStartedOverThumbs &&
                  !i.dragStartedOverTabs) ||
                  ("start" === o && h > 0 && 0 === f && 0 === g))
              )
                switch (
                  ((i.dragStartedOverSlider = !0),
                  (s =
                    n && n.match(/left|up/g)
                      ? Math.round(-1 * s)
                      : (s = Math.round(1 * s))),
                  o)
                ) {
                  case "start":
                    void 0 !== r.positionanim &&
                      (r.positionanim.kill(),
                      (r.slide_globaloffset =
                        "off" === r.infinity
                          ? r.slide_offset
                          : t.simp(r.slide_offset, r.maxwidth))),
                      (r.overpull = "none"),
                      r.wrap.addClass("dragged");
                    break;
                  case "move":
                    if (
                      ((r.slide_offset =
                        "off" === r.infinity
                          ? r.slide_globaloffset + s
                          : t.simp(r.slide_globaloffset + s, r.maxwidth)),
                      "off" === r.infinity)
                    ) {
                      var w =
                        "center" === r.horizontal_align
                          ? (r.wrapwidth / 2 -
                              r.slide_width / 2 -
                              r.slide_offset) /
                            r.slide_width
                          : (0 - r.slide_offset) / r.slide_width;
                      ("none" !== r.overpull && 0 !== r.overpull) ||
                      !(w < 0 || w > i.slideamount - 1)
                        ? w >= 0 &&
                          w <= i.slideamount - 1 &&
                          ((w >= 0 && s > r.overpull) ||
                            (w <= i.slideamount - 1 && s < r.overpull)) &&
                          (r.overpull = 0)
                        : (r.overpull = s),
                        (r.slide_offset =
                          w < 0
                            ? r.slide_offset +
                              (r.overpull - s) / 1.1 +
                              Math.sqrt(Math.abs((r.overpull - s) / 1.1))
                            : w > i.slideamount - 1
                            ? r.slide_offset +
                              (r.overpull - s) / 1.1 -
                              Math.sqrt(Math.abs((r.overpull - s) / 1.1))
                            : r.slide_offset);
                    }
                    t.organiseCarousel(i, n, !0, !0);
                    break;
                  case "end":
                  case "cancel":
                    (r.slide_globaloffset = r.slide_offset),
                      r.wrap.removeClass("dragged"),
                      t.carouselToEvalPosition(i, n),
                      (i.dragStartedOverSlider = !1),
                      (i.dragStartedOverThumbs = !1),
                      (i.dragStartedOverTabs = !1);
                }
              else {
                if (
                  (("move" !== o && "end" !== o && "cancel" != o) ||
                    i.dragStartedOverSlider ||
                    (!i.dragStartedOverThumbs && !i.dragStartedOverTabs)) &&
                  !("start" === o && h > 0 && (f > 0 || g > 0))
                ) {
                  if ("end" == o && !v) {
                    if (
                      ((i.sc_indicator = "arrow"),
                      ("horizontal" == d && "left" == n) ||
                        ("vertical" == d && "up" == n))
                    )
                      return (
                        (i.sc_indicator_dir = 0), t.callingNewSlide(i.c, 1), !1
                      );
                    if (
                      ("horizontal" == d && "right" == n) ||
                      ("vertical" == d && "down" == n)
                    )
                      return (
                        (i.sc_indicator_dir = 1), t.callingNewSlide(i.c, -1), !1
                      );
                  }
                  return (
                    (i.dragStartedOverSlider = !1),
                    (i.dragStartedOverThumbs = !1),
                    (i.dragStartedOverTabs = !1),
                    !0
                  );
                }
                f > 0 && (i.dragStartedOverThumbs = !0),
                  g > 0 && (i.dragStartedOverTabs = !0);
                var b = i.dragStartedOverThumbs ? ".tp-thumbs" : ".tp-tabs",
                  y = i.dragStartedOverThumbs
                    ? ".tp-thumb-mask"
                    : ".tp-tab-mask",
                  _ = i.dragStartedOverThumbs
                    ? ".tp-thumbs-inner-wrapper"
                    : ".tp-tabs-inner-wrapper",
                  x = i.dragStartedOverThumbs ? ".tp-thumb" : ".tp-tab",
                  T = i.dragStartedOverThumbs
                    ? i.navigation.thumbnails
                    : i.navigation.tabs;
                s =
                  n && n.match(/left|up/g)
                    ? Math.round(-1 * s)
                    : (s = Math.round(1 * s));
                var L = e.parent().find(y),
                  k = L.find(_),
                  j = T.direction,
                  z = "vertical" === j ? k.height() : k.width(),
                  Q = "vertical" === j ? L.height() : L.width(),
                  I =
                    "vertical" === j
                      ? L.find(x).first().outerHeight(!0) + T.space
                      : L.find(x).first().outerWidth(!0) + T.space,
                  M =
                    void 0 === k.data("offset")
                      ? 0
                      : parseInt(k.data("offset"), 0),
                  O = 0;
                switch (o) {
                  case "start":
                    e.parent().find(b).addClass("dragged"),
                      (M =
                        "vertical" === j
                          ? k.position().top
                          : k.position().left),
                      k.data("offset", M),
                      k.data("tmmove") && k.data("tmmove").pause();
                    break;
                  case "move":
                    if (z <= Q) return !1;
                    (O = M + s),
                      (O =
                        O > 0
                          ? "horizontal" === j
                            ? O -
                              k.width() * (((O / k.width()) * O) / k.width())
                            : O -
                              k.height() * (((O / k.height()) * O) / k.height())
                          : O);
                    var C =
                      "vertical" === j
                        ? 0 - (k.height() - L.height())
                        : 0 - (k.width() - L.width());
                    (O =
                      O < C
                        ? "horizontal" === j
                          ? O +
                            (((k.width() * (O - C)) / k.width()) * (O - C)) /
                              k.width()
                          : O +
                            (((k.height() * (O - C)) / k.height()) * (O - C)) /
                              k.height()
                        : O),
                      "vertical" === j
                        ? punchgs.TweenLite.set(k, { top: O + "px" })
                        : punchgs.TweenLite.set(k, { left: O + "px" });
                    break;
                  case "end":
                  case "cancel":
                    if (v)
                      return (
                        (O = M + s),
                        (O =
                          "vertical" === j
                            ? O < 0 - (k.height() - L.height())
                              ? 0 - (k.height() - L.height())
                              : O
                            : O < 0 - (k.width() - L.width())
                            ? 0 - (k.width() - L.width())
                            : O),
                        (O = O > 0 ? 0 : O),
                        (O =
                          Math.abs(s) > I / 10
                            ? s <= 0
                              ? Math.floor(O / I) * I
                              : Math.ceil(O / I) * I
                            : s < 0
                            ? Math.ceil(O / I) * I
                            : Math.floor(O / I) * I),
                        (O =
                          "vertical" === j
                            ? O < 0 - (k.height() - L.height())
                              ? 0 - (k.height() - L.height())
                              : O
                            : O < 0 - (k.width() - L.width())
                            ? 0 - (k.width() - L.width())
                            : O),
                        (O = O > 0 ? 0 : O),
                        "vertical" === j
                          ? punchgs.TweenLite.to(k, 0.5, {
                              top: O + "px",
                              ease: punchgs.Power3.easeOut,
                            })
                          : punchgs.TweenLite.to(k, 0.5, {
                              left: O + "px",
                              ease: punchgs.Power3.easeOut,
                            }),
                        (O =
                          O ||
                          ("vertical" === j
                            ? k.position().top
                            : k.position().left)),
                        k.data("offset", O),
                        k.data("distance", s),
                        setTimeout(function () {
                          (i.dragStartedOverSlider = !1),
                            (i.dragStartedOverThumbs = !1),
                            (i.dragStartedOverTabs = !1);
                        }, 100),
                        e.parent().find(b).removeClass("dragged"),
                        !1
                      );
                }
              }
            },
          });
      },
      c = function (e) {
        (e.hide_delay = jQuery.isNumeric(parseInt(e.hide_delay, 0))
          ? e.hide_delay / 1e3
          : 0.2),
          (e.hide_delay_mobile = jQuery.isNumeric(
            parseInt(e.hide_delay_mobile, 0)
          )
            ? e.hide_delay_mobile / 1e3
            : 0.2);
      },
      u = function (e) {
        return e && e.enable;
      },
      h = function (e) {
        return (
          e &&
          e.enable &&
          !0 === e.hide_onleave &&
          (void 0 === e.position || !e.position.match(/outer/g))
        );
      },
      f = function (e, t) {
        var i = e.parent();
        h(t.navigation.arrows) &&
          punchgs.TweenLite.delayedCall(
            a
              ? t.navigation.arrows.hide_delay_mobile
              : t.navigation.arrows.hide_delay,
            g,
            [i.find(".tparrows"), t.navigation.arrows, "hide"]
          ),
          h(t.navigation.bullets) &&
            punchgs.TweenLite.delayedCall(
              a
                ? t.navigation.bullets.hide_delay_mobile
                : t.navigation.bullets.hide_delay,
              g,
              [i.find(".tp-bullets"), t.navigation.bullets, "hide"]
            ),
          h(t.navigation.thumbnails) &&
            punchgs.TweenLite.delayedCall(
              a
                ? t.navigation.thumbnails.hide_delay_mobile
                : t.navigation.thumbnails.hide_delay,
              g,
              [i.find(".tp-thumbs"), t.navigation.thumbnails, "hide"]
            ),
          h(t.navigation.tabs) &&
            punchgs.TweenLite.delayedCall(
              a
                ? t.navigation.tabs.hide_delay_mobile
                : t.navigation.tabs.hide_delay,
              g,
              [i.find(".tp-tabs"), t.navigation.tabs, "hide"]
            );
      },
      g = function (e, t, a, i) {
        switch (((i = void 0 === i ? 0.5 : i), a)) {
          case "show":
            punchgs.TweenLite.to(e, i, {
              autoAlpha: 1,
              ease: punchgs.Power3.easeInOut,
              overwrite: "auto",
            });
            break;
          case "hide":
            punchgs.TweenLite.to(e, i, {
              autoAlpha: 0,
              ease: punchgs.Power3.easeInOu,
              overwrite: "auto",
            });
        }
      },
      m = function (e, t, a) {
        (t.style = void 0 === t.style ? "" : t.style),
          (t.left.style = void 0 === t.left.style ? "" : t.left.style),
          (t.right.style = void 0 === t.right.style ? "" : t.right.style),
          0 === e.find(".tp-leftarrow.tparrows").length &&
            e.append(
              '<div class="tp-leftarrow tparrows ' +
                t.style +
                " " +
                t.left.style +
                '">' +
                t.tmp +
                "</div>"
            ),
          0 === e.find(".tp-rightarrow.tparrows").length &&
            e.append(
              '<div class="tp-rightarrow tparrows ' +
                t.style +
                " " +
                t.right.style +
                '">' +
                t.tmp +
                "</div>"
            );
        var i = e.find(".tp-leftarrow.tparrows"),
          o = e.find(".tp-rightarrow.tparrows");
        t.rtl
          ? (i.click(function () {
              (a.sc_indicator = "arrow"), (a.sc_indicator_dir = 0), e.revnext();
            }),
            o.click(function () {
              (a.sc_indicator = "arrow"), (a.sc_indicator_dir = 1), e.revprev();
            }))
          : (o.click(function () {
              (a.sc_indicator = "arrow"), (a.sc_indicator_dir = 0), e.revnext();
            }),
            i.click(function () {
              (a.sc_indicator = "arrow"), (a.sc_indicator_dir = 1), e.revprev();
            })),
          (t.right.j = e.find(".tp-rightarrow.tparrows")),
          (t.left.j = e.find(".tp-leftarrow.tparrows")),
          (t.padding_top = parseInt(a.carousel.padding_top || 0, 0)),
          (t.padding_bottom = parseInt(a.carousel.padding_bottom || 0, 0)),
          b(i, t.left, a),
          b(o, t.right, a),
          (t.left.opt = a),
          (t.right.opt = a),
          ("outer-left" != t.position && "outer-right" != t.position) ||
            (a.outernav = !0);
      },
      v = function (e, t, a) {
        var i = e.outerHeight(!0),
          o =
            (e.outerWidth(!0),
            void 0 == t.opt ? 0 : 0 == a.conh ? a.height : a.conh),
          r =
            "layergrid" == t.container
              ? "fullscreen" == a.sliderLayout
                ? a.height / 2 - (a.gridheight[a.curWinRange] * a.bh) / 2
                : "on" == a.autoHeight ||
                  (void 0 != a.minHeight && a.minHeight > 0)
                ? o / 2 - (a.gridheight[a.curWinRange] * a.bh) / 2
                : 0
              : 0,
          n =
            "top" === t.v_align
              ? { top: "0px", y: Math.round(t.v_offset + r) + "px" }
              : "center" === t.v_align
              ? { top: "50%", y: Math.round(0 - i / 2 + t.v_offset) + "px" }
              : { top: "100%", y: Math.round(0 - (i + t.v_offset + r)) + "px" };
        e.hasClass("outer-bottom") || punchgs.TweenLite.set(e, n);
      },
      w = function (e, t, a) {
        var i = (e.outerHeight(!0), e.outerWidth(!0)),
          o =
            "layergrid" == t.container
              ? "carousel" === a.sliderType
                ? 0
                : a.width / 2 - (a.gridwidth[a.curWinRange] * a.bw) / 2
              : 0,
          r =
            "left" === t.h_align
              ? { left: "0px", x: Math.round(t.h_offset + o) + "px" }
              : "center" === t.h_align
              ? { left: "50%", x: Math.round(0 - i / 2 + t.h_offset) + "px" }
              : {
                  left: "100%",
                  x: Math.round(0 - (i + t.h_offset + o)) + "px",
                };
        punchgs.TweenLite.set(e, r);
      },
      b = function (e, t, a) {
        var i =
            e.closest(".tp-simpleresponsive").length > 0
              ? e.closest(".tp-simpleresponsive")
              : e.closest(".tp-revslider-mainul").length > 0
              ? e.closest(".tp-revslider-mainul")
              : e.closest(".rev_slider_wrapper").length > 0
              ? e.closest(".rev_slider_wrapper")
              : e.parent().find(".tp-revslider-mainul"),
          o = i.width(),
          r = i.height();
        if (
          (v(e, t, a),
          w(e, t, a),
          "outer-left" !== t.position ||
          ("fullwidth" != t.sliderLayout && "fullscreen" != t.sliderLayout)
            ? "outer-right" !== t.position ||
              ("fullwidth" != t.sliderLayout &&
                "fullscreen" != t.sliderLayout) ||
              punchgs.TweenLite.set(e, {
                right: 0 - e.outerWidth() + "px",
                x: t.h_offset + "px",
              })
            : punchgs.TweenLite.set(e, {
                left: 0 - e.outerWidth() + "px",
                x: t.h_offset + "px",
              }),
          e.hasClass("tp-thumbs") || e.hasClass("tp-tabs"))
        ) {
          var n = e.data("wr_padding"),
            s = e.data("maxw"),
            d = e.data("maxh"),
            l = e.hasClass("tp-thumbs")
              ? e.find(".tp-thumb-mask")
              : e.find(".tp-tab-mask"),
            p = parseInt(t.padding_top || 0, 0),
            c = parseInt(t.padding_bottom || 0, 0);
          s > o && "outer-left" !== t.position && "outer-right" !== t.position
            ? (punchgs.TweenLite.set(e, {
                left: "0px",
                x: 0,
                maxWidth: o - 2 * n + "px",
              }),
              punchgs.TweenLite.set(l, { maxWidth: o - 2 * n + "px" }))
            : (punchgs.TweenLite.set(e, { maxWidth: s + "px" }),
              punchgs.TweenLite.set(l, { maxWidth: s + "px" })),
            d + 2 * n > r &&
            "outer-bottom" !== t.position &&
            "outer-top" !== t.position
              ? (punchgs.TweenLite.set(e, {
                  top: "0px",
                  y: 0,
                  maxHeight: p + c + (r - 2 * n) + "px",
                }),
                punchgs.TweenLite.set(l, {
                  maxHeight: p + c + (r - 2 * n) + "px",
                }))
              : (punchgs.TweenLite.set(e, { maxHeight: d + "px" }),
                punchgs.TweenLite.set(l, { maxHeight: d + "px" })),
            "outer-left" !== t.position &&
              "outer-right" !== t.position &&
              ((p = 0), (c = 0)),
            !0 === t.span && "vertical" === t.direction
              ? (punchgs.TweenLite.set(e, {
                  maxHeight: p + c + (r - 2 * n) + "px",
                  height: p + c + (r - 2 * n) + "px",
                  top: 0 - p,
                  y: 0,
                }),
                v(l, t, a))
              : !0 === t.span &&
                "horizontal" === t.direction &&
                (punchgs.TweenLite.set(e, {
                  maxWidth: "100%",
                  width: o - 2 * n + "px",
                  left: 0,
                  x: 0,
                }),
                w(l, t, a));
        }
      },
      y = function (e, t, a, i) {
        0 === e.find(".tp-bullets").length &&
          ((t.style = void 0 === t.style ? "" : t.style),
          e.append(
            '<div class="tp-bullets ' + t.style + " " + t.direction + '"></div>'
          ));
        var o = e.find(".tp-bullets"),
          r = a.data("index"),
          n = t.tmp;
        jQuery.each(i.thumbs[a.index()].params, function (e, t) {
          n = n.replace(t.from, t.to);
        }),
          o.append('<div class="justaddedbullet tp-bullet">' + n + "</div>");
        var s = e.find(".justaddedbullet"),
          d = e.find(".tp-bullet").length,
          l = s.outerWidth() + parseInt(void 0 === t.space ? 0 : t.space, 0),
          p = s.outerHeight() + parseInt(void 0 === t.space ? 0 : t.space, 0);
        "vertical" === t.direction
          ? (s.css({ top: (d - 1) * p + "px", left: "0px" }),
            o.css({
              height: (d - 1) * p + s.outerHeight(),
              width: s.outerWidth(),
            }))
          : (s.css({ left: (d - 1) * l + "px", top: "0px" }),
            o.css({
              width: (d - 1) * l + s.outerWidth(),
              height: s.outerHeight(),
            })),
          s
            .find(".tp-bullet-image")
            .css({ backgroundImage: "url(" + i.thumbs[a.index()].src + ")" }),
          s.data("liref", r),
          s.click(function () {
            (i.sc_indicator = "bullet"),
              e.revcallslidewithid(r),
              e.find(".tp-bullet").removeClass("selected"),
              jQuery(this).addClass("selected");
          }),
          s.removeClass("justaddedbullet"),
          (t.padding_top = parseInt(i.carousel.padding_top || 0, 0)),
          (t.padding_bottom = parseInt(i.carousel.padding_bottom || 0, 0)),
          (t.opt = i),
          ("outer-left" != t.position && "outer-right" != t.position) ||
            (i.outernav = !0),
          o.addClass("nav-pos-hor-" + t.h_align),
          o.addClass("nav-pos-ver-" + t.v_align),
          o.addClass("nav-dir-" + t.direction),
          b(o, t, i);
      },
      _ = function (e, t) {
        return (
          (t = parseFloat(t)),
          (e = e.replace("#", "")),
          "rgba(" +
            parseInt(e.substring(0, 2), 16) +
            "," +
            parseInt(e.substring(2, 4), 16) +
            "," +
            parseInt(e.substring(4, 6), 16) +
            "," +
            t +
            ")"
        );
      },
      x = function (e, t, a, i, o) {
        var r = "tp-thumb" === i ? ".tp-thumbs" : ".tp-tabs",
          n = "tp-thumb" === i ? ".tp-thumb-mask" : ".tp-tab-mask",
          s =
            "tp-thumb" === i
              ? ".tp-thumbs-inner-wrapper"
              : ".tp-tabs-inner-wrapper",
          d = "tp-thumb" === i ? ".tp-thumb" : ".tp-tab",
          l = "tp-thumb" === i ? ".tp-thumb-image" : ".tp-tab-image";
        if (
          ((t.visibleAmount =
            t.visibleAmount > o.slideamount ? o.slideamount : t.visibleAmount),
          (t.sliderLayout = o.sliderLayout),
          0 === e.parent().find(r).length)
        ) {
          t.style = void 0 === t.style ? "" : t.style;
          var p = !0 === t.span ? "tp-span-wrapper" : "",
            c =
              '<div class="' +
              i +
              "s " +
              p +
              " " +
              t.position +
              " " +
              t.style +
              '"><div class="' +
              i +
              '-mask"><div class="' +
              i +
              's-inner-wrapper" style="position:relative;"></div></div></div>';
          "outer-top" === t.position
            ? e.parent().prepend(c)
            : "outer-bottom" === t.position
            ? e.after(c)
            : e.append(c),
            (t.padding_top = parseInt(o.carousel.padding_top || 0, 0)),
            (t.padding_bottom = parseInt(o.carousel.padding_bottom || 0, 0)),
            ("outer-left" != t.position && "outer-right" != t.position) ||
              (o.outernav = !0);
        }
        var u = a.data("index"),
          h = e.parent().find(r),
          f = h.find(n),
          g = f.find(s),
          m =
            "horizontal" === t.direction
              ? t.width * t.visibleAmount + t.space * (t.visibleAmount - 1)
              : t.width,
          v =
            "horizontal" === t.direction
              ? t.height
              : t.height * t.visibleAmount + t.space * (t.visibleAmount - 1),
          w = t.tmp;
        jQuery.each(o.thumbs[a.index()].params, function (e, t) {
          w = w.replace(t.from, t.to);
        }),
          g.append(
            '<div data-liindex="' +
              a.index() +
              '" data-liref="' +
              u +
              '" class="justaddedthumb ' +
              i +
              '" style="width:' +
              t.width +
              "px;height:" +
              t.height +
              'px;">' +
              w +
              "</div>"
          );
        var y = h.find(".justaddedthumb"),
          x = h.find(d).length,
          T = y.outerWidth() + parseInt(void 0 === t.space ? 0 : t.space, 0),
          L = y.outerHeight() + parseInt(void 0 === t.space ? 0 : t.space, 0);
        y
          .find(l)
          .css({ backgroundImage: "url(" + o.thumbs[a.index()].src + ")" }),
          "vertical" === t.direction
            ? (y.css({ top: (x - 1) * L + "px", left: "0px" }),
              g.css({
                height: (x - 1) * L + y.outerHeight(),
                width: y.outerWidth(),
              }))
            : (y.css({ left: (x - 1) * T + "px", top: "0px" }),
              g.css({
                width: (x - 1) * T + y.outerWidth(),
                height: y.outerHeight(),
              })),
          h.data("maxw", m),
          h.data("maxh", v),
          h.data("wr_padding", t.wrapper_padding);
        var k =
          "outer-top" === t.position || "outer-bottom" === t.position
            ? "relative"
            : "absolute";
        ("outer-top" !== t.position && "outer-bottom" !== t.position) ||
          t.h_align,
          f.css({
            maxWidth: m + "px",
            maxHeight: v + "px",
            overflow: "hidden",
            position: "relative",
          }),
          h.css({
            maxWidth: m + "px",
            maxHeight: v + "px",
            overflow: "visible",
            position: k,
            background: _(t.wrapper_color, t.wrapper_opacity),
            padding: t.wrapper_padding + "px",
            boxSizing: "contet-box",
          }),
          y.click(function () {
            o.sc_indicator = "bullet";
            var t = e.parent().find(s).data("distance");
            (t = void 0 === t ? 0 : t),
              Math.abs(t) < 10 &&
                (e.revcallslidewithid(u),
                e.parent().find(r).removeClass("selected"),
                jQuery(this).addClass("selected"));
          }),
          y.removeClass("justaddedthumb"),
          (t.opt = o),
          h.addClass("nav-pos-hor-" + t.h_align),
          h.addClass("nav-pos-ver-" + t.v_align),
          h.addClass("nav-dir-" + t.direction),
          b(h, t, o);
      },
      T = function (e) {
        var t = e.c.parent().find(".outer-top"),
          a = e.c.parent().find(".outer-bottom");
        (e.top_outer = t.hasClass("tp-forcenotvisible")
          ? 0
          : t.outerHeight() || 0),
          (e.bottom_outer = a.hasClass("tp-forcenotvisible")
            ? 0
            : a.outerHeight() || 0);
      },
      L = function (e, t, a, i) {
        t > a || a > i
          ? e.addClass("tp-forcenotvisible")
          : e.removeClass("tp-forcenotvisible");
      };
  })(jQuery),
  (function (e) {
    "use strict";
    function t(e, t) {
      e.lastscrolltop = t;
    }
    var a = jQuery.fn.revolution,
      i = a.is_mobile(),
      o = {
        alias: "Parallax Min JS",
        name: "revolution.extensions.parallax.min.js",
        min_core: "5.3",
        version: "2.0.1",
      };
    jQuery.extend(!0, a, {
      checkForParallax: function (e, t) {
        function r(e) {
          if ("3D" == n.type || "3d" == n.type) {
            e
              .find(".slotholder")
              .wrapAll(
                '<div class="dddwrapper" style="width:100%;height:100%;position:absolute;top:0px;left:0px;overflow:hidden"></div>'
              ),
              e
                .find(".tp-parallax-wrap")
                .wrapAll(
                  '<div class="dddwrapper-layer" style="width:100%;height:100%;position:absolute;top:0px;left:0px;z-index:5;overflow:' +
                    n.ddd_layer_overflow +
                    ';"></div>'
                ),
              e
                .find(".rs-parallaxlevel-tobggroup")
                .closest(".tp-parallax-wrap")
                .wrapAll(
                  '<div class="dddwrapper-layertobggroup" style="position:absolute;top:0px;left:0px;z-index:50;width:100%;height:100%"></div>'
                );
            var a = e.find(".dddwrapper"),
              i = e.find(".dddwrapper-layer");
            e.find(".dddwrapper-layertobggroup").appendTo(a),
              "carousel" == t.sliderType &&
                ("on" == n.ddd_shadow && a.addClass("dddwrappershadow"),
                punchgs.TweenLite.set(a, {
                  borderRadius: t.carousel.border_radius,
                })),
              punchgs.TweenLite.set(e, {
                overflow: "visible",
                transformStyle: "preserve-3d",
                perspective: 1600,
              }),
              punchgs.TweenLite.set(a, {
                force3D: "auto",
                transformOrigin: "50% 50%",
              }),
              punchgs.TweenLite.set(i, {
                force3D: "auto",
                transformOrigin: "50% 50%",
                zIndex: 5,
              }),
              punchgs.TweenLite.set(t.ul, {
                transformStyle: "preserve-3d",
                transformPerspective: 1600,
              });
          }
        }
        if ("stop" === a.compare_version(o).check) return !1;
        var n = t.parallax;
        if (!n.done) {
          if (((n.done = !0), i && "on" == n.disable_onmobile)) return !1;
          ("3D" != n.type && "3d" != n.type) ||
            (punchgs.TweenLite.set(t.c, { overflow: n.ddd_overflow }),
            punchgs.TweenLite.set(t.ul, {
              overflow: n.ddd_overflow,
            }),
            "carousel" != t.sliderType &&
              "on" == n.ddd_shadow &&
              (t.c.prepend('<div class="dddwrappershadow"></div>'),
              punchgs.TweenLite.set(t.c.find(".dddwrappershadow"), {
                force3D: "auto",
                transformPerspective: 1600,
                transformOrigin: "50% 50%",
                width: "100%",
                height: "100%",
                position: "absolute",
                top: 0,
                left: 0,
                zIndex: 0,
              }))),
            t.li.each(function () {
              r(jQuery(this));
            }),
            ("3D" == n.type || "3d" == n.type) &&
              t.c.find(".tp-static-layers").length > 0 &&
              (punchgs.TweenLite.set(t.c.find(".tp-static-layers"), {
                top: 0,
                left: 0,
                width: "100%",
                height: "100%",
              }),
              r(t.c.find(".tp-static-layers"))),
            (n.pcontainers = new Array()),
            (n.pcontainer_depths = new Array()),
            (n.bgcontainers = new Array()),
            (n.bgcontainer_depths = new Array()),
            t.c
              .find(
                ".tp-revslider-slidesli .slotholder, .tp-revslider-slidesli .rs-background-video-layer"
              )
              .each(function () {
                var e = jQuery(this),
                  a = e.data("bgparallax") || t.parallax.bgparallax;
                void 0 !== (a = "on" == a ? 1 : a) &&
                  "off" !== a &&
                  (n.bgcontainers.push(e),
                  n.bgcontainer_depths.push(
                    t.parallax.levels[parseInt(a, 0) - 1] / 100
                  ));
              });
          for (var s = 1; s <= n.levels.length; s++)
            t.c.find(".rs-parallaxlevel-" + s).each(function () {
              var e = jQuery(this),
                t = e.closest(".tp-parallax-wrap");
              t.data("parallaxlevel", n.levels[s - 1]),
                t.addClass("tp-parallax-container"),
                n.pcontainers.push(t),
                n.pcontainer_depths.push(n.levels[s - 1]);
            });
          ("mouse" != n.type &&
            "scroll+mouse" != n.type &&
            "mouse+scroll" != n.type &&
            "3D" != n.type &&
            "3d" != n.type) ||
            (e.mouseenter(function (t) {
              var a = e.find(".active-revslide"),
                i = e.offset().top,
                o = e.offset().left,
                r = t.pageX - o,
                n = t.pageY - i;
              a.data("enterx", r), a.data("entery", n);
            }),
            e.on(
              "mousemove.hoverdir, mouseleave.hoverdir, trigger3dpath",
              function (a, i) {
                var o = i && i.li ? i.li : e.find(".active-revslide");
                if ("enterpoint" == n.origo) {
                  var r = e.offset().top,
                    s = e.offset().left;
                  void 0 == o.data("enterx") && o.data("enterx", a.pageX - s),
                    void 0 == o.data("entery") && o.data("entery", a.pageY - r);
                  var d = o.data("enterx") || a.pageX - s,
                    l = o.data("entery") || a.pageY - r,
                    p = d - (a.pageX - s),
                    c = l - (a.pageY - r),
                    u = n.speed / 1e3 || 0.4;
                } else
                  var r = e.offset().top,
                    s = e.offset().left,
                    p = t.conw / 2 - (a.pageX - s),
                    c = t.conh / 2 - (a.pageY - r),
                    u = n.speed / 1e3 || 3;
                "mouseleave" == a.type &&
                  ((p = n.ddd_lasth || 0), (c = n.ddd_lastv || 0), (u = 1.5));
                for (var h = 0; h < n.pcontainers.length; h++) {
                  var f = n.pcontainers[h],
                    g = n.pcontainer_depths[h],
                    m = "3D" == n.type || "3d" == n.type ? g / 200 : g / 100,
                    v = p * m,
                    w = c * m;
                  "scroll+mouse" == n.type || "mouse+scroll" == n.type
                    ? punchgs.TweenLite.to(f, u, {
                        force3D: "auto",
                        x: v,
                        ease: punchgs.Power3.easeOut,
                        overwrite: "all",
                      })
                    : punchgs.TweenLite.to(f, u, {
                        force3D: "auto",
                        x: v,
                        y: w,
                        ease: punchgs.Power3.easeOut,
                        overwrite: "all",
                      });
                }
                if ("3D" == n.type || "3d" == n.type) {
                  var b =
                    ".tp-revslider-slidesli .dddwrapper, .dddwrappershadow, .tp-revslider-slidesli .dddwrapper-layer, .tp-static-layers .dddwrapper-layer";
                  "carousel" === t.sliderType &&
                    (b =
                      ".tp-revslider-slidesli .dddwrapper, .tp-revslider-slidesli .dddwrapper-layer, .tp-static-layers .dddwrapper-layer"),
                    t.c.find(b).each(function () {
                      var e = jQuery(this),
                        i = n.levels[n.levels.length - 1] / 200,
                        o = p * i,
                        r = c * i,
                        s =
                          0 == t.conw
                            ? 0
                            : Math.round((p / t.conw) * i * 100) || 0,
                        d =
                          0 == t.conh
                            ? 0
                            : Math.round((c / t.conh) * i * 100) || 0,
                        l = e.closest("li"),
                        h = 0,
                        f = !1;
                      e.hasClass("dddwrapper-layer") &&
                        ((h = n.ddd_z_correction || 65), (f = !0)),
                        e.hasClass("dddwrapper-layer") && ((o = 0), (r = 0)),
                        l.hasClass("active-revslide") ||
                        "carousel" != t.sliderType
                          ? "on" != n.ddd_bgfreeze || f
                            ? punchgs.TweenLite.to(e, u, {
                                rotationX: d,
                                rotationY: -s,
                                x: o,
                                z: h,
                                y: r,
                                ease: punchgs.Power3.easeOut,
                                overwrite: "all",
                              })
                            : punchgs.TweenLite.to(e, 0.5, {
                                force3D: "auto",
                                rotationY: 0,
                                rotationX: 0,
                                z: 0,
                                ease: punchgs.Power3.easeOut,
                                overwrite: "all",
                              })
                          : punchgs.TweenLite.to(e, 0.5, {
                              force3D: "auto",
                              rotationY: 0,
                              x: 0,
                              y: 0,
                              rotationX: 0,
                              z: 0,
                              ease: punchgs.Power3.easeOut,
                              overwrite: "all",
                            }),
                        "mouseleave" == a.type &&
                          punchgs.TweenLite.to(jQuery(this), 3.8, {
                            z: 0,
                            ease: punchgs.Power3.easeOut,
                          });
                    });
                }
              }
            ),
            i &&
              (window.ondeviceorientation = function (a) {
                var i = Math.round(a.beta || 0) - 70,
                  o = Math.round(a.gamma || 0),
                  r = e.find(".active-revslide");
                if (jQuery(window).width() > jQuery(window).height()) {
                  var s = o;
                  (o = i), (i = s);
                }
                var d = e.width(),
                  l = e.height(),
                  p = (360 / d) * o,
                  c = (180 / l) * i,
                  u = n.speed / 1e3 || 3,
                  h = [];
                if (
                  (r.find(".tp-parallax-container").each(function (e) {
                    h.push(jQuery(this));
                  }),
                  e
                    .find(".tp-static-layers .tp-parallax-container")
                    .each(function () {
                      h.push(jQuery(this));
                    }),
                  jQuery.each(h, function () {
                    var e = jQuery(this),
                      t = parseInt(e.data("parallaxlevel"), 0),
                      a = t / 100,
                      i = p * a * 2,
                      o = c * a * 4;
                    punchgs.TweenLite.to(e, u, {
                      force3D: "auto",
                      x: i,
                      y: o,
                      ease: punchgs.Power3.easeOut,
                      overwrite: "all",
                    });
                  }),
                  "3D" == n.type || "3d" == n.type)
                ) {
                  var f =
                    ".tp-revslider-slidesli .dddwrapper, .dddwrappershadow, .tp-revslider-slidesli .dddwrapper-layer, .tp-static-layers .dddwrapper-layer";
                  "carousel" === t.sliderType &&
                    (f =
                      ".tp-revslider-slidesli .dddwrapper, .tp-revslider-slidesli .dddwrapper-layer, .tp-static-layers .dddwrapper-layer"),
                    t.c.find(f).each(function () {
                      var e = jQuery(this),
                        i = n.levels[n.levels.length - 1] / 200,
                        o = p * i,
                        r = c * i * 3,
                        s =
                          0 == t.conw
                            ? 0
                            : Math.round((p / t.conw) * i * 500) || 0,
                        d =
                          0 == t.conh
                            ? 0
                            : Math.round((c / t.conh) * i * 700) || 0,
                        l = e.closest("li"),
                        h = 0,
                        f = !1;
                      e.hasClass("dddwrapper-layer") &&
                        ((h = n.ddd_z_correction || 65), (f = !0)),
                        e.hasClass("dddwrapper-layer") && ((o = 0), (r = 0)),
                        l.hasClass("active-revslide") ||
                        "carousel" != t.sliderType
                          ? "on" != n.ddd_bgfreeze || f
                            ? punchgs.TweenLite.to(e, u, {
                                rotationX: d,
                                rotationY: -s,
                                x: o,
                                z: h,
                                y: r,
                                ease: punchgs.Power3.easeOut,
                                overwrite: "all",
                              })
                            : punchgs.TweenLite.to(e, 0.5, {
                                force3D: "auto",
                                rotationY: 0,
                                rotationX: 0,
                                z: 0,
                                ease: punchgs.Power3.easeOut,
                                overwrite: "all",
                              })
                          : punchgs.TweenLite.to(e, 0.5, {
                              force3D: "auto",
                              rotationY: 0,
                              z: 0,
                              x: 0,
                              y: 0,
                              rotationX: 0,
                              ease: punchgs.Power3.easeOut,
                              overwrite: "all",
                            }),
                        "mouseleave" == a.type &&
                          punchgs.TweenLite.to(jQuery(this), 3.8, {
                            z: 0,
                            ease: punchgs.Power3.easeOut,
                          });
                    });
                }
              })),
            a.scrollTicker(t, e);
        }
      },
      scrollTicker: function (e, t) {
        1 != e.scrollTicker &&
          ((e.scrollTicker = !0),
          i
            ? (punchgs.TweenLite.ticker.fps(150),
              punchgs.TweenLite.ticker.addEventListener(
                "tick",
                function () {
                  a.scrollHandling(e);
                },
                t,
                !1,
                1
              ))
            : document.addEventListener(
                "scroll",
                function (t) {
                  a.scrollHandling(e, !0);
                },
                { passive: !0 }
              )),
          a.scrollHandling(e, !0);
      },
      scrollHandling: function (e, o) {
        if (
          ((e.lastwindowheight = e.lastwindowheight || window.innerHeight),
          (e.conh =
            0 === e.conh || void 0 === e.conh
              ? e.infullscreenmode
                ? e.minHeight
                : e.c.height()
              : e.conh),
          e.lastscrolltop == window.scrollY && !e.duringslidechange && !o)
        )
          return !1;
        punchgs.TweenLite.delayedCall(0.2, t, [e, window.scrollY]);
        var r = e.c[0].getBoundingClientRect(),
          n = e.viewPort,
          s = e.parallax,
          d =
            r.top < 0 || r.height > e.lastwindowheight
              ? r.top / r.height
              : r.bottom > e.lastwindowheight
              ? (r.bottom - e.lastwindowheight) / r.height
              : 0;
        if (
          ((e.scrollproc = d),
          a.callBackHandling && a.callBackHandling(e, "parallax", "start"),
          n.enable)
        ) {
          var l = 1 - Math.abs(d);
          (l = l < 0 ? 0 : l),
            jQuery.isNumeric(n.visible_area) ||
              (-1 !== n.visible_area.indexOf("%") &&
                (n.visible_area = parseInt(n.visible_area) / 100)),
            1 - n.visible_area <= l
              ? e.inviewport || ((e.inviewport = !0), a.enterInViewPort(e))
              : e.inviewport && ((e.inviewport = !1), a.leaveViewPort(e));
        }
        if (i && "on" == s.disable_onmobile) return !1;
        if ("3d" != s.type && "3D" != s.type) {
          if (
            ("scroll" == s.type ||
              "scroll+mouse" == s.type ||
              "mouse+scroll" == s.type) &&
            s.pcontainers
          )
            for (var p = 0; p < s.pcontainers.length; p++)
              if (s.pcontainers[p].length > 0) {
                var c = s.pcontainers[p],
                  u = s.pcontainer_depths[p] / 100,
                  h = Math.round(d * (-u * e.conh) * 10) / 10 || 0;
                c.data("parallaxoffset", h),
                  punchgs.TweenLite.set(c, {
                    overwrite: "auto",
                    force3D: "auto",
                    y: h,
                  });
              }
          if (s.bgcontainers)
            for (var p = 0; p < s.bgcontainers.length; p++) {
              var f = s.bgcontainers[p],
                g = s.bgcontainer_depths[p],
                h = d * (-g * e.conh) || 0;
              punchgs.TweenLite.set(f, {
                position: "absolute",
                top: "0px",
                left: "0px",
                backfaceVisibility: "hidden",
                force3D: "true",
                y: h + "px",
              });
            }
        }
        a.callBackHandling && a.callBackHandling(e, "parallax", "end");
      },
    });
  })(jQuery),
  (function (e) {
    "use strict";
    var t = jQuery.fn.revolution,
      a = {
        alias: "SlideAnimations Min JS",
        name: "revolution.extensions.slideanims.min.js",
        min_core: "4.5",
        version: "1.5.0",
      };
    jQuery.extend(!0, t, {
      animateSlide: function (e, i, o, r, s, d, l, p) {
        return "stop" === t.compare_version(a).check
          ? p
          : n(e, i, o, r, s, d, l, p);
      },
    });
    var i = function (e, a, i, o) {
        var r = e,
          n = r.find(".defaultimg"),
          s = r.data("zoomstart"),
          d = r.data("rotationstart");
        void 0 != n.data("currotate") && (d = n.data("currotate")),
          void 0 != n.data("curscale") && "box" == o
            ? (s = 100 * n.data("curscale"))
            : void 0 != n.data("curscale") && (s = n.data("curscale")),
          t.slotSize(n, a);
        var l = n.attr("src"),
          p = n.css("backgroundColor"),
          c = a.width,
          u = a.height,
          h = n.data("fxof");
        "on" == a.autoHeight && (u = a.c.height()), void 0 == h && (h = 0);
        var f = 0,
          g = n.data("bgfit"),
          m = n.data("bgrepeat"),
          v = n.data("bgposition");
        switch (
          (void 0 == g && (g = "cover"),
          void 0 == m && (m = "no-repeat"),
          void 0 == v && (v = "center center"),
          o)
        ) {
          case "box":
            for (var w = 0, b = 0, y = 0; y < a.slots; y++) {
              b = 0;
              for (var _ = 0; _ < a.slots; _++)
                r.append(
                  '<div class="slot" style="position:absolute;top:' +
                    (0 + b) +
                    "px;left:" +
                    (h + w) +
                    "px;width:" +
                    a.slotw +
                    "px;height:" +
                    a.sloth +
                    'px;overflow:hidden;"><div class="slotslide" data-x="' +
                    w +
                    '" data-y="' +
                    b +
                    '" style="position:absolute;top:0px;left:0px;width:' +
                    a.slotw +
                    "px;height:" +
                    a.sloth +
                    'px;overflow:hidden;"><div style="position:absolute;top:' +
                    (0 - b) +
                    "px;left:" +
                    (0 - w) +
                    "px;width:" +
                    c +
                    "px;height:" +
                    u +
                    "px;background-color:" +
                    p +
                    ";background-image:url(" +
                    l +
                    ");background-repeat:" +
                    m +
                    ";background-size:" +
                    g +
                    ";background-position:" +
                    v +
                    ';"></div></div></div>'
                ),
                  (b += a.sloth),
                  void 0 != s &&
                    void 0 != d &&
                    punchgs.TweenLite.set(r.find(".slot").last(), {
                      rotationZ: d,
                    });
              w += a.slotw;
            }
            break;
          case "vertical":
          case "horizontal":
            if ("horizontal" == o) {
              if (!i) var f = 0 - a.slotw;
              for (var _ = 0; _ < a.slots; _++)
                r.append(
                  '<div class="slot" style="position:absolute;top:0px;left:' +
                    (h + _ * a.slotw) +
                    "px;overflow:hidden;width:" +
                    (a.slotw + 0.3) +
                    "px;height:" +
                    u +
                    'px"><div class="slotslide" style="position:absolute;top:0px;left:' +
                    f +
                    "px;width:" +
                    (a.slotw + 0.6) +
                    "px;height:" +
                    u +
                    'px;overflow:hidden;"><div style="background-color:' +
                    p +
                    ";position:absolute;top:0px;left:" +
                    (0 - _ * a.slotw) +
                    "px;width:" +
                    c +
                    "px;height:" +
                    u +
                    "px;background-image:url(" +
                    l +
                    ");background-repeat:" +
                    m +
                    ";background-size:" +
                    g +
                    ";background-position:" +
                    v +
                    ';"></div></div></div>'
                ),
                  void 0 != s &&
                    void 0 != d &&
                    punchgs.TweenLite.set(r.find(".slot").last(), {
                      rotationZ: d,
                    });
            } else {
              if (!i) var f = 0 - a.sloth;
              for (var _ = 0; _ < a.slots + 2; _++)
                r.append(
                  '<div class="slot" style="position:absolute;top:' +
                    (0 + _ * a.sloth) +
                    "px;left:" +
                    h +
                    "px;overflow:hidden;width:" +
                    c +
                    "px;height:" +
                    a.sloth +
                    'px"><div class="slotslide" style="position:absolute;top:' +
                    f +
                    "px;left:0px;width:" +
                    c +
                    "px;height:" +
                    a.sloth +
                    'px;overflow:hidden;"><div style="background-color:' +
                    p +
                    ";position:absolute;top:" +
                    (0 - _ * a.sloth) +
                    "px;left:0px;width:" +
                    c +
                    "px;height:" +
                    u +
                    "px;background-image:url(" +
                    l +
                    ");background-repeat:" +
                    m +
                    ";background-size:" +
                    g +
                    ";background-position:" +
                    v +
                    ';"></div></div></div>'
                ),
                  void 0 != s &&
                    void 0 != d &&
                    punchgs.TweenLite.set(r.find(".slot").last(), {
                      rotationZ: d,
                    });
            }
        }
      },
      o = function (e, t, a, i) {
        var o = e[0].opt,
          r = punchgs.Power1.easeIn,
          n = punchgs.Power1.easeOut,
          s = punchgs.Power1.easeInOut,
          d = punchgs.Power2.easeIn,
          l = punchgs.Power2.easeOut,
          p = punchgs.Power2.easeInOut,
          c = (punchgs.Power3.easeIn, punchgs.Power3.easeOut),
          u = punchgs.Power3.easeInOut,
          h = [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 28, 29, 30,
            31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45,
          ],
          f = [16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 27],
          g = 0,
          m = 1,
          v = 0,
          w = 0,
          b =
            (new Array(),
            [
              ["boxslide", 0, 1, 10, 0, "box", !1, null, 0, n, n, 500, 6],
              ["boxfade", 1, 0, 10, 0, "box", !1, null, 1, s, s, 700, 5],
              [
                "slotslide-horizontal",
                2,
                0,
                0,
                200,
                "horizontal",
                !0,
                !1,
                2,
                p,
                p,
                700,
                3,
              ],
              [
                "slotslide-vertical",
                3,
                0,
                0,
                200,
                "vertical",
                !0,
                !1,
                3,
                p,
                p,
                700,
                3,
              ],
              ["curtain-1", 4, 3, 0, 0, "horizontal", !0, !0, 4, n, n, 300, 5],
              ["curtain-2", 5, 3, 0, 0, "horizontal", !0, !0, 5, n, n, 300, 5],
              ["curtain-3", 6, 3, 25, 0, "horizontal", !0, !0, 6, n, n, 300, 5],
              [
                "slotzoom-horizontal",
                7,
                0,
                0,
                400,
                "horizontal",
                !0,
                !0,
                7,
                n,
                n,
                300,
                7,
              ],
              [
                "slotzoom-vertical",
                8,
                0,
                0,
                0,
                "vertical",
                !0,
                !0,
                8,
                l,
                l,
                500,
                8,
              ],
              [
                "slotfade-horizontal",
                9,
                0,
                0,
                1e3,
                "horizontal",
                !0,
                null,
                9,
                l,
                l,
                2e3,
                10,
              ],
              [
                "slotfade-vertical",
                10,
                0,
                0,
                1e3,
                "vertical",
                !0,
                null,
                10,
                l,
                l,
                2e3,
                10,
              ],
              ["fade", 11, 0, 1, 300, "horizontal", !0, null, 11, p, p, 1e3, 1],
              [
                "crossfade",
                11,
                1,
                1,
                300,
                "horizontal",
                !0,
                null,
                11,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadethroughdark",
                11,
                2,
                1,
                300,
                "horizontal",
                !0,
                null,
                11,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadethroughlight",
                11,
                3,
                1,
                300,
                "horizontal",
                !0,
                null,
                11,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadethroughtransparent",
                11,
                4,
                1,
                300,
                "horizontal",
                !0,
                null,
                11,
                p,
                p,
                1e3,
                1,
              ],
              [
                "slideleft",
                12,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                12,
                u,
                u,
                1e3,
                1,
              ],
              ["slideup", 13, 0, 1, 0, "horizontal", !0, !0, 13, u, u, 1e3, 1],
              [
                "slidedown",
                14,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                14,
                u,
                u,
                1e3,
                1,
              ],
              [
                "slideright",
                15,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                15,
                u,
                u,
                1e3,
                1,
              ],
              [
                "slideoverleft",
                12,
                7,
                1,
                0,
                "horizontal",
                !0,
                !0,
                12,
                u,
                u,
                1e3,
                1,
              ],
              [
                "slideoverup",
                13,
                7,
                1,
                0,
                "horizontal",
                !0,
                !0,
                13,
                u,
                u,
                1e3,
                1,
              ],
              [
                "slideoverdown",
                14,
                7,
                1,
                0,
                "horizontal",
                !0,
                !0,
                14,
                u,
                u,
                1e3,
                1,
              ],
              [
                "slideoverright",
                15,
                7,
                1,
                0,
                "horizontal",
                !0,
                !0,
                15,
                u,
                u,
                1e3,
                1,
              ],
              [
                "slideremoveleft",
                12,
                8,
                1,
                0,
                "horizontal",
                !0,
                !0,
                12,
                u,
                u,
                1e3,
                1,
              ],
              [
                "slideremoveup",
                13,
                8,
                1,
                0,
                "horizontal",
                !0,
                !0,
                13,
                u,
                u,
                1e3,
                1,
              ],
              [
                "slideremovedown",
                14,
                8,
                1,
                0,
                "horizontal",
                !0,
                !0,
                14,
                u,
                u,
                1e3,
                1,
              ],
              [
                "slideremoveright",
                15,
                8,
                1,
                0,
                "horizontal",
                !0,
                !0,
                15,
                u,
                u,
                1e3,
                1,
              ],
              ["papercut", 16, 0, 0, 600, "", null, null, 16, u, u, 1e3, 2],
              [
                "3dcurtain-horizontal",
                17,
                0,
                20,
                100,
                "vertical",
                !1,
                !0,
                17,
                s,
                s,
                500,
                7,
              ],
              [
                "3dcurtain-vertical",
                18,
                0,
                10,
                100,
                "horizontal",
                !1,
                !0,
                18,
                s,
                s,
                500,
                5,
              ],
              ["cubic", 19, 0, 20, 600, "horizontal", !1, !0, 19, u, u, 500, 1],
              ["cube", 19, 0, 20, 600, "horizontal", !1, !0, 20, u, u, 500, 1],
              ["flyin", 20, 0, 4, 600, "vertical", !1, !0, 21, c, u, 500, 1],
              [
                "turnoff",
                21,
                0,
                1,
                500,
                "horizontal",
                !1,
                !0,
                22,
                u,
                u,
                500,
                1,
              ],
              [
                "incube",
                22,
                0,
                20,
                200,
                "horizontal",
                !1,
                !0,
                23,
                p,
                p,
                500,
                1,
              ],
              [
                "cubic-horizontal",
                23,
                0,
                20,
                500,
                "vertical",
                !1,
                !0,
                24,
                l,
                l,
                500,
                1,
              ],
              [
                "cube-horizontal",
                23,
                0,
                20,
                500,
                "vertical",
                !1,
                !0,
                25,
                l,
                l,
                500,
                1,
              ],
              [
                "incube-horizontal",
                24,
                0,
                20,
                500,
                "vertical",
                !1,
                !0,
                26,
                p,
                p,
                500,
                1,
              ],
              [
                "turnoff-vertical",
                25,
                0,
                1,
                200,
                "horizontal",
                !1,
                !0,
                27,
                p,
                p,
                500,
                1,
              ],
              [
                "fadefromright",
                14,
                1,
                1,
                0,
                "horizontal",
                !0,
                !0,
                28,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadefromleft",
                15,
                1,
                1,
                0,
                "horizontal",
                !0,
                !0,
                29,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadefromtop",
                14,
                1,
                1,
                0,
                "horizontal",
                !0,
                !0,
                30,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadefrombottom",
                13,
                1,
                1,
                0,
                "horizontal",
                !0,
                !0,
                31,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadetoleftfadefromright",
                12,
                2,
                1,
                0,
                "horizontal",
                !0,
                !0,
                32,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadetorightfadefromleft",
                15,
                2,
                1,
                0,
                "horizontal",
                !0,
                !0,
                33,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadetobottomfadefromtop",
                14,
                2,
                1,
                0,
                "horizontal",
                !0,
                !0,
                34,
                p,
                p,
                1e3,
                1,
              ],
              [
                "fadetotopfadefrombottom",
                13,
                2,
                1,
                0,
                "horizontal",
                !0,
                !0,
                35,
                p,
                p,
                1e3,
                1,
              ],
              [
                "parallaxtoright",
                15,
                3,
                1,
                0,
                "horizontal",
                !0,
                !0,
                36,
                p,
                d,
                1500,
                1,
              ],
              [
                "parallaxtoleft",
                12,
                3,
                1,
                0,
                "horizontal",
                !0,
                !0,
                37,
                p,
                d,
                1500,
                1,
              ],
              [
                "parallaxtotop",
                14,
                3,
                1,
                0,
                "horizontal",
                !0,
                !0,
                38,
                p,
                r,
                1500,
                1,
              ],
              [
                "parallaxtobottom",
                13,
                3,
                1,
                0,
                "horizontal",
                !0,
                !0,
                39,
                p,
                r,
                1500,
                1,
              ],
              [
                "scaledownfromright",
                12,
                4,
                1,
                0,
                "horizontal",
                !0,
                !0,
                40,
                p,
                d,
                1e3,
                1,
              ],
              [
                "scaledownfromleft",
                15,
                4,
                1,
                0,
                "horizontal",
                !0,
                !0,
                41,
                p,
                d,
                1e3,
                1,
              ],
              [
                "scaledownfromtop",
                14,
                4,
                1,
                0,
                "horizontal",
                !0,
                !0,
                42,
                p,
                d,
                1e3,
                1,
              ],
              [
                "scaledownfrombottom",
                13,
                4,
                1,
                0,
                "horizontal",
                !0,
                !0,
                43,
                p,
                d,
                1e3,
                1,
              ],
              ["zoomout", 13, 5, 1, 0, "horizontal", !0, !0, 44, p, d, 1e3, 1],
              ["zoomin", 13, 6, 1, 0, "horizontal", !0, !0, 45, p, d, 1e3, 1],
              [
                "slidingoverlayup",
                27,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                47,
                s,
                n,
                2e3,
                1,
              ],
              [
                "slidingoverlaydown",
                28,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                48,
                s,
                n,
                2e3,
                1,
              ],
              [
                "slidingoverlayright",
                30,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                49,
                s,
                n,
                2e3,
                1,
              ],
              [
                "slidingoverlayleft",
                29,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                50,
                s,
                n,
                2e3,
                1,
              ],
              [
                "parallaxcirclesup",
                31,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                51,
                p,
                r,
                1500,
                1,
              ],
              [
                "parallaxcirclesdown",
                32,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                52,
                p,
                r,
                1500,
                1,
              ],
              [
                "parallaxcirclesright",
                33,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                53,
                p,
                r,
                1500,
                1,
              ],
              [
                "parallaxcirclesleft",
                34,
                0,
                1,
                0,
                "horizontal",
                !0,
                !0,
                54,
                p,
                r,
                1500,
                1,
              ],
              [
                "notransition",
                26,
                0,
                1,
                0,
                "horizontal",
                !0,
                null,
                46,
                p,
                d,
                1e3,
                1,
              ],
              [
                "parallaxright",
                15,
                3,
                1,
                0,
                "horizontal",
                !0,
                !0,
                55,
                p,
                d,
                1500,
                1,
              ],
              [
                "parallaxleft",
                12,
                3,
                1,
                0,
                "horizontal",
                !0,
                !0,
                56,
                p,
                d,
                1500,
                1,
              ],
              [
                "parallaxup",
                14,
                3,
                1,
                0,
                "horizontal",
                !0,
                !0,
                57,
                p,
                r,
                1500,
                1,
              ],
              [
                "parallaxdown",
                13,
                3,
                1,
                0,
                "horizontal",
                !0,
                !0,
                58,
                p,
                r,
                1500,
                1,
              ],
            ]);
        (o.duringslidechange = !0),
          (o.testanims = !1),
          1 == o.testanims &&
            ((o.nexttesttransform =
              void 0 === o.nexttesttransform ? 34 : o.nexttesttransform + 1),
            (o.nexttesttransform =
              o.nexttesttransform > 70 ? 0 : o.nexttesttransform),
            (t = b[o.nexttesttransform][0])),
          jQuery.each(
            [
              "parallaxcircles",
              "slidingoverlay",
              "slide",
              "slideover",
              "slideremove",
              "parallax",
              "parralaxto",
            ],
            function (e, a) {
              t == a + "horizontal" && (t = 1 != i ? a + "left" : a + "right"),
                t == a + "vertical" && (t = 1 != i ? a + "up" : a + "down");
            }
          ),
          "random" == t &&
            (t = Math.round(Math.random() * b.length - 1)) > b.length - 1 &&
            (t = b.length - 1),
          "random-static" == t &&
            ((t = Math.round(Math.random() * h.length - 1)),
            t > h.length - 1 && (t = h.length - 1),
            (t = h[t])),
          "random-premium" == t &&
            ((t = Math.round(Math.random() * f.length - 1)),
            t > f.length - 1 && (t = f.length - 1),
            (t = f[t]));
        var y = [
          12, 13, 14, 15, 16, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39,
          40, 41, 42, 43, 44, 45,
        ];
        if (
          1 == o.isJoomla &&
          void 0 != window.MooTools &&
          -1 != y.indexOf(t)
        ) {
          var _ = Math.round(Math.random() * (f.length - 2)) + 1;
          _ > f.length - 1 && (_ = f.length - 1), 0 == _ && (_ = 1), (t = f[_]);
        }
        (function () {
          jQuery.each(b, function (e, a) {
            (a[0] != t && a[8] != t) || ((g = a[1]), (m = a[2]), (v = w)),
              (w += 1);
          });
        })(),
          g > 30 && (g = 30),
          g < 0 && (g = 0);
        var x = new Object();
        return (x.nexttrans = g), (x.STA = b[v]), (x.specials = m), x;
      },
      r = function (e, t) {
        return void 0 == t || jQuery.isNumeric(e)
          ? e
          : void 0 == e
          ? e
          : e.split(",")[t];
      },
      n = function (e, t, a, n, s, d, l, p) {
        var c = a[0].opt,
          u = s.index(),
          h = n.index(),
          f = h < u ? 1 : 0;
        "arrow" == c.sc_indicator && (f = c.sc_indicator_dir);
        var g = o(a, t, 0, f),
          m = g.STA,
          v = g.specials,
          e = g.nexttrans;
        "on" == d.data("kenburns") && (e = 11);
        var w = n.data("nexttransid") || 0,
          b = r(n.data("masterspeed"), w);
        (b =
          "default" === b
            ? m[11]
            : "random" === b
            ? Math.round(1e3 * Math.random() + 300)
            : void 0 != b
            ? parseInt(b, 0)
            : m[11]),
          (b = b > c.delay ? c.delay : b),
          (b += m[4]),
          (c.slots = r(n.data("slotamount"), w)),
          (c.slots =
            void 0 == c.slots || "default" == c.slots
              ? m[12]
              : "random" == c.slots
              ? Math.round(12 * Math.random() + 4)
              : c.slots),
          (c.slots =
            c.slots < 1
              ? "boxslide" == t
                ? Math.round(6 * Math.random() + 3)
                : "flyin" == t
                ? Math.round(4 * Math.random() + 1)
                : c.slots
              : c.slots),
          (c.slots = (4 == e || 5 == e || 6 == e) && c.slots < 3 ? 3 : c.slots),
          (c.slots = 0 != m[3] ? Math.min(c.slots, m[3]) : c.slots),
          (c.slots =
            9 == e
              ? c.width / c.slots
              : 10 == e
              ? c.height / c.slots
              : c.slots),
          (c.rotate = r(n.data("rotate"), w)),
          (c.rotate =
            void 0 == c.rotate || "default" == c.rotate
              ? 0
              : 999 == c.rotate || "random" == c.rotate
              ? Math.round(360 * Math.random())
              : c.rotate),
          (c.rotate =
            !jQuery.support.transition || c.ie || c.ie9 ? 0 : c.rotate),
          11 != e &&
            (null != m[7] && i(l, c, m[7], m[5]),
            null != m[6] && i(d, c, m[6], m[5])),
          p.add(
            punchgs.TweenLite.set(d.find(".defaultvid"), {
              y: 0,
              x: 0,
              top: 0,
              left: 0,
              scale: 1,
            }),
            0
          ),
          p.add(
            punchgs.TweenLite.set(l.find(".defaultvid"), {
              y: 0,
              x: 0,
              top: 0,
              left: 0,
              scale: 1,
            }),
            0
          ),
          p.add(
            punchgs.TweenLite.set(d.find(".defaultvid"), {
              y: "+0%",
              x: "+0%",
            }),
            0
          ),
          p.add(
            punchgs.TweenLite.set(l.find(".defaultvid"), {
              y: "+0%",
              x: "+0%",
            }),
            0
          ),
          p.add(
            punchgs.TweenLite.set(d, { autoAlpha: 1, y: "+0%", x: "+0%" }),
            0
          ),
          p.add(
            punchgs.TweenLite.set(l, { autoAlpha: 1, y: "+0%", x: "+0%" }),
            0
          ),
          p.add(
            punchgs.TweenLite.set(d.parent(), {
              backgroundColor: "transparent",
            }),
            0
          ),
          p.add(
            punchgs.TweenLite.set(l.parent(), {
              backgroundColor: "transparent",
            }),
            0
          );
        var y = r(n.data("easein"), w),
          _ = r(n.data("easeout"), w);
        if (
          ((y =
            "default" === y
              ? m[9] || punchgs.Power2.easeInOut
              : y || m[9] || punchgs.Power2.easeInOut),
          (_ =
            "default" === _
              ? m[10] || punchgs.Power2.easeInOut
              : _ || m[10] || punchgs.Power2.easeInOut),
          0 == e)
        ) {
          var x = Math.ceil(c.height / c.sloth),
            T = 0;
          d.find(".slotslide").each(function (e) {
            var t = jQuery(this);
            (T += 1),
              T == x && (T = 0),
              p.add(
                punchgs.TweenLite.from(t, b / 600, {
                  opacity: 0,
                  top: 0 - c.sloth,
                  left: 0 - c.slotw,
                  rotation: c.rotate,
                  force3D: "auto",
                  ease: y,
                }),
                (15 * e + 30 * T) / 1500
              );
          });
        }
        if (1 == e) {
          var L,
            k = 0;
          d.find(".slotslide").each(function (e) {
            var t = jQuery(this),
              a = Math.random() * b + 300,
              i = 500 * Math.random() + 200;
            a + i > L && ((L = i + i), (k = e)),
              p.add(
                punchgs.TweenLite.from(t, a / 1e3, {
                  autoAlpha: 0,
                  force3D: "auto",
                  rotation: c.rotate,
                  ease: y,
                }),
                i / 1e3
              );
          });
        }
        if (2 == e) {
          var j = new punchgs.TimelineLite();
          l.find(".slotslide").each(function () {
            var e = jQuery(this);
            j.add(
              punchgs.TweenLite.to(e, b / 1e3, {
                left: c.slotw,
                ease: y,
                force3D: "auto",
                rotation: 0 - c.rotate,
              }),
              0
            ),
              p.add(j, 0);
          }),
            d.find(".slotslide").each(function () {
              var e = jQuery(this);
              j.add(
                punchgs.TweenLite.from(e, b / 1e3, {
                  left: 0 - c.slotw,
                  ease: y,
                  force3D: "auto",
                  rotation: c.rotate,
                }),
                0
              ),
                p.add(j, 0);
            });
        }
        if (3 == e) {
          var j = new punchgs.TimelineLite();
          l.find(".slotslide").each(function () {
            var e = jQuery(this);
            j.add(
              punchgs.TweenLite.to(e, b / 1e3, {
                top: c.sloth,
                ease: y,
                rotation: c.rotate,
                force3D: "auto",
                transformPerspective: 600,
              }),
              0
            ),
              p.add(j, 0);
          }),
            d.find(".slotslide").each(function () {
              var e = jQuery(this);
              j.add(
                punchgs.TweenLite.from(e, b / 1e3, {
                  top: 0 - c.sloth,
                  rotation: c.rotate,
                  ease: _,
                  force3D: "auto",
                  transformPerspective: 600,
                }),
                0
              ),
                p.add(j, 0);
            });
        }
        if (4 == e || 5 == e) {
          setTimeout(function () {
            l.find(".defaultimg").css({ opacity: 0 });
          }, 100);
          var z = b / 1e3,
            j = new punchgs.TimelineLite();
          l.find(".slotslide").each(function (t) {
            var a = jQuery(this),
              i = (t * z) / c.slots;
            5 == e && (i = ((c.slots - t - 1) * z) / c.slots / 1.5),
              j.add(
                punchgs.TweenLite.to(a, 3 * z, {
                  transformPerspective: 600,
                  force3D: "auto",
                  top: 0 + c.height,
                  opacity: 0.5,
                  rotation: c.rotate,
                  ease: y,
                  delay: i,
                }),
                0
              ),
              p.add(j, 0);
          }),
            d.find(".slotslide").each(function (t) {
              var a = jQuery(this),
                i = (t * z) / c.slots;
              5 == e && (i = ((c.slots - t - 1) * z) / c.slots / 1.5),
                j.add(
                  punchgs.TweenLite.from(a, 3 * z, {
                    top: 0 - c.height,
                    opacity: 0.5,
                    rotation: c.rotate,
                    force3D: "auto",
                    ease: punchgs.eo,
                    delay: i,
                  }),
                  0
                ),
                p.add(j, 0);
            });
        }
        if (6 == e) {
          c.slots < 2 && (c.slots = 2), c.slots % 2 && (c.slots = c.slots + 1);
          var j = new punchgs.TimelineLite();
          setTimeout(function () {
            l.find(".defaultimg").css({ opacity: 0 });
          }, 100),
            l.find(".slotslide").each(function (e) {
              var t = jQuery(this);
              if (e + 1 < c.slots / 2) var a = 90 * (e + 2);
              else var a = 90 * (2 + c.slots - e);
              j.add(
                punchgs.TweenLite.to(t, (b + a) / 1e3, {
                  top: 0 + c.height,
                  opacity: 1,
                  force3D: "auto",
                  rotation: c.rotate,
                  ease: y,
                }),
                0
              ),
                p.add(j, 0);
            }),
            d.find(".slotslide").each(function (e) {
              var t = jQuery(this);
              if (e + 1 < c.slots / 2) var a = 90 * (e + 2);
              else var a = 90 * (2 + c.slots - e);
              j.add(
                punchgs.TweenLite.from(t, (b + a) / 1e3, {
                  top: 0 - c.height,
                  opacity: 1,
                  force3D: "auto",
                  rotation: c.rotate,
                  ease: _,
                }),
                0
              ),
                p.add(j, 0);
            });
        }
        if (7 == e) {
          (b *= 2) > c.delay && (b = c.delay);
          var j = new punchgs.TimelineLite();
          setTimeout(function () {
            l.find(".defaultimg").css({ opacity: 0 });
          }, 100),
            l.find(".slotslide").each(function () {
              var e = jQuery(this).find("div");
              j.add(
                punchgs.TweenLite.to(e, b / 1e3, {
                  left: 0 - c.slotw / 2 + "px",
                  top: 0 - c.height / 2 + "px",
                  width: 2 * c.slotw + "px",
                  height: 2 * c.height + "px",
                  opacity: 0,
                  rotation: c.rotate,
                  force3D: "auto",
                  ease: y,
                }),
                0
              ),
                p.add(j, 0);
            }),
            d.find(".slotslide").each(function (e) {
              var t = jQuery(this).find("div");
              j.add(
                punchgs.TweenLite.fromTo(
                  t,
                  b / 1e3,
                  { left: 0, top: 0, opacity: 0, transformPerspective: 600 },
                  {
                    left: 0 - e * c.slotw + "px",
                    ease: _,
                    force3D: "auto",
                    top: "0px",
                    width: c.width,
                    height: c.height,
                    opacity: 1,
                    rotation: 0,
                    delay: 0.1,
                  }
                ),
                0
              ),
                p.add(j, 0);
            });
        }
        if (8 == e) {
          (b *= 3) > c.delay && (b = c.delay);
          var j = new punchgs.TimelineLite();
          l.find(".slotslide").each(function () {
            var e = jQuery(this).find("div");
            j.add(
              punchgs.TweenLite.to(e, b / 1e3, {
                left: 0 - c.width / 2 + "px",
                top: 0 - c.sloth / 2 + "px",
                width: 2 * c.width + "px",
                height: 2 * c.sloth + "px",
                force3D: "auto",
                ease: y,
                opacity: 0,
                rotation: c.rotate,
              }),
              0
            ),
              p.add(j, 0);
          }),
            d.find(".slotslide").each(function (e) {
              var t = jQuery(this).find("div");
              j.add(
                punchgs.TweenLite.fromTo(
                  t,
                  b / 1e3,
                  { left: 0, top: 0, opacity: 0, force3D: "auto" },
                  {
                    left: "0px",
                    top: 0 - e * c.sloth + "px",
                    width: d.find(".defaultimg").data("neww") + "px",
                    height: d.find(".defaultimg").data("newh") + "px",
                    opacity: 1,
                    ease: _,
                    rotation: 0,
                  }
                ),
                0
              ),
                p.add(j, 0);
            });
        }
        if (9 == e || 10 == e) {
          var Q = 0;
          d.find(".slotslide").each(function (e) {
            var t = jQuery(this);
            Q++,
              p.add(
                punchgs.TweenLite.fromTo(
                  t,
                  b / 2e3,
                  { autoAlpha: 0, force3D: "auto", transformPerspective: 600 },
                  { autoAlpha: 1, ease: y, delay: (e * c.slots) / 100 / 2e3 }
                ),
                0
              );
          });
        }
        if (27 == e || 28 == e || 29 == e || 30 == e) {
          var I = d.find(".slot"),
            M = 27 == e || 28 == e ? 1 : 2,
            O = 27 == e || 29 == e ? "-100%" : "+100%",
            C = 27 == e || 29 == e ? "+100%" : "-100%",
            S = 27 == e || 29 == e ? "-80%" : "80%",
            A = 27 == e || 29 == e ? "+80%" : "-80%",
            R = 27 == e || 29 == e ? "+10%" : "-10%",
            P = { overwrite: "all" },
            D = { autoAlpha: 0, zIndex: 1, force3D: "auto", ease: y },
            W = {
              position: "inherit",
              autoAlpha: 0,
              overwrite: "all",
              zIndex: 1,
            },
            V = { autoAlpha: 1, force3D: "auto", ease: _ },
            H = { overwrite: "all", zIndex: 2, opacity: 1, autoAlpha: 1 },
            Y = { autoAlpha: 1, force3D: "auto", overwrite: "all", ease: y },
            N = { overwrite: "all", zIndex: 2, autoAlpha: 1 },
            X = { autoAlpha: 1, force3D: "auto", ease: y },
            F = 1 == M ? "y" : "x";
          (P[F] = "0px"),
            (D[F] = O),
            (W[F] = R),
            (V[F] = "0%"),
            (H[F] = C),
            (Y[F] = O),
            (N[F] = S),
            (X[F] = A),
            I.append(
              '<span style="background-color:rgba(0,0,0,0.6);width:100%;height:100%;position:absolute;top:0px;left:0px;display:block;z-index:2"></span>'
            ),
            p.add(punchgs.TweenLite.fromTo(l, b / 1e3, P, D), 0),
            p.add(
              punchgs.TweenLite.fromTo(d.find(".defaultimg"), b / 2e3, W, V),
              b / 2e3
            ),
            p.add(punchgs.TweenLite.fromTo(I, b / 1e3, H, Y), 0),
            p.add(
              punchgs.TweenLite.fromTo(I.find(".slotslide div"), b / 1e3, N, X),
              0
            );
        }
        if (31 == e || 32 == e || 33 == e || 34 == e) {
          (b = 6e3), (y = punchgs.Power3.easeInOut);
          var B = b / 1e3;
          (mas = B - B / 5),
            (_nt = e),
            (fy = 31 == _nt ? "+100%" : 32 == _nt ? "-100%" : "0%"),
            (fx = 33 == _nt ? "+100%" : 34 == _nt ? "-100%" : "0%"),
            (ty = 31 == _nt ? "-100%" : 32 == _nt ? "+100%" : "0%"),
            (tx = 33 == _nt ? "-100%" : 34 == _nt ? "+100%" : "0%"),
            p.add(
              punchgs.TweenLite.fromTo(
                l,
                B - 0.2 * B,
                { y: 0, x: 0 },
                { y: ty, x: tx, ease: _ }
              ),
              0.2 * B
            ),
            p.add(
              punchgs.TweenLite.fromTo(
                d,
                B,
                { y: fy, x: fx },
                { y: "0%", x: "0%", ease: y }
              ),
              0
            ),
            d.find(".slot").remove(),
            d.find(".defaultimg").clone().appendTo(d).addClass("slot"),
            (function (e, t, a, i, o) {
              var r = e.find(".slot"),
                n = [2, 1.2, 0.9, 0.7, 0.55, 0.42],
                s = e.width(),
                l = e.height();
              r.wrap(
                '<div class="slot-circle-wrapper" style="overflow:hidden;position:absolute;border:1px solid #fff"></div>'
              );
              for (var c = 0; c < 6; c++) r.parent().clone(!1).appendTo(d);
              e.find(".slot-circle-wrapper").each(function (e) {
                if (e < 6) {
                  var i = jQuery(this),
                    r = i.find(".slot"),
                    d = s > l ? n[e] * s : n[e] * l,
                    c = d,
                    u = c / 2 - s / 2 + 0,
                    h = d / 2 - l / 2 + 0,
                    f = 0 != e ? "50%" : "0",
                    g = l / 2 - d / 2,
                    m =
                      33 == a ? s / 2 - c / 2 : 34 == a ? s - c : s / 2 - c / 2,
                    v = {
                      scale: 1,
                      transformOrigo: "50% 50%",
                      width: c + "px",
                      height: d + "px",
                      top: g + "px",
                      left: m + "px",
                      borderRadius: f,
                    },
                    w = {
                      scale: 1,
                      top: l / 2 - d / 2,
                      left: s / 2 - c / 2,
                      ease: o,
                    },
                    b = h,
                    y = 33 == a ? u : 34 == a ? u + s / 2 : u,
                    _ = {
                      width: s,
                      height: l,
                      autoAlpha: 1,
                      top: b + "px",
                      position: "absolute",
                      left: y + "px",
                    },
                    x = { top: h + "px", left: u + "px", ease: o },
                    T = t;
                  p.add(punchgs.TweenLite.fromTo(i, T, v, w), 0),
                    p.add(punchgs.TweenLite.fromTo(r, T, _, x), 0),
                    p.add(
                      punchgs.TweenLite.fromTo(
                        i,
                        0.001,
                        { autoAlpha: 0 },
                        { autoAlpha: 1 }
                      ),
                      0
                    );
                }
              });
            })(d, B, _nt, "in", y);
        }
        if (11 == e) {
          v > 4 && (v = 0);
          var Q = 0,
            E = 2 == v ? "#000000" : 3 == v ? "#ffffff" : "transparent";
          switch (v) {
            case 0:
              p.add(
                punchgs.TweenLite.fromTo(
                  d,
                  b / 1e3,
                  { autoAlpha: 0 },
                  { autoAlpha: 1, force3D: "auto", ease: y }
                ),
                0
              );
              break;
            case 1:
              p.add(
                punchgs.TweenLite.fromTo(
                  d,
                  b / 1e3,
                  { autoAlpha: 0 },
                  { autoAlpha: 1, force3D: "auto", ease: y }
                ),
                0
              ),
                p.add(
                  punchgs.TweenLite.fromTo(
                    l,
                    b / 1e3,
                    { autoAlpha: 1 },
                    { autoAlpha: 0, force3D: "auto", ease: y }
                  ),
                  0
                );
              break;
            case 2:
            case 3:
            case 4:
              p.add(
                punchgs.TweenLite.set(l.parent(), {
                  backgroundColor: E,
                  force3D: "auto",
                }),
                0
              ),
                p.add(
                  punchgs.TweenLite.set(d.parent(), {
                    backgroundColor: "transparent",
                    force3D: "auto",
                  }),
                  0
                ),
                p.add(
                  punchgs.TweenLite.to(l, b / 2e3, {
                    autoAlpha: 0,
                    force3D: "auto",
                    ease: y,
                  }),
                  0
                ),
                p.add(
                  punchgs.TweenLite.fromTo(
                    d,
                    b / 2e3,
                    { autoAlpha: 0 },
                    { autoAlpha: 1, force3D: "auto", ease: y }
                  ),
                  b / 2e3
                );
          }
          p.add(
            punchgs.TweenLite.set(d.find(".defaultimg"), { autoAlpha: 1 }),
            0
          ),
            p.add(
              punchgs.TweenLite.set(l.find("defaultimg"), { autoAlpha: 1 }),
              0
            );
        }
        if (26 == e) {
          var Q = 0;
          (b = 0),
            p.add(
              punchgs.TweenLite.fromTo(
                d,
                b / 1e3,
                { autoAlpha: 0 },
                { autoAlpha: 1, force3D: "auto", ease: y }
              ),
              0
            ),
            p.add(
              punchgs.TweenLite.to(l, b / 1e3, {
                autoAlpha: 0,
                force3D: "auto",
                ease: y,
              }),
              0
            ),
            p.add(
              punchgs.TweenLite.set(d.find(".defaultimg"), { autoAlpha: 1 }),
              0
            ),
            p.add(
              punchgs.TweenLite.set(l.find("defaultimg"), { autoAlpha: 1 }),
              0
            );
        }
        if (12 == e || 13 == e || 14 == e || 15 == e) {
          (b = b),
            b > c.delay && (b = c.delay),
            setTimeout(function () {
              punchgs.TweenLite.set(l.find(".defaultimg"), { autoAlpha: 0 });
            }, 100);
          var q = c.width,
            Z = c.height,
            J = d.find(".slotslide, .defaultvid"),
            $ = 0,
            U = 0,
            K = 1,
            G = 1,
            ee = 1,
            te = b / 1e3,
            ae = te;
          ("fullwidth" != c.sliderLayout && "fullscreen" != c.sliderLayout) ||
            ((q = J.width()), (Z = J.height())),
            12 == e
              ? ($ = q)
              : 15 == e
              ? ($ = 0 - q)
              : 13 == e
              ? (U = Z)
              : 14 == e && (U = 0 - Z),
            1 == v && (K = 0),
            2 == v && (K = 0),
            3 == v && (te = b / 1300),
            (4 != v && 5 != v) || (G = 0.6),
            6 == v && (G = 1.4),
            (5 != v && 6 != v) ||
              ((ee = 1.4), (K = 0), (q = 0), (Z = 0), ($ = 0), (U = 0)),
            6 == v && (ee = 0.6),
            7 == v && ((q = 0), (Z = 0));
          var ie = d.find(".slotslide"),
            oe = l.find(".slotslide, .defaultvid");
          if (
            (p.add(punchgs.TweenLite.set(s, { zIndex: 15 }), 0),
            p.add(punchgs.TweenLite.set(n, { zIndex: 20 }), 0),
            8 == v
              ? (p.add(punchgs.TweenLite.set(s, { zIndex: 20 }), 0),
                p.add(punchgs.TweenLite.set(n, { zIndex: 15 }), 0),
                p.add(
                  punchgs.TweenLite.set(ie, {
                    left: 0,
                    top: 0,
                    scale: 1,
                    opacity: 1,
                    rotation: 0,
                    ease: y,
                    force3D: "auto",
                  }),
                  0
                ))
              : p.add(
                  punchgs.TweenLite.from(ie, te, {
                    left: $,
                    top: U,
                    scale: ee,
                    opacity: K,
                    rotation: c.rotate,
                    ease: y,
                    force3D: "auto",
                  }),
                  0
                ),
            (4 != v && 5 != v) || ((q = 0), (Z = 0)),
            1 != v)
          )
            switch (e) {
              case 12:
                p.add(
                  punchgs.TweenLite.to(oe, ae, {
                    left: 0 - q + "px",
                    force3D: "auto",
                    scale: G,
                    opacity: K,
                    rotation: c.rotate,
                    ease: _,
                  }),
                  0
                );
                break;
              case 15:
                p.add(
                  punchgs.TweenLite.to(oe, ae, {
                    left: q + "px",
                    force3D: "auto",
                    scale: G,
                    opacity: K,
                    rotation: c.rotate,
                    ease: _,
                  }),
                  0
                );
                break;
              case 13:
                p.add(
                  punchgs.TweenLite.to(oe, ae, {
                    top: 0 - Z + "px",
                    force3D: "auto",
                    scale: G,
                    opacity: K,
                    rotation: c.rotate,
                    ease: _,
                  }),
                  0
                );
                break;
              case 14:
                p.add(
                  punchgs.TweenLite.to(oe, ae, {
                    top: Z + "px",
                    force3D: "auto",
                    scale: G,
                    opacity: K,
                    rotation: c.rotate,
                    ease: _,
                  }),
                  0
                );
            }
        }
        if (16 == e) {
          var j = new punchgs.TimelineLite();
          p.add(
            punchgs.TweenLite.set(s, { position: "absolute", "z-index": 20 }),
            0
          ),
            p.add(
              punchgs.TweenLite.set(n, { position: "absolute", "z-index": 15 }),
              0
            ),
            s.wrapInner(
              '<div class="tp-half-one" style="position:relative; width:100%;height:100%"></div>'
            ),
            s
              .find(".tp-half-one")
              .clone(!0)
              .appendTo(s)
              .addClass("tp-half-two"),
            s.find(".tp-half-two").removeClass("tp-half-one");
          var q = c.width,
            Z = c.height;
          "on" == c.autoHeight && (Z = a.height()),
            s
              .find(".tp-half-one .defaultimg")
              .wrap(
                '<div class="tp-papercut" style="width:' +
                  q +
                  "px;height:" +
                  Z +
                  'px;"></div>'
              ),
            s
              .find(".tp-half-two .defaultimg")
              .wrap(
                '<div class="tp-papercut" style="width:' +
                  q +
                  "px;height:" +
                  Z +
                  'px;"></div>'
              ),
            s
              .find(".tp-half-two .defaultimg")
              .css({ position: "absolute", top: "-50%" }),
            s
              .find(".tp-half-two .tp-caption")
              .wrapAll(
                '<div style="position:absolute;top:-50%;left:0px;"></div>'
              ),
            p.add(
              punchgs.TweenLite.set(s.find(".tp-half-two"), {
                width: q,
                height: Z,
                overflow: "hidden",
                zIndex: 15,
                position: "absolute",
                top: Z / 2,
                left: "0px",
                transformPerspective: 600,
                transformOrigin: "center bottom",
              }),
              0
            ),
            p.add(
              punchgs.TweenLite.set(s.find(".tp-half-one"), {
                width: q,
                height: Z / 2,
                overflow: "visible",
                zIndex: 10,
                position: "absolute",
                top: "0px",
                left: "0px",
                transformPerspective: 600,
                transformOrigin: "center top",
              }),
              0
            );
          var re = (s.find(".defaultimg"), Math.round(20 * Math.random() - 10)),
            ne = Math.round(20 * Math.random() - 10),
            se = Math.round(20 * Math.random() - 10),
            de = 0.4 * Math.random() - 0.2,
            le = 0.4 * Math.random() - 0.2,
            pe = 1 * Math.random() + 1,
            ce = 1 * Math.random() + 1,
            ue = 0.3 * Math.random() + 0.3;
          p.add(
            punchgs.TweenLite.set(s.find(".tp-half-one"), {
              overflow: "hidden",
            }),
            0
          ),
            p.add(
              punchgs.TweenLite.fromTo(
                s.find(".tp-half-one"),
                b / 800,
                {
                  width: q,
                  height: Z / 2,
                  position: "absolute",
                  top: "0px",
                  left: "0px",
                  force3D: "auto",
                  transformOrigin: "center top",
                },
                {
                  scale: pe,
                  rotation: re,
                  y: 0 - Z - Z / 4,
                  autoAlpha: 0,
                  ease: y,
                }
              ),
              0
            ),
            p.add(
              punchgs.TweenLite.fromTo(
                s.find(".tp-half-two"),
                b / 800,
                {
                  width: q,
                  height: Z,
                  overflow: "hidden",
                  position: "absolute",
                  top: Z / 2,
                  left: "0px",
                  force3D: "auto",
                  transformOrigin: "center bottom",
                },
                {
                  scale: ce,
                  rotation: ne,
                  y: Z + Z / 4,
                  ease: y,
                  autoAlpha: 0,
                  onComplete: function () {
                    punchgs.TweenLite.set(s, {
                      position: "absolute",
                      "z-index": 15,
                    }),
                      punchgs.TweenLite.set(n, {
                        position: "absolute",
                        "z-index": 20,
                      }),
                      s.find(".tp-half-one").length > 0 &&
                        (s.find(".tp-half-one .defaultimg").unwrap(),
                        s.find(".tp-half-one .slotholder").unwrap()),
                      s.find(".tp-half-two").remove();
                  },
                }
              ),
              0
            ),
            j.add(
              punchgs.TweenLite.set(d.find(".defaultimg"), { autoAlpha: 1 }),
              0
            ),
            null != s.html() &&
              p.add(
                punchgs.TweenLite.fromTo(
                  n,
                  (b - 200) / 1e3,
                  {
                    scale: ue,
                    x: (c.width / 4) * de,
                    y: (Z / 4) * le,
                    rotation: se,
                    force3D: "auto",
                    transformOrigin: "center center",
                    ease: _,
                  },
                  { autoAlpha: 1, scale: 1, x: 0, y: 0, rotation: 0 }
                ),
                0
              ),
            p.add(j, 0);
        }
        if (
          (17 == e &&
            d.find(".slotslide").each(function (e) {
              var t = jQuery(this);
              p.add(
                punchgs.TweenLite.fromTo(
                  t,
                  b / 800,
                  {
                    opacity: 0,
                    rotationY: 0,
                    scale: 0.9,
                    rotationX: -110,
                    force3D: "auto",
                    transformPerspective: 600,
                    transformOrigin: "center center",
                  },
                  {
                    opacity: 1,
                    top: 0,
                    left: 0,
                    scale: 1,
                    rotation: 0,
                    rotationX: 0,
                    force3D: "auto",
                    rotationY: 0,
                    ease: y,
                    delay: 0.06 * e,
                  }
                ),
                0
              );
            }),
          18 == e &&
            d.find(".slotslide").each(function (e) {
              var t = jQuery(this);
              p.add(
                punchgs.TweenLite.fromTo(
                  t,
                  b / 500,
                  {
                    autoAlpha: 0,
                    rotationY: 110,
                    scale: 0.9,
                    rotationX: 10,
                    force3D: "auto",
                    transformPerspective: 600,
                    transformOrigin: "center center",
                  },
                  {
                    autoAlpha: 1,
                    top: 0,
                    left: 0,
                    scale: 1,
                    rotation: 0,
                    rotationX: 0,
                    force3D: "auto",
                    rotationY: 0,
                    ease: y,
                    delay: 0.06 * e,
                  }
                ),
                0
              );
            }),
          19 == e || 22 == e)
        ) {
          var j = new punchgs.TimelineLite();
          p.add(punchgs.TweenLite.set(s, { zIndex: 20 }), 0),
            p.add(punchgs.TweenLite.set(n, { zIndex: 20 }), 0),
            setTimeout(function () {
              l.find(".defaultimg").css({ opacity: 0 });
            }, 100);
          var he = 90,
            K = 1,
            fe = "center center ";
          1 == f && (he = -90),
            19 == e
              ? ((fe = fe + "-" + c.height / 2), (K = 0))
              : (fe += c.height / 2),
            punchgs.TweenLite.set(a, {
              transformStyle: "flat",
              backfaceVisibility: "hidden",
              transformPerspective: 600,
            }),
            d.find(".slotslide").each(function (e) {
              var t = jQuery(this);
              j.add(
                punchgs.TweenLite.fromTo(
                  t,
                  b / 1e3,
                  {
                    transformStyle: "flat",
                    backfaceVisibility: "hidden",
                    left: 0,
                    rotationY: c.rotate,
                    z: 10,
                    top: 0,
                    scale: 1,
                    force3D: "auto",
                    transformPerspective: 600,
                    transformOrigin: fe,
                    rotationX: he,
                  },
                  {
                    left: 0,
                    rotationY: 0,
                    top: 0,
                    z: 0,
                    scale: 1,
                    force3D: "auto",
                    rotationX: 0,
                    delay: (50 * e) / 1e3,
                    ease: y,
                  }
                ),
                0
              ),
                j.add(
                  punchgs.TweenLite.to(t, 0.1, {
                    autoAlpha: 1,
                    delay: (50 * e) / 1e3,
                  }),
                  0
                ),
                p.add(j);
            }),
            l.find(".slotslide").each(function (e) {
              var t = jQuery(this),
                a = -90;
              1 == f && (a = 90),
                j.add(
                  punchgs.TweenLite.fromTo(
                    t,
                    b / 1e3,
                    {
                      transformStyle: "flat",
                      backfaceVisibility: "hidden",
                      autoAlpha: 1,
                      rotationY: 0,
                      top: 0,
                      z: 0,
                      scale: 1,
                      force3D: "auto",
                      transformPerspective: 600,
                      transformOrigin: fe,
                      rotationX: 0,
                    },
                    {
                      autoAlpha: 1,
                      rotationY: c.rotate,
                      top: 0,
                      z: 10,
                      scale: 1,
                      rotationX: a,
                      delay: (50 * e) / 1e3,
                      force3D: "auto",
                      ease: _,
                    }
                  ),
                  0
                ),
                p.add(j);
            }),
            p.add(punchgs.TweenLite.set(s, { zIndex: 18 }), 0);
        }
        if (20 == e) {
          if (
            (setTimeout(function () {
              l.find(".defaultimg").css({ opacity: 0 });
            }, 100),
            1 == f)
          )
            var ge = -c.width,
              he = 80,
              fe = "20% 70% -" + c.height / 2;
          else
            var ge = c.width,
              he = -80,
              fe = "80% 70% -" + c.height / 2;
          d.find(".slotslide").each(function (e) {
            var t = jQuery(this),
              a = (50 * e) / 1e3;
            p.add(
              punchgs.TweenLite.fromTo(
                t,
                b / 1e3,
                {
                  left: ge,
                  rotationX: 40,
                  z: -600,
                  opacity: K,
                  top: 0,
                  scale: 1,
                  force3D: "auto",
                  transformPerspective: 600,
                  transformOrigin: fe,
                  transformStyle: "flat",
                  rotationY: he,
                },
                {
                  left: 0,
                  rotationX: 0,
                  opacity: 1,
                  top: 0,
                  z: 0,
                  scale: 1,
                  rotationY: 0,
                  delay: a,
                  ease: y,
                }
              ),
              0
            );
          }),
            l.find(".slotslide").each(function (e) {
              var t = jQuery(this),
                a = (50 * e) / 1e3;
              if (((a = e > 0 ? a + b / 9e3 : 0), 1 != f))
                var i = -c.width / 2,
                  o = 30,
                  r = "20% 70% -" + c.height / 2;
              else
                var i = c.width / 2,
                  o = -30,
                  r = "80% 70% -" + c.height / 2;
              (_ = punchgs.Power2.easeInOut),
                p.add(
                  punchgs.TweenLite.fromTo(
                    t,
                    b / 1e3,
                    {
                      opacity: 1,
                      rotationX: 0,
                      top: 0,
                      z: 0,
                      scale: 1,
                      left: 0,
                      force3D: "auto",
                      transformPerspective: 600,
                      transformOrigin: r,
                      transformStyle: "flat",
                      rotationY: 0,
                    },
                    {
                      opacity: 1,
                      rotationX: 20,
                      top: 0,
                      z: -600,
                      left: i,
                      force3D: "auto",
                      rotationY: o,
                      delay: a,
                      ease: _,
                    }
                  ),
                  0
                );
            });
        }
        if (21 == e || 25 == e) {
          setTimeout(function () {
            l.find(".defaultimg").css({ opacity: 0 });
          }, 100);
          var he = 90,
            ge = -c.width,
            me = -he;
          if (1 == f)
            if (25 == e) {
              var fe = "center top 0";
              he = c.rotate;
            } else {
              var fe = "left center 0";
              me = c.rotate;
            }
          else if (((ge = c.width), (he = -90), 25 == e)) {
            var fe = "center bottom 0";
            (me = -he), (he = c.rotate);
          } else {
            var fe = "right center 0";
            me = c.rotate;
          }
          d.find(".slotslide").each(function (e) {
            var t = jQuery(this),
              a = b / 1.5 / 3;
            p.add(
              punchgs.TweenLite.fromTo(
                t,
                (2 * a) / 1e3,
                {
                  left: 0,
                  transformStyle: "flat",
                  rotationX: me,
                  z: 0,
                  autoAlpha: 0,
                  top: 0,
                  scale: 1,
                  force3D: "auto",
                  transformPerspective: 1200,
                  transformOrigin: fe,
                  rotationY: he,
                },
                {
                  left: 0,
                  rotationX: 0,
                  top: 0,
                  z: 0,
                  autoAlpha: 1,
                  scale: 1,
                  rotationY: 0,
                  force3D: "auto",
                  delay: a / 1e3,
                  ease: y,
                }
              ),
              0
            );
          }),
            1 != f
              ? ((ge = -c.width),
                (he = 90),
                25 == e
                  ? ((fe = "center top 0"), (me = -he), (he = c.rotate))
                  : ((fe = "left center 0"), (me = c.rotate)))
              : ((ge = c.width),
                (he = -90),
                25 == e
                  ? ((fe = "center bottom 0"), (me = -he), (he = c.rotate))
                  : ((fe = "right center 0"), (me = c.rotate))),
            l.find(".slotslide").each(function (e) {
              var t = jQuery(this);
              p.add(
                punchgs.TweenLite.fromTo(
                  t,
                  b / 1e3,
                  {
                    left: 0,
                    transformStyle: "flat",
                    rotationX: 0,
                    z: 0,
                    autoAlpha: 1,
                    top: 0,
                    scale: 1,
                    force3D: "auto",
                    transformPerspective: 1200,
                    transformOrigin: fe,
                    rotationY: 0,
                  },
                  {
                    left: 0,
                    rotationX: me,
                    top: 0,
                    z: 0,
                    autoAlpha: 1,
                    force3D: "auto",
                    scale: 1,
                    rotationY: he,
                    ease: _,
                  }
                ),
                0
              );
            });
        }
        if (23 == e || 24 == e) {
          setTimeout(function () {
            l.find(".defaultimg").css({ opacity: 0 });
          }, 100);
          var he = -90,
            K = 1;
          if ((1 == f && (he = 90), 23 == e)) {
            var fe = "center center -" + c.width / 2;
            K = 0;
          } else var fe = "center center " + c.width / 2;
          punchgs.TweenLite.set(a, {
            transformStyle: "preserve-3d",
            backfaceVisibility: "hidden",
            perspective: 2500,
          }),
            d.find(".slotslide").each(function (e) {
              var t = jQuery(this);
              p.add(
                punchgs.TweenLite.fromTo(
                  t,
                  b / 1e3,
                  {
                    left: 0,
                    rotationX: c.rotate,
                    force3D: "auto",
                    opacity: K,
                    top: 0,
                    scale: 1,
                    transformPerspective: 1200,
                    transformOrigin: fe,
                    rotationY: he,
                  },
                  {
                    left: 0,
                    rotationX: 0,
                    autoAlpha: 1,
                    top: 0,
                    z: 0,
                    scale: 1,
                    rotationY: 0,
                    delay: (50 * e) / 500,
                    ease: y,
                  }
                ),
                0
              );
            }),
            (he = 90),
            1 == f && (he = -90),
            l.find(".slotslide").each(function (t) {
              var a = jQuery(this);
              p.add(
                punchgs.TweenLite.fromTo(
                  a,
                  b / 1e3,
                  {
                    left: 0,
                    rotationX: 0,
                    top: 0,
                    z: 0,
                    scale: 1,
                    force3D: "auto",
                    transformStyle: "flat",
                    transformPerspective: 1200,
                    transformOrigin: fe,
                    rotationY: 0,
                  },
                  {
                    left: 0,
                    rotationX: c.rotate,
                    top: 0,
                    scale: 1,
                    rotationY: he,
                    delay: (50 * t) / 500,
                    ease: _,
                  }
                ),
                0
              ),
                23 == e &&
                  p.add(
                    punchgs.TweenLite.fromTo(
                      a,
                      b / 2e3,
                      { autoAlpha: 1 },
                      { autoAlpha: 0, delay: (50 * t) / 500 + b / 3e3, ease: _ }
                    ),
                    0
                  );
            });
        }
        return p;
      };
  })(jQuery),
  (function (e) {
    "use strict";
    function t(e) {
      return void 0 == e
        ? -1
        : jQuery.isNumeric(e)
        ? e
        : e.split(":").length > 1
        ? 60 * parseInt(e.split(":")[0], 0) + parseInt(e.split(":")[1], 0)
        : e;
    }
    var a = jQuery.fn.revolution,
      i = a.is_mobile(),
      o = {
        alias: "Video Min JS",
        name: "revolution.extensions.video.min.js",
        min_core: "5.3",
        version: "2.0.1",
      };
    jQuery.extend(!0, a, {
      preLoadAudio: function (e, t) {
        return (
          "stop" !== a.compare_version(o).check &&
          void e.find(".tp-audiolayer").each(function () {
            var e = jQuery(this),
              i = {};
            0 === e.find("audio").length &&
              ((i.src = void 0 != e.data("videomp4") ? e.data("videomp4") : ""),
              (i.pre = e.data("videopreload") || ""),
              void 0 === e.attr("id") &&
                e.attr("audio-layer-" + Math.round(199999 * Math.random())),
              (i.id = e.attr("id")),
              (i.status = "prepared"),
              (i.start = jQuery.now()),
              (i.waittime = 1e3 * e.data("videopreloadwait") || 5e3),
              ("auto" != i.pre &&
                "canplaythrough" != i.pre &&
                "canplay" != i.pre &&
                "progress" != i.pre) ||
                (void 0 === t.audioqueue && (t.audioqueue = []),
                t.audioqueue.push(i),
                a.manageVideoLayer(e, t)));
          })
        );
      },
      preLoadAudioDone: function (e, t, a) {
        t.audioqueue &&
          t.audioqueue.length > 0 &&
          jQuery.each(t.audioqueue, function (t, i) {
            e.data("videomp4") !== i.src ||
              (i.pre !== a && "auto" !== i.pre) ||
              (i.status = "loaded");
          });
      },
      resetVideo: function (e, o) {
        var r = e.data();
        switch (r.videotype) {
          case "youtube":
            r.player;
            try {
              if ("on" == r.forcerewind) {
                var n = t(e.data("videostartat")),
                  s = -1 == n,
                  d = 1 === r.bgvideo || e.find(".tp-videoposter").length > 0;
                (n = -1 == n ? 0 : n),
                  void 0 != r.player &&
                    ((0 !== n && !s) || d) &&
                    (r.player.seekTo(n), r.player.pauseVideo());
              }
            } catch (e) {}
            0 == e.find(".tp-videoposter").length &&
              1 !== r.bgvideo &&
              punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                autoAlpha: 1,
                display: "block",
                ease: punchgs.Power3.easeInOut,
              });
            break;
          case "vimeo":
            var l = $f(e.find("iframe").attr("id"));
            try {
              if ("on" == r.forcerewind) {
                var n = t(r.videostartat),
                  s = -1 == n,
                  d = 1 === r.bgvideo || e.find(".tp-videoposter").length > 0;
                ((0 !== (n = -1 == n ? 0 : n) && !s) || d) &&
                  (l.api("seekTo", n), l.api("pause"));
              }
            } catch (e) {}
            0 == e.find(".tp-videoposter").length &&
              1 !== r.bgvideo &&
              punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                autoAlpha: 1,
                display: "block",
                ease: punchgs.Power3.easeInOut,
              });
            break;
          case "html5":
            if (i && 1 == r.disablevideoonmobile) return !1;
            var p = "html5" == r.audio ? "audio" : "video",
              c = e.find(p),
              u = c[0];
            if (
              (punchgs.TweenLite.to(c, 0.3, {
                autoAlpha: 1,
                display: "block",
                ease: punchgs.Power3.easeInOut,
              }),
              "on" == r.forcerewind && !e.hasClass("videoisplaying"))
            )
              try {
                var n = t(r.videostartat);
                u.currentTime = -1 == n ? 0 : n;
              } catch (e) {}
            ("mute" == r.volume ||
              a.lastToggleState(e.videomutetoggledby) ||
              !0 === o.globalmute) &&
              (u.muted = !0);
        }
      },
      isVideoMuted: function (e, t) {
        var a = !1,
          i = e.data();
        switch (i.videotype) {
          case "youtube":
            try {
              a = i.player.isMuted();
            } catch (e) {}
            break;
          case "vimeo":
            try {
              $f(e.find("iframe").attr("id")), "mute" == i.volume && (a = !0);
            } catch (e) {}
            break;
          case "html5":
            var o = "html5" == i.audio ? "audio" : "video";
            e.find(o)[0].muted && (a = !0);
        }
        return a;
      },
      muteVideo: function (e, t) {
        var a = e.data();
        switch (a.videotype) {
          case "youtube":
            try {
              a.player.mute();
            } catch (e) {}
            break;
          case "vimeo":
            try {
              var i = $f(e.find("iframe").attr("id"));
              e.data("volume", "mute"), i.api("setVolume", 0);
            } catch (e) {}
            break;
          case "html5":
            var o = "html5" == a.audio ? "audio" : "video";
            e.find(o)[0].muted = !0;
        }
      },
      unMuteVideo: function (e, t) {
        if (!0 !== t.globalmute) {
          var a = e.data();
          switch (a.videotype) {
            case "youtube":
              try {
                a.player.unMute();
              } catch (e) {}
              break;
            case "vimeo":
              try {
                var i = $f(e.find("iframe").attr("id"));
                e.data("volume", "1"), i.api("setVolume", 1);
              } catch (e) {}
              break;
            case "html5":
              var o = "html5" == a.audio ? "audio" : "video";
              e.find(o)[0].muted = !1;
          }
        }
      },
      stopVideo: function (e, t) {
        var a = e.data();
        switch (
          (t.leaveViewPortBasedStop || (t.lastplayedvideos = []),
          (t.leaveViewPortBasedStop = !1),
          a.videotype)
        ) {
          case "youtube":
            try {
              var i = a.player;
              if (2 === i.getPlayerState() || 5 === i.getPlayerState()) return;
              i.pauseVideo(),
                (a.youtubepausecalled = !0),
                setTimeout(function () {
                  a.youtubepausecalled = !1;
                }, 80);
            } catch (e) {}
            break;
          case "vimeo":
            try {
              $f(e.find("iframe").attr("id")).api("pause"),
                (a.vimeopausecalled = !0),
                setTimeout(function () {
                  a.vimeopausecalled = !1;
                }, 80);
            } catch (e) {}
            break;
          case "html5":
            var o = "html5" == a.audio ? "audio" : "video",
              r = e.find(o),
              n = r[0];
            void 0 != r && void 0 != n && n.pause();
        }
      },
      playVideo: function (e, o) {
        clearTimeout(e.data("videoplaywait"));
        var n = e.data();
        switch (n.videotype) {
          case "youtube":
            if (0 == e.find("iframe").length)
              e.append(e.data("videomarkup")), s(e, o, !0);
            else if (void 0 != n.player.playVideo) {
              var d = t(e.data("videostartat")),
                l = n.player.getCurrentTime();
              1 == e.data("nextslideatend-triggered") &&
                ((l = -1), e.data("nextslideatend-triggered", 0)),
                -1 != d && d > l && n.player.seekTo(d),
                !0 !== n.youtubepausecalled && n.player.playVideo();
            } else
              e.data(
                "videoplaywait",
                setTimeout(function () {
                  !0 !== n.youtubepausecalled && a.playVideo(e, o);
                }, 50)
              );
            break;
          case "vimeo":
            if (0 == e.find("iframe").length)
              e.append(e.data("videomarkup")), s(e, o, !0);
            else if (e.hasClass("rs-apiready")) {
              var p = e.find("iframe").attr("id"),
                c = $f(p);
              void 0 == c.api("play")
                ? e.data(
                    "videoplaywait",
                    setTimeout(function () {
                      !0 !== n.vimeopausecalled && a.playVideo(e, o);
                    }, 50)
                  )
                : setTimeout(function () {
                    c.api("play");
                    var a = t(e.data("videostartat")),
                      i = e.data("currenttime");
                    1 == e.data("nextslideatend-triggered") &&
                      ((i = -1), e.data("nextslideatend-triggered", 0)),
                      -1 != a && a > i && c.api("seekTo", a);
                  }, 510);
            } else
              e.data(
                "videoplaywait",
                setTimeout(function () {
                  !0 !== n.vimeopausecalled && a.playVideo(e, o);
                }, 50)
              );
            break;
          case "html5":
            if (i && 1 == e.data("disablevideoonmobile")) return !1;
            var u = "html5" == n.audio ? "audio" : "video",
              h = e.find(u),
              f = h[0];
            if (1 != h.parent().data("metaloaded"))
              r(
                f,
                "loadedmetadata",
                (function (e) {
                  a.resetVideo(e, o), f.play();
                  var i = t(e.data("videostartat")),
                    r = f.currentTime;
                  1 == e.data("nextslideatend-triggered") &&
                    ((r = -1), e.data("nextslideatend-triggered", 0)),
                    -1 != i && i > r && (f.currentTime = i);
                })(e)
              );
            else {
              f.play();
              var d = t(e.data("videostartat")),
                l = f.currentTime;
              1 == e.data("nextslideatend-triggered") &&
                ((l = -1), e.data("nextslideatend-triggered", 0)),
                -1 != d && d > l && (f.currentTime = d);
            }
        }
      },
      isVideoPlaying: function (e, t) {
        var a = !1;
        return (
          void 0 != t.playingvideos &&
            jQuery.each(t.playingvideos, function (t, i) {
              e.attr("id") == i.attr("id") && (a = !0);
            }),
          a
        );
      },
      removeMediaFromList: function (e, t) {
        u(e, t);
      },
      prepareCoveredVideo: function (e, t, i) {
        var o = i.find("iframe, video"),
          r = e.split(":")[0],
          n = e.split(":")[1],
          s = i.closest(".tp-revslider-slidesli"),
          d = s.width() / s.height(),
          l = r / n,
          p = (d / l) * 100,
          c = (l / d) * 100;
        d > l
          ? punchgs.TweenLite.to(o, 0.001, {
              height: p + "%",
              width: "100%",
              top: -(p - 100) / 2 + "%",
              left: "0px",
              position: "absolute",
            })
          : punchgs.TweenLite.to(o, 0.001, {
              width: c + "%",
              height: "100%",
              left: -(c - 100) / 2 + "%",
              top: "0px",
              position: "absolute",
            }),
          o.hasClass("resizelistener") ||
            (o.addClass("resizelistener"),
            jQuery(window).resize(function () {
              clearTimeout(o.data("resizelistener")),
                o.data(
                  "resizelistener",
                  setTimeout(function () {
                    a.prepareCoveredVideo(e, t, i);
                  }, 30)
                );
            }));
      },
      checkVideoApis: function (e, t, a) {
        if (
          (location.protocol,
          (void 0 != e.data("ytid") ||
            (e.find("iframe").length > 0 &&
              e.find("iframe").attr("src").toLowerCase().indexOf("youtube") >
                0)) &&
            (t.youtubeapineeded = !0),
          (void 0 != e.data("ytid") ||
            (e.find("iframe").length > 0 &&
              e.find("iframe").attr("src").toLowerCase().indexOf("youtube") >
                0)) &&
            0 == a.addedyt)
        ) {
          (t.youtubestarttime = jQuery.now()), (a.addedyt = 1);
          var i = document.createElement("script");
          i.src = "https://www.youtube.com/iframe_api";
          var o = document.getElementsByTagName("script")[0],
            r = !0;
          jQuery("head")
            .find("*")
            .each(function () {
              "https://www.youtube.com/iframe_api" ==
                jQuery(this).attr("src") && (r = !1);
            }),
            r && o.parentNode.insertBefore(i, o);
        }
        if (
          ((void 0 != e.data("vimeoid") ||
            (e.find("iframe").length > 0 &&
              e.find("iframe").attr("src").toLowerCase().indexOf("vimeo") >
                0)) &&
            (t.vimeoapineeded = !0),
          (void 0 != e.data("vimeoid") ||
            (e.find("iframe").length > 0 &&
              e.find("iframe").attr("src").toLowerCase().indexOf("vimeo") >
                0)) &&
            0 == a.addedvim)
        ) {
          (t.vimeostarttime = jQuery.now()), (a.addedvim = 1);
          var n = document.createElement("script"),
            o = document.getElementsByTagName("script")[0],
            r = !0;
          (n.src = "https://secure-a.vimeocdn.com/js/froogaloop2.min.js"),
            jQuery("head")
              .find("*")
              .each(function () {
                "https://secure-a.vimeocdn.com/js/froogaloop2.min.js" ==
                  jQuery(this).attr("src") && (r = !1);
              }),
            r && o.parentNode.insertBefore(n, o);
        }
        return a;
      },
      manageVideoLayer: function (e, n, d, l) {
        if ("stop" === a.compare_version(o).check) return !1;
        var c = e.data(),
          u = c.videoattributes,
          h = c.ytid,
          f = c.vimeoid,
          g =
            "auto" === c.videopreload ||
            "canplay" === c.videopreload ||
            "canplaythrough" === c.videopreload ||
            "progress" === c.videopreload
              ? "auto"
              : c.videopreload,
          m = c.videomp4,
          v = c.videowebm,
          w = c.videoogv,
          b = c.allowfullscreenvideo,
          y = c.videocontrols,
          _ = "http",
          x =
            "loop" == c.videoloop
              ? "loop"
              : "loopandnoslidestop" == c.videoloop
              ? "loop"
              : "",
          T =
            void 0 != m || void 0 != v
              ? "html5"
              : void 0 != h && String(h).length > 1
              ? "youtube"
              : void 0 != f && String(f).length > 1
              ? "vimeo"
              : "none",
          L = "html5" == c.audio ? "audio" : "video",
          k =
            "html5" == T && 0 == e.find(L).length
              ? "html5"
              : "youtube" == T && 0 == e.find("iframe").length
              ? "youtube"
              : "vimeo" == T && 0 == e.find("iframe").length
              ? "vimeo"
              : "none";
        switch (
          ((x = !0 === c.nextslideatend ? "" : x), (c.videotype = T), k)
        ) {
          case "html5":
            "controls" != y && (y = "");
            var L = "video";
            "html5" == c.audio && ((L = "audio"), e.addClass("tp-audio-html5"));
            var j =
              "<" +
              L +
              ' style="object-fit:cover;background-size:cover;visible:hidden;width:100%; height:100%" class="" ' +
              x +
              ' preload="' +
              g +
              '">';
            "auto" == g && (n.mediapreload = !0),
              void 0 != v &&
                "firefox" == a.get_browser().toLowerCase() &&
                (j = j + '<source src="' + v + '" type="video/webm" />'),
              void 0 != m &&
                (j = j + '<source src="' + m + '" type="video/mp4" />'),
              void 0 != w &&
                (j = j + '<source src="' + w + '" type="video/ogg" />'),
              (j = j + "</" + L + ">");
            var z = "";
            ("true" !== b && !0 !== b) ||
              (z =
                '<div class="tp-video-button-wrap"><button  type="button" class="tp-video-button tp-vid-full-screen">Full-Screen</button></div>'),
              "controls" == y &&
                (j +=
                  '<div class="tp-video-controls"><div class="tp-video-button-wrap"><button type="button" class="tp-video-button tp-vid-play-pause">Play</button></div><div class="tp-video-seek-bar-wrap"><input  type="range" class="tp-seek-bar" value="0"></div><div class="tp-video-button-wrap"><button  type="button" class="tp-video-button tp-vid-mute">Mute</button></div><div class="tp-video-vol-bar-wrap"><input  type="range" class="tp-volume-bar" min="0" max="1" step="0.1" value="1"></div>' +
                  z +
                  "</div>"),
              e.data("videomarkup", j),
              e.append(j),
              ((i && 1 == e.data("disablevideoonmobile")) || a.isIE(8)) &&
                e.find(L).remove(),
              e.find(L).each(function (t) {
                var i = this,
                  o = jQuery(this);
                o.parent().hasClass("html5vid") ||
                  o.wrap(
                    '<div class="html5vid" style="position:relative;top:0px;left:0px;width:100%;height:100%; overflow:hidden;"></div>'
                  ),
                  1 != o.parent().data("metaloaded") &&
                    r(
                      i,
                      "loadedmetadata",
                      (function (e) {
                        p(e, n), a.resetVideo(e, n);
                      })(e)
                    );
              });
            break;
          case "youtube":
            (_ = "https"),
              "none" == y &&
                ((u = u.replace("controls=1", "controls=0")),
                -1 == u.toLowerCase().indexOf("controls") &&
                  (u += "&controls=0")),
              (!0 !== c.videoinline &&
                "true" !== c.videoinline &&
                1 !== c.videoinline) ||
                (u += "&playsinline=1");
            var Q = t(e.data("videostartat")),
              I = t(e.data("videoendat"));
            -1 != Q && (u = u + "&start=" + Q),
              -1 != I && (u = u + "&end=" + I);
            var M = u.split("origin=" + _ + "://"),
              O = "";
            M.length > 1
              ? ((O = M[0] + "origin=" + _ + "://"),
                self.location.href.match(/www/gi) &&
                  !M[1].match(/www/gi) &&
                  (O += "www."),
                (O += M[1]))
              : (O = u);
            var C = "true" === b || !0 === b ? "allowfullscreen" : "";
            e.data(
              "videomarkup",
              '<iframe style="visible:hidden" type="text/html" src="' +
                _ +
                "://www.youtube.com/embed/" +
                h +
                "?" +
                O +
                '" ' +
                C +
                ' width="100%" height="100%" style="width:100%;height:100%"></iframe>'
            );
            break;
          case "vimeo":
            (_ = "https"),
              e.data(
                "videomarkup",
                '<iframe style="visible:hidden" src="' +
                  _ +
                  "://player.vimeo.com/video/" +
                  f +
                  "?autoplay=0&" +
                  u +
                  '" webkitallowfullscreen mozallowfullscreen allowfullscreen width="100%" height="100%" style="100%;height:100%"></iframe>'
              );
        }
        var S = i && "on" == e.data("noposteronmobile");
        if (void 0 != c.videoposter && c.videoposter.length > 2 && !S)
          0 == e.find(".tp-videoposter").length &&
            e.append(
              '<div class="tp-videoposter noSwipe" style="cursor:pointer; position:absolute;top:0px;left:0px;width:100%;height:100%;z-index:3;background-image:url(' +
                c.videoposter +
                '); background-size:cover;background-position:center center;"></div>'
            ),
            0 == e.find("iframe").length &&
              e.find(".tp-videoposter").click(function () {
                if ((a.playVideo(e, n), i)) {
                  if (1 == e.data("disablevideoonmobile")) return !1;
                  punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                    autoAlpha: 0,
                    force3D: "auto",
                    ease: punchgs.Power3.easeInOut,
                  }),
                    punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                      autoAlpha: 1,
                      display: "block",
                      ease: punchgs.Power3.easeInOut,
                    });
                }
              });
        else {
          if (i && 1 == e.data("disablevideoonmobile")) return !1;
          0 != e.find("iframe").length ||
            ("youtube" != T && "vimeo" != T) ||
            (e.append(e.data("videomarkup")), s(e, n, !1));
        }
        "none" != e.data("dottedoverlay") &&
          void 0 != e.data("dottedoverlay") &&
          1 != e.find(".tp-dottedoverlay").length &&
          e.append(
            '<div class="tp-dottedoverlay ' +
              e.data("dottedoverlay") +
              '"></div>'
          ),
          e.addClass("HasListener"),
          1 == e.data("bgvideo") &&
            punchgs.TweenLite.set(e.find("video, iframe"), { autoAlpha: 0 });
      },
    });
    var r = function (e, t, a) {
        e.addEventListener
          ? e.addEventListener(t, a, { capture: !1, passive: !0 })
          : e.attachEvent(t, a, { capture: !1, passive: !0 });
      },
      n = function (e, t, a) {
        var i = {};
        return (i.video = e), (i.videotype = t), (i.settings = a), i;
      },
      s = function (e, o, r) {
        var s = e.data(),
          p = e.find("iframe"),
          h = "iframe" + Math.round(1e5 * Math.random() + 1),
          f = s.videoloop,
          g = "loopandnoslidestop" != f;
        if (
          ((f = "loop" == f || "loopandnoslidestop" == f),
          1 == e.data("forcecover"))
        ) {
          e.removeClass("fullscreenvideo").addClass("coverscreenvideo");
          var m = e.data("aspectratio");
          void 0 != m &&
            m.split(":").length > 1 &&
            a.prepareCoveredVideo(m, o, e);
        }
        if (1 == e.data("bgvideo")) {
          var m = e.data("aspectratio");
          void 0 != m &&
            m.split(":").length > 1 &&
            a.prepareCoveredVideo(m, o, e);
        }
        if (
          (p.attr("id", h),
          r && e.data("startvideonow", !0),
          1 !== e.data("videolistenerexist"))
        )
          switch (s.videotype) {
            case "youtube":
              var v = new YT.Player(h, {
                events: {
                  onStateChange: function (i) {
                    var r = e.closest(".tp-simpleresponsive"),
                      p = (s.videorate, e.data("videostart"), l());
                    if (i.data == YT.PlayerState.PLAYING)
                      punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                        autoAlpha: 0,
                        force3D: "auto",
                        ease: punchgs.Power3.easeInOut,
                      }),
                        punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                          autoAlpha: 1,
                          display: "block",
                          ease: punchgs.Power3.easeInOut,
                        }),
                        "mute" == e.data("volume") ||
                        a.lastToggleState(e.data("videomutetoggledby")) ||
                        !0 === o.globalmute
                          ? v.mute()
                          : (v.unMute(),
                            v.setVolume(parseInt(e.data("volume"), 0) || 75)),
                        (o.videoplaying = !0),
                        c(e, o),
                        g ? o.c.trigger("stoptimer") : (o.videoplaying = !1),
                        o.c.trigger(
                          "revolution.slide.onvideoplay",
                          n(v, "youtube", e.data())
                        ),
                        a.toggleState(s.videotoggledby);
                    else {
                      if (0 == i.data && f) {
                        var h = t(e.data("videostartat"));
                        -1 != h && v.seekTo(h),
                          v.playVideo(),
                          a.toggleState(s.videotoggledby);
                      }
                      !p &&
                        (0 == i.data || 2 == i.data) &&
                        "on" == e.data("showcoveronpause") &&
                        e.find(".tp-videoposter").length > 0 &&
                        (punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                          autoAlpha: 1,
                          force3D: "auto",
                          ease: punchgs.Power3.easeInOut,
                        }),
                        punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                          autoAlpha: 0,
                          ease: punchgs.Power3.easeInOut,
                        })),
                        -1 != i.data &&
                          3 != i.data &&
                          ((o.videoplaying = !1),
                          (o.tonpause = !1),
                          u(e, o),
                          r.trigger("starttimer"),
                          o.c.trigger(
                            "revolution.slide.onvideostop",
                            n(v, "youtube", e.data())
                          ),
                          (void 0 != o.currentLayerVideoIsPlaying &&
                            o.currentLayerVideoIsPlaying.attr("id") !=
                              e.attr("id")) ||
                            a.unToggleState(s.videotoggledby)),
                        0 == i.data && 1 == e.data("nextslideatend")
                          ? (d(),
                            e.data("nextslideatend-triggered", 1),
                            o.c.revnext(),
                            u(e, o))
                          : (u(e, o),
                            (o.videoplaying = !1),
                            r.trigger("starttimer"),
                            o.c.trigger(
                              "revolution.slide.onvideostop",
                              n(v, "youtube", e.data())
                            ),
                            (void 0 != o.currentLayerVideoIsPlaying &&
                              o.currentLayerVideoIsPlaying.attr("id") !=
                                e.attr("id")) ||
                              a.unToggleState(s.videotoggledby));
                    }
                  },
                  onReady: function (a) {
                    var o = s.videorate;
                    if (
                      (e.data("videostart"),
                      e.addClass("rs-apiready"),
                      void 0 != o && a.target.setPlaybackRate(parseFloat(o)),
                      e.find(".tp-videoposter").unbind("click"),
                      e.find(".tp-videoposter").click(function () {
                        i || v.playVideo();
                      }),
                      e.data("startvideonow"))
                    ) {
                      s.player.playVideo();
                      var r = t(e.data("videostartat"));
                      -1 != r && s.player.seekTo(r);
                    }
                    e.data("videolistenerexist", 1);
                  },
                },
              });
              e.data("player", v);
              break;
            case "vimeo":
              for (
                var w,
                  b = p.attr("src"),
                  y = {},
                  _ = b,
                  x = /([^&=]+)=([^&]*)/g;
                (w = x.exec(_));

              )
                y[decodeURIComponent(w[1])] = decodeURIComponent(w[2]);
              b =
                void 0 != y.player_id
                  ? b.replace(y.player_id, h)
                  : b + "&player_id=" + h;
              try {
                b = b.replace("api=0", "api=1");
              } catch (e) {}
              (b += "&api=1"), p.attr("src", b);
              var v = e.find("iframe")[0],
                T = (jQuery("#" + h), $f(h));
              T.addEvent("ready", function () {
                if (
                  (e.addClass("rs-apiready"),
                  T.addEvent("play", function (t) {
                    e.data("nextslidecalled", 0),
                      punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                        autoAlpha: 0,
                        force3D: "auto",
                        ease: punchgs.Power3.easeInOut,
                      }),
                      punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                        autoAlpha: 1,
                        display: "block",
                        ease: punchgs.Power3.easeInOut,
                      }),
                      o.c.trigger(
                        "revolution.slide.onvideoplay",
                        n(T, "vimeo", e.data())
                      ),
                      (o.videoplaying = !0),
                      c(e, o),
                      g ? o.c.trigger("stoptimer") : (o.videoplaying = !1),
                      "mute" == e.data("volume") ||
                      a.lastToggleState(e.data("videomutetoggledby")) ||
                      !0 === o.globalmute
                        ? T.api("setVolume", "0")
                        : T.api(
                            "setVolume",
                            parseInt(e.data("volume"), 0) / 100 || 0.75
                          ),
                      a.toggleState(s.videotoggledby);
                  }),
                  T.addEvent("playProgress", function (a) {
                    var i = t(e.data("videoendat"));
                    if (
                      (e.data("currenttime", a.seconds),
                      0 != i &&
                        Math.abs(i - a.seconds) < 0.3 &&
                        i > a.seconds &&
                        1 != e.data("nextslidecalled"))
                    )
                      if (f) {
                        T.api("play");
                        var r = t(e.data("videostartat"));
                        -1 != r && T.api("seekTo", r);
                      } else
                        1 == e.data("nextslideatend") &&
                          (e.data("nextslideatend-triggered", 1),
                          e.data("nextslidecalled", 1),
                          o.c.revnext()),
                          T.api("pause");
                  }),
                  T.addEvent("finish", function (t) {
                    u(e, o),
                      (o.videoplaying = !1),
                      o.c.trigger("starttimer"),
                      o.c.trigger(
                        "revolution.slide.onvideostop",
                        n(T, "vimeo", e.data())
                      ),
                      1 == e.data("nextslideatend") &&
                        (e.data("nextslideatend-triggered", 1), o.c.revnext()),
                      (void 0 != o.currentLayerVideoIsPlaying &&
                        o.currentLayerVideoIsPlaying.attr("id") !=
                          e.attr("id")) ||
                        a.unToggleState(s.videotoggledby);
                  }),
                  T.addEvent("pause", function (t) {
                    e.find(".tp-videoposter").length > 0 &&
                      "on" == e.data("showcoveronpause") &&
                      (punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                        autoAlpha: 1,
                        force3D: "auto",
                        ease: punchgs.Power3.easeInOut,
                      }),
                      punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                        autoAlpha: 0,
                        ease: punchgs.Power3.easeInOut,
                      })),
                      (o.videoplaying = !1),
                      (o.tonpause = !1),
                      u(e, o),
                      o.c.trigger("starttimer"),
                      o.c.trigger(
                        "revolution.slide.onvideostop",
                        n(T, "vimeo", e.data())
                      ),
                      (void 0 != o.currentLayerVideoIsPlaying &&
                        o.currentLayerVideoIsPlaying.attr("id") !=
                          e.attr("id")) ||
                        a.unToggleState(s.videotoggledby);
                  }),
                  e.find(".tp-videoposter").unbind("click"),
                  e.find(".tp-videoposter").click(function () {
                    if (!i) return T.api("play"), !1;
                  }),
                  e.data("startvideonow"))
                ) {
                  T.api("play");
                  var r = t(e.data("videostartat"));
                  -1 != r && T.api("seekTo", r);
                }
                e.data("videolistenerexist", 1);
              });
          }
        else {
          var L = t(e.data("videostartat"));
          switch (s.videotype) {
            case "youtube":
              r && (s.player.playVideo(), -1 != L && s.player.seekTo());
              break;
            case "vimeo":
              if (r) {
                var T = $f(e.find("iframe").attr("id"));
                T.api("play"), -1 != L && T.api("seekTo", L);
              }
          }
        }
      },
      d = function () {
        document.exitFullscreen
          ? document.exitFullscreen()
          : document.mozCancelFullScreen
          ? document.mozCancelFullScreen()
          : document.webkitExitFullscreen && document.webkitExitFullscreen();
      },
      l = function () {
        try {
          if (void 0 !== window.fullScreen) return window.fullScreen;
          var e = 5;
          return (
            jQuery.browser.webkit &&
              /Apple Computer/.test(navigator.vendor) &&
              (e = 42),
            screen.width == window.innerWidth &&
              Math.abs(screen.height - window.innerHeight) < e
          );
        } catch (e) {}
      },
      p = function (e, o, s) {
        if (i && 1 == e.data("disablevideoonmobile")) return !1;
        var p = e.data(),
          h = "html5" == p.audio ? "audio" : "video",
          f = e.find(h),
          g = f[0],
          m = f.parent(),
          v = p.videoloop,
          w = "loopandnoslidestop" != v;
        if (
          ((v = "loop" == v || "loopandnoslidestop" == v),
          m.data("metaloaded", 1),
          1 != e.data("bgvideo") ||
            ("none" !== p.videoloop && !1 !== p.videoloop) ||
            (w = !1),
          void 0 == f.attr("control") &&
            (0 != e.find(".tp-video-play-button").length ||
              i ||
              e.append(
                '<div class="tp-video-play-button"><i class="revicon-right-dir"></i><span class="tp-revstop">&nbsp;</span></div>'
              ),
            e
              .find("video, .tp-poster, .tp-video-play-button")
              .click(function () {
                e.hasClass("videoisplaying") ? g.pause() : g.play();
              })),
          1 == e.data("forcecover") ||
            e.hasClass("fullscreenvideo") ||
            1 == e.data("bgvideo"))
        )
          if (1 == e.data("forcecover") || 1 == e.data("bgvideo")) {
            m.addClass("fullcoveredvideo");
            var b = e.data("aspectratio") || "4:3";
            a.prepareCoveredVideo(b, o, e);
          } else m.addClass("fullscreenvideo");
        var y = e.find(".tp-vid-play-pause")[0],
          _ = e.find(".tp-vid-mute")[0],
          x = e.find(".tp-vid-full-screen")[0],
          T = e.find(".tp-seek-bar")[0],
          L = e.find(".tp-volume-bar")[0];
        void 0 != y &&
          r(y, "click", function () {
            1 == g.paused ? g.play() : g.pause();
          }),
          void 0 != _ &&
            r(_, "click", function () {
              0 == g.muted
                ? ((g.muted = !0), (_.innerHTML = "Unmute"))
                : ((g.muted = !1), (_.innerHTML = "Mute"));
            }),
          void 0 != x &&
            x &&
            r(x, "click", function () {
              g.requestFullscreen
                ? g.requestFullscreen()
                : g.mozRequestFullScreen
                ? g.mozRequestFullScreen()
                : g.webkitRequestFullscreen && g.webkitRequestFullscreen();
            }),
          void 0 != T &&
            (r(T, "change", function () {
              var e = g.duration * (T.value / 100);
              g.currentTime = e;
            }),
            r(T, "mousedown", function () {
              e.addClass("seekbardragged"), g.pause();
            }),
            r(T, "mouseup", function () {
              e.removeClass("seekbardragged"), g.play();
            })),
          r(g, "canplaythrough", function () {
            a.preLoadAudioDone(e, o, "canplaythrough");
          }),
          r(g, "canplay", function () {
            a.preLoadAudioDone(e, o, "canplay");
          }),
          r(g, "progress", function () {
            a.preLoadAudioDone(e, o, "progress");
          }),
          r(g, "timeupdate", function () {
            var a = (100 / g.duration) * g.currentTime,
              i = t(e.data("videoendat")),
              r = g.currentTime;
            if (
              (void 0 != T && (T.value = a),
              0 != i &&
                -1 != i &&
                Math.abs(i - r) <= 0.3 &&
                i > r &&
                1 != e.data("nextslidecalled"))
            )
              if (v) {
                g.play();
                var n = t(e.data("videostartat"));
                -1 != n && (g.currentTime = n);
              } else
                1 == e.data("nextslideatend") &&
                  (e.data("nextslideatend-triggered", 1),
                  e.data("nextslidecalled", 1),
                  (o.just_called_nextslide_at_htmltimer = !0),
                  o.c.revnext(),
                  setTimeout(function () {
                    o.just_called_nextslide_at_htmltimer = !1;
                  }, 1e3)),
                  g.pause();
          }),
          void 0 != L &&
            r(L, "change", function () {
              g.volume = L.value;
            }),
          r(g, "play", function () {
            e.data("nextslidecalled", 0);
            var t = e.data("volume");
            (t = void 0 != t && "mute" != t ? parseFloat(t) / 100 : t),
              !0 === o.globalmute ? (g.muted = !0) : (g.muted = !1),
              t > 1 && (t /= 100),
              "mute" == t ? (g.muted = !0) : void 0 != t && (g.volume = t),
              e.addClass("videoisplaying");
            var i = "html5" == p.audio ? "audio" : "video";
            c(e, o),
              w && "audio" != i
                ? ((o.videoplaying = !0),
                  o.c.trigger("stoptimer"),
                  o.c.trigger("revolution.slide.onvideoplay", n(g, "html5", p)))
                : ((o.videoplaying = !1),
                  "audio" != i && o.c.trigger("starttimer"),
                  o.c.trigger(
                    "revolution.slide.onvideostop",
                    n(g, "html5", p)
                  )),
              punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                autoAlpha: 0,
                force3D: "auto",
                ease: punchgs.Power3.easeInOut,
              }),
              punchgs.TweenLite.to(e.find(i), 0.3, {
                autoAlpha: 1,
                display: "block",
                ease: punchgs.Power3.easeInOut,
              });
            var r = e.find(".tp-vid-play-pause")[0],
              s = e.find(".tp-vid-mute")[0];
            void 0 != r && (r.innerHTML = "Pause"),
              void 0 != s && g.muted && (s.innerHTML = "Unmute"),
              a.toggleState(p.videotoggledby);
          }),
          r(g, "pause", function () {
            var t = "html5" == p.audio ? "audio" : "video";
            !l() &&
              e.find(".tp-videoposter").length > 0 &&
              "on" == e.data("showcoveronpause") &&
              !e.hasClass("seekbardragged") &&
              (punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                autoAlpha: 1,
                force3D: "auto",
                ease: punchgs.Power3.easeInOut,
              }),
              punchgs.TweenLite.to(e.find(t), 0.3, {
                autoAlpha: 0,
                ease: punchgs.Power3.easeInOut,
              })),
              e.removeClass("videoisplaying"),
              (o.videoplaying = !1),
              u(e, o),
              "audio" != t && o.c.trigger("starttimer"),
              o.c.trigger(
                "revolution.slide.onvideostop",
                n(g, "html5", e.data())
              );
            var i = e.find(".tp-vid-play-pause")[0];
            void 0 != i && (i.innerHTML = "Play"),
              (void 0 != o.currentLayerVideoIsPlaying &&
                o.currentLayerVideoIsPlaying.attr("id") != e.attr("id")) ||
                a.unToggleState(p.videotoggledby);
          }),
          r(g, "ended", function () {
            d(),
              u(e, o),
              (o.videoplaying = !1),
              u(e, o),
              "audio" != h && o.c.trigger("starttimer"),
              o.c.trigger(
                "revolution.slide.onvideostop",
                n(g, "html5", e.data())
              ),
              !0 === e.data("nextslideatend") &&
                g.currentTime > 0 &&
                (1 == !o.just_called_nextslide_at_htmltimer &&
                  (e.data("nextslideatend-triggered", 1),
                  o.c.revnext(),
                  (o.just_called_nextslide_at_htmltimer = !0)),
                setTimeout(function () {
                  o.just_called_nextslide_at_htmltimer = !1;
                }, 1500)),
              e.removeClass("videoisplaying");
          });
      },
      c = function (e, t) {
        void 0 == t.playingvideos && (t.playingvideos = new Array()),
          e.data("stopallvideos") &&
            void 0 != t.playingvideos &&
            t.playingvideos.length > 0 &&
            ((t.lastplayedvideos = jQuery.extend(!0, [], t.playingvideos)),
            jQuery.each(t.playingvideos, function (e, i) {
              a.stopVideo(i, t);
            })),
          t.playingvideos.push(e),
          (t.currentLayerVideoIsPlaying = e);
      },
      u = function (e, t) {
        void 0 != t.playingvideos &&
          jQuery.inArray(e, t.playingvideos) >= 0 &&
          t.playingvideos.splice(jQuery.inArray(e, t.playingvideos), 1);
      };
  })(jQuery);
