(function(g){function p(){return Array.prototype.slice.call(arguments,1)}var q=g.pick,j=g.wrap,r=g.extend,o=HighchartsAdapter.fireEvent,n=g.Axis,s=g.Series;r(n.prototype,{isInBreak:function(f,d){var a=f.repeat||Infinity,c=f.from,b=f.to-f.from,a=d>=c?(d-c)%a:a-(c-d)%a;return f.inclusive?a<=b:a<b&&a!==0},isInAnyBreak:function(f,d){if(!this.options.breaks)return!1;for(var a=this.options.breaks,c=a.length,b=!1,h=!1;c--;)this.isInBreak(a[c],f)&&(b=!0,h||(h=q(a[c].showPoints,this.isXAxis?!1:!0)));return b&&
d?b&&!h:b}});j(n.prototype,"setTickPositions",function(f){f.apply(this,Array.prototype.slice.call(arguments,1));if(this.options.breaks){var d=this.tickPositions,a=this.tickPositions.info,c=[],b;if(!(a&&a.totalRange>=this.closestPointRange)){for(b=0;b<d.length;b++)this.isInAnyBreak(d[b])||c.push(d[b]);this.tickPositions=c;this.tickPositions.info=a}}});j(n.prototype,"init",function(f,d,a){if(a.breaks&&a.breaks.length)a.ordinal=!1;f.call(this,d,a);if(this.options.breaks){var c=this;c.postTranslate=!0;
this.val2lin=function(b){var h=b,a,d;for(d=0;d<c.breakArray.length;d++)if(a=c.breakArray[d],a.to<=b)h-=a.len;else if(a.from>=b)break;else if(c.isInBreak(a,b)){h-=b-a.from;break}return h};this.lin2val=function(b){var a,d;for(d=0;d<c.breakArray.length;d++)if(a=c.breakArray[d],a.from>=b)break;else a.to<b?b+=a.to-a.from:c.isInBreak(a,b)&&(b+=a.to-a.from);return b};this.setAxisTranslation=function(b){n.prototype.setAxisTranslation.call(this,b);var a=c.options.breaks,b=[],d=[],f=0,g,e,k=c.userMin||c.min,
l=c.userMax||c.max,i,m;for(m in a)e=a[m],c.isInBreak(e,k)&&(k+=e.to%e.repeat-k%e.repeat),c.isInBreak(e,l)&&(l-=l%e.repeat-e.from%e.repeat);for(m in a){e=a[m];i=e.from;for(g=e.repeat||Infinity;i-g>k;)i-=g;for(;i<k;)i+=g;for(;i<l;i+=g)b.push({value:i,move:"in"}),b.push({value:i+(e.to-e.from),move:"out",size:e.breakSize})}b.sort(function(a,b){return a.value===b.value?(a.move==="in"?0:1)-(b.move==="in"?0:1):a.value-b.value});a=0;i=k;for(m in b){e=b[m];a+=e.move==="in"?1:-1;if(a===1&&e.move==="in")i=e.value;
a===0&&(d.push({from:i,to:e.value,len:e.value-i-(e.size||0)}),f+=e.value-i-(e.size||0))}c.breakArray=d;o(c,"afterBreaks");c.transA*=(l-c.min)/(l-k-f);c.min=k;c.max=l}}});j(s.prototype,"generatePoints",function(f){f.apply(this,p(arguments));var d=this.xAxis,a=this.yAxis,c=this.points,b,h=c.length;if(d&&a&&(d.options.breaks||a.options.breaks))for(;h--;)b=c[h],(d.isInAnyBreak(b.x,!0)||a.isInAnyBreak(b.y,!0))&&c.splice(h,1)});j(g.seriesTypes.column.prototype,"drawPoints",function(f){f.apply(this);var f=
this.points,d=this.yAxis,a=d.breakArray||[],c,b,h,g,j;for(h=0;h<f.length;h++){c=f[h];j=c.stackY||c.y;for(g=0;g<a.length;g++)if(b=a[g],j<b.from)break;else j>b.to?o(d,"pointBreak",{point:c,brk:b}):o(d,"pointInBreak",{point:c,brk:b})}})})(Highcharts);
