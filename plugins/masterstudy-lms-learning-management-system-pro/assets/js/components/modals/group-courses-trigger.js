(function ($) {
  $(document).ready(function () {
    $('body').on('click', '.masterstudy-group-courses-modal__header-title-close, .masterstudy-group-courses-modal__close', function () {
      let $modal = $(this).closest('.masterstudy-group-courses-modal');
      $modal.removeClass('active');
      $('body').removeClass('masterstudy-group-courses-modal-active');
      $modal.find('.masterstudy-group-courses-modal__wrapper').removeClass('active');
      $modal.find('.masterstudy-group-courses__error > div').hide();
      $modal.find('.masterstudy-group-courses__addition-list input').removeClass('invalid-email');
    });

    $('[data-masterstudy-modal]').on('click', function (e) {
      e.preventDefault();
      let modalSelector = $(this).data('masterstudy-modal');
      let $modal = $(this).parent().next('.masterstudy-group-courses-modal');

      if ($modal.length) {
        $('body').addClass('masterstudy-group-courses-modal-active');
        $modal.addClass('active');

        let $group_courses_list = $modal.find('.masterstudy-group-courses__list-wrap');

        if ($group_courses_list.height() >= 300) {
          $group_courses_list.addClass('scrolled');
        }

        setTimeout(function () {
          $modal.find('.masterstudy-group-courses-modal__wrapper').addClass('active');
        }, 30);
      } else {
        console.error('Модальное окно не найдено:', modalSelector);
      }
    });
  });
})(jQuery);