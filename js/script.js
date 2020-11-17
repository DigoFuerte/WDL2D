$(document).ready(function () {

  $(".fancybox").fancybox({
    fitToView: true, // scaling the image to fit in the viewport
    beforeShow: function () {
      this.width = 1000;
      this.height = 600;
      this.title = $(this.element).data("caption");
    },
    // helpers : {
    //     title: {
    //         type: 'inside'
    //     }
    // }
  });

  $(".zoom").hover(function () {
    $(this).addClass('transition');
  }, function () {
    $(this).removeClass('transition');
  });

  // profile image upload
  $(document).on("click", "#upload-button", function () {
    document.getElementById("upload_file").value = '';
    $('#upload-image').slideToggle("slow").css({
      "display": "block"
    })

    if ($('#upload-button').html() == 'Change Image') {
      $('#upload-button').html('Cancel Upload')
    }
    else if ($('#upload-button').html() == 'Cancel Upload') {
      $('#upload-button').html('Change Image');
      $('#upload-error-msg').slideToggle("slow").css({
        "display": "none"
      });
    }
  })

  // profile update

  $(document).on("click", "#update-button", function (event) {
    $('#update-profile').slideToggle("slow").css({
      "display": "block"
    })

    if ($('#update-button').html() == 'Update Profile') {
      $('#update-button').html('Cancel Update')
    }
    else if ($('#update-button').html() == 'Cancel Update') {
      $("#update-button").html('Update Profile')
      $('#error_firstname,#error_lastname,#error_email,#error_passowrd').slideToggle("slow").css({
        "display": "none"
      });
    }

  })

});

// stop form resubmission on page refresh
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}