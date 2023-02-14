import BaseModal from '@/components/Modal/BaseModal';
import ICardPage from '@/components/utils/ICardPage';
import ISingleDatePicker from '@/components/utils/ISingleDatePicker';

import Vue from 'vue';
import IDatePicker from '@/components/utils/IDatePicker';

export default {
    connect () {
        Vue.component('base-modal', BaseModal);
        Vue.component('i-card-page', ICardPage);
        Vue.component('i-single-date-picker', ISingleDatePicker);
        Vue.component('i-date-picker', IDatePicker);
    }
}

