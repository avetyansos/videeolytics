"use strict";

(function($) {
    $.fn.extend({

        setMessage: function(message, className, timeout) {
            const $messageBoxes = $(this);
            message = message || '';
            className = className || '';
            timeout = timeout || 0;

            setTimeout(function() {
                $messageBoxes.each(function() {
                    $(this).removeClass('success error hidden').addClass(className).html(message).css('display', '');
                })
            }, timeout);
            return $messageBoxes;
        },

        startLoader: function(position, loaderText) {
            const $blocks = $(this);
            position = position || false;
            loaderText = loaderText || '';
            if (loaderText === true) {
                loaderText = 'Loading, please wait ...';
            }

            $blocks.each(function() {
                let $block = $(this);
                if (loaderText !== '') {
                    loaderText = '<span class="ajax-loader-text">&nbsp;&nbsp;&nbsp;'+ loaderText +'&nbsp;&nbsp;&nbsp;</span>';
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

        stopLoader: function(position) {
            const $blocks = $(this);
            position = position || false;

            $blocks.each(function() {
                let $block = $(this);
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

        customCheckbox: function(timeout) {
            const $fields = $(this);
            timeout     = timeout || 0;

            setTimeout(function() {
                $fields.each(function() {
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

                    $(this).on('change', function() {
                        if($(this).is(':checked')){
                            $(this).parent().addClass('checked');
                        } else {
                            $(this).parent().removeClass('checked');
                        }
                    });
                });
            }, timeout);
        },

        customRadioButton: function(timeout){
            const $fields = $(this);
            timeout     = timeout || 0;

            setTimeout(function() {
                $fields.each(function() {
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

                    $(this).on('change', function() {
                        $('input[name="' + $(this).attr('name') + '"][type="radio"]').each(function() {
                            if($(this).is(':checked')){
                                $(this).parent().addClass('checked');
                            } else {
                                $(this).parent().removeClass('checked');
                            }
                        });
                    });

                });
            }, timeout);

        },

        customSelect: function(timeout) {
            const $fields = $(this);
            timeout     = timeout || 0;

            setTimeout(function() {
                $fields.each(function() {
                    let $select = $(this);
                    if (this.tagName !== 'SELECT') {
                        return;
                    }
                    if ($select.val() === '') {
                        $select.addClass('empty-select');
                    } else {
                        $select.removeClass('empty-select');
                    }
                    $select.on('change', function() {
                        if ($select.val() === '') {
                            $select.addClass('empty-select');
                        } else {
                            $select.removeClass('empty-select');
                        }
                    }).closest('form').on('reset', function() {
                        $select.addClass('empty-select');
                    })
                });
            }, timeout);
            return $fields;
        },

        scrollTo: function(speed) {
            speed = speed || false;
            const $elem = $(this);
            if ($elem.length > 0) {
                const height = $elem.offset().top,
                    navbarHeight = $('header').outerHeight() + 50;
                if (speed === false) {
                    window.scrollTo(0, height - navbarHeight);
                } else {
                    $("html, body").animate({
                        scrollTop: height - navbarHeight
                    }, speed)
                }
            }
        },

        serializeToJSON: function(excludeEmpty) {
            excludeEmpty = excludeEmpty || false;
            let obj = {};
            const arr = this.serializeArray();
            $.each(arr, function() {
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

        confirmAction: function() {
            const $items = $(this);

            $items.each(function() {
                let $item = $(this);
                let tag = this.tagName;

                let eventType;
                let uri;
                let method = 'get';
                let data;
                let confirmMessage;
                let successCallback;
                let failCallback;

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

                $item.on(eventType, function(e) {
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

                    let $confirmButton = $('<button class="btn btn-danger">Confirm</button>').on('click', function () {
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

        autoCollapse: function(subSelector, activeSelector) {
            subSelector = subSelector || '.sub-nav';
            activeSelector = activeSelector || 'a.active';
            const $items = $(this);

            $items.each(function() {
                let $item = $(this);
                let $sub = $item.find(subSelector);
                if ($sub.length && $sub.find(activeSelector).length) {
                    $sub.collapse('show');
                }
            });

            return $items;
        },

        autoOpenTabOnError: function (errorSelector) {
            errorSelector = errorSelector || '.error-msg';
            const $items = $(this).find('[data-toggle="tab"]');
            let isError = false;

            $items.each(function() {
                let $item = $(this);
                let $content = $($item.attr('href'));
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

        copyText: function() {
            const $items = $(this);

            $items.each(function() {
                let $item = $(this);
                let tag = this.tagName;
                let eventType;

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

                $item.on(eventType, function(e) {
                    if (tag === 'INPUT' || tag === 'TEXTAREA') {
                        $item.select();
                        try {
                            if (document.execCommand('copy')) {
                                notify('Copied: <strong>' + $item.val() + '</strong>')
                            } else {
                                notify('Use <strong>Ctrl-C</strong> for copy.');
                            }
                        } catch (e) {
                            console.log(e);
                            notify('Use <strong>Ctrl-C</strong> for copy.');
                        }
                    } else {
                        let text = $item.data('copy');
                        if (text === undefined) {
                            text = $item.is(':input') ? $item.val() : $item.text();
                        }
                        copyText(text);
                    }
                })
            });

            return $items;
        }

    });
})(jQuery);

String.prototype.ucFirst = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};
String.prototype.lcFirst = function() {
    return this.charAt(0).toLocaleLowerCase() + this.slice(1);
};

String.prototype.highlightText = function(text, all, className, tagName) {
    all       = all || false;
    className = className || null;
    tagName   = tagName || null;

    if (tagName === null) {
        if (className === null) {
            tagName = 'strong';
        } else {
            tagName = 'span'
        }
    }

    const regExp = all ? new RegExp('(' + text + ')', "gi") : new RegExp('(' + text + ')', "i");
    const replacement = "<" + tagName + " class=\"" + className + "\">$1</" + tagName + ">";

    return this.replace(regExp, replacement);
};

String.prototype.getQueryParam = function(name) {
    let url = decodeURI(this);
    name = name.replace(/[\[\]]/g, "\\$&");
    let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return undefined;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
};

function getLoader() {
    return '<img class="ajax-loader" src="'+$('#assetsUrlForJS').val()+'images/ajax-loader.gif">';
}

function openModal(body, footer, header, style) {
    header = header || false;
    footer = footer || false;
    style = style || '';
    const $modal = getModal();
    let $content = $('<div class="modal-dialog">\n\
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
    const $modal = getModal();
    if (timeout === -1) {
        $modal.modal('hide');
    } else {
        setTimeout(function() {
            $modal.modal('hide');
        }, timeout);
    }
    return $modal;
}
function openPureModal(data) {
    const $modal = getModal();
    $modal.html(data).modal('show');
    return $modal;
}

function getModal() {
    let $modal = $('#universal-modal');
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
    const $alert = $('#alert-notification');
    $alert.html(text);
    $alert.stop(true).slideDown(300).delay(delay).slideUp(500);
}

function sendAjax(params, success, fail) {
    success = success || function (r) {
        if (r.status && r.status === 'success') {
            let $modal = openModal(r.message || 'Done', true);
            if (r.redirect) {
                $modal.on('hidden.bs.modal', function () {
                    location.href = r.redirect;
                })
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
        beforeSend: function (xhr) {
            showOverlay();
        }
    }).done(function (response) {
        success(response);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        fail(jqXHR);
    }).always(function () {
        hideOverlay();
    })
}

function copyText(text) {
    // clear text
    // const tmpDiv = document.createElement("DIV");
    // tmpDiv.innerHTML = text;
    // text = tmpDiv.textContent || tmpDiv.innerText || '';

    let $tmpCopyContainer = $('#tmp-copy-container');
    if ($tmpCopyContainer.length === 0) {
        $tmpCopyContainer = $('<textarea id="tmp-copy-container" style="width: 0; height: 0; margin-left: -9999px;"></textarea>');
        $(document.body).append($tmpCopyContainer);
    }
    $tmpCopyContainer.val(text).select();

    try {
        if (document.execCommand('copy')) {
            notify('Copied: <strong>' + text + '</strong>')
        } else {
            notify('Use <strong>Ctrl-C</strong> for copy.');
        }
    } catch (e) {
        console.log(e);
        notify('Use <strong>Ctrl-C</strong> for copy.');
    }
}

function showIframe(html, header) {
    const $frame = $('<iframe src="" width="100%" height="400px" frameborder="0"></iframe>');
    openModal($frame, true, header, 'large');

    const frameContext = $frame[0].contentWindow.document;
    const $frameBody = $('body', frameContext);

    $frameBody.html(html);
}

window.getModal = getModal;
window.openModal = openModal;
window.closeModal = closeModal;
window.openPureModal = openPureModal;
window.showOverlay = showOverlay;
window.hideOverlay = hideOverlay;
window.notify = notify;
window.copyText = copyText;
window.showIframe = showIframe;