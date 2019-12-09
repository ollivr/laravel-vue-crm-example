import Vue from 'vue';
import VueI18n from 'vue-i18n';
import messages  from './translations';

Vue.use(VueI18n);

// Create VueI18n instance with options
const i18n = new VueI18n({
    locale: 'ru', // set locale
    fallbackLocale: 'ru',
    messages, // set locale messages
});

export default i18n;

