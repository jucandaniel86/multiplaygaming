function onScroll(event) {
  var scrollPos = $(document).scrollTop();
  $('.link_nav-fair').each(function () {
    var currLink = $(this);
    var refElement = $(currLink.attr("href"));
    if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
      $('#menu-center ul li a').removeClass("w--current");
      currLink.addClass("w--current");
    } else {
      currLink.removeClass("w--current");
    }
  });
}

export const __initPrivacy = () => {
  $(document).on("scroll", onScroll);

  $('a[href^="#"]').on('click', function (e) {
    e.preventDefault();
    $(document).off("scroll");

    $('a').each(function () {
      $(this).removeClass('active');
    })
    $(this).addClass('active');

    var target = this.hash,
      menu = target;
    let $target = $(target),
      scrollTop = $target.offset().top + parseInt($('.navbar_component').height());

    $('html, body').stop().animate({
      'scrollTop': scrollTop
    }, 500, 'swing', function () {
      window.location.hash = target;
      $(document).on("scroll", onScroll);
      console.log($target.offset().top)
    });
  });
}
