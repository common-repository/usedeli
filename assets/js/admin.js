(function ($) {
  $(document).ready(function () {
    usedeli_check_api();

    // .usedeli-field-post-ids
    $("#usedeli_post_ids").select2();

    // On change select #usedeli_display_on
    $("#usedeli_display_on").on("change", function () {
      // Get selected option
      const selected = $(this).find(":selected").val();
      if ("specific" === selected) {
        $(".usedeli-field-post-ids").show();
        $("#usedeli_post_ids").select2();
      } else {
        $(".usedeli-field-post-ids").hide();
      }
    });

    // Check #usedeli_display_on on page load
    if ("specific" === $("#usedeli_display_on").find(":selected").val()) {
      $(".usedeli-field-post-ids").show();
      $("#usedeli_post_ids").select2();
    }

    $(".usedeli-save").on("click", function (e) {
      e.preventDefault();
      $("#usedeli-settings").submit();
    });

    $("#usedeli-settings").validate({
      errorElement: "div",
      submitHandler: function (form) {
        var formData = $(form).serialize();
        $.ajax({
          url: usedeli.ajaxurl,
          type: "POST",
          data: formData,
          beforeSend: function () {
            $(".usedeli-save").addClass("loading");
          },
          success: function (response) {
            $(".usedeli-save").removeClass("loading");
            if (response.success) {
              $.toast({
                icon: "success",
                heading: response.message.heading,
                text: response.message.text,
                position: "bottom-right",
              });
            } else {
              $.toast({
                icon: "error",
                heading: response.message.heading,
                text: response.message.text,
                position: "bottom-right",
              });
            }
            usedeli_check_api();
          },
        });
      },
    });
  });

  $("body").on("click", ".usedeli-upload", function (e) {
    e.preventDefault();
    const button = $(this);
    const wrapper = button.parent(".usedeli-image-field");
    const input = wrapper.find('input[name="usedeli_logo"]');
    const image = wrapper.find("img");
    const imageId = input.val();

    const uploader = wp
      .media({
        title: "Select Image",
        library: {
          type: "image",
        },
        button: {
          text: "Use this image",
        },
        multiple: false,
      })
      .on("select", function () {
        const attachment = uploader.state().get("selection").first().toJSON();
        input.val(attachment.id);
        image.attr("src", attachment.url);
      });

    uploader.on("open", function () {
      if (imageId) {
        const selection = uploader.state().get("selection");
        attachment = wp.media.attachment(imageId);
        attachment.fetch();
        selection.add(attachment ? [attachment] : []);
      }
    });

    uploader.open();
  });

  $(".usedeli-color").iris({
    change: function (event, ui) {
      $(this)
        .parent()
        .find(".usedeli-color-field__preview")
        .css("background-color", ui.color.toString());
    },
  });

  $(document).click(function (e) {
    if (!$(e.target).is(".usedeli-color, .iris-picker, .iris-picker-inner")) {
      $(".usedeli-color").iris("hide");
      // return false;
    }
  });

  $(".usedeli-color").click(function (event) {
    $(".usedeli-color").iris("hide");
    $(this).iris("show");
    return false;
  });

  /**
   * Check API connection
   */
  function usedeli_check_api() {
    $.ajax({
      url: usedeli.ajaxurl + "?action=usedeli_check_api",
      type: "POST",
      beforeSend: function () {
        $(".usedeli-status")
          .removeClass("connected disconnected")
          .addClass("loading")
          .text(usedeli.strings.checking_api);
      },
      success: function (response) {
        if (response.success) {
          $(".usedeli-status")
            .removeClass("loading")
            .addClass("connected")
            .text(response.status);
        } else {
          $(".usedeli-status")
            .removeClass("loading")
            .addClass("disconnected")
            .text(response.status);
        }
      },
    });
  }
})(jQuery);
