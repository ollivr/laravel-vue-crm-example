<template>
    <div class="locale-changer">
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $i18n.locale }}<span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <div v-for="(lang, i) in langs" :key="`Lang${i}`" :value="lang">
                    <div v-if="$i18n.locale != lang" class="dropdown-item">
                        <a class="d-block" href="#" @click="changeLang($event, lang)">{{ lang }}</a>
                    </div>
                </div>
            </div>
        </li>
    </div>
</template>

<script>
    export default {
        name: 'LocaleChanger',
        data () {
            return { langs: ['en', 'ru'] }
        },
        methods: {
            changeLang(e,lang) {
                e.preventDefault();
                this.$i18n.locale = lang;
            }
        }
    }
</script>