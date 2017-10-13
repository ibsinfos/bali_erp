(function ( $ ) {
 
    $.fn.curren = function( options ) {
        
        var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
        // Firefox 1.0+
        var isFirefox = typeof InstallTrigger !== 'undefined';
            // At least Safari 3+: "[object HTMLElementConstructor]"
        var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
            // Internet Explorer 6-11
        var isIE = /*@cc_on!@*/false || !!document.documentMode;
            // Edge 20+
        var isEdge = !isIE && !!window.StyleMedia;
            // Chrome 1+
        var isChrome = !!window.chrome && !!window.chrome.webstore;
            // Blink engine detection
        var isBlink = (isChrome || isOpera) && !!window.CSS;

        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            symbol: "RS",
        }, options );
 
        // Greenify the collection based on the settings variable.
        return this.each(function() {
            var elem = $( this );
            var elemData = elem.data();
            $.each(elemData,function(i,o){
                if(i=='aSign'){
                    settings.symbol = o;
                }else{
                    settings[i] = o;
                }    
            })

            if(elem.prop('nodeName')=='SPAN'){
                if(elem.find('.has-symbol').length==0){
                    mL = settings.symbol.length*20;
                    preHtml = elem.html();//margin-left:-'+mL+'px;
                    mkcss = 'padding:10px 5px;display: inline-table;margin-top:-10px;';
                    markup = '<span class="has-symbol" style="'+mkcss+'">'+settings.symbol+'</span>'+preHtml;
                    elem.html(markup);
                    //elem.css('padding-left',mL+'px');
                }
            }else if(elem.prop('nodeName')=='TD'){
                if(elem.find('.has-symbol').length==0){
                    mL = settings.symbol.length*12;
                    preHtml = elem.html();//margin-left:-'+mL+'px;
                    mkcss = 'padding:10px 5px;display:inline-table;';
                    markup = '<span class="has-symbol" style="'+mkcss+'">'+settings.symbol+'</span>'+preHtml;
                    elem.html(markup);
                    //elem.css('padding-left',mL+'px');
                }
            }else if(elem.prop('nodeName')=='INPUT'){
                if(elem.prev('.has-symbol').length==0){
                    mL = settings.symbol.length*12;
                    mkcss = 'position:absolute;padding:8px 5px;';
                    markup = '<span class="has-symbol" style="'+mkcss+'">'+settings.symbol+'</span>';
                    elem.before(markup);
                    elem.css('padding-left',mL+'px');
                }
            }else{
                if(elem.find('.has-symbol').length==0){
                    mL = settings.symbol.length*20;
                    preHtml = elem.html();//margin-left:-'+mL+'px;
                    mkcss = 'padding:10px 5px;display: inline-table;margin-top:-10px;';
                    markup = '<span class="has-symbol" style="'+mkcss+'">'+settings.symbol+'</span>'+preHtml;
                    elem.html(markup);
                    //elem.css('padding-left',mL+'px');
                }
            }    

        });
 
    };
 
}( jQuery ));