/**
 * @Author: Waris Agung Widodo <user>
 * @Date:   2018-01-21T12:15:49+07:00
 * @Email:  ido.alit@gmail.com
 * @Filename: app.js
 * @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time: 2026-07-09T09:16:12+07:00
 */

'use strict';

Vue.directive('click-outside', {
    priority: 700,
    bind: function (el, binding, vnode) {
        window.event = function (event) {
            if (!(el === event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', window.event)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', window.event)
    },
});

const allowedSearchFields = ['keywords', 'author', 'subject', 'isbn'];
const makeSearchUrl = function (searchBy, text) {
    const field = allowedSearchFields.indexOf(searchBy) !== -1 ? searchBy : 'keywords';
    const params = new URLSearchParams();
    params.set(field, text || '');
    params.set('search', 'search');
    return `index.php?${params.toString()}`;
};
const fetchJsonArray = function (url) {
    return fetch(url, {headers: {'Accept': 'application/json'}})
        .then(res => {
            if (!res.ok) {
                throw new Error(`Request failed with status ${res.status}`);
            }
            return res.json();
        })
        .then(res => Array.isArray(res) ? res : []);
};
const renderAsyncMessage = function (createElement, type, message) {
    return createElement('div', {
        attrs: {
            class: `theme-async-state theme-async-state-${type}`,
            role: type === 'error' ? 'alert' : 'status',
            'aria-live': 'polite'
        }
    }, message);
};
const renderSkeleton = function (createElement, type, count) {
    const items = [];
    for (let i = 0; i < count; i++) {
        items.push(createElement('div', {
            key: `skeleton-${type}-${i}`,
            attrs: {
                class: `theme-skeleton-item theme-skeleton-item-${type}`
            }
        }, [
            createElement('span', {
                attrs: {
                    class: 'theme-skeleton-block'
                }
            })
        ]));
    }

    return createElement('div', {
        attrs: {
            class: `theme-skeleton-list theme-skeleton-list-${type}`,
            role: 'status',
            'aria-live': 'polite'
        }
    }, [
        createElement('span', {
            attrs: {
                class: 'sr-only'
            }
        }, 'Loading...'),
        ...items
    ]);
};
const getParallelTitleSeparator = function () {
    const separator = String(window.rasamalaParallelTitleSeparator || '').trim();
    if (separator === '0' || separator.toLowerCase() === 'none') {
        return '';
    }
    return separator;
};
const splitParallelTitle = function (title) {
    const rawTitle = String(title || '').trim();
    const separator = getParallelTitleSeparator();
    const separatorIndex = separator ? rawTitle.indexOf(separator) : -1;

    if (separatorIndex < 0) {
        return {
            main: rawTitle,
            parallel: ''
        };
    }

    const main = rawTitle.slice(0, separatorIndex).trim();
    const parallel = rawTitle.slice(separatorIndex + separator.length).trim();

    if (!main || !parallel) {
        return {
            main: rawTitle,
            parallel: ''
        };
    }

    return {
        main: main,
        parallel: parallel
    };
};
const getTitleCharacterLimit = function () {
    const limit = parseInt(window.rasamalaTitleCharacterLimit, 10);
    if (!Number.isFinite(limit)) {
        return 100;
    }

    return Math.max(1, Math.min(300, limit));
};
const limitTitleText = function (title, limit) {
    const cleanTitle = String(title || '').trim();
    const safeLimit = typeof limit === 'number' ? Math.max(1, Math.min(300, limit)) : getTitleCharacterLimit();
    const suffix = '...';
    const chars = Array.from(cleanTitle);

    if (chars.length <= safeLimit) {
        return cleanTitle;
    }

    return chars.slice(0, Math.max(0, safeLimit - suffix.length)).join('').replace(/\s+$/, '') + suffix;
};

const show_advanced = new Vue({
    el: '#search-wraper',
    data: function () {
        return {
            show: false,
            isFocus: false,
            searchBy: 'keywords',
            keywords: '',
            tmpObj: {},
            isProgrammaticFocus: false
        }
    },
    computed: {
        lastKeywords: function () {
            let raw = localStorage.getItem('keywords')
            if (raw) {
                try {
                    let keywords = JSON.parse(raw), arr = []
                    for (let key in keywords) {
                        if (keywords.hasOwnProperty(key)) {
                            arr.push(keywords[key].time)
                            keywords[key].text = key
                            this.tmpObj[keywords[key].time] = keywords[key]
                        }
                    }
                    arr.sort()
                    arr.reverse()
                    return arr.slice(0, 5)
                } catch (e) {
                    console.error(e.message)
                    return []
                }
            }
            return []
        }
    },
    mounted: function () {
        if (this.$refs.keywords) {
            this.isProgrammaticFocus = true;
            this.$refs.keywords.focus();
        }
    },
    methods: {
        searchOnFocus: function (e) {
            if (this.isProgrammaticFocus) {
                this.isProgrammaticFocus = false;
                this.isFocus = true;
                return;
            }
            this.show = true;
            this.isFocus = true;
            const urlParams = new URLSearchParams(window.location.search);
            const search = urlParams.get('search');
            const page = urlParams.get('p');
            if (!search && !page) window.scrollTo(0, 250)
        },
        searchOnBlur: function (e) {
            this.isFocus = false
        },
        hideSearch: function () {
            if (!this.isFocus) {
                this.show = false;
                this.searchBy = 'keywords'
            }
        },
        searchOnClick: function (searchBy) {
            this.searchBy = searchBy
            this.searchSubmit()
        },
        historySearchUrl: function (key) {
            const item = this.tmpObj[key] || {}
            return makeSearchUrl(item.searchBy, item.text)
        },
        searchSubmit: function () {
            if (this.keywords !== '') this.saveKeyword()
            window.location.href = makeSearchUrl(this.searchBy, this.keywords)
        },
        saveKeyword: function () {
            let rawKeywords = localStorage.getItem('keywords')
            let keywords = {};
            if (rawKeywords) {
                try {
                    keywords = JSON.parse(rawKeywords)
                } catch (e) {
                    console.error(e.message)
                }
            }
            if (keywords.hasOwnProperty(this.keywords)) {
                keywords[this.keywords] = {
                    count: keywords[this.keywords].count + 1,
                    searchBy: this.searchBy,
                    time: Date.now()
                }
            } else {
                keywords[this.keywords] = {
                    count: 1,
                    searchBy: this.searchBy,
                    time: Date.now()
                }
            }
            let strKeyword = JSON.stringify(keywords)
            localStorage.setItem('keywords', strKeyword)
        }
    }
});

Vue.component('slims-subject', {
    props: {
        topic: {
            type: String,
            default: ''
        }
    },
    render: function(createElement) {
        return createElement('a', {
            attrs: {
                href: `index.php?subject="${encodeURIComponent(this.topic).replace(/%20/g, "+")}"&search=search`,
                class: 'btn btn-outline-secondary btn-rounded btn-sm mr-2 mb-2'
            }
        }, this.topic)
    }
});Vue.component('slims-book', {
    props: {
        biblioId: {
            type: String,
            default: ''
        },
        title: {
            type: String,
            default: ''
        },
        image: {
            type: String,
            default: ''
        }
    },
    render: function (createElement) {
        const titleParts = splitParallelTitle(this.title);
        const titleLimit = getTitleCharacterLimit();
        const titleChildren = [
            createElement('span', {
                attrs: {
                    class: 'parallel-title-main'
                }
            }, limitTitleText(titleParts.main, titleLimit))
        ];

        if (titleParts.parallel) {
            titleChildren.push(createElement('span', {
                attrs: {
                    class: 'parallel-title-alt'
                }
            }, [
                createElement('i', {
                    attrs: {
                        class: 'fas fa-language',
                        'aria-hidden': 'true'
                    }
                }),
                limitTitleText(titleParts.parallel, titleLimit)
            ]));
        }

        const imageUrl = String(this.image || '').trim();
        const isPlaceholder = !imageUrl || 
                              imageUrl.indexOf('default/image.png') !== -1 || 
                              imageUrl.indexOf('notfound.png') !== -1;

        let imageElement;
        if (isPlaceholder) {
            let titleHash = 0;
            const cleanText = String(titleParts.main || '').trim();
            for (let i = 0; i < cleanText.length; i++) {
                titleHash = cleanText.charCodeAt(i) + ((titleHash << 5) - titleHash);
            }
            const gradientIndex = Math.abs(titleHash) % 6;

            imageElement = createElement('div', {
                attrs: {
                    class: `book-cover-placeholder book-cover-gradient-${gradientIndex}`
                }
            }, [
                createElement('div', {
                    attrs: {
                        class: 'book-cover-spine'
                    }
                }),
                createElement('div', {
                    attrs: {
                        class: 'book-cover-content'
                    }
                }, [
                    createElement('i', {
                        attrs: {
                            class: 'fas fa-book book-cover-icon'
                        }
                    }),
                    createElement('div', {
                        attrs: {
                            class: 'book-cover-title-text'
                        }
                    }, limitTitleText(titleParts.main, 40))
                ])
            ]);
        } else {
            imageElement = createElement('img', {
                attrs: {
                    src: this.image,
                    class: 'img-fluid',
                    loading: 'lazy',
                    alt: this.title
                }
            });
        }

        return createElement('div', {
            attrs: {
                class: 'col-6 col-sm-4 col-md-3 col-lg-2 pb-4'
            }
        }, [
            createElement('a', {
                attrs: {
                    href: `index.php?p=show_detail&id=${this.biblioId}`,
                    class: 'card border-0 shadow-sm cursor-pointer text-decoration-none h-full slims-book-card'
                },
            }, [
                createElement('div', {
                    attrs: {
                        class: 'card-body'
                    }
                }, [
                    createElement('div', {
                        attrs: {
                            class: 'card-image fit-height'
                        }
                    }, [
                        imageElement
                    ]),
                    createElement('div', {
                        attrs: {
                            class: 'card-text mt-2 parallel-title parallel-title-home'
                        }
                    }, titleChildren)
                ])
            ])
        ])
    }
});

Vue.component('slims-member', {
    props: {
        image: {
            type: String,
            default: ''
        },
        memberName: {
            type: String,
            default: ''
        },
        memberType: {
            type: String,
            default: ''
        },
        totalLoan: {
            type: String,
            default: '0'
        },
        totalBiblio: {
            type: String,
            default: '0'
        }
    },
    render: function (createElement) {
        const imageUrl = String(this.image || '').trim();
        const isPlaceholder = !imageUrl || 
                              imageUrl.indexOf('default/image.png') !== -1 || 
                              imageUrl.indexOf('notfound.png') !== -1;

        let avatarElement;
        if (isPlaceholder) {
            const nameParts = String(this.memberName || '').trim().split(/\s+/);
            let initials = '';
            if (nameParts.length > 0) {
                initials += nameParts[0].charAt(0).toUpperCase();
                if (nameParts.length > 1) {
                    initials += nameParts[nameParts.length - 1].charAt(0).toUpperCase();
                }
            }
            if (!initials) initials = '?';

            let nameHash = 0;
            const cleanName = String(this.memberName || '').trim();
            for (let i = 0; i < cleanName.length; i++) {
                nameHash = cleanName.charCodeAt(i) + ((nameHash << 5) - nameHash);
            }
            const avatarGradientIndex = Math.abs(nameHash) % 5;

            avatarElement = createElement('div', {
                attrs: {
                    class: `member-avatar-placeholder member-avatar-gradient-${avatarGradientIndex}`
                }
            }, initials);
        } else {
            avatarElement = createElement('img', {
                attrs: {
                    class: 'img-fluid h-auto',
                    src: this.image,
                    loading: 'lazy'
                }
            });
        }

        return createElement('div', {
            attrs: {
                class: 'col-12 col-md-4 mb-4'
            }
        }, [
            createElement('div', {
                attrs: {
                    class: 'card hover:shadow-md member-card'
                }
            }, [
                createElement('div', {
                    attrs: {
                        class: 'card-body'
                    }
                }, [
                    createElement('div', {
                        attrs: {
                            class: 'card-image-rounded mx-auto'
                        }
                    }, [
                        avatarElement
                    ]),
                    createElement('h5', {
                        attrs: {
                            class: 'card-title text-center mt-3'
                        }
                    }, [
                        createElement('span', this.memberName),
                        createElement('br'),
                        createElement('small', {
                            attrs: {
                                class: 'text-secondary'
                            }
                        }, this.memberType)
                    ]),
                    createElement('p', {
                        attrs: {
                            class: 'card-text text-center'
                        }
                    }, [
                        createElement('b', this.totalLoan),
                        createElement('span', {
                            attrs: {
                                class: 'text-secondary ml-1'
                            }
                        }, 'Loans'),
                        createElement('span', {
                            attrs: {
                                class: 'd-inline-block mx-3 align-middle bg-secondary',
                                style: 'width: 1px; height: 16px;'
                            }
                        }),
                        createElement('b', this.totalBiblio),
                        createElement('span', {
                            attrs: {
                                class: 'text-secondary ml-1'
                            }
                        }, 'Title'),
                    ])
                ])
            ])
        ]);
    }
});

Vue.component('slims-collection', {
    props: {
        url: {
            type: String,
            default: ''
        },
        limit: {
            type: [Number, String],
            default: 6
        }
    },
    data() {
        return {
            biblios: [],
            loading: false,
            error: ''
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        getData() {
            this.loading = true
            this.error = ''
            fetchJsonArray(this.url)
                .then(res => {
                    this.biblios = res
                })
                .catch(err => {
                    console.error(err.message)
                    this.error = 'Unable to load collections.'
                    this.biblios = []
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    render: function (createElement) {
        var limitVal = parseInt(this.limit) || 6;
        if (this.loading && this.biblios.length < 1) {
            return renderSkeleton(createElement, 'collection', limitVal)
        }
        if (this.error) {
            return renderAsyncMessage(createElement, 'error', this.error)
        }
        if (this.biblios.length < 1) {
            return renderAsyncMessage(createElement, 'empty', 'No collections available yet.')
        }

        var items = this.biblios.slice(0, limitVal);
        return createElement('div', {
            attrs: {
                class: 'row mt-4 collection'
            }
        }, items.map(function (item) {
            return createElement('slims-book', {
                key: item.biblio_id,
                attrs: {
                    biblioId: item.biblio_id,
                    image: item.image,
                    title: item.title,
                }
            })
        }))
    }
});

Vue.component('slims-group-subject', {
    props: {
        url: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            subjects: [],
            loading: false,
            error: ''
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        getData() {
            this.loading = true
            this.error = ''
            fetchJsonArray(this.url)
                .then(res => {
                    this.subjects = res
                })
                .catch(err => {
                    console.error(err.message)
                    this.error = 'Unable to load topics.'
                    this.subjects = []
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    render: function (createElement) {
        if (this.loading && this.subjects.length < 1) {
            return renderSkeleton(createElement, 'subject', 8)
        }
        if (this.error) {
            return renderAsyncMessage(createElement, 'error', this.error)
        }
        if (this.subjects.length < 1) {
            return renderAsyncMessage(createElement, 'empty', 'No topics available yet.')
        }

        return createElement('div', {
            attrs: {
                class: 'd-flex flex-row flex-wrap mb-3'
            }
        }, this.subjects.map(function (topic) {
            return createElement('slims-subject', {
                key: topic,
                attrs: {
                    topic
                }
            })
        }))
    }
});

Vue.component('slims-group-member', {
    props: {
        url: {
            type: String,
            default: ''
        },
        limit: {
            type: [Number, String],
            default: 3
        }
    },
    data() {
        return {
            members: [],
            loading: false,
            error: ''
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        getData() {
            this.loading = true
            this.error = ''
            fetchJsonArray(this.url)
                .then(res => {
                    this.members = res
                })
                .catch(err => {
                    console.error(err.message)
                    this.error = 'Unable to load top readers.'
                    this.members = []
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    render: function (createElement) {
        var limitVal = parseInt(this.limit) || 3;
        if (this.loading && this.members.length < 1) {
            return renderSkeleton(createElement, 'member', limitVal)
        }
        if (this.error) {
            return renderAsyncMessage(createElement, 'error', this.error)
        }
        if (this.members.length < 1) {
            return renderAsyncMessage(createElement, 'empty', 'No top readers available yet.')
        }

        var items = this.members.slice(0, limitVal);
        return createElement('div', {
            attrs: {
                class: 'row'
            }
        }, items.map(function (member) {
            return createElement('slims-member', {
                key: member.member_id || member.name,
                attrs: {
                    memberName: member.name,
                    memberType: member.type,
                    image: member.image,
                    totalLoan: member.total,
                    totalBiblio: member.total_title
                }
            })
        }))
    }
});

if (document.getElementById('slims-home')) {
    const slimsHome = new Vue({
        el: '#slims-home',
    })
}
