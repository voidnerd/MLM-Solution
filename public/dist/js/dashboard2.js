$(function () {
    "use strict";
    jQuery("#visitfromworld").vectorMap({
            map: "world_mill_en"
            , backgroundColor: "#fff"
            , borderColor: "#000"
            , borderOpacity: .9
            , borderWidth: 1
            , zoomOnScroll: !1
            , color: "#ddd"
            , regionStyle: {
                initial: {
                    fill: "#fff"
                    , "stroke-width": 1
                    , stroke: "#a6b7bf"
                }
            }
            , markerStyle: {
                initial: {
                    r: 5
                    , fill: "#26c6da"
                    , "fill-opacity": 1
                    , stroke: "#fff"
                    , "stroke-width": 1
                    , "stroke-opacity": 1
                }
            }
            , enableZoom: !0
            , hoverColor: "#79e580"
            , markers: [{
                latLng: [21, 78]
                , name: "India : 9347"
                , style: {
                    fill: "#24d2b5"
                }
        }, {
                latLng: [-33, 151]
                , name: "Australia : 250"
                , style: {
                    fill: "#ff9040"
                }
        }, {
                latLng: [36.77, -119.41]
                , name: "USA : 250"
                , style: {
                    fill: "#20aee3"
                }
        }, {
                latLng: [55.37, -3.41]
                , name: "UK   : 250"
                , style: {
                    fill: "#6772e5"
                }
        }, {
                latLng: [25.2, 55.27]
                , name: "UAE : 250"
                , style: {
                    fill: "#24d2b5"
                }
        }]
            , hoverOpacity: null
            , normalizeFunction: "linear"
            , scaleColors: ["#fff", "#ccc"]
            , selectedColor: "#c9dfaf"
            , selectedRegions: []
            , showTooltip: !0
            , onRegionClick: function (e, o, l) {
                var t = 'You clicked "' + l + '" which has the code: ' + o.toUpperCase();
                alert(t)
            }
        })
        // Real Time chart
    var data = []
        , totalPoints = 100;

    function getRandomData() {
        if (data.length > 0) data = data.slice(1);
        // Do a random walk
        while (data.length < totalPoints) {
            var prev = data.length > 0 ? data[data.length - 1] : 50
                , y = prev + Math.random() * 10 - 5;
            if (y < 0) {
                y = 0;
            }
            else if (y > 100) {
                y = 100;
            }
            data.push(y);
        }
        // Zip the generated y values with the x values
        var res = [];
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
        }
        return res;
    }
    // Set up the control widget
    var updateInterval = 20;
    $("#updateInterval").val(updateInterval).change(function () {
        var v = $(this).val();
        if (v && !isNaN(+v)) {
            updateInterval = +v;
            if (updateInterval < 1) {
                updateInterval = 1;
            }
            else if (updateInterval > 2000) {
                updateInterval = 2000;
            }
            $(this).val("" + updateInterval);
        }
    });
    var plot = $.plot("#placeholder", [getRandomData()], {
        series: {
            shadowSize: 0 // Drawing is faster without shadows
        }
        , yaxis: {
            min: 0
            , max: 100
        }
        , xaxis: {
            show: false
        }
        , colors: ["#01c0c8"]
        , grid: {
            color: "#AFAFAF"
            , hoverable: true
            , borderWidth: 0
            , backgroundColor: '#FFF'
        }
        , tooltip: true
        , resize: true
        , tooltipOpts: {
            content: "Y: %y"
            , defaultTheme: false
        }
    });

    function update() {
        plot.setData([getRandomData()]);
        // Since the axes don't change, we don't need to call plot.setupGrid()
        plot.draw();
        setTimeout(update, updateInterval);
    }
    update();
    
    $("body").trigger("resize");
    //This is for the perfect scroll
    
    $('.slimscrollcountry').perfectScrollbar(); 
});
//sparkline charts
var sparklineLogin = function () {
    $("#sparkline8").sparkline([2, 4, 4, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
        type: 'line'
        , width: '100%'
        , height: '50'
        , lineColor: '#99d683'
        , fillColor: '#99d683'
        , maxSpotColor: '#99d683'
        , highlightLineColor: 'rgba(0, 0, 0, 0.2)'
        , highlightSpotColor: '#99d683'
    });
    $("#sparkline9").sparkline([0, 2, 8, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
        type: 'line'
        , width: '100%'
        , height: '50'
        , lineColor: '#13dafe'
        , fillColor: '#13dafe'
        , minSpotColor: '#13dafe'
        , maxSpotColor: '#13dafe'
        , highlightLineColor: 'rgba(0, 0, 0, 0.2)'
        , highlightSpotColor: '#13dafe'
    });
    $("#sparkline10").sparkline([2, 4, 4, 6, 8, 5, 6, 4, 8, 6, 6, 2], {
        type: 'line'
        , width: '100%'
        , height: '50'
        , lineColor: '#ffdb4a'
        , fillColor: '#ffdb4a'
        , maxSpotColor: '#ffdb4a'
        , highlightLineColor: 'rgba(0, 0, 0, 0.2)'
        , highlightSpotColor: '#ffdb4a'
    });
}
var sparkResize;
$(window).resize(function (e) {
    clearTimeout(sparkResize);
    sparkResize = setTimeout(sparklineLogin, 500);
});
sparklineLogin();