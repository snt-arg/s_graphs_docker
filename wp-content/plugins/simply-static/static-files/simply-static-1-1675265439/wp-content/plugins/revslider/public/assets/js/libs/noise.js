if (THREE!==undefined) {		
	THREE.EffectComposer=function(a,b){if(this.renderer=a,void 0===b){var c={minFilter:THREE.LinearFilter,magFilter:THREE.LinearFilter,format:THREE.RGBAFormat},d=a.getSize(new THREE.Vector2);this._pixelRatio=a.getPixelRatio(),this._width=d.width,this._height=d.height,b=new THREE.WebGLRenderTarget(this._width*this._pixelRatio,this._height*this._pixelRatio,c),b.texture.name="EffectComposer.rt1"}else this._pixelRatio=1,this._width=b.width,this._height=b.height;this.renderTarget1=b,this.renderTarget2=b.clone(),this.renderTarget2.texture.name="EffectComposer.rt2",this.writeBuffer=this.renderTarget1,this.readBuffer=this.renderTarget2,this.renderToScreen=!0,this.passes=[],void 0===THREE.CopyShader&&console.error("THREE.EffectComposer relies on THREE.CopyShader"),void 0===THREE.ShaderPass&&console.error("THREE.EffectComposer relies on THREE.ShaderPass"),this.copyPass=new THREE.ShaderPass(THREE.CopyShader),this.clock=new THREE.Clock},Object.assign(THREE.EffectComposer.prototype,{swapBuffers:function(){var a=this.readBuffer;this.readBuffer=this.writeBuffer,this.writeBuffer=a},addPass:function(a){this.passes.push(a),a.setSize(this._width*this._pixelRatio,this._height*this._pixelRatio)},insertPass:function(a,b){this.passes.splice(b,0,a),a.setSize(this._width*this._pixelRatio,this._height*this._pixelRatio)},removePass:function(a){const b=this.passes.indexOf(a);-1!==b&&this.passes.splice(b,1)},isLastEnabledPass:function(a){for(var b=a+1;b<this.passes.length;b++)if(this.passes[b].enabled)return!1;return!0},render:function(a){a===void 0&&(a=this.clock.getDelta());var b,c,d=this.renderer.getRenderTarget(),e=!1,f=this.passes.length;for(c=0;c<f;c++)if(b=this.passes[c],!1!==b.enabled){if(b.renderToScreen=this.renderToScreen&&this.isLastEnabledPass(c),b.render(this.renderer,this.writeBuffer,this.readBuffer,a,e),b.needsSwap){if(e){var g=this.renderer.getContext(),h=this.renderer.state.buffers.stencil;h.setFunc(g.NOTEQUAL,1,4294967295),this.copyPass.render(this.renderer,this.writeBuffer,this.readBuffer,a),h.setFunc(g.EQUAL,1,4294967295)}this.swapBuffers()}void 0!==THREE.MaskPass&&(b instanceof THREE.MaskPass?e=!0:b instanceof THREE.ClearMaskPass&&(e=!1))}this.renderer.setRenderTarget(d)},reset:function(a){if(a===void 0){var b=this.renderer.getSize(new THREE.Vector2);this._pixelRatio=this.renderer.getPixelRatio(),this._width=b.width,this._height=b.height,a=this.renderTarget1.clone(),a.setSize(this._width*this._pixelRatio,this._height*this._pixelRatio)}this.renderTarget1.dispose(),this.renderTarget2.dispose(),this.renderTarget1=a,this.renderTarget2=a.clone(),this.writeBuffer=this.renderTarget1,this.readBuffer=this.renderTarget2},setSize:function(a,b){this._width=a,this._height=b;var c=this._width*this._pixelRatio,d=this._height*this._pixelRatio;this.renderTarget1.setSize(c,d),this.renderTarget2.setSize(c,d);for(var e=0;e<this.passes.length;e++)this.passes[e].setSize(c,d)},setPixelRatio:function(a){this._pixelRatio=a,this.setSize(this._width,this._height)}}),THREE.Pass=function(){this.enabled=!0,this.needsSwap=!0,this.clear=!1,this.renderToScreen=!1},Object.assign(THREE.Pass.prototype,{setSize:function(){},render:function(){console.error("THREE.Pass: .render() must be implemented in derived pass.")}}),THREE.Pass.FullScreenQuad=function(){var a=new THREE.OrthographicCamera(-1,1,1,-1,0,1),b=new THREE.BufferGeometry;b.setAttribute("position",new THREE.Float32BufferAttribute([-1,3,0,-1,-1,0,3,-1,0],3)),b.setAttribute("uv",new THREE.Float32BufferAttribute([0,2,0,0,2,0],2));var c=function(a){this._mesh=new THREE.Mesh(b,a)};return Object.defineProperty(c.prototype,"material",{get:function(){return this._mesh.material},set:function(a){this._mesh.material=a}}),Object.assign(c.prototype,{dispose:function(){this._mesh.geometry.dispose()},render:function(b){b.render(this._mesh,a)}}),c}();
	THREE.RenderPass=function(a,b,c,d,e){THREE.Pass.call(this),this.scene=a,this.camera=b,this.overrideMaterial=c,this.clearColor=d,this.clearAlpha=e===void 0?0:e,this.clear=!0,this.clearDepth=!1,this.needsSwap=!1,this._oldClearColor=new THREE.Color},THREE.RenderPass.prototype=Object.assign(Object.create(THREE.Pass.prototype),{constructor:THREE.RenderPass,render:function(a,b,c){var d=a.autoClear;a.autoClear=!1;var e,f;this.overrideMaterial!==void 0&&(f=this.scene.overrideMaterial,this.scene.overrideMaterial=this.overrideMaterial),this.clearColor&&(a.getClearColor(this._oldClearColor),e=a.getClearAlpha(),a.setClearColor(this.clearColor,this.clearAlpha)),this.clearDepth&&a.clearDepth(),a.setRenderTarget(this.renderToScreen?null:c),this.clear&&a.clear(a.autoClearColor,a.autoClearDepth,a.autoClearStencil),a.render(this.scene,this.camera),this.clearColor&&a.setClearColor(this._oldClearColor,e),this.overrideMaterial!==void 0&&(this.scene.overrideMaterial=f),a.autoClear=d}});
	THREE.Blur2dShader = {

		uniforms: {
			'tColor': { value: null },
			'intensity': { value: 0 },
			'progress': { value: 0 },
			'left': {value: 1.0},
			'top': {value: 0.0}
		},

		vertexShader: /* glsl */`
			varying vec2 vUv;
			void main() {
				vUv = uv;
				gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
			}`,

		fragmentShader: /* glsl */`
			#if __VERSION__ < 130\n
			#define TEXTURE2D texture2D\n
			#else\n
			#define TEXTURE2D texture\n
			#endif\n

			#include <common>
			varying vec2 vUv;
			uniform sampler2D tColor;
			uniform float progress;
			uniform float intensity;
			uniform float left;
			uniform float top;
			int Samples = 64;
			#include <packing>
			
			vec4 DirectionalBlur(in vec2 UV, in vec2 Direction, in float Intensity, in sampler2D Texture) {
				vec4 Color = vec4(0.0);  

				for (int i=1; i<=Samples/2; i++)
				{
					Color += TEXTURE2D(Texture,UV+float(i)*Intensity/float(Samples/2)*Direction);
					Color += TEXTURE2D(Texture,UV-float(i)*Intensity/float(Samples/2)*Direction);
				}

				return Color/float(Samples);    
			}

			void main() {
				vec2 uv = vUv;
				
				vec2 Direction = vec2(left, top);
				float Intensity = intensity;
				float m = progress;
				
				float mult = (m -0.5)*2.;
				Intensity *= (-(mult * mult) + 1.);
				Intensity *= 1.0 - step(1.0,m);
				
				vec4 Color = DirectionalBlur(uv,normalize(Direction), Intensity, tColor);

				gl_FragColor = vec4(Color.xyz, 1.0);
		}`
	};


	/**
	 * Directional blur post-process with Blur2D shader
	 */

	THREE.Blur2D = function ( scene, camera, params ) {

		THREE.Pass.call( this );

		this.scene = scene;
		this.camera = camera;

		var left = params.left === undefined ? 0 : params.left;
		var top = params.top === undefined ? 0 : params.top;
		if(left === 0 && top === 0) left = 1.0;
		// render targets

		var width = params.width || window.innerWidth || 1;
		var height = params.height || window.innerHeight || 1;

		this.renderTargetDepth = new THREE.WebGLRenderTarget( width, height, {
			minFilter: THREE.NearestFilter,
			magFilter: THREE.NearestFilter
		} );

		this.renderTargetDepth.texture.name = 'Blur2D.depth';

		// blur2d material

		if ( THREE.Blur2dShader === undefined ) console.error( 'THREE.Blur2D relies on THREE.Blur2dShader' );

		var Blur2dShader = THREE.Blur2dShader;
		var blur2dUniforms = THREE.UniformsUtils.clone( Blur2dShader.uniforms );

		blur2dUniforms[ 'intensity' ].value = params.intensity !== undefined ? params.intensity : 0.1;
		blur2dUniforms[ 'progress' ].value = 0.0;
		blur2dUniforms[ 'left' ].value = left;
		blur2dUniforms[ 'top' ].value = top;

		this.materialBlur2d = new THREE.ShaderMaterial( {
			uniforms: blur2dUniforms,
			vertexShader: Blur2dShader.vertexShader,
			fragmentShader: Blur2dShader.fragmentShader
		} );

		this.uniforms = blur2dUniforms;
		this.needsSwap = false;

		this.fsQuad = new THREE.Pass.FullScreenQuad( this.materialBlur2d );

		this._oldClearColor = new THREE.Color();

	};

	THREE.Blur2D.prototype = Object.assign( Object.create( THREE.Pass.prototype ), {

		constructor: THREE.Blur2D,

		render: function ( renderer, writeBuffer, readBuffer/*, deltaTime, maskActive*/ ) {

			// Render depth into texture

			renderer.getClearColor( this._oldClearColor );
			var oldClearAlpha = renderer.getClearAlpha();
			var oldAutoClear = renderer.autoClear;
			renderer.autoClear = false;

			renderer.setClearColor( 0xffffff );
			renderer.setClearAlpha( 1.0 );
			renderer.setRenderTarget( this.renderTargetDepth );
			renderer.clear();
			renderer.render( this.scene, this.camera );

			// Render blur2d composite
			this.uniforms[ 'tColor' ].value = readBuffer.texture;

			if ( this.renderToScreen ) {

				renderer.setRenderTarget( null );
				this.fsQuad.render( renderer );

			} else {

				renderer.setRenderTarget( writeBuffer );
				renderer.clear();
				this.fsQuad.render( renderer );

			}

			this.scene.overrideMaterial = null;
			renderer.setClearColor( this._oldClearColor );
			renderer.setClearAlpha( oldClearAlpha );
			renderer.autoClear = oldAutoClear;

		}

	} );


	var _R = _R_is_Editor ? RVS._R : jQuery.fn.revolution;

	_R.postProcessing = _R.postProcessing || {};

	_R.postProcessing.blur2d = {
		init: function(renderer, scene, camera, opt) {
			let PP = {};
			PP.type = "blur2d";
			PP.renderPass = new THREE.RenderPass( scene, camera );
			PP.blur2D = new THREE.Blur2D( scene, camera, {
				progress: opt.progress,
				intensity: opt.intensity,
				left: opt.left,
				top: opt.top,
				width: opt.width,
				height: opt.height
			});						
			PP.composer = new THREE.EffectComposer( renderer);
			PP.composer.addPass( PP.renderPass );
			PP.composer.addPass( PP.blur2D );
			return PP;
		}
	}

}
