(function() {
    var tagMMUnicode = function () {
        var regexMM = new RegExp("[က-အ]+");
        var timerID = undefined;
        var mmFonts = new RegExp("Zawgyi-One|Masterpiece Uni Sans|Myanmar3|Yunghkio|Parabaik|WinUni Innwa|Win Uni Innwa|Padauk|MyMyanmar|Panglong");
        var unicodeFonts = "TharLon, 'Masterpiece Uni Sans', Myanmar3, 'Myanmar Sangam MN', 'Myanmar MN', Yunghkio, Parabaik, 'WinUni Innwa','Win Uni Innwa', Padauk, Panglong, 'MyMyanmar Unicode'";
   
        // inject css rules bookmarklet source
        // by paul irish. public domain code.
        // http://paulirish.com/2008/bookmarklet-inject-new-css-rules/


        var newcss = '#respond textarea { font-family: '+unicodeFonts+'; }';
        if ('\v'=='v') /* ie only */ {
            document.createStyleSheet().cssText = newcss;
        } else {
            var tag = document.createElement('style');
            tag.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(tag);
            tag.innerHTML = newcss;
        }
        
        var dummySpanEl = document.createElement('span');
        dummySpanEl.style.fontFamily = unicodeFonts;
        unicodeFonts = dummySpanEl.style.fontFamily;

        var tagPage = function () {
            var el = document.getElementsByTagName('*');
            for (var i = 0; i < el.length; i++) {
                var childs = el[i].childNodes;
                for (var j = 0; j < childs.length; j++) {
                    var thisNode = childs[j];
                    if (thisNode.nodeType == 3) {
                        var prNode = thisNode.parentNode;
                        var text = thisNode.textContent;

                        if (!regexMM.test(text)) {
                            continue;
                        }

                        var computedStyles = document.defaultView.getComputedStyle(prNode, null);

                        if (computedStyles.fontFamily != unicodeFonts && mmFonts.test(computedStyles.fontFamily)) {
                            continue;
                        }

                        prNode.style.fontFamily = unicodeFonts;
                        while (thisNode.nextSibling) {
                            thisNode = thisNode.nextSibling;
                            prNode.style.fontFamily = computedStyles.fontFamily + "," + unicodeFonts;
                        }
                    }
                }
            }
        }

        tagPage();

        document.body.addEventListener("DOMNodeInserted", function () {
            if (timerID) {
                clearTimeout(timerID);
            }
            timerID = window.setTimeout(tagPage, 500);
        }, false);
    }
    document.addEventListener("DOMContentLoaded", tagMMUnicode, false);
})();

(function() {
    var a = function() {
            console.log('a');
        };
    setTimeout(1000, a);
})();