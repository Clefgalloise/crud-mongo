<template>
    <div class="w-3/6 h-full px-6 py-10">
        <template v-if="load">
            <div class="loader">
                <SpinningDots/>
            </div>
        </template>
        <template v-else-if="images.length <= 0">
            <div class="not-found">
                <p>No image found...</p>
            </div>
        </template>
        <template v-else>
            <stack :column-min-width="200" :gutter-width="16" :gutter-height="16" monitor-images-loaded>
                <stack-item v-for="image in images" :key="image._id" style="transition: transform .3s">
                    <Item :image="image"/>
                </stack-item>
            </stack>
        </template>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import {Stack, StackItem} from 'vue-stack-grid';
import Item from './ItemComponent';
import SpinningDots from './../../components/SpinningDots';

export default {
    name: 'ImagesList',

    components: {Stack, StackItem, Item, SpinningDots},

    data() {
        return {
            load: true
        }
    },

    methods: {
        isSelected: function (image) {
            return image === this.$route.params.image;
        },
        hasImage: function () {
            return !!this.$route.params.image;
        }
    },

    computed: {
        ...mapGetters({
            images: 'images/images'
        })
    },

    mounted() {
        this.$store.dispatch('images/fetchImages').then(() => {
            setTimeout(() => this.load = false, 1000);
        });
    }
}
</script>

<style lang="scss" scoped>
.loader {
    display: flex;
    justify-content: center;
}

.not-found {
    display: flex;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;

    p {
        color: rgb(35, 43, 60);
    }
}
</style>
