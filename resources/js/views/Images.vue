<template>
    <div id="images" class="bg-gray-100 w-full h-full overflow-hidden">
        <div class="overflow-auto h-full hide-scroll" :class="{drag: drag}">
            <div class="container mx-auto flex justify-center h-full">
                <router-view/>
                <router-view name="detail"/>
            </div>
        </div>

        <transition name="fade">
            <DropZone @dragover="ondragover"/>
        </transition>
    </div>
</template>

<script>
import DropZone from "./Images/DropZoneComponent";

export default {
    name: 'Images',

    components: {DropZone},

    data() {
        return {
            drag: false
        }
    },

    methods: {
        ondragover: function (drag) {
            this.drag = drag;
        }
    }
}
</script>

<style lang="scss" scoped>
#images {
    user-select: none;
    box-shadow: inset 0 0 2rem 1rem rgba(0, 0, 0, .2);

    .drag {
        filter: blur(5px);
        transition: all .3s linear;
    }
}

.fade-enter-active, .fade-leave-active {
    transition: opacity .3s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>
