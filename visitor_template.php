<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-03 08:49
 * @File name           : visitor_template.php
 */

$main_template_path = __DIR__ . '/login_template.inc.php';
include_once __DIR__ . '/classic.php';

// set default language
if (isset($_GET['select_lang'])) {
    $select_lang = trim(strip_tags($_GET['select_lang']));
    // delete previous language cookie
    if (isset($_COOKIE['select_lang'])) {
        #@setcookie('select_lang', $select_lang, time()-14400, SWB);
        #@setcookie('select_lang', $select_lang, time()-14400, SWB, "", FALSE, TRUE);

        @setcookie('select_lang', $select_lang, [
            'expires' => time()-14400,
            'path' => SWB,
            'domain' => '',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);



    }
    // create language cookie
    #@setcookie('select_lang', $select_lang, time()+14400, SWB);
    #@setcookie('select_lang', $select_lang, time()+14400, SWB, "", FALSE, TRUE);

    @setcookie('select_lang', $select_lang, [
        'expires' => time()+14400,
        'path' => SWB,
        'domain' => '',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);



    $sysconf['default_lang'] = $select_lang;
} else if (isset($_COOKIE['select_lang'])) {
    $sysconf['default_lang'] = trim(strip_tags($_COOKIE['select_lang']));
}

$visitor_quote_enabled = ($sysconf['template']['visitor_quote'] ?? 1) == 1;

?>
<div class="visitor-bg-gradient"></div>
<div class="d-flex min-vh-100 w-100 visitor-backdrop" id="visitor-counter">
    <div class="bg-apple-light px-4 px-md-5 pt-5 pb-3 d-flex flex-column justify-content-between visitor-sidebar">
        <div>
            <h3 class="font-weight-bold mb-3 visitor-welcome-title"><?= themeEscape(__('Welcome to ').$sysconf['library_name']); ?></h3>
            <p class="lead visitor-label">
                <?= themeEscape(__('Please fill your member ID or name.'))?>
            </p>

            <div v-if="textInfo !== ''" class="alert mt-4 d-md-none shadow-sm" :class="'alert-' + textInfoType" v-text="textInfo"></div>

            <form class="mt-4" @submit.prevent="onSubmit" :aria-busy="isSubmitting ? 'true' : 'false'">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="font-weight-bold visitor-label"><?= themeEscape(__('Member ID'))?></label>
                    <input v-model="memberId" ref="memberId" autofocus type="text" class="form-control rounded-lg" id="exampleInputEmail1"
                           aria-describedby="emailHelp" placeholder="<?= themeEscape(__('Enter your member ID'))?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1" class="font-weight-bold visitor-label"><?= themeEscape(__('Institution'))?></label>
                    <input v-model="institution" type="text" class="form-control rounded-lg" id="exampleInputPassword1"
                           placeholder="<?= themeEscape(__('Enter your institution'))?>">
                    <small id="emailHelp" class="form-text mt-2 visitor-label"><?= themeEscape(__('Enough fill your member ID if you are member of ').$sysconf['library_name']); ?></small>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4 btn-visitor-checkin" :disabled="isSubmitting">{{ isSubmitting ? submittingLabel : submitLabel }}</button>
            </form>
        </div>
        <div class="text-right mt-4">
            <small><?= themeEscape(__('Powered by '))?> <code>SLiMS</code></small>
        </div>
    </div>
    <div class="flex-grow-1 d-none d-md-flex flex-column justify-content-between h-100 p-5 position-relative min-vh-100">
        <!-- welcome info card dynamic -->
        <div class="h-100 d-flex flex-column justify-content-between">
            <div v-show="textInfo !== ''" class="d-flex align-items-center my-auto p-4 visitor-info-card">
                <div class="mr-3">
                    <div class="bg-apple-light rounded-circle shadow-sm visitor-avatar-wrap">
                        <img :src="image" alt="image" class="img-fluid rounded-circle visitor-avatar-img" @error="onImageError">
                    </div>
                </div>
                <div class="px-4">
                    <h3 class="font-weight-bold mb-0 visitor-welcome-title" v-text="textInfo"></h3>
                </div>
            </div>
            
            <div class="mt-auto pt-5 w-100">
                <blockquote class="blockquote border-0 p-0 m-0 bg-transparent" v-if="quotesEnabled && textInfo === ''">
                    <p class="font-weight-light visitor-quotes-text">"{{quotes.content}}"</p>
                    <footer class="blockquote-footer bg-transparent border-0 p-0 m-0 mt-2 visitor-quotes-author">{{quotes.author}}</footer>
                </blockquote>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo themeEscape($sysconf['template']['dir'].'/'.$sysconf['template']['theme'].'/assets/js/axios.min.js'); ?>"></script>
<script src="<?= themeEscape(JWB . 'he.js') ?>"></script>
<script>
    new Vue({
        el: '#visitor-counter',
        data() {
            return {
                memberId: '',
                institution: '',
                textInfo: '',
                textInfoType: 'info',
                isSubmitting: false,
                submitLabel: <?= json_encode(__('Check In')) ?>,
                submittingLabel: <?= json_encode(__('Checking in...')) ?>,
                image: './images/persons/photo.png',
                quotesEnabled: <?= json_encode($visitor_quote_enabled) ?>,
                quoteFallback: {
                    content: "Sing penting madhiang.",
                    author: "Pai-Jo"
                },
                quotes: {
                    content: "Sing penting madhiang.",
                    author: "Pai-Jo"
                },
                timeout: null,
                csrfName: <?= json_encode(\Volnix\CSRF\CSRF::getTokenName()) ?>,
                csrfToken: <?= json_encode(\Volnix\CSRF\CSRF::getToken()) ?>
            }
        },
        mounted() {
            this.$refs.memberId.focus()
            if (this.quotesEnabled) {
                this.getQuotes()
            }
        },
        methods: {
            onImageError: function() {
                this.image = './images/persons/photo.png'
            },
            getQuotes: function() {
                if (!this.quotesEnabled) {
                    this.quotes = this.quoteFallback
                    this.textInfo = ''
                    this.textInfoType = 'info'
                    return
                }
                // Alternative Free Quotes API: https://api.quotable.io/random
                axios.get('https://slims.web.id/kutipan/', {timeout: 3000})
                    .then(res => {
                        this.quotes = {
                            content: he.decode(res.data.content || this.quoteFallback.content),
                            author: res.data.author || this.quoteFallback.author
                        }
                    })
                    .catch(() => {
                        this.quotes = this.quoteFallback
                    })
                    .finally(() => {
                        this.textInfo = ''
                        this.textInfoType = 'info'
                    })
            },
            plainText: function(message) {
                return String(message || '').replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').trim()
            },
            responseType: function(response) {
                const type = response && response.type ? String(response.type).toLowerCase() : ''
                if (['success', 'info', 'warning', 'danger'].indexOf(type) !== -1) {
                    return type
                }
                if (type === 'error') {
                    return 'danger'
                }
                return response && response.status === false ? 'danger' : 'info'
            },
            safeImageName: function(image) {
                return String(image || 'photo.png').replace(/[^a-zA-Z0-9._-]/g, '') || 'photo.png'
            },
            onSubmit: function() {
                if (this.memberId === '' || this.isSubmitting) {
                    this.resetForm()
                    return
                }
                this.isSubmitting = true
                let url = 'index.php?p=visitor<?= trim(isset($_GET['room']) ? '&room=' . simbio_security::xssFree($_GET['room']) : '')  ?>'
                let data = new FormData()
                data.append('memberID', this.memberId)
                data.append('institution', this.institution)
                data.append('counter', 1)
                data.append(this.csrfName, this.csrfToken)

                axios({
                    url: url,
                    method: 'post',
                    data: data,
                    headers: {'Content-Type': 'multipart/form-data', 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => {
                        this.textInfo = this.plainText(res.data.message)
                        this.textInfoType = this.responseType(res.data)
                        this.image = `./images/persons/${this.safeImageName(res.data.image)}`
                        if (res.data.new_token) {
                            this.csrfToken = res.data.new_token
                        }
                        <?php if ($sysconf['template']['visitor_log_voice']) : ?>
                            this.textToSpeech(this.textInfo)
                        <?php endif; ?>
                    })
                    .catch(err => {
                        console.log(err);
                        this.textInfo = this.plainText((err.response && err.response.data && err.response.data.message) || <?= json_encode(__('Check in failed')) ?>)
                        this.textInfoType = 'danger'
                        if (err.response && err.response.data.new_token) {
                            this.csrfToken = err.response.data.new_token
                        }
                    })
                    .finally(() => {
                        this.isSubmitting = false
                        this.resetForm()
                        clearTimeout(this.timeout)
                        this.timeout = setTimeout(() => {
                            this.getQuotes()
                        }, 5000)
                    })
            },
            resetForm: function () {
                this.memberId = ''
                this.institution = ''
                this.$refs.memberId.focus()
            },
            textToSpeech: function(message) {
                var message = new SpeechSynthesisUtterance(message);
                var voices = speechSynthesis.getVoices();
                // console.log(message);
                message['volume'] = 1;
                message['rate'] = 1;
                message['pitch'] = 1;
                message['lang'] = <?= json_encode(str_replace('_', '-', $sysconf['default_lang'])) ?>;
                message['voice'] = null;
                speechSynthesis.cancel();
                speechSynthesis.speak(message);
            }
        }
    })
</script>
