import Vue from 'vue';
import {library} from '@fortawesome/fontawesome-svg-core';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {
    faTimes
} from '@fortawesome/free-solid-svg-icons';

Vue.component('Icon', FontAwesomeIcon);

library.add(faTimes);
