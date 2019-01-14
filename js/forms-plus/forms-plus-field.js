/* global formsPlus */

//Mask
if( jQuery().mask ){
    jQuery.mask.definitions['h']                    = "[A-Fa-f0-9]";
    jQuery.mask.definitions['~']                    = "[+-]";
    jQuery.fn.fpMask                                = function(opts){
        if( !formsPlus.pluginCheck(this, "Forms Plus: mask - Nothing selected.") ){
            return this;
        }
        for (var i = 0; i < this.length; i++) {
            var
                $el                                 = jQuery(this[i]),
                options                             = jQuery.extend({}, opts, formsPlus.getDataOptions( $el, 'js', ['mask', 'placeholder'] )),
                mask                                = options.mask + ''
            ;
            if( !mask ){
                continue;
            }else{
                delete options.mask;
            }
            $el.mask( mask, options );
        }
        return this;
    };
    // Add init function
    formsPlus.initFn.push(function($container){
        $container.find('input[data-js-mask]').fpMask();
    });
}

jQuery.fn.fpTriggerChange                           = function(){
    var
        $els                                        = jQuery(this),
        $radios                                     = $els.filter('[type="radio"]')
    ;
    $els                                            = $els.not($radios);
    $els.trigger('fpChange');
    $radios.each(function(i, $el){
        $el     = jQuery($el);
        $el
            .closest('form, body').find('[name="' + $el.attr('name') + '"]')
            .trigger('fpChange')
        ;
    });
    return this;
};

// Add init function
formsPlus.initFn.push(function($container){
    //Toggle type
    $container.find('[data-js-toggle-type]')
        .off('.pToggleType')
        .on('click.pToggleType', function(e){
            e.preventDefault();
            var $el                                 = jQuery(this);
            if( !formsPlus.hasDataString( $el, 'jsToggleType' ) ){
                return;
            }
            var
                $container                          = $el.closest( formsPlus.selectors.fieldWrap ),
                $field                              = $container.find('input.form-control'),
                $tContent                           = $container.find('[data-js-toggle-content]')
            ;
            
            if( $container.hasClass('p-field-toggled') ){
                $container.removeClass('p-field-toggled');
                $field.attr('type', $field.data('jsOriginalType') );
                $tContent.each(function(n, $t){
                    $t                              = jQuery($t);
                    $t.html($t.data('jsOriginalContent') );
                });
            }else{
                if( !$field.data('jsOriginalType') ){
                    $field.data('jsOriginalType', $field.attr('type'));
                }
                $container.addClass('p-field-toggled');
                $field.attr('type', $el.data('jsToggleType') );
                $tContent.each(function(n, $t){
                    $t                              = jQuery($t);
                    if( !$t.data('jsOriginalContent') ){
                        $t.data('jsOriginalContent', $t.html());
                    }
                    $t.html($t.data('jsToggleContent') );
                });
            }
        })
    ;
    
    //Toggle class
    $container.find('[data-js-toggle-class]')
        .off('.pToggleClass')
        .on('click.pToggleClass', function(e){
            e.preventDefault();
            var $el                                 = jQuery(this);
            if( !formsPlus.hasDataString( $el, 'jsToggleClass' ) ){
                return;
            }
            $el.closest( formsPlus.selectors.fieldWrap ).toggleClass( $el.data('jsToggleClass') );
        })
    ;


    //clickout
    $container.find('[data-js-clickout-remove-class], [data-js-clickout-add-class]')
        .off('.fpClickOut')
        .on('mousedown.fpClickOut', function(e){
            e.stopPropagation();
        })
    ;

    //check input
    $container.find('.p-check-input .input-group').find('input, select, textarea')
        .off('.fpCheckInput')
        .on('click.fpCheckInput keyup.fpCheckInput blur.fpCheckInput', function(){
            var $el                                 = jQuery(this).closest('.p-check-input').find('input.p-check-input');
            $el.prop('checked', $el.is(':checked') || !!this.value).fpTriggerChange();
        })
    ;
    //check group toggle
    $container.find('[data-js-toggle-check-group]')
        .off('.fpToggleCheckGroup')
        .on('click.fpToggleCheckGroup', function(){
            var $el                                 = jQuery(this);
            if( formsPlus.hasDataString( $el, 'jsToggleCheckGroup' ) ){
                jQuery('[data-js-check-group="' + jQuery($el).data('jsToggleCheckGroup') + '"]')
                    .filter('[type="checkbox"],[type="radio"]')
                    .prop('checked', $el.is(':checked'))
                    .fpTriggerChange()
                ;
            }
        })
    ;
    $container.find('[data-js-check-group]')
        .off('.fpCheckGroup')
        .on('fpChange.fpCheckGroup', function(){
            var $el                                 = jQuery(this);
            if( formsPlus.hasDataString( $el, 'jsCheckGroup' ) && !$el.is(':checked') ){
                jQuery('[data-js-toggle-check-group="' + jQuery($el).data('jsCheckGroup') + '"]')
                    .filter('[type="checkbox"],[type="radio"]')
                    .prop('checked', false)
                    .fpTriggerChange()
                ;
            }
        })
    ;
    //sub checkboxes
    $container.find('[data-js-sub-check]')
        .off('.fpSubCheck')
        .on('fpChange.fpSubCheck', function(){
            var $el                                 = jQuery(this);
            if( formsPlus.hasDataString( $el, 'jsSubCheck' ) && $el.is(':checked') ){
                jQuery('[data-js-check-name="' + jQuery($el).data('jsSubCheck') + '"]')
                    .filter('[type="checkbox"],[type="radio"]')
                    .prop('checked', true)
                    .fpTriggerChange()
                ;
            }
        })
    ;
    $container.find('[data-js-check-name]')
        .off('.fpCheckNameSub')
        .on({
            'fpChange.fpCheckNameSub'   : function(){
                var $el                                 = jQuery(this);
                if( formsPlus.hasDataString( $el, 'jsCheckName' ) && !$el.is(':checked')){
                    jQuery('[data-js-sub-check="' + jQuery($el).data('jsCheckName') + '"]')
                        .filter('[type="checkbox"],[type="radio"]')
                        .prop('checked', false)
                        .fpTriggerChange()
                    ;
                }
            },
            'click.fpCheckNameSub'      : function(){
                var $el                                 = jQuery(this);
                if( formsPlus.hasDataString( $el, 'jsCheckName' ) && $el.is(':checked')){
                    var $sub                            = jQuery('[data-js-sub-check="' + jQuery($el).data('jsCheckName') + '"]')
                        .filter('[type="checkbox"],[type="radio"]')
                    ;
                    if( !$sub.filter(':checked').length ){
                        $sub
                            .filter('[data-js-sub-default]')
                            .prop('checked', true)
                            .fpTriggerChange()
                        ;
                    }
                }
            }
        })
    ;
    $container.find('[data-js-input-group]')
        .off('.fpInputGroup')
        .on({
            'focus.fpInputGroup'        : function(){
                var
                    $el                             = jQuery(this),
                    $group                          = jQuery('[data-js-input-group="' + $el.data('jsInputGroup') + '"]'),
                    ind                             = $group.index($el),
                    $test                           = false
                ;
                $el.data('prevValue', $el.val());
                if( ind > 0 ){
                    for (var i = ind - 1; i >= 0; i--) {
                        $el                         = $group.eq(i);
                        if( $el.attr('maxlength') && formsPlus.toNumber($el.attr('maxlength')) > $el.val().length ){
                            $test                   = $el;
                        }else{
                            break;
                        }
                    }
                    if( $test ){
                        $test.focus();
                    }
                }
            },
            'keydown.fpInputGroup'      : function(e){
                var
                    $el                             = jQuery(this),
                    value                           = $el.val()
                ;
                if( e.which !== 8 || value ){
                    return;
                }
                var
                    $group                          = jQuery('[data-js-input-group="' + $el.data('jsInputGroup') + '"]'),
                    ind                             = $group.index($el) - 1
                ;
                $group.eq(ind).focus();
            },
            'keypress.fpInputGroup'     : function(e){
                var
                    $el                             = jQuery(this),
                    value                           = $el.val()
                ;

                if( !($el.attr('maxlength') && formsPlus.toNumber($el.attr('maxlength')) === value.length && e.charCode !== 0) ){
                    return;
                }
                var
                    character                       = String.fromCharCode(e.charCode),
                    $group                          = jQuery('[data-js-input-group="' + $el.data('jsInputGroup') + '"]'),
                    pos                             = $el.getCursorPosition(),
                    ind                             = $group.index($el) + 1
                ;
                if(pos === formsPlus.toNumber($el.attr('maxlength'))){
                    if( ind >= $group.length ){
                        return;
                    }
                    $el                             = $group.eq(ind).focus();
                    pos                             = 0;
                    value                           = $el.val();
                    if( value === '' ){
                        $el.val(character);
                        return;
                    }
                }
                $el.val(value.slice(0, pos) + character + value.slice(pos + 1));
                $el[0].setSelectionRange(pos+1,pos+1);
            }
        })
    ;


    jQuery('body')
        .off('.fpClickOut')
        .on('mousedown', function(){
            jQuery('[data-js-clickout-remove-class], [data-js-clickout-add-class]').each(function(i, $el){
                $el                                 = jQuery($el);
                if( formsPlus.hasDataString( $el, 'jsClickoutRemoveClass' ) ){
                    $el.closest( formsPlus.selectors.fieldWrap ).removeClass( $el.data('jsClickoutRemoveClass') );
                }
                if( formsPlus.hasDataString( $el, 'jsClickoutAddClass' ) ){
                    $el.closest( formsPlus.selectors.fieldWrap ).addClass( $el.data('jsClickoutAddClass') );
                }
            });
        })
    ;
});