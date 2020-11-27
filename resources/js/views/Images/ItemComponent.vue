<template>
    <router-link :to="{name: 'images.show', params: {image: image._id}}" class="item">
        <img :src="image.path" class="rounded-md shadow-md cursor-pointer image"
             :class="{selected: isSelected(image._id), 'has-image': hasImage()}">
        <button class="close" @click.prevent.stop="submitDelete">
            <Icon icon="times"/>
        </button>
    </router-link>
</template>

<script>
export default {
    name: 'ImagesItem',

    props: {
        image: Object
    },

    methods: {
        isSelected: function (image) {
            return image === this.$route.params.image;
        },
        hasImage: function () {
            return !!this.$route.params.image;
        },
        submitDelete: function () {
            this.$store.dispatch('images/deleteImage', this.image._id);
        }
    }
}
</script>

<style lang="scss" scoped>
.image {
    transition: filter .3s;
    filter: grayscale(.4);

    &.selected {
        transform: scale(1.05);
        filter: grayscale(0) saturate(1.2) !important;
        box-shadow: 0 0 1rem .2rem rgba(0, 0, 0, .3);
    }

    &.has-image {
        filter: grayscale(1);
    }
}

.item:hover .image {
    transform: scale(1.05);
    filter: grayscale(0) saturate(1.2) !important;
    box-shadow: 0 0 1rem .2rem rgba(0, 0, 0, .3);
}

.item:hover .close {
    opacity: 1;
}

.close {
    position: absolute;
    top: 0;
    right: 0;
    height: 2rem;
    width: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgb(0, 0, 0);
    background: radial-gradient(circle, rgba(0, 0, 0, 0.2) 0%, rgba(255, 255, 255, 0) 80%);
    color: #ffffff;
    text-shadow: 0 0 1rem black;
    font-size: 1.5rem;
    opacity: 0;
    transition: all .3s;

    &:hover {
        transform: rotate(90deg);
    }
}
</style>
