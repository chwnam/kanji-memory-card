jQuery(function ($) {
    const defined = $.extend({
        ajax_url: '',
        actions: {
            kmc_get_kanji: {
                action: '',
                nonce: '',
            },
        },
    }, kmcMemoryCard)

    $.fn.kanjiMemoryCard = function () {
        const that = $(this),
            question = $('.kanji-memory-card__question', that),
            counter = $('.kanji-memory-card__counter', that),
            title = $('.kanji-memory-card__title', that),
            answer = $('.kanji-memory-card__answer', that),
            prev = $('.kanji-memory-card__answer-button-prev', that),
            show = $('.kanji-memory-card__answer-button-show', that),
            next = $('.kanji-memory-card__answer-button-next', that)

        let current = -1,
            items = []

        function display() {
            if (-1 < current && current < items.length) {
                counter.text(current + 1 + ' / ' + items.length)
                title.text(items[current].question)
                answer.html(items[current].answer)
            }
        }

        function getPrev() {
            if (current > 0) {
                current--
                display()
            }
        }

        function getNext() {
            if (-1 < current && current < items.length - 1) {
                current++
                display()
            } else {
                fetchNext().done(function () {
                    current++
                    display()
                })
            }
        }

        function fetchNext() {
            return $.ajax({
                beforeSend: function () {
                    next.prop('disabled', true)
                },
                complete: function () {
                    next.prop('disabled', false)
                },
                error: function (jqXhr) {
                    console.log(jqXhr.responseText)
                },
                data: {
                    action: defined.actions.kmc_get_kanji.action,
                    nonce: defined.actions.kmc_get_kanji.nonce,
                },
                method: 'get',
                success: function (response) {
                    if (!response.success) {
                        alert(response.data)
                        return
                    }
                    items.push(response.data)
                },
                url: defined.ajax_url,
            })
        }

        prev.on('click', function () {
            getPrev()
        })

        next.on('click', function () {
            getNext()
        }).trigger('click')

        show.on('mousedown', function () {
            // show answer
            question.addClass('hidden')
            answer.removeClass('hidden')
        })

        show.on('mouseup', function () {
            // hide answer
            question.removeClass('hidden')
            answer.addClass('hidden')
        })

        return this
    }

    $('.kanji-memory-card').kanjiMemoryCard()
})