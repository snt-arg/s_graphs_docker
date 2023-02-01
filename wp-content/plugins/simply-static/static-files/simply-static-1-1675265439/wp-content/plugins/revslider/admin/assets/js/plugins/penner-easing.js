var PennerEasing = {
		
	linear: {
		
		easenone: function(t, b, c, d) {
	
			return c * t / d + b;
			
		},

		easein: function(t, b, c, d) {
			
			return c * t / d + b;
			
		},
		
		easeout: function(t, b, c, d) {
			
			return c * t / d + b;
			
		},
		
		easeinout: function(t, b, c, d) {
			
			return c * t / d + b;
			
		}
	
	},
	
	quint: {
		
		easeout: function (t, b, c, d) {
			
			return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
			
		},
		
		easein: function(t, b, c, d) {
			
			return c * (t /= d) * t * t * t * t + b;
			
		},
		
		easeinout: function(t, b, c, d) {
			
			return ((t /= d / 2) < 1) ? c / 2 * t * t * t * t * t + b : c / 2 * ((t -= 2) * t * t * t * t + 2) + b;
			
		}
		
	},
		
	quad: {
		
		easein: function (t, b, c, d) {
		
			return c * (t /= d) * t + b;
		
		},
		
		easeout: function (t, b, c, d) {
			
			return -c * (t /= d) * (t - 2) + b;
		
		},
		
		easeinout: function (t, b, c, d) {
			
			return ((t /= d / 2) < 1) ? c / 2 * t * t + b : -c / 2 * ((--t) * (t - 2) - 1) + b;
		
		}	
		
	},
	
	quart: {
	
		easein: function(t, b, c, d) {
			
			return c * (t /= d) * t * t * t + b;
			
		},
		
		easeout: function(t, b, c, d) {
			
			return -c * ((t = t / d - 1) * t * t * t - 1) + b;
			
		},
		
		easeinout: function(t, b, c, d) {
			
			return ((t /= d / 2) < 1) ? c / 2 * t * t * t * t + b : -c / 2 * ((t -= 2) * t * t * t - 2) + b;
			
		}
		
	},
	
	cubic: {
	
		easein: function(t, b, c, d) {
			
			return c * (t /= d) * t * t + b;
			
		},
		
		easeout: function(t, b, c, d) {
			
			return c * ((t = t / d - 1) * t * t + 1) + b;
			
		},
		
		easeinout: function(t, b, c, d) {
			
			return ((t /= d / 2) < 1) ? c / 2 * t * t * t + b : c / 2 * ((t -= 2) * t * t + 2) + b;
			
		}
		
	},
	
	circ: {
	
		easein: function(t, b, c, d) {
			
			return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;
			
		},
		
		easeout: function(t, b, c, d) {
			
			return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
			
		},
		
		easeinout: function(t, b, c, d) {
			
			return ((t /= d / 2) < 1) ? -c / 2 * (Math.sqrt(1 - t * t) - 1) + b : c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
			
		}
		
	},
	
	sine: {
	
		easein: function(t, b, c, d) {
			
			return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
			
		},
		
		easeout: function(t, b, c, d) {
			
			return c * Math.sin(t / d * (Math.PI / 2)) + b;
			
		},
		
		easeinout: function(t, b, c, d) {
			
			return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
			
		}
		
	},
	
	expo: {
	
		easein: function(t, b, c, d) {
			
			return (t === 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;
		
		},
		
		easeout: function(t, b, c, d) {
			
			return (t === d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
			
		},
		
		easeinout: function(t, b, c, d) {
			
			if(t === 0) return b;
			if(t === d) return b + c;
			if((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
			
			return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
			
		}
		
	}
	
};