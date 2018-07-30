// !function(e,t,r){function n(){for(;d[0]&&"loaded"==d[0][f];)c=d.shift(),c[o]=!i.parentNode.insertBefore(c,i)}for(var s,a,c,d=[],i=e.scripts[0],o="onreadystatechange",f="readyState";s=r.shift();)a=e.createElement(t),"async"in i?(a.async=!1,e.head.appendChild(a)):i[f]?(d.push(a),a[o]=n):e.write("<"+t+' src="'+s+'" defer></'+t+">"),a.src=s}(document,"script",[
//     // "/public/js/lib/jquery-1.11.3.js",
//     "/public/js/src/EntriesHidden.js",
//     "/public/js/src/SearchConfig.js",
//     "/public/js/src/Search.js",
//     "/public/js/main.js"
// ]);


// # getScript()
// more or less stolen from jquery core and adapted by paul irish

var Loader = {
    nestedCount: 1,
    classStack: [],
    tryCounter: 0,
    
    create: function() {
        var loader = Object.create(this);   
        // loader.scripts = [];
        // loader.funcs = [];
        loader.requireArray = [];
        
        return loader;
    },
    
    add: function() {
        var self = this;
        var args = [];
        Array.prototype.push.apply( args, arguments );
        
        // return;

        var loadScriptAsync = function(script, childCount, callback) {
            var parentCount = callback();
            var index = self.classStack[childCount].dependency[script];
            var loop = function () {
                // var parentScript = self.classStack[parentCount].parentScript;
                // var nestedScript = self.classStack[childCount].parentScript;
                if (true === self.classStack[childCount].scriptsLoaded) {
                    return;
                }
                
                self.tryCounter++;
                
                if (!self.classStack[childCount].scriptsLoaded
                    && self.classStack[childCount].args.filter(Boolean).length === self.classStack[childCount].argsLengthMax
                ) {
                    self.classStack[childCount].scriptsLoaded = true;
                    var obj = self.classStack[childCount].func.apply(self, self.classStack[childCount].args);
                    
                    if (self.classStack[parentCount].args.filter(Boolean).length < self.classStack[parentCount].argsLengthMax) {
                        var index = self.classStack[parentCount].dependency[self.classStack[childCount].parentScript];
                        if (undefined === self.classStack[parentCount].args[index]) {
                            self.classStack[parentCount].args[index] = obj;
                        }
                    }
                } else {
                    setTimeout(loop, 200);
                }
            };
                if ('jQuery' === script) {
                    self.classStack[childCount].args[index] = jQuery;
                    if (self.classStack[childCount].args === self.classStack[childCount].argsLengthMax) {
                        self.classStack[childCount].scriptsLoaded = true;
                    }
                    loop();
                } else {
                    self.loadScript(script, function () {
                        console.log("nestedCount:" + childCount + " loaded:" + script);
                        loop();
                    });
                }
        };
        var execute = function(loadScriptAsync) {
            var definedArgs = args;
            var parentScript = definedArgs.shift();
            var scripts = definedArgs.shift();
            var definedFunction = definedArgs.shift();
            // var definedFunctionArgs = definedArgs;
            var nestedCount = self.nestedCount;
            var parentCount = 0;
            for (var i in self.classStack) {
                if (undefined !== self.classStack[i].dependency[parentScript]) {
                    parentCount = i;
                }
            }

            var dependencyView = {

            };

            if (0 < scripts.length) {
                var scriptsCloned = scripts.slice();
                var counter = 0;
                while (0 < scriptsCloned.length) {
                    var tempScript = scriptsCloned.shift();
                    dependencyView[counter] = tempScript;
                    dependencyView[tempScript] = counter;
                    counter++;
                }    
            }
            
            self.classStack[nestedCount] = {
                parentScript: parentScript,
                args: [],
                dependency: dependencyView,
                argsLengthMax: scripts.length,
                scriptsLoaded: false,
                func: definedFunction
            };    
            
            if (1 === nestedCount) {
                parentCount = 0;
                self.classStack[parentCount] = {
                    parentScript: parentScript,
                    args: [],
                    dependency: dependencyView,
                    argsLengthMax: scripts.length,
                    scriptsLoaded: false,
                    func: definedFunction
                };
            }
            var getParentCount = function() {
                return parentCount;
            };

            if (0 === scripts.length) {
                var obj = definedFunction();
                self.classStack[nestedCount].scriptsLoaded = true;
                var index = self.classStack[parentCount].dependency[parentScript];
                
                self.classStack[parentCount].args[index] = obj;
            }
            while (0 < scripts.length) {
                var script = scripts.shift();
                loadScriptAsync(script, nestedCount, getParentCount);
            }
        };
        execute(loadScriptAsync);
       
        this.nestedCount++;
    },


    loadScript: function(url,success) {
        var head = document.getElementsByTagName("head")[0], done = false;
        var script = document.createElement("script");
        script.src = url;
        // Attach handlers for all browsers
        script.onload = script.onreadystatechange = function(){
            if (!done && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") ) {
                done = true;
                if (typeof success === 'function') success();
            }
        };
        head.appendChild(script);
    }
};

window.Loader = Loader.create();
Loader.add('/public/js/a_load/a_load.js', ["/public/js/main.js"], function () {
    console.log(Loader.tryCounter);
});
// Loader.loadFunctions();




// getScript();