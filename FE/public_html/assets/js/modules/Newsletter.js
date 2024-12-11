export const __initCheckboxses = () => {
  $('.form_checkbox').on('click', e => {
    const currentElement = $(e.currentTarget);
    const currentCheckbox = currentElement.find('input:checked');

    if (currentCheckbox.length) {
      currentElement.find('.w-checkbox-input').addClass('w--redirected-checked');
    } else {
      currentElement.find('.w-checkbox-input').removeClass('w--redirected-checked');
    }
  });
}

const handleError = (_err) => {
  $(".form_message-warn").show();
  $("#newsletter_success_message").hide();
  if (typeof _err.response.data !== "undefined") {
    $(".form_message-warn").html(_err.response.data.message);
  }
}

const handleSuccess = () => {
  $(".form_message-warn").hide();
  $("#newsletter_success_message").show();

  $("#footer_email").val('');
}

const validateEmail = (email) => {
  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

const submitNewsletter = async () => {
  try {
    const {data} = await axios(baseURL + 'api/newsletter', {
      method: 'post',
      data: {
        agree: 1,
        email: $("#footer_email").val(),
        news_subscription: $("input[name=news_subscribe]:checked").length ? 1 : 0,
        catalog_subscription: 1,
        consultation_subscription: $("input[name=consultation]:checked").length ? 1 : 0,
      }
    });
    if (data.success) {
      handleSuccess();
    }
  } catch (err) {
    console.warn('[NewsletterController::err]', err);
    handleError(err);
  }
}

export const __initNewsletter = () => {
  let $footerForm = $(".form_get-pres");

  $footerForm.find('input[name=agree]').on('change', function (e) {
    let item = $(e.target);
    if (item.is(':checked')) {
      $footerForm.find('.button').removeAttr('disabled');
    } else {
      $footerForm.find('.button').attr('disabled', true);
    }
  })

  $footerForm.on('submit', e => {
    e.preventDefault();
    let IS_VALID = true;

    if (!validateEmail($("#footer_email").val())) {
      IS_VALID = false;
    }
    if ($("input[name=agree]:checked").length === 0) {
      IS_VALID = false;
    }

    if (!IS_VALID) return false;

    submitNewsletter();
  })
}
