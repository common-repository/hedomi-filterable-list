class WidgetHandlerClass extends elementorModules.frontend.handlers.Base {
  getDefaultSettings() {
    return {
      selectors: {
        elem : '.items__list',
        controls: '.filter__link',
        actives: '.filter__item'       
      },
    };
  }
   
  getDefaultElements() {
    const selectors = this.getSettings( 'selectors' );
        
    return {
      $controls: this.$element.find( selectors.controls ),
      $elem: this.$element.find( selectors.elem ),
      $actives: this.$element.find( selectors.actives ),
 
    };
    
  }
  
 
  // Bind the reverse Rows method on the thead .day column. 
   bindEvents() {       
    const elem = this.elements.$elem;
    const active = this.elements.$actives;
    const iso = new Isotope(elem[0], {    
    itemSelector: '.items__item',
    filter: '.items__item',
    masonry: {
       gutter: 20
    }
    });   
       
    for (const control of this.elements.$controls) {
      control.addEventListener("click", function(e) {
        e.preventDefault();
        
        const filterName = control.getAttribute("data-filter");
        iso.arrange({
            filter: `.${filterName}`
          });
            
          for (const filters of active){
            filters.classList.remove('filter__item--active');
          }
          control.closest(".filter__item").classList.add('filter__item--active');
        }) 

    
    } 
    
   }   
}
jQuery( window ).on( 'elementor/frontend/init', () => {
  const addHandler = ( $element ) => {
      elementorFrontend.elementsHandler.addHandler( WidgetHandlerClass, {
          $element,
      } );
  };

  elementorFrontend.hooks.addAction( 'frontend/element_ready/hedomi-filterable-gallary.default', addHandler );
} );
 