function galaxy_canvas() {

    var width, height, largeHeader, canvas, ctx, points, target, animateHeader, color, canvas_color, canvas_color_r, canvas_color_g, canvas_color_b = true;

    // Main
    canvas = document.getElementById('galaxy-canvas');
    if (canvas){
	    initHeader();
	    initAnimation();
	    addListenersGalaxy();
	} 
    function initHeader() {
        width = window.innerWidth;
        height = window.innerHeight;
        target = {x: width/2, y: height/2};

        canvas = document.getElementById('galaxy-canvas');
        if (canvas){
	        canvas.width = width;
	        canvas.height = height;
	        ctx = canvas.getContext('2d');
    	}
        // create points
        points = [];
        for(var x = 0; x < width; x = x + width/25) {
            for(var y = 0; y < height; y = y + height/25) {
                var px = x + Math.random()*width/25;
                var py = y + Math.random()*height/25;
                var p = {x: px, originX: px, y: py, originY: py };
                points.push(p);
            }
        }
        // for each point find the 4 closest points
        for(var i = 0; i < points.length; i++) {
            var closest = [];
            var p1 = points[i];
            for(var j = 0; j < points.length; j++) {
                var p2 = points[j]
                if(!(p1 == p2)) {
                    var placed = false;
                    for(var k = 0; k < 4; k++) {
                        if(!placed) {
                            if(closest[k] == undefined) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }

                    for(var k = 0; k < 4; k++) {
                        if(!placed) {
                            if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                }
            }
            p1.closest = closest;
        }

        // assign a circle to each point
        for(var i in points) {
            var c = new CircleGalaxy(points[i], 1+Math.random(), 'rgba(255,255,255,0.3)');
            points[i].circle = c;
        }
    }

    // animation
    function initAnimation() {
        animate();
        for(var i in points) {
            shiftPoint(points[i]);
        }
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in points) {
                // detect points in range
                if(Math.abs(getDistance(target, points[i])) < 4000) {
                    points[i].active = 0.3;
                    points[i].circle.active = 0.6;
                } else if(Math.abs(getDistance(target, points[i])) < 20000) {
                    points[i].active = 0.1;
                    points[i].circle.active = 0.3;
                } else if(Math.abs(getDistance(target, points[i])) < 40000) {
                    points[i].active = 0.02;
                    points[i].circle.active = 0.1;
                } else {
                    points[i].active = 0;
                    points[i].circle.active = 0;
                }

                drawLines(points[i]);
                points[i].circle.drawGalaxy();
            }
        }
        requestAnimationFrame(animate);
    }

    function shiftPoint(p) {
        TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
            y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
            onComplete: function() {
                shiftPoint(p);
            }});
    }

    // Canvas manipulation
    function drawLines(p) {
        stroke_color = hexToRGB(jQuery('#galaxy-canvas').attr("data-color1"));
        if(!p.active) return;
        for(var i in p.closest) {
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(p.closest[i].x, p.closest[i].y);
            ctx.strokeStyle = 'rgba('+ stroke_color +','+ p.active+')';
            ctx.stroke();
        }
    }

    function CircleGalaxy(pos,rad,color) {
        var _this = this;
		var fill_color = hexToRGB(jQuery('#galaxy-canvas').attr("data-color2"));       	
        // constructor
        (function() {
            _this.pos = pos || null;
            _this.radius = rad || null;
            _this.color = color || null;
        })();

        this.drawGalaxy = function() {
        
            if(!_this.active) return;
            ctx.beginPath();
            ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
            ctx.fillStyle = 'rgba(' + fill_color + ','+ _this.active+')';
            ctx.fill();
        };
    }

    // Util
    function getDistance(p1, p2) {
        return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
    }

	function mouseMove(e) {
	    var posx = posy = 0;
	    if (e.pageX || e.pageY) {
	        posx = e.pageX;
	        posy = e.pageY;
	    }
	    else if (e.clientX || e.clientY)    {
	        posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
	        posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
	    }
	    target.x = posx;
	    target.y = posy;
	}
	// Event handling
	function addListenersGalaxy() {
	    if(!('ontouchstart' in window)) {
	        jQuery(window).on('mousemove.galaxymove', mouseMove);
	    }
	    
	   jQuery(window).on('load.galaxyanimate', startanimate);
	   jQuery(window).on( 'update_content', startanimate );
	   jQuery(window).on('resize.galaxyresize', resize);
	}

	function startanimate(){
		animateHeader = true;
	}
	function scrollCheck() {
	    if(document.body.scrollTop > height) animateHeader = false;
	    else animateHeader = true;
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