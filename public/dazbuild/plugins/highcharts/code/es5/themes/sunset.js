!/**
 * Highcharts JS v11.4.3 (2024-05-22)
 *
 * (c) 2009-2024 Highsoft AS
 *
 * License: www.highcharts.com/license
 */function(e){"object"==typeof module&&module.exports?(e.default=e,module.exports=e):"function"==typeof define&&define.amd?define("highcharts/themes/sunset",["highcharts"],function(o){return e(o),e.Highcharts=o,e}):e("undefined"!=typeof Highcharts?Highcharts:void 0)}(function(e){"use strict";var o=e?e._modules:{};function t(e,o,t,n){e.hasOwnProperty(o)||(e[o]=n.apply(null,t),"function"==typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:o,module:e[o]}})))}t(o,"Extensions/Themes/Sunset.js",[o["Core/Defaults.js"]],function(e){var o,t,n=e.setOptions;return(o=t||(t={})).options={colors:["#FDD089","#FF7F79","#A0446E","#251535"],colorAxis:{maxColor:"#60042E",minColor:"#FDD089"},plotOptions:{map:{nullColor:"#fefefc"}},navigator:{series:{color:"#FF7F79",lineColor:"#A0446E"}}},o.apply=function(){n(o.options)},t}),t(o,"masters/themes/sunset.src.js",[o["Core/Globals.js"],o["Extensions/Themes/Sunset.js"]],function(e,o){return e.theme=o.options,o.apply(),e})});