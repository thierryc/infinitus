/**
 * ie add HTML 5 to dom.
 *
 *
 * @package WordPress
 * @subpackage Infinitus
 * @since Infinitus 1.0
 */
var e = ("abbr,article,aside,audio,canvas,datalist,details,figcaption,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video").split(',');
for (var i = 0; i < e.length; i++) { document.createElement(e[i]); }
