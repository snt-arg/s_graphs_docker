/**
 * Block dependencies
 */     
import './style.scss';
import './editor.scss';

/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
if(typeof wp.blockEditor !== 'undefined')
  var { InspectorControls, InspectorAdvancedControls } = wp.blockEditor;
else
  var { InspectorControls, InspectorAdvancedControls } = wp.editor;
  const { Component } = wp.element;
import { deprecated } from './deprecated';
import { RevSlider } from './revslider';


import { TextControl } from '@wordpress/components';
const { withState } = wp.compose;



/**
 * Register block
 */
export default registerBlockType(
    'themepunch/revslider',
    {
        title: __( 'Slider Revolution', 'revslider' ),
        description: __( 'Add your Slider Revolution Module!', 'revslider' ),
        category: 'common',
        icon: {
          src:  'update',
          background: 'rgb(94, 53, 177)',
          color: 'white',
          viewbox: "0 0 28 28"
        },   
        example: {
          attributes: {
              cover: true
          },
        },  
        keywords: [
            __( 'Banner', 'revslider' ),
            __( 'CTA', 'revslider' ),
            __( 'Slider', 'revslider' ),
        ],
        attributes: {
          checked: {
            type: 'boolean',
            default: false
          },
          modal: {
            type: 'boolean',
            default: false
          },
          content: {
              selector: '.revslider',
              type: 'string',
              source: 'text',
          },
          text: {
            selector: '.revslider',
            type: 'string',
            source: 'text',
          },
          slidertitle: {
              selector: '.revslider',
              type: 'string',
              source: 'attribute',
              attribute: 'data-slidertitle',
          },
          sliderImage: {
             type:'string'
          },
          hideSliderImage:{
              boolean: false
          },
          alias: {
            type: 'string'
          },
          zindex: {
            type: 'string'
          },
          wrapperid: {
           type: 'string'
          },
          cover: {
            default: false
          }
        },
        edit: props => {
          const { setAttributes, attributes: { wrapperid ,cover} } = props;
          
          return [
            !cover &&
            <div>
              <RevSlider {...{ setAttributes, ...props }} />
            </div>,
            cover &&
            <center><img src={revslider_gutenberg.pluginurl + "/admin/includes/shortcode_generator/gutenberg/dist/images/sr-minigif.gif"} width={320} height={180}></img></center>
          ];
        },
        deprecated,
        save: props => {
          const { attributes: { text, content, slidertitle, modal, zindex, wrapperid } } = props;
          let style;
          style = zindex ? "z-index:"+zindex+";" : "";
          let shortcode = !content && text ? text : content;
          return (
            <div className="revslider" id={wrapperid} data-modal={modal} data-slidertitle={slidertitle} style={style}>
               {shortcode}
            </div>
          );
        }
    },
);