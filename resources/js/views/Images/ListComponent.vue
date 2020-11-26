<template>
    <div class="w-3/6 h-full px-6 py-10">
        <stack :column-min-width="150" :gutter-width="16" :gutter-height="16" monitor-images-loaded>
            <stack-item v-for="(image, i) in images" :key="i" style="transition: transform .3s">
                <router-link :to="{name: 'images.show', params: {image: image.id}}">
                    <img :src="image.src" class="rounded-md shadow-md cursor-pointer image"
                         :class="{selected: isSelected(image.id), 'has-image': hasImage()}">
                </router-link>
            </stack-item>
        </stack>
    </div>
</template>

<script>
import {Stack, StackItem} from 'vue-stack-grid';

export default {
    name: 'ImagesList',

    components: {Stack, StackItem},

    data() {
        return {
            images: []
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

    mounted() {
        this.$nextTick(() => {
            for (let i = 1; i <= 50; i++) {
                this.images.push({
                    id: i,
                    src: 'https://source.unsplash.com/random/' + i
                });
            }
        })
    }
}
</script>

<style lang="scss" scoped>
.image {
    transition: filter .3s;
    filter: grayscale(.4);

    &:hover, &.selected {
        transform: scale(1.05);
        filter: grayscale(0) saturate(1.2) !important;
        box-shadow: 0 0 1rem .2rem rgba(0, 0, 0, .3);
    }

    &.has-image {
        filter: grayscale(1);
    }
}
</style>
