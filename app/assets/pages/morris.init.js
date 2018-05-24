
/**
* Theme: Xadmino
* Morris Chart
*DEMO ONLY MINIFY
*/

!function(e){"use strict";var a=function(){};a.prototype.createLineChart=function(e,a,t,n,i,r){Morris.Line({element:e,data:a,xkey:t,ykeys:n,labels:i,gridLineColor:"#eef0f2",resize:!0,lineColors:r})},a.prototype.createAreaChart=function(e,a,t,n,i,r,o,l){Morris.Area({element:e,pointSize:3,lineWidth:0,data:n,xkey:i,ykeys:r,labels:o,resize:!0,gridLineColor:"#eef0f2",lineColors:l})},a.prototype.createBarChart=function(e,a,t,n,i,r){Morris.Bar({element:e,data:a,xkey:t,ykeys:n,labels:i,gridLineColor:"#eef0f2",barColors:r})},a.prototype.createDonutChart=function(e,a,t){Morris.Donut({element:e,data:a,colors:t})},a.prototype.init=function(){var e=[{y:"2009",a:100,b:90},{y:"2010",a:75,b:65},{y:"2011",a:50,b:40},{y:"2012",a:75,b:65},{y:"2013",a:50,b:40},{y:"2014",a:75,b:65},{y:"2015",a:100,b:90}];this.createLineChart("morris-line-example",e,"y",["a","b"],["Series A","Series B"],["#03a9f4","#dcdcdc"]);var a=[{y:"2009",a:10,b:20},{y:"2010",a:75,b:65},{y:"2011",a:50,b:40},{y:"2012",a:75,b:65},{y:"2013",a:50,b:40},{y:"2014",a:75,b:65},{y:"2015",a:90,b:60}];this.createAreaChart("morris-area-example",0,0,a,"y",["a","b"],["Series A","Series B"],["#03a9f4","#bdbdbd"]);var t=[{y:"2009",a:100,b:90},{y:"2010",a:75,b:65},{y:"2011",a:50,b:40},{y:"2012",a:75,b:65},{y:"2013",a:50,b:40},{y:"2014",a:75,b:65},{y:"2015",a:100,b:90}];this.createBarChart("morris-bar-example",t,"y",["a","b"],["Series A","Series B"],["#03a9f4","#dcdcdc"]);var n=[{label:"Download Sales",value:12},{label:"In-Store Sales",value:30},{label:"Mail-Order Sales",value:20}];this.createDonutChart("morris-donut-example",n,["#dcdcdc","#03a9f4","#01ba9a"])},e.MorrisCharts=new a,e.MorrisCharts.Constructor=a}(window.jQuery),function(e){"use strict";e.MorrisCharts.init()}(window.jQuery);