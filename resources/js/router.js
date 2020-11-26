import Vue from 'vue';
import VueRouter from 'vue-router';

import Images from './views/Images';
import ImagesList from './views/Images/ListComponent';
import ImagesDetail from './views/Images/DetailComponent';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/images', component: Images,
            children: [
                {
                    path: '/', name: 'images', component: ImagesList
                },
                {
                    path: ':image', name: 'images.show',
                    components: {
                        default: ImagesList,
                        detail: ImagesDetail
                    }
                }
            ]
        }
    ]
});
