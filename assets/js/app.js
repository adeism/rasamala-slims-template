/**
 * @Author: Waris Agung Widodo <user>
 * @Date:   2018-01-21T12:15:49+07:00
 * @Email:  ido.alit@gmail.com
 * @Filename: app.js
 * @Last modified by:   Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time: 2026-07-15T15:16:37+07:00
 */

'use strict';

// Vue 3 click-outside directive definition
const clickOutsideDirective = {
    beforeMount(el, binding) {
        el.clickOutsideEvent = function (event) {
            if (!(el === event.target || el.contains(event.target))) {
                binding.value(event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent);
    },
    unmounted(el) {
        document.body.removeEventListener('click', el.clickOutsideEvent);
    }
};

const allowedSearchFields = ['keywords', 'author', 'subject', 'isbn'];
const makeSearchUrl = function (searchBy, text) {
    const field = allowedSearchFields.indexOf(searchBy) !== -1 ? searchBy : 'keywords';
    const params = new URLSearchParams();
    params.set(field, text || '');
    params.set('search', 'search');
    return `index.php?${params.toString()}`;
};
const searchHistoryStorageKey = 'keywords';
const searchHistoryLimit = 25;
const searchHistoryKeywordMaxLength = 120;
const normalizeSearchKeyword = function (value) {
    const keyword = String(value || '').replace(/\s+/g, ' ').trim();
    return keyword.length > 0 && keyword.length <= searchHistoryKeywordMaxLength ? keyword : '';
};
const normalizeSearchHistory = function (history) {
    if (!history || typeof history !== 'object' || Array.isArray(history)) {
        return {};
    }

    const entries = [];
    Object.keys(history).forEach(key => {
        const item = history[key];
        const text = normalizeSearchKeyword(key);
        if (!text || !item || typeof item !== 'object') {
            return;
        }

        const time = Number(item.time);
        if (!Number.isFinite(time) || time < 0) {
            return;
        }

        const count = Number(item.count);
        const searchBy = allowedSearchFields.indexOf(item.searchBy) !== -1 ? item.searchBy : 'keywords';
        entries.push({
            text: text,
            count: Number.isFinite(count) ? Math.max(1, Math.min(9999, Math.floor(count))) : 1,
            searchBy: searchBy,
            time: time
        });
    });

    entries.sort((a, b) => b.time - a.time);
    return entries.slice(0, searchHistoryLimit).reduce((result, item) => {
        result[item.text] = {
            count: item.count,
            searchBy: item.searchBy,
            time: item.time
        };
        return result;
    }, {});
};
const readSearchHistory = function () {
    try {
        if (!window.localStorage) {
            return {};
        }
        const raw = window.localStorage.getItem(searchHistoryStorageKey);
        if (!raw || raw.length > 20000) {
            return {};
        }
        return normalizeSearchHistory(JSON.parse(raw));
    } catch (e) {
        return {};
    }
};
const writeSearchHistory = function (history) {
    try {
        if (!window.localStorage) {
            return;
        }
        window.localStorage.setItem(searchHistoryStorageKey, JSON.stringify(normalizeSearchHistory(history)));
    } catch (e) {}
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
const renderAsyncMessage = function (h, type, message) {
    return h('div', {
        class: `theme-async-state theme-async-state-${type}`,
        role: type === 'error' ? 'alert' : 'status',
        'aria-live': 'polite'
    }, message);
};
const renderSkeleton = function (h, type, count) {
    const items = [];
    for (let i = 0; i < count; i++) {
        if (type === 'collection') {
            items.push(h('div', {
                key: `skeleton-col-${i}`,
                class: 'col-6 col-sm-4 col-md-3 col-lg-2 pb-4'
            }, [
                h('div', {
                    class: 'card border-0 shadow-sm h-full theme-skeleton-card theme-skeleton-book-card'
                }, [
                    h('div', {
                        class: 'card-body p-2'
                    }, [
                        h('div', {
                            class: 'card-image fit-height theme-skeleton-cover-box'
                        }, [
                            h('div', { class: 'theme-skeleton-block theme-skeleton-cover' })
                        ]),
                        h('div', {
                            class: 'card-text mt-2'
                        }, [
                            h('div', { class: 'theme-skeleton-block theme-skeleton-line theme-skeleton-line-title mb-1' }),
                            h('div', { class: 'theme-skeleton-block theme-skeleton-line theme-skeleton-line-sub' })
                        ])
                    ])
                ])
            ]));
        } else if (type === 'member') {
            items.push(h('div', {
                key: `skeleton-mem-${i}`,
                class: 'col-12 col-md-4 mb-4'
            }, [
                h('div', {
                    class: 'card member-card theme-skeleton-card theme-skeleton-member-card'
                }, [
                    h('div', {
                        class: 'card-body text-center p-4'
                    }, [
                        h('div', {
                            class: 'card-image-rounded mx-auto theme-skeleton-avatar-box'
                        }, [
                            h('div', { class: 'theme-skeleton-block theme-skeleton-avatar rounded-circle' })
                        ]),
                        h('div', {
                            class: 'mt-3 text-center d-flex flex-column align-items-center gap-2'
                        }, [
                            h('div', { class: 'theme-skeleton-block theme-skeleton-line theme-skeleton-line-name mx-auto' }),
                            h('div', { class: 'theme-skeleton-block theme-skeleton-line theme-skeleton-line-sub mx-auto mt-1' })
                        ]),
                        h('div', {
                            class: 'mt-3 d-flex justify-content-center gap-3'
                        }, [
                            h('div', { class: 'theme-skeleton-block theme-skeleton-line theme-skeleton-line-stat' }),
                            h('div', { class: 'theme-skeleton-block theme-skeleton-line theme-skeleton-line-stat' })
                        ])
                    ])
                ])
            ]));
        } else if (type === 'subject') {
            items.push(h('div', {
                key: `skeleton-sub-${i}`,
                class: 'theme-skeleton-badge mr-2 mb-2'
            }, [
                h('div', { class: 'theme-skeleton-block theme-skeleton-badge-pill' })
            ]));
        } else {
            items.push(h('div', {
                key: `skeleton-${type}-${i}`,
                class: `theme-skeleton-item theme-skeleton-item-${type}`
            }, [
                h('div', { class: 'theme-skeleton-block' })
            ]));
        }
    }

    let wrapperClass = `theme-skeleton-list theme-skeleton-list-${type}`;
    if (type === 'collection') {
        wrapperClass = 'row mt-4 collection justify-content-center theme-skeleton-list theme-skeleton-list-collection';
    } else if (type === 'member') {
        wrapperClass = 'row justify-content-center theme-skeleton-list theme-skeleton-list-member';
    } else if (type === 'subject') {
        wrapperClass = 'd-flex flex-row flex-wrap justify-content-center mb-3 rasamala-group-subject theme-skeleton-list theme-skeleton-list-subject';
    }

    return h('div', {
        class: wrapperClass,
        role: 'status',
        'aria-live': 'polite'
    }, [
        h('span', { class: 'sr-only' }, 'Loading...'),
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
const getAutoCoverMode = function () {
    const mode = String(window.rasamalaAutoCoverMode || '').trim();
    if (['empty_missing', 'empty_only', 'none'].indexOf(mode) !== -1) {
        return mode;
    }

    return window.rasamalaAutoCoverGenerator === false ? 'none' : 'empty_missing';
};
const getCoverState = function (imageUrl, imageLoadError) {
    if (imageLoadError) {
        return 'missing';
    }

    const value = String(imageUrl || '').trim();
    const lowerValue = value.toLowerCase();
    if (!value ||
        lowerValue.indexOf('default/image.png') !== -1 ||
        lowerValue.indexOf('no-image') !== -1 ||
        lowerValue.indexOf('no-cover') !== -1) {
        return 'empty';
    }

    if (lowerValue.indexOf('notfound') !== -1 ||
        lowerValue.indexOf('not-found') !== -1 ||
        lowerValue.indexOf('file-not-found') !== -1) {
        return 'missing';
    }

    return 'valid';
};
const shouldGenerateAutoCover = function (imageUrl, imageLoadError) {
    const mode = getAutoCoverMode();
    const state = getCoverState(imageUrl, imageLoadError);
    if (mode === 'none') {
        return false;
    }
    if (mode === 'empty_only') {
        return state === 'empty';
    }

    return state === 'empty' || state === 'missing';
};

// Component Definitions
const SlimsSubject = {
    props: {
        topic: {
            type: String,
            default: ''
        }
    },
    render() {
        return Vue.h('a', {
            href: `index.php?subject="${encodeURIComponent(this.topic).replace(/%20/g, "+")}"&search=search`,
            class: 'btn btn-outline-secondary btn-rounded btn-sm mr-2 mb-2'
        }, this.topic);
    }
};

const SlimsBook = {
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
        },
        isPopular: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            imageLoadError: false
        };
    },
    render() {
        const titleParts = splitParallelTitle(this.title);
        const titleLimit = getTitleCharacterLimit();
        const titleChildren = [
            Vue.h('span', {
                class: 'parallel-title-main'
            }, limitTitleText(titleParts.main, titleLimit))
        ];

        if (titleParts.parallel) {
            titleChildren.push(Vue.h('span', {
                class: 'parallel-title-alt'
            }, [
                Vue.h('i', {
                    class: 'fas fa-language',
                    'aria-hidden': 'true'
                }),
                limitTitleText(titleParts.parallel, titleLimit)
            ]));
        }

        const imageUrl = String(this.image || '').trim();
        const fallbackImageUrl = 'lib/minigallery/file-not-found.png';

        let imageElement;
        if (!this.isPopular && shouldGenerateAutoCover(imageUrl, this.imageLoadError)) {
            let titleHash = 0;
            const cleanText = String(titleParts.main || '').trim();
            for (let i = 0; i < cleanText.length; i++) {
                titleHash = cleanText.charCodeAt(i) + ((titleHash << 5) - titleHash);
            }
            const gradientIndex = Math.abs(titleHash) % 6;

            imageElement = Vue.h('div', {
                class: `book-cover-placeholder book-cover-gradient-${gradientIndex}`,
                'aria-hidden': 'true'
            }, [
                Vue.h('div', {
                    class: 'book-cover-content'
                }, [
                    Vue.h('div', {
                        class: 'book-cover-header-text'
                    }, 'COLLECTION'),
                    Vue.h('div', {
                        class: 'book-cover-title-text'
                    }, limitTitleText(titleParts.main, 40)),
                    Vue.h('div', {
                        class: 'book-cover-footer-text'
                    }, 'FEB UI')
                ])
            ]);
        } else {
            imageElement = Vue.h('img', {
                src: this.imageLoadError ? fallbackImageUrl : (this.image || fallbackImageUrl),
                class: 'img-fluid',
                loading: 'lazy',
                alt: this.title ? `Cover of ${this.title}` : 'Collection cover',
                onError: () => {
                    if (!this.imageLoadError) {
                        this.imageLoadError = true;
                    }
                }
            });
        }

        return Vue.h('div', {
            class: 'col-6 col-sm-4 col-md-3 col-lg-2 pb-4'
        }, [
            Vue.h('a', {
                href: `index.php?p=show_detail&id=${this.biblioId}`,
                class: 'card border-0 shadow-sm cursor-pointer text-decoration-none h-full slims-book-card'
            }, [
                Vue.h('div', {
                    class: 'card-body'
                }, [
                    Vue.h('div', {
                        class: 'card-image fit-height'
                    }, [
                        imageElement
                    ]),
                    Vue.h('div', {
                        class: 'card-text mt-2 parallel-title parallel-title-home'
                    }, titleChildren)
                ])
            ])
        ]);
    }
};

const SlimsMember = {
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
    render() {
        const imageUrl = String(this.image || '').trim();
        const isPlaceholder = !imageUrl || 
                              imageUrl.indexOf('default/image.png') !== -1 || 
                              imageUrl.indexOf('notfound') !== -1 ||
                              imageUrl.indexOf('not-found') !== -1 ||
                              imageUrl.indexOf('file-not-found') !== -1 ||
                              imageUrl.indexOf('no-image') !== -1 ||
                              imageUrl.indexOf('no-avatar') !== -1;

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

            avatarElement = Vue.h('div', {
                class: `member-avatar-placeholder member-avatar-gradient-${avatarGradientIndex}`,
                'aria-label': this.memberName ? `Initials for ${this.memberName}` : 'Member initials',
                role: 'img'
            }, initials);
        } else {
            avatarElement = Vue.h('img', {
                class: 'img-fluid h-auto',
                src: this.image,
                loading: 'lazy',
                alt: this.memberName ? `Avatar of ${this.memberName}` : 'Member avatar'
            });
        }

        return Vue.h('div', {
            class: 'col-12 col-md-4 mb-4'
        }, [
            Vue.h('div', {
                class: 'card hover:shadow-md member-card'
            }, [
                Vue.h('div', {
                    class: 'card-body'
                }, [
                    Vue.h('div', {
                        class: 'card-image-rounded mx-auto'
                    }, [
                        avatarElement
                    ]),
                    Vue.h('h3', {
                        class: 'card-title text-center mt-3'
                    }, [
                        Vue.h('span', this.memberName),
                        Vue.h('br'),
                        Vue.h('small', {
                            class: 'text-secondary'
                        }, this.memberType)
                    ]),
                    Vue.h('p', {
                        class: 'card-text text-center'
                    }, [
                        Vue.h('b', this.totalLoan),
                        Vue.h('span', {
                            class: 'text-secondary ml-1'
                        }, 'Loans'),
                        Vue.h('span', {
                            class: 'd-inline-block mx-3 align-middle bg-secondary',
                            style: 'width: 1px; height: 16px;'
                        }),
                        Vue.h('b', this.totalBiblio),
                        Vue.h('span', {
                            class: 'text-secondary ml-1'
                        }, 'Title'),
                    ])
                ])
            ])
        ]);
    }
};

const SlimsCollection = {
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
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            this.loading = true;
            this.error = '';
            fetchJsonArray(this.url)
                .then(res => {
                    this.biblios = res;
                })
                .catch(err => {
                    console.error(err.message);
                    this.error = 'Unable to load collections.';
                    this.biblios = [];
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    },
    render() {
        var limitVal = parseInt(this.limit) || 6;
        if (this.loading && this.biblios.length < 1) {
            return renderSkeleton(Vue.h, 'collection', limitVal);
        }
        if (this.error) {
            return renderAsyncMessage(Vue.h, 'error', this.error);
        }
        if (this.biblios.length < 1) {
            return renderAsyncMessage(Vue.h, 'empty', 'No collections available yet.');
        }

        var isPopular = String(this.url || '').indexOf('/popular') !== -1;
        var items = this.biblios.slice(0, limitVal);
        return Vue.h('div', {
            class: 'row mt-4 collection justify-content-center'
        }, items.map(item => {
            return Vue.h(SlimsBook, {
                key: item.biblio_id,
                biblioId: item.biblio_id,
                image: item.image,
                title: item.title,
                isPopular: isPopular
            });
        }));
    }
};

const SlimsGroupSubject = {
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
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            this.loading = true;
            this.error = '';
            fetchJsonArray(this.url)
                .then(res => {
                    this.subjects = res;
                })
                .catch(err => {
                    console.error(err.message);
                    this.error = 'Unable to load topics.';
                    this.subjects = [];
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    },
    render() {
        if (this.loading && this.subjects.length < 1) {
            return renderSkeleton(Vue.h, 'subject', 8);
        }
        if (this.error) {
            return renderAsyncMessage(Vue.h, 'error', this.error);
        }
        if (this.subjects.length < 1) {
            return renderAsyncMessage(Vue.h, 'empty', 'No topics available yet.');
        }

        return Vue.h('div', {
            class: 'd-flex flex-row flex-wrap justify-content-center mb-3 rasamala-group-subject'
        }, this.subjects.map(topic => {
            return Vue.h(SlimsSubject, {
                key: topic,
                topic: topic
            });
        }));
    }
};

const SlimsGroupMember = {
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
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            this.loading = true;
            this.error = '';
            fetchJsonArray(this.url)
                .then(res => {
                    this.members = res;
                })
                .catch(err => {
                    console.error(err.message);
                    this.error = 'Unable to load top readers.';
                    this.members = [];
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    },
    render() {
        var limitVal = parseInt(this.limit) || 3;
        if (this.loading && this.members.length < 1) {
            return renderSkeleton(Vue.h, 'member', limitVal);
        }
        if (this.error) {
            return renderAsyncMessage(Vue.h, 'error', this.error);
        }
        if (this.members.length < 1) {
            return renderAsyncMessage(Vue.h, 'empty', 'No top readers available yet.');
        }

        var items = this.members.slice(0, limitVal);
        return Vue.h('div', {
            class: 'row justify-content-center'
        }, items.map(member => {
            return Vue.h(SlimsMember, {
                key: member.member_id || member.name,
                memberName: member.name,
                memberType: member.type,
                image: member.image,
                totalLoan: member.total,
                totalBiblio: member.total_title
            });
        }));
    }
};

// Initialize showAdvancedApp Vue instance if element exists
if (document.getElementById('search-wraper')) {
    const showAdvancedApp = Vue.createApp({
        data() {
            return {
                show: false,
                isFocus: false,
                searchBy: 'keywords',
                keywords: '',
                tmpObj: {},
                isProgrammaticFocus: false,
                loading: false
            };
        },
        computed: {
            lastKeywords() {
                let keywords = readSearchHistory(), arr = [];
                this.tmpObj = {};
                for (let key in keywords) {
                    if (Object.prototype.hasOwnProperty.call(keywords, key)) {
                        arr.push(keywords[key].time);
                        keywords[key].text = key;
                        this.tmpObj[keywords[key].time] = keywords[key];
                    }
                }
                arr.sort((a, b) => b - a);
                return arr.slice(0, 5);
            }
        },
        mounted() {
            if (this.$refs.keywords && window.innerWidth >= 768) {
                this.isProgrammaticFocus = true;
                this.$refs.keywords.focus();
            }
        },
        methods: {
            searchOnFocus(e) {
                if (this.isProgrammaticFocus) {
                    this.isProgrammaticFocus = false;
                    this.isFocus = true;
                    return;
                }
                this.show = true;
                this.isFocus = true;
            },
            searchOnBlur(e) {
                this.isFocus = false;
            },
            hideSearch() {
                if (!this.isFocus) {
                    this.show = false;
                    this.searchBy = 'keywords';
                }
            },
            searchOnClick(searchBy) {
                this.searchBy = searchBy;
                this.searchSubmit();
            },
            historySearchUrl(key) {
                const item = this.tmpObj[key] || {};
                return makeSearchUrl(item.searchBy, item.text);
            },
            searchSubmit() {
                if (this.keywords !== '') this.saveKeyword();
                this.loading = true;
                window.location.href = makeSearchUrl(this.searchBy, this.keywords);
            },
            saveKeyword() {
                const keyword = normalizeSearchKeyword(this.keywords);
                if (!keyword) {
                    return;
                }

                let keywords = readSearchHistory();
                if (Object.prototype.hasOwnProperty.call(keywords, keyword)) {
                    keywords[keyword] = {
                        count: keywords[keyword].count + 1,
                        searchBy: this.searchBy,
                        time: Date.now()
                    };
                } else {
                    keywords[keyword] = {
                        count: 1,
                        searchBy: this.searchBy,
                        time: Date.now()
                    };
                }
                writeSearchHistory(keywords);
            }
        }
    });

    showAdvancedApp.directive('click-outside', clickOutsideDirective);
    showAdvancedApp.mount('#search-wraper');
}

// Initialize slimsHomeApp Vue instance if element exists
if (document.getElementById('slims-home')) {
    const slimsHomeApp = Vue.createApp({});
    slimsHomeApp.directive('click-outside', clickOutsideDirective);
    slimsHomeApp.component('slims-subject', SlimsSubject);
    slimsHomeApp.component('slims-book', SlimsBook);
    slimsHomeApp.component('slims-member', SlimsMember);
    slimsHomeApp.component('slims-collection', SlimsCollection);
    slimsHomeApp.component('slims-group-subject', SlimsGroupSubject);
    slimsHomeApp.component('slims-group-member', SlimsGroupMember);
    slimsHomeApp.mount('#slims-home');
}

// Global Keyboard Shortcut (Ctrl+K / Cmd+K) for Search
(function () {
    const isMac = typeof navigator !== 'undefined' && /mac/i.test(navigator.platform || navigator.userAgent || '');
    
    document.addEventListener('DOMContentLoaded', function () {
        const kbdModifier = document.getElementById('search-kbd-modifier');
        if (kbdModifier) {
            kbdModifier.textContent = isMac ? '⌘' : 'Ctrl';
        }
    });

    document.addEventListener('keydown', function (e) {
        const isKbdShortcut = (e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K');
        if (isKbdShortcut) {
            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                e.preventDefault();

                if (document.activeElement === searchInput) {
                    searchInput.select();
                    return;
                }

                const searchWrapper = document.getElementById('search-wraper') || document.getElementById('search-form');
                if (searchWrapper) {
                    const rect = searchWrapper.getBoundingClientRect();
                    const isVisible = rect.top >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight);
                    if (!isVisible) {
                        searchWrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }

                searchInput.focus();
                if (searchInput.value) {
                    searchInput.select();
                }
            }
        }

        if (e.key === 'Escape') {
            const searchInput = document.getElementById('search-input');
            if (searchInput && document.activeElement === searchInput) {
                searchInput.blur();
            }
        }
    });
})();

// PWA Service Worker Registration
if ('serviceWorker' in navigator && window.location.protocol !== 'file:') {
    window.addEventListener('load', function () {
        const swPath = 'template/rasamala/assets/js/sw.js';
        navigator.serviceWorker.register(swPath).catch(function () {});
    });
}
