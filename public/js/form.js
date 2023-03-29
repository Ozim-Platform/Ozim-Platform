//TODO Сделать на es-2015 https://learn.javascript.ru/es-class
(function ($) {
  "use strict";

  $.fn.activeForm = function (method) {
    if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === 'object' || !method) {
      return methods.init.apply(this, arguments);
    } else {
      $.error('Method ' + method + ' does not exist on jQuery.yiiActiveForm');
      return false;
    }
  };
  // NOTE: If you change any of these defaults, make sure you update yii\widgets\ActiveForm::getClientOptions() as well
  let defaults = {
    isModal: false,
    ajaxDataType: 'JSON',
    button_click: null
  };
  let methods = {
    init: function (options) {
      return this.each(function () {
        let $form = $(this);
        if ($form.data('activeForm')) {
          return;
        }
        let settings = $.extend({}, defaults, options || {});
        $form.data('activeForm', {
          settings: settings
        });
        let messages = {};
        $('[type="submit"]', $form).on('click', function (e) {
          $form.data().button_click = $(this)
        });
        $form.ajaxForm(
          {
            url: $form.prop('action'),
            type: $form.prop('method'),
            dataType: settings.ajaxDataType,
            beforeSubmit: function (arr, form_send, options) {
              return loading_button($form.data().button_click)
            },
            success: function (response) {
              loading_button($form.data().button_click);
              let modal = $form.data('activeForm').settings.isModal;
              if (modal) {
                $(modal).modal('hide');
              }
              if (response.reload_ajax !== undefined) {
                ajax_load_relation($('[data-block-relation="' + response.reload_ajax + '"]'))
              }
            },
            error: function (response) {
              loading_button($form.data().button_click);
              if (response.status === 422 || response.status === 423) {
                updateInputs($form, response.responseJSON)
                let errors = [];
                $.each(response.responseJSON, function (i, val) {
                  errors = errors.concat(val)
                });
                show_notice(errors, 'error');
              } else {
                show_notice("Произошла ошибка на стороне сервера!", 'error');
              }
            }
          }
        );
      });
    },
  };
  let updateInputs = function ($form, messages) {
    clearInputs($form);
    let data = $form.data('activeForm');
    let controller = $form.data('controller');
    if (data === undefined) {
      return false;
    }
    let locale = false;
    if ($('#' + controller + '-locale', $form).length) {
      locale = $('#' + controller + '-locale', $form).val();
    }

    $.each(messages, function (field_name, field_errors) {
      let field = false;
      if ($('#' + controller + '-' + field_name, $form).length) {
        field = $('#' + controller + '-' + field_name, $form);
      } else if ($('#' + controller + '-' + locale + '-' + field_name, $form).length) {
        field = $('#' + controller + '-' + locale + '-' + field_name, $form);
      }
      let container = $(field).closest('.form-group');
      $(container).addClass('has-error');
      let errors = '';
      $.each(field_errors, function (i, val) {
        if (errors !== '') {
          errors += '<br/>';
        }
        errors += val;
      });
      let error_block = $('<span class="help-block help-block-error"></span>');
      $(error_block).html(errors);
      $(container).append(error_block);
    })
  };
  let clearInputs = function ($form) {
    $('.has-error', $form).removeClass('has-error');
    $('.help-block-error', $form).remove();
  }
})(window.jQuery);


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on('click', 'a#destroyer', function(e) {
    e.preventDefault();

    var $this = $(this);

    $.post({
        type: $this.data('method'),
        url: $this.attr('href')
    }).done(function (data) {
        $('#modal-message').modal('show');
        if(data.success === 'OK') {
            setTimeout(reload_page, 2500);
        }
    });
});

function reload_page() {
    window.location.reload();
}
