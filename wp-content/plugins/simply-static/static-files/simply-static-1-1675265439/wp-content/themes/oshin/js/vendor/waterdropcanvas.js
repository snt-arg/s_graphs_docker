function water_drop_canvas() {

    var width, height, largeHeader, canvas, ctx,fill_color, circles, target, animateHeader = true;

    // Main
    canvas = document.getElementById('waterdrops-canvas');
    if (canvas) {
	    initHeader();
	    addListenersWater();
	}
    function initHeader() {
        width = window.innerWidth;
        height = window.innerHeight;
        target = {x: 0, y: height};

        canvas = document.getElementById('waterdrops-canvas');
        fill_color = hexToRGB(document.getElementById('waterdrops-canvas').getAttribute("data-color1"));
	    canvas.width = width;
	    canvas.height = height;
	    ctx = canvas.getContext('2d');
        // create particles
        circles = [];
        for(var x = 0; x < width*0.2; x++) {
            var c = new CircleWater();
            circles.push(c);
        }
        animate();
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in circles) {
                circles[i].drawWater(fill_color);
            }
        }
        requestAnimationFrame(animate);
    }

    // Canvas manipulation
    function CircleWater() {
        var _this = this;

        // constructor
        (function() {
            _this.pos = {};
            init();
        })();

        function init() {
            _this.pos.x = Math.random()*width;
            _this.pos.y = height+Math.random()*100;
            _this.alpha = 0.1+Math.random()*0.3;
            _this.scale = 0.1+Math.random()*0.3;
            _this.velocity = Math.random();
        }

        this.drawWater = function(fill_color) {

        	//fill_color = hexToRGB(document.getElementById('waterdrops-canvas').getAttribute("data-color1"));

            if(_this.alpha <= 0) {
                init();
            }
            _this.pos.y -= _this.velocity;
            _this.alpha -= 0.0005;
            ctx.beginPath();
            ctx.arc(_this.pos.x, _this.pos.y, _this.scale*10, 0, 2 * Math.PI, false);
            ctx.fillStyle = 'rgba('+ fill_color + ',' + _this.alpha+')';
            ctx.fill();
        };
    }

	// Event handling
	function addListenersWater() {
	    jQuery(window).on('load', startanimate);
	    jQuery(window).on('resize', resize);
	    jQuery(window).on( 'update_content', startanimate );
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