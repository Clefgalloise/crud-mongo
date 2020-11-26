<template>
    <div>
        <div v-if="drag && !load" class="dropzone" @dragleave="dragleave" @drop="drop" @dragover="dragover">
            <p>Drop image here</p>
        </div>
        <div v-if="load" class="loader">
            <SpinningDots :width="50" :circle-radius="4"/>
        </div>
    </div>
</template>

<script>
import SpinningDots from "./../../components/SpinningDots";

export default {
    name: 'ImagesDropZone',

    components: {SpinningDots},

    data() {
        return {
            drag: false,
            load: false
        }
    },

    methods: {
        drop: function (event) {
            event.preventDefault();

            this.drag = false;
            this.load = true;

            this.$store.dispatch('images/create', event.dataTransfer.files).then(() => {
                this.load = false;
            });
        },
        dragleave: function () {
            this.drag = false;
        },
        dragover: function (event) {
            event.preventDefault();

            this.drag = true;
        }
    },

    mounted() {
        document.addEventListener('dragover', this.dragover);
    },

    watch: {
        drag: function (newState) {
            this.$emit('dragover', newState)
        }
    }
}
</script>

<style lang="scss" scoped>
#container {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(#1D1D2D, .3);
    display: flex;
    justify-content: center;
    align-items: center;
}

.dropzone {
    @extend #container;

    &::before {
        content: '';
        display: block;
        position: absolute;
        border: .4rem #ffffff dashed;
        top: 5rem;
        left: 5rem;
        right: 5rem;
        bottom: 5rem;
    }

    p {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 5rem;
    }

    @supports (-webkit-text-stroke: .2rem #ffffff) {
        p {
            -webkit-text-stroke: .2rem #ffffff;
            -webkit-text-fill-color: transparent;
        }
    }
}

.loader {
    @extend #container;

    color: #ffffff;
}
</style>
