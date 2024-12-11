function getRotationDegrees(obj) {
  var matrix = obj.css("-webkit-transform") ||
    obj.css("-moz-transform") ||
    obj.css("-ms-transform") ||
    obj.css("-o-transform") ||
    obj.css("transform");
  if (matrix !== 'none') {
    var values = matrix.split('(')[1].split(')')[0].split(',');
    var a = values[0];
    var b = values[1];
    var angle = Math.round(Math.atan2(b, a) * (180 / Math.PI));
  } else {
    var angle = 0;
  }
  return (angle < 0) ? angle + 360 : angle;
}

export const __initParalax = () => {
  if ($('.paralax').length === 0) return;

  let translate = function () {
    $('.paralax, .img_awards-parallax').each(function () {
      let currentElement = $(this);

      let windowTop = $(window).scrollTop();
      let elementTop = currentElement.offset().top;
      let elementHeight = currentElement.height();
      let viewPortHeight = window.innerHeight * 0.2 - elementHeight * 0.2;
      let scrolled = windowTop - elementTop + viewPortHeight;
     
      currentElement.css({
        transform: "translate3d(0," + scrolled * 0.15 + "px, 0) " +
          "scale3d(1, 1, 1) scale3d(1, 1, 1) rotate(" + getRotationDegrees(currentElement) + "deg) skew(0deg, 0deg)",
        transformStyle: "preserve-3d"
      });
    })
  }

  $(window).on('scroll', function () {
    window.requestAnimationFrame(translate);
  });
}
