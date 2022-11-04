$(function(){
    //$('.cata__prod .cata__image, .cata__prod .cata__name').click(function(){
    //    location.href = "product.php";
    //});
    var homeSlider = new Swiper('.sc1__slider-swip', {
        autoplay: {
            delay: 4800
        },
        effect: 'fade',
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
                return '<span class="' + className + '">0' + (index + 1) + '</span>';
            }
        }
    });
    var homeSlider2 = new Swiper('.sc4__hits-slider', {
        slidesPerView: 'auto',
        spaceBetween: parseInt($(window).outerWidth()/100*3),
        autoplay: {
            delay: 2500,
            disableOnInteraction: false
        },
        loop: true,
        centeredSlides: true
    });
    if ($('.you__saw-cs').find('.cata__prod').length > 4 || $(window).outerWidth() > 980 ) {
        var nhomeSlider2 = new Swiper('.you__saw-cs', {
            slidesPerView: 'auto',
            spaceBetween: parseInt($(window).outerWidth()/100*3),
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            },
            loop: true,
            centeredSlides: true
        });
    }
    $('.header__nav').click(function (e) {
        $(this).toggleClass('active');
    });
    $('.col-cata__filter').click(function (e) {
        $(this).addClass('active');
    });

    RenderFavoriteProducts();

    /*
     ** Добавить/удалить в/из списка избранных товаров
     */
    $(".cata__like").on('click', function() {
        if ($(this).hasClass('in-favorite-list')) {
            var wishlist = $.cookie('wishlist');
            if (typeof wishlist == 'undefined' || null == wishlist) {
                $.cookie('wishlist', "");
            } else {
                var arr = wishlist.split(',');
                var w_new = [];
                for (var i = 0; i < arr.length; i++) {
                    if (arr[i] != $(this).data('product_id')) {
                        w_new.push(arr[i]);
                    }
                }
                $.cookie('wishlist', w_new.join(','), {expires: 7, path: '/'});
                $(this).removeClass('in-favorite-list');
            }
        } else {
            var wishlist = $.cookie('wishlist');
            if (typeof wishlist == 'undefined' || null == wishlist) {
                $.cookie('wishlist', $(this).data('product_id'), {expires: 7, path: '/'});
                $(".num-like").html(1);
                $(this).addClass('in-favorite-list');
            } else {
                var arr = wishlist.split(',');
                for (var i = 0; i < arr.length; i++) {
                    if (arr[i] == $(this).data('product_id')) {
                        return false;
                    }
                }
                $.cookie('wishlist', wishlist + ',' + $(this).data('product_id'), {expires: 7, path: '/'});
                $(this).addClass('in-favorite-list');
                $(".num-like").html(arr.length + 1);
            }
        }
    });
    $(".cata__like-delete").on('click', function() {
        var wishlist = $.cookie('wishlist');
        if (typeof wishlist == 'undefined' || null == wishlist) {
            return false;
        } else {
            var wishlistNew = '';
            var arr = wishlist.split(',');
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] != $(this).data('product_id')) {
                    wishlistNew += wishlistNew != '' ? ',' + arr[i] : arr[i];
                }
            }

            if (wishlistNew != '') {
                $.cookie('wishlist', wishlistNew, {expires: 7, path: '/'});
            } else {
                $.cookie('wishlist', null, {path: '/'});
            }

            // На странице со списком избранных товаров спрятать карточку товара (без перезагрузки неправильно работает умный фильтр)
            //if (document.URL.indexOf('/catalog/favorite/') != -1) {
                location.reload();
            //}
        }
    });
    $('body').on('click', '.expand__header', function (e) {
        var headr = $(this);
        headr.closest('.block-expand').toggleClass('active');
    });
    $('body').on('click', '.color__sel-holder', function (e) {
        var holdr = $(this);
        holdr.addClass('active');
    });
    $('body').on('change', '.color__sel-holder input', function (e) {
        var holdr = $(this).closest('.color__sel-holder');
        holdr.removeClass('active');
    });
    $(window).resize(function(){
        $.cookie('sc_w', $(window).outerWidth(), {expires: 120, path: '/'});
    }).resize();
    $('.you-saw-wrapper, .col__cata-prods').each(function () {
        if ($(this).find('.cata__prod').length % 4 !== 0) {
            $(this).find('.cata__prod').last().after('<div class="cata__prod">&nbsp;</div>');
        }
    });
    $('.you-saw-wrapper, .col__cata-prods').each(function () {
        if ($(this).find('.cata__prod').length % 4 !== 0) {
            $(this).find('.cata__prod').last().after('<div class="cata__prod">&nbsp;</div>');
        }
    });
    $('.you-saw-wrapper, .col__cata-prods').each(function () {
        if ($(this).find('.cata__prod').length % 4 !== 0) {
            $(this).find('.cata__prod').last().after('<div class="cata__prod">&nbsp;</div>');
        }
    });

    $('#detailAdd2BasketButton').click(function (e) {
        var proto = $(this).closest('.prod-bg-wrapper').find('.product-item-detail-slider-image.active img');
        var x = proto.offset().left;
        var y = proto.offset().top;
        var w = proto.outerWidth();
        var h = proto.outerHeight();
        var clone = proto.clone().addClass('fly-to-cart').css({
            'position': 'absolute',
            'top' : y+'px',
            'left' : x+'px',
            'width' : w+'px',
            'height' : h+'px',
            'z-index' : '1000',
            // 'border' : '1px solid #F00',
        }).appendTo('body').animate({
            opacity: 0.25,
            left: $('.header__cart').offset().left+'px',
            top: $('.header__cart').offset().top+'px',
            width: '20px',
            height: '20px',
        }, 1200, function() {
            console.log('finished');
            $($('.fly-to-cart')[0]).remove();
        });

        $('#modal__add-to-cart').show("slow");
        setTimeout(function () {
            $('#modal__add-to-cart').hide("slow");
        }, 3000);
    });
});

function RenderFavoriteProducts() {
    var wishlist = $.cookie('wishlist');
    if (typeof wishlist != 'undefined' && null != wishlist) {
        var arr = wishlist.split(',');
    } else {
        var arr = [];
    }
    $('.product-item-container').each(function (index, value) {
        var id = $(this).find('.cata__like').data('product_id');
        if ($.inArray(id+'', arr) !== -1) {
            $(this).find('.cata__like').addClass('in-favorite-list');
        } else {
            $(this).find('.cata__like').removeClass('in-favorite-list');
        }
    });
}