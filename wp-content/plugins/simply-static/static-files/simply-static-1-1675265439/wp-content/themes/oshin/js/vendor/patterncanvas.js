function pattern_canvas() {

    var width, height, largeHeader, canvas, ctx, triangles, target, animateHeader = true;
    var triangle_color1 , triangle_color2 , triangle_color3 , triangle_color4 , triangle_color5; 
  
	canvas = document.getElementById('pattern-canvas');
	if(canvas) {  
	    triangle_color1 = hexToRGB(document.getElementById('pattern-canvas').getAttribute("data-color1")); 
	    triangle_color2 = hexToRGB(document.getElementById('pattern-canvas').getAttribute("data-color2")); 
	    triangle_color3 = hexToRGB(document.getElementById('pattern-canvas').getAttribute("data-color3")); 
	    triangle_color4 = hexToRGB(document.getElementById('pattern-canvas').getAttribute("data-color4")); 
	    triangle_color5 = hexToRGB(document.getElementById('pattern-canvas').getAttribute("data-color5")); 

	    var colors = [triangle_color1, triangle_color2, triangle_color3, triangle_color4, triangle_color5];

	    // Main
	    initHeader();
	    addListenersPattern();
	    initAnimation();
	}

    function initHeader() {
        width = window.innerWidth;
        height = window.innerHeight;
        target = {x: 0, y: height};

        canvas = document.getElementById('pattern-canvas');
        if (canvas){
	        canvas.width = width; 
	        canvas.height = height;
	        ctx = canvas.getContext('2d');
    	}
        // create particles
        triangles = [];
        for(var x = 0; x < 480; x++) {
            addTriangle(x*20);
        }
    }

    function addTriangle(delay) {
        setTimeout(function() {
            var t = new Triangle();
            triangles.push(t);
            tweenTriangle(t);
        }, delay);
    }

    function initAnimation() {
        animate();
    }

    function tweenTriangle(tri) {
        var t = Math.random()*(2*Math.PI);
        var x = (200+Math.random()*100)*Math.cos(t) + width*0.5;
        var y = (200+Math.random()*100)*Math.sin(t) + height*0.5-20;
        var time = 4+3*Math.random();

        TweenLite.to(tri.pos, time, {x: x,
            y: y, ease:Circ.easeOut,
            onComplete: function() {
                tri.init();
                tweenTriangle(tri);
        }});
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in triangles) {
                triangles[i].drawPattern();
            }
        }
        requestAnimationFrame(animate);
    }

    // Canvas manipulation
    function Triangle() {
        var _this = this;

        // constructor
        (function() {
            _this.coords = [{},{},{}];
            _this.pos = {};
            init();
        })();

        function init() {
            _this.pos.x = width*0.5;
            _this.pos.y = height*0.5-20;
            _this.coords[0].x = -10+Math.random()*40;
            _this.coords[0].y = -10+Math.random()*40;
            _this.coords[1].x = -10+Math.random()*40;
            _this.coords[1].y = -10+Math.random()*40;
            _this.coords[2].x = -10+Math.random()*40;
            _this.coords[2].y = -10+Math.random()*40;
            _this.scale = 0.1+Math.random()*0.3;
            _this.color = colors[Math.floor(Math.random()*colors.length)];
            setTimeout(function() { _this.alpha = 0.8; }, 10);
        }

        this.drawPattern = function() {
            if(_this.alpha >= 0.005) _this.alpha -= 0.005;
            else _this.alpha = 0;
            ctx.beginPath();
            ctx.moveTo(_this.coords[0].x+_this.pos.x, _this.coords[0].y+_this.pos.y);
            ctx.lineTo(_this.coords[1].x+_this.pos.x, _this.coords[1].y+_this.pos.y);
            ctx.lineTo(_this.coords[2].x+_this.pos.x, _this.coords[2].y+_this.pos.y);
            ctx.closePath();
            ctx.fillStyle = 'rgba('+_this.color+','+ _this.alpha+')';
            ctx.fill();
        };

        this.init = init;
    }

	// Event handling
	function addListenersPattern() {	    
	    jQuery(window).on('resize', resize);
	    jQuery(window).on('load', startanimate);
	    jQuery(window).on('update_content', startanimate );
	}

	function scrollCheck() {
	    if(document.body.scrollTop > height) animateHeader = false;
	    else animateHeader = true;
	}

	function startanimate(){
		animateHeader = true;
	}


	function resize() {
	    width = window.innerWidth;
	    height = window.innerHeight;
	    canvas.width = width;
	    canvas.height = height;
	}

     function hexToRGB(h) {

        if (typeof h != 'undefined') {

            var r , g , b ;
            r = parseInt((h).substring(1,3),16) ;
            g = parseInt((h).substring(3,5),16) ;
            b = parseInt((h).substring(5,7),16) ;
        }
        else {
            r = 0;
            g = 0;
            b = 0;
        }
        return r + ',' + g + ',' + b ;

    }   
    
}