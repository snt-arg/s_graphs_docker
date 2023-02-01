(function() {
    'use strict';

    var Loader = (function() {

        var scripts = {},
            queue = {},
            loadCount = 0,
            head = document.getElementsByTagName('head')[0],

            register = function( script, id ) {
                if( id ) {
                    scripts[id] = script;
                }  
            },

            isRegistered = function( id ) {
                if( scripts.hasOwnProperty(id) ) {
                    return true;
                } else {
                    console.log( 'Script '+id+' has not been registered' );
                }
            },

            inQueue = function( id ) {
                return queue.hasOwnProperty(id) ? true : false;
            },        
           
            require = function( ids, callback ) {
                //check if each script is a registered callback

                ids = ids['push'] ? ids : [ ids ];
                var totalRequired = ids.length,
                    currentScripts = [];
                if( ids.every( isRegistered ) ) {
                    for( var i = 0; i < totalRequired; i++ ) {
                        if( !inQueue( ids[i] ) ) {
                            queue[ ids[i] ] = writeScript( scripts[ ids[i] ] );          
                        }
                        currentScripts.push( queue[ ids[i] ] );
                    }
                    Promise.all( currentScripts ).then( function() {
                        callback.call();
                    });
                }
                else {
                    console.log( 'Scripts not Registered' );
                }

            },

            writeScript = function( src ) {
                return new Promise( function(resolve, reject ) { 
                    var s = document.createElement('script');
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = src;
                    head.appendChild(s);
                    s.onload = resolve;
                    s.onerror = reject;
                });    
            },

            getRegistredScripts = function() {
                return scripts;
            };

            return {
                register : register,
                require : require,
                getRegistredScripts: getRegistredScripts
            }
    })();
    window.asyncloader = Loader;
})();            