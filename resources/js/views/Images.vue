<template>
    <div id="images" class="bg-gray-100 w-full h-full overflow-hidden">
        <div class="overflow-auto h-full hide-scroll">
            <div class="container mx-auto flex justify-center items-center h-full">
                <router-view/>
                <transition name="slide-fade">
                    <router-view name="detail"/>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Images'
}
</script>

<style lang="scss" scoped>
#images {
    box-shadow: inset 0 0 2rem 1rem rgba(0, 0, 0, .2);
}

.slide-fade-enter-active {
    transition: all .3s ease;
}

.slide-fade-leave-active {
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}
</style>
