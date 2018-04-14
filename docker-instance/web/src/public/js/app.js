webpackJsonp([0],[
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(4);
module.exports = __webpack_require__(10);


/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

__webpack_require__(5);
__webpack_require__(7);
__webpack_require__(8);
__webpack_require__(9);

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {


// window._ = require('lodash');
window.Popper = __webpack_require__(0).default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = __webpack_require__(1);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    __webpack_require__(2);
} catch (e) {}

/***/ }),
/* 6 */,
/* 7 */
/***/ (function(module, exports) {

/*

Main javascript functions to init most of the elements

#1. CHAT APP
#2. CALENDAR INIT
#3. FORM VALIDATION
#4. DATE RANGE PICKER
#5. DATATABLES
#6. EDITABLE TABLES
#7. FORM STEPS FUNCTIONALITY
#8. SELECT 2 ACTIVATION
#9. CKEDITOR ACTIVATION
#10. CHARTJS CHARTS http://www.chartjs.org/
#11. MENU RELATED STUFF
#12. CONTENT SIDE PANEL TOGGLER
#13. EMAIL APP
#14. FULL CHAT APP
#15. CRM PIPELINE
#16. OUR OWN CUSTOM DROPDOWNS 
#17. BOOTSTRAP RELATED JS ACTIVATIONS
#18. TODO Application
#19. Fancy Selector
#20. SUPPORT SERVICE
#21. Onboarding Screens Modal
#22. Colors Toggler
#23. Auto Suggest Search

*/

// Initiate on click and on hover sub menu activation logic
function os_init_sub_menus() {
    // INIT MENU TO ACTIVATE ON HOVER
    var menu_timer;
    $('.menu-activated-on-hover').on('mouseenter', 'ul.main-menu > li.has-sub-menu', function () {
        var $elem = $(this);
        clearTimeout(menu_timer);
        $elem.closest('ul').addClass('has-active').find('> li').removeClass('active');
        $elem.addClass('active');
    });

    $('.menu-activated-on-hover').on('mouseleave', 'ul.main-menu > li.has-sub-menu', function () {
        var $elem = $(this);
        menu_timer = setTimeout(function () {
            $elem.removeClass('active').closest('ul').removeClass('has-active');
        }, 30);
    });

    // INIT MENU TO ACTIVATE ON CLICK
    $('.menu-activated-on-click').on('click', 'li.has-sub-menu > a', function (event) {
        var $elem = $(this).closest('li');
        if ($elem.hasClass('active')) {
            $elem.removeClass('active');
        } else {
            $elem.closest('ul').find('li.active').removeClass('active');
            $elem.addClass('active');
        }
        return false;
    });
}

$(function () {
    os_init_sub_menus();
});

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function ($) {
    $.fn.extend({

        setMessage: function setMessage(message, className, timeout) {
            var $messageBoxes = $(this);
            message = message || '';
            className = className || '';
            timeout = timeout || 0;

            setTimeout(function () {
                $messageBoxes.each(function () {
                    $(this).removeClass('success error hidden').addClass(className).html(message).css('display', '');
                });
            }, timeout);
            return $messageBoxes;
        },

        startLoader: function startLoader(position, loaderText) {
            var $blocks = $(this);
            position = position || false;
            loaderText = loaderText || '';
            if (loaderText === true) {
                loaderText = 'Loading, please wait ...';
            }

            $blocks.each(function () {
                var $block = $(this);
                if (loaderText !== '') {
                    loaderText = '<span class="ajax-loader-text">&nbsp;&nbsp;&nbsp;' + loaderText + '&nbsp;&nbsp;&nbsp;</span>';
                }
                if (position === false) {
                    $block.stopLoader(position).append(getLoader() + loaderText);
                } else {
                    if (position === 'before') {
                        $block.stopLoader(position).before(getLoader() + loaderText);
                    } else {
                        $block.stopLoader(position).after(getLoader() + loaderText);
                    }
                }
            });
            return $blocks;
        },

        stopLoader: function stopLoader(position) {
            var $blocks = $(this);
            position = position || false;

            $blocks.each(function () {
                var $block = $(this);
                $block.removeClass('error success');
                if (position === false) {
                    $block.find('.ajax-loader').remove();
                    $block.find('.ajax-loader-text').remove();
                } else {
                    if (position === 'before') {
                        $block.prev('.ajax-loader').remove();
                        $block.prev('.ajax-loader-text').remove();
                    } else {
                        $block.next('.ajax-loader').remove();
                        $block.next('.ajax-loader-text').remove();
                    }
                }
            });
            return $blocks;
        },

        customCheckbox: function customCheckbox(timeout) {
            var $fields = $(this);
            timeout = timeout || 0;

            setTimeout(function () {
                $fields.each(function () {
                    if (!$(this).parent().hasClass('custom-checkbox')) {
                        if ($(this).is(':checked')) {
                            $(this).wrap('<span class="custom-checkbox checked"></span>');
                        } else {
                            $(this).wrap('<span class="custom-checkbox"></span>');
                        }
                    } else {
                        if ($(this).is(':checked')) {
                            $(this).parent().addClass('checked');
                        } else {
                            $(this).parent().removeClass('checked');
                        }
                    }

                    $(this).on('change', function () {
                        if ($(this).is(':checked')) {
                            $(this).parent().addClass('checked');
                        } else {
                            $(this).parent().removeClass('checked');
                        }
                    });
                });
            }, timeout);
        },

        customRadioButton: function customRadioButton(timeout) {
            var $fields = $(this);
            timeout = timeout || 0;

            setTimeout(function () {
                $fields.each(function () {
                    if (!$(this).parent().hasClass('custom-radio')) {
                        if ($(this).is(':checked')) {
                            $(this).wrap('<span class="custom-radio checked"></span>');
                        } else {
                            $(this).wrap('<span class="custom-radio"></span>');
                        }
                    } else {
                        if ($(this).is(':checked')) {
                            $(this).parent().addClass('checked');
                        } else {
                            $(this).parent().removeClass('checked');
                        }
                    }

                    $(this).on('change', function () {
                        $('input[name="' + $(this).attr('name') + '"][type="radio"]').each(function () {
                            if ($(this).is(':checked')) {
                                $(this).parent().addClass('checked');
                            } else {
                                $(this).parent().removeClass('checked');
                            }
                        });
                    });
                });
            }, timeout);
        },

        customSelect: function customSelect(timeout) {
            var $fields = $(this);
            timeout = timeout || 0;

            setTimeout(function () {
                $fields.each(function () {
                    var $select = $(this);
                    if (this.tagName !== 'SELECT') {
                        return;
                    }
                    if ($select.val() === '') {
                        $select.addClass('empty-select');
                    } else {
                        $select.removeClass('empty-select');
                    }
                    $select.on('change', function () {
                        if ($select.val() === '') {
                            $select.addClass('empty-select');
                        } else {
                            $select.removeClass('empty-select');
                        }
                    }).closest('form').on('reset', function () {
                        $select.addClass('empty-select');
                    });
                });
            }, timeout);
            return $fields;
        },

        scrollTo: function scrollTo(speed) {
            speed = speed || false;
            var $elem = $(this);
            if ($elem.length > 0) {
                var height = $elem.offset().top,
                    navbarHeight = $('header').outerHeight() + 50;
                if (speed === false) {
                    window.scrollTo(0, height - navbarHeight);
                } else {
                    $("html, body").animate({
                        scrollTop: height - navbarHeight
                    }, speed);
                }
            }
        },

        serializeToJSON: function serializeToJSON(excludeEmpty) {
            excludeEmpty = excludeEmpty || false;
            var obj = {};
            var arr = this.serializeArray();
            $.each(arr, function () {
                if (excludeEmpty && (this.value === undefined || this.value === '')) {
                    return;
                }
                if (obj[this.name] !== undefined) {
                    if (!obj[this.name].push) {
                        obj[this.name] = [obj[this.name]];
                    }
                    obj[this.name].push(this.value || '');
                } else {
                    obj[this.name] = this.value || '';
                }
            });
            return obj;
        },

        confirmAction: function confirmAction() {
            var $items = $(this);

            $items.each(function () {
                var $item = $(this);
                var tag = this.tagName;

                var eventType = void 0;
                var uri = void 0;
                var method = 'get';
                var data = void 0;
                var confirmMessage = void 0;
                var successCallback = void 0;
                var failCallback = void 0;

                switch (tag) {
                    case 'FORM':
                        eventType = 'submit';
                        break;
                    case 'A':
                        eventType = 'click';
                        break;
                    case 'BUTTON':
                        eventType = 'click';
                        break;
                    default:
                        return; // ignore other elements
                }

                $item.on(eventType, function (e) {
                    e.preventDefault();

                    switch (tag) {
                        case 'FORM':
                            uri = $item.data('action') || $item.attr('action');
                            method = $item.data('method') || $item.attr('method');
                            data = $item.serialize();
                            break;
                        case 'A':
                        case 'BUTTON':
                            uri = $item.data('href') || $item.attr('href');
                            method = $item.data('method') || 'get';
                            break;
                        default:
                            return;
                    }

                    confirmMessage = $item.data('confirm') || 'Are you sure';
                    successCallback = $item.data('on-success');
                    failCallback = $item.data('on-fail');

                    var $confirmButton = $('<button class="btn btn-danger">Confirm</button>').on('click', function () {
                        sendAjax({
                            method: method,
                            url: uri,
                            data: data
                        }, successCallback, failCallback);
                    });
                    openModal(confirmMessage, $confirmButton);
                });
            });
            return $items;
        },

        autoCollapse: function autoCollapse(subSelector, activeSelector) {
            subSelector = subSelector || '.sub-nav';
            activeSelector = activeSelector || 'a.active';
            var $items = $(this);

            $items.each(function () {
                var $item = $(this);
                var $sub = $item.find(subSelector);
                if ($sub.length && $sub.find(activeSelector).length) {
                    $sub.collapse('show');
                }
            });

            return $items;
        },

        autoOpenTabOnError: function autoOpenTabOnError(errorSelector) {
            errorSelector = errorSelector || '.error-msg';
            var $items = $(this).find('[data-toggle="tab"]');
            var isError = false;

            $items.each(function () {
                var $item = $(this);
                var $content = $($item.attr('href'));
                if (!$item.hasClass('hidden') && $content.length && $content.find(errorSelector).length) {
                    if ($content.find(errorSelector).first().text().trim() !== '') {
                        $item.tab('show');
                        isError = true;
                        return false;
                    }
                }
            });

            if (!isError) {
                $items.not('.hidden').first().tab('show');
            }

            return $items;
        },

        copyText: function copyText() {
            var $items = $(this);

            $items.each(function () {
                var $item = $(this);
                var tag = this.tagName;
                var eventType = void 0;

                switch (tag) {
                    case 'TEXTAREA':
                    case 'INPUT':
                        eventType = 'focus';
                        break;
                    case 'SELECT':
                        eventType = 'change';
                        break;
                    default:
                        eventType = 'click';
                        break;
                }

                $item.on(eventType, function (e) {
                    if (tag === 'INPUT' || tag === 'TEXTAREA') {
                        $item.select();
                        try {
                            if (document.execCommand('copy')) {
                                notify('Copied: <strong>' + $item.val() + '</strong>');
                            } else {
                                notify('Use <strong>Ctrl-C</strong> for copy.');
                            }
                        } catch (e) {
                            console.log(e);
                            notify('Use <strong>Ctrl-C</strong> for copy.');
                        }
                    } else {
                        var text = $item.data('copy');
                        if (text === undefined) {
                            text = $item.is(':input') ? $item.val() : $item.text();
                        }
                        _copyText(text);
                    }
                });
            });

            return $items;
        }

    });
})(jQuery);

String.prototype.ucFirst = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
};
String.prototype.lcFirst = function () {
    return this.charAt(0).toLocaleLowerCase() + this.slice(1);
};

String.prototype.highlightText = function (text, all, className, tagName) {
    all = all || false;
    className = className || null;
    tagName = tagName || null;

    if (tagName === null) {
        if (className === null) {
            tagName = 'strong';
        } else {
            tagName = 'span';
        }
    }

    var regExp = all ? new RegExp('(' + text + ')', "gi") : new RegExp('(' + text + ')', "i");
    var replacement = "<" + tagName + " class=\"" + className + "\">$1</" + tagName + ">";

    return this.replace(regExp, replacement);
};

String.prototype.getQueryParam = function (name) {
    var url = decodeURI(this);
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return undefined;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
};

function getLoader() {
    return '<img class="ajax-loader" src="' + $('#assetsUrlForJS').val() + 'images/ajax-loader.gif">';
}

function openModal(body, footer, header, style) {
    header = header || false;
    footer = footer || false;
    style = style || '';
    var $modal = getModal();
    var $content = $('<div class="modal-dialog">\n\
                            <div class="modal-content">\n\
                                <div class="modal-header"></div>\n\
                                <div class="modal-body"></div>\n\
                                <div class="modal-footer"></div>\n\
                            </div>\n\
                        </div>');

    if (header) {
        if (header !== true) {
            $content.find('.modal-header').append(header);
        }
        $content.find('.modal-header').append('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
    } else {
        $content.find('.modal-header').remove();
    }
    if (footer) {
        if (footer !== true) {
            $content.find('.modal-footer').append(footer);
        }
        $content.find('.modal-footer').append('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
    } else {
        $content.find('.modal-footer').remove();
    }

    if (style === 'large') {
        $content.addClass('modal-lg');
    } else if (style === 'small') {
        $content.addClass('modal-sm');
    } else {
        $content.find('.modal-body').attr('style', style);
    }
    $content.find('.modal-body').html(body);

    $modal.empty().append($content).modal('show');
    return $modal;
}

function closeModal(timeout) {
    timeout = timeout || 0;
    var $modal = getModal();
    if (timeout === -1) {
        $modal.modal('hide');
    } else {
        setTimeout(function () {
            $modal.modal('hide');
        }, timeout);
    }
    return $modal;
}
function openPureModal(data) {
    var $modal = getModal();
    $modal.html(data).modal('show');
    return $modal;
}

function getModal() {
    var $modal = $('#universal-modal');
    if ($modal.length === 0) {
        $modal = $('<div class="modal fade universal-modal" id="universal-modal" tabindex="-1" role="dialog" aria-labelledby="universal-modal" aria-hidden="true" data-backdrop="static"></div>').prependTo('body');
    }
    return $modal;
}

function showOverlay(time) {
    time = time || 200;
    $('#overlay').fadeIn(time);
}
function hideOverlay(time) {
    time = time || 200;
    $('#overlay').fadeOut(time);
}
function notify(text, delay) {
    delay = delay || 3000;
    var $alert = $('#alert-notification');
    $alert.html(text);
    $alert.stop(true).slideDown(300).delay(delay).slideUp(500);
}

function sendAjax(params, success, fail) {
    success = success || function (r) {
        if (r.status && r.status === 'success') {
            var $modal = openModal(r.message || 'Done', true);
            if (r.redirect) {
                $modal.on('hidden.bs.modal', function () {
                    location.href = r.redirect;
                });
            }
        } else {
            openModal(r.message || 'Failed', true);
        }
    };
    fail = fail || function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.responseJSON !== undefined) {
            openModal(jqXHR.responseJSON.message || 'Failed', true);
        } else {
            openModal('Failed. ' + (jqXHR.statusText || jqXHR.status), true);
        }
    };
    $.ajax({
        method: params.method || 'GET',
        url: params.url,
        data: params.data,
        beforeSend: function beforeSend(xhr) {
            showOverlay();
        }
    }).done(function (response) {
        success(response);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        fail(jqXHR);
    }).always(function () {
        hideOverlay();
    });
}

function _copyText(text) {
    // clear text
    // const tmpDiv = document.createElement("DIV");
    // tmpDiv.innerHTML = text;
    // text = tmpDiv.textContent || tmpDiv.innerText || '';

    var $tmpCopyContainer = $('#tmp-copy-container');
    if ($tmpCopyContainer.length === 0) {
        $tmpCopyContainer = $('<textarea id="tmp-copy-container" style="width: 0; height: 0; margin-left: -9999px;"></textarea>');
        $(document.body).append($tmpCopyContainer);
    }
    $tmpCopyContainer.val(text).select();

    try {
        if (document.execCommand('copy')) {
            notify('Copied: <strong>' + text + '</strong>');
        } else {
            notify('Use <strong>Ctrl-C</strong> for copy.');
        }
    } catch (e) {
        console.log(e);
        notify('Use <strong>Ctrl-C</strong> for copy.');
    }
}

function showIframe(html, header) {
    var $frame = $('<iframe src="" width="100%" height="400px" frameborder="0"></iframe>');
    openModal($frame, true, header, 'large');

    var frameContext = $frame[0].contentWindow.document;
    var $frameBody = $('body', frameContext);

    $frameBody.html(html);
}

window.getModal = getModal;
window.openModal = openModal;
window.closeModal = closeModal;
window.openPureModal = openPureModal;
window.showOverlay = showOverlay;
window.hideOverlay = hideOverlay;
window.notify = notify;
window.copyText = _copyText;
window.showIframe = showIframe;

/***/ }),
/* 9 */
/***/ (function(module, exports) {

$(document).ready(function () {
    if (window.location.hash) {
        $(window.location.hash).scrollTo(1000);
    }

    $('a.scroll-to').on('click', function (e) {
        e.preventDefault();
        var id = $(this).attr('href');
        $(id).scrollTo(1000);
    });

    $('[data-confirm]').confirmAction();
    $('nav.sidebar').autoCollapse();
    $('[role="tablist"]').autoOpenTabOnError();
    $('[data-copy]').copyText();

    $('a[data-content]').popover({
        'trigger': 'click',
        'placement': 'auto',
        'html': true,
        'template': '<div class="popover info-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
    });
});

window.onbeforeunload = function (e) {
    showOverlay();
};

/***/ }),
/* 10 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
],[3]);