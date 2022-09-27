import BaseModal from '@/components/Modal/BaseModal';
import ICardPage from '@/components/utils/ICardPage';

import Vue from 'vue';

export default {
    connect () {
        Vue.component('base-modal', BaseModal);
        Vue.component('i-card-page', ICardPage)
    }
}

