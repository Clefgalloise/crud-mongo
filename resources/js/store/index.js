import Vue from 'vue';
import Vuex from 'vuex';

import images from './modules/images';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    strict: debug,
    modules: {
        images
    }
});
