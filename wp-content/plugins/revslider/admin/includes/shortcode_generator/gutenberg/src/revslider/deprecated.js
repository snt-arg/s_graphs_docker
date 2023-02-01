const deprecated = [
  {
    attributes: {
        checked: {
          type: 'boolean',
          default: false
        },
        modal: {
          type: 'boolean',
          default: false
        },
        text: {
            selector: '.revslider',
            type: 'string',
            source: 'text',
        },
        sliderTitle: {
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
        }
     },
      save( props ) {
        const { attributes: { text, sliderTitle, modal } } = props;
        return (
          <div className="revslider" data-modal={modal} data-slidertitle={sliderTitle}>
            {text} 
          </div>
        );
      },
  },
  {
    attributes: {
          checked: {
            type: 'boolean',
            default: false
          },
          text: {
              selector: '.revslider',
              type: 'string',
              source: 'text',
          },
          sliderTitle: {
              selector: '.revslider',
              type: 'string',
              source: 'attribute',
              attribute: 'data-slidertitle',
          }
     },
      save( props ) {
        return (
          <div className="revslider" data-slidertitle={props.attributes.sliderTitle}>
             {props.attributes.text} 
          </div>
        );
      },
  },
  {
    attributes: {
      checked: {
        type: 'boolean',
        default: false
      },
      modal: {
        type: 'boolean',
        default: false
      },
      popup: {
        type: 'object'  
      },
      text: {
          selector: '.revslider',
          type: 'string',
          source: 'text',
      },
      sliderTitle: {
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
      offset: {
          type: 'object'
      },
      layout: {
          type: 'string '
      },
      alias: {
        type: 'string'
      },
      zindex: {
        type: 'string'
      },
      shortcode: {
        type: 'string'
      }
    },
    save( props ) {
      const { attributes: { text, sliderTitle, modal, zindex } } = props;
      let style;
      style = zindex ? "z-index:"+zindex+";" : "";
      return (
        <div className="revslider" data-modal={modal} data-slidertitle={sliderTitle} style={style}>
            {text} 
        </div>
      );
    }
  },
  {
    attributes: {
      checked: {
        type: 'boolean',
        default: false
      },
      modal: {
        type: 'boolean',
        default: false
      },
      popup: {
        type: 'object'  
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
      sliderTitle: {
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
      offset: {
          type: 'object'
      },
      layout: {
          type: 'string '
      },
      alias: {
        type: 'string'
      },
      zindex: {
        type: 'string'
      },
      shortcode: {
        type: 'string'
      }
    },
    save( props ) {
      const { attributes: { text, content, sliderTitle, modal, zindex } } = props;
      let style;
      style = zindex ? "z-index:" + zindex + ";" : "";
      let shortcode = !content && text ? text : content;
      return (
        <div className="revslider" data-modal={ modal } data-slidertitle={ sliderTitle } style={ style }>
            { shortcode }
        </div>
      );
    }
  }
];

export {deprecated};