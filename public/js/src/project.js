(function ($, undefined) {
    var Project = function() {
        function run(text) {
            console.log(text);
        }
        
        function priv() {
            
        }
        
        return {
            run: run,
            priv: priv
        }
    }();
        // var Project = {
        //     run: function (text) {
        //         console.log(text);
        //     }
        // };

        window.Project = Object.create(Project);
        window.Project.run("init run");
        window.Project.priv();
}(jQuery));