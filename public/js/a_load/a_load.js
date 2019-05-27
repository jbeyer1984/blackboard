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
    definedStack: [],
    // index: 0,
    initState: true,
    classStack: [],
    tryCounter: 0,
    
    create: function() {
        var loader = Object.create(this);   
        // loader.scripts = [];
        // loader.funcs = [];
        loader.requireArray = [];
        
        return loader;
    },
    
    define: function() {
        var self = this;
        var args = [];
        Array.prototype.push.apply( args, arguments );
        var definedArgs = args;
        var executingScript = definedArgs.shift();
        var scripts = definedArgs.shift();
        var definedFunction = definedArgs.shift();
        
        var definitions = {
            script: executingScript,
            scripts: scripts,
            func: definedFunction
        };
        
        if (self.initState) {
            self.initState = false;
            self.define(executingScript, [executingScript], function(param) {});
            return;
        }
        
        this.definedStack.push(definitions);

        var index = this.definedStack.length -1;

        var dependencyView = self.getGeneratedDependencies(scripts);

        self.classStack[index] = {
            script: executingScript,
            dependency: dependencyView,
            argsLengthMax: scripts.length,
            args: [],
            loading: true,
            func: definedFunction,
        }

        var parentCount = index;
        
        while (0 < scripts.length) {
            var script = scripts.shift();
            if ('jQuery' === script) {
                // self.loadScriptDirectly(definedFunction, index, executingScript);
                var argIndex = self.classStack[parentCount].dependency[script];
                self.classStack[parentCount].args[argIndex] = jQuery;
                var loaded = true;
                if (self.classStack[parentCount].args.filter(Boolean).length === self.classStack[parentCount].argsLengthMax) {
                    self.classStack[parentCount].scriptsLoaded = true;
                }
            } else {
                var loadFunc = function() { // will be called one time
                    var lastItem = self.definedStack.length - 1;
                    var loaded = true;
                    var lastScript = self.definedStack[lastItem].script;
                    self.loadAsync(lastItem, parentCount, lastScript, loaded);
                };
                self.loadScript(script, loadFunc);    
            }
        }
    },

    createObject: function (index) {
        this.classStack[index].scriptsLoaded = true;
        var obj = this.classStack[index].func.apply(this, this.classStack[index].args);
        return obj;
    }, assignObjToParent: function (parentCount, script, obj) {
        if (undefined !== this.classStack[parentCount].dependency[script]) {
            if (this.classStack[parentCount].args.filter(Boolean).length < this.classStack[parentCount].argsLengthMax) {
                var argIndex = this.classStack[parentCount].dependency[script];
                if (undefined === this.classStack[parentCount].args[argIndex]) {
                    this.classStack[parentCount].args[argIndex] = obj;
                }
            }
        }
    },
    
    loadAsync: function(index, parentCount, script, loaded) {
        var self = this;
        if (loaded) {
            if (self.classStack[index].argsLengthMax !== self.classStack[index].args.filter(Boolean).length) {
                setTimeout(function() {
                    self.loadAsync(index, parentCount, script, loaded)
                }, 100);
                self.tryCounter++;
                return;
            } else {
                var obj = self.createObject(index);
                self.assignObjToParent(parentCount, script, obj);
                return;
            }
        }
    },

    getGeneratedDependencies: function (scripts) {
        var dependencyView = [];
        if (0 < scripts.length) {
            var scriptsCloned = scripts.slice();
            var counter = 0;
            while (0 < scriptsCloned.length) {
                var tempScript = scriptsCloned.shift();
                // dependencyView[counter] = tempScript;
                dependencyView[tempScript] = counter;
                counter++;
            }
        }
        return dependencyView;
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