<template>
    <div class="w-3/6 ml-10">
        <div v-if="load" class="loader">
            <SpinningDots/>
        </div>
        <div v-else class="detail">
            <img :src="image.path" class="image">
            <div class="box">
                <p class="name truncate">{{ image.name }}</p>
                <p class="ext">.{{ image.ext }}</p>

                <div class="predictions hide-scroll">
                    <template v-if="image.predictions.length > 0">
                        <div v-for="(prediction, index) in image.predictions" :key="index" class="prediction">
                            <p class="class">{{ prediction.class }}</p>
                            <p class="score">{{ formatScore(prediction.score) }}%</p>
                        </div>
                    </template>
                    <template v-else>
                        <p>No object detected.</p>
                    </template>
                </div>

                <div class="date">
                    {{ formatDate(image.created_at) }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import SpinningDots from './../../components/SpinningDots';
import * as timeago from 'timeago.js';

export default {
    name: 'ImagesDetail',

    components: {SpinningDots},

    data() {
        return {
            load: true
        }
    },

    computed: {
        ...mapGetters({
            image: 'images/current'
        })
    },

    methods: {
        fetchImage: function () {
            this.load = true;

            this.$store.dispatch('images/fetchImage', this.$route.params.image).then(() => {
                setTimeout(() => {
                    this.load = false;
                }, 500);
            });
        },
        formatScore: function (score) {
            return Math.round((score * 100) * Math.pow(10, 2)) / Math.pow(10, 2);
        },
        formatDate: function (date) {
            return timeago.format(date);
        }
    },

    mounted() {
        this.fetchImage();
    },

    watch: {
        $route() {
            this.fetchImage();
        },
        image(to) {
            if (to === null) {
                this.$router.push({name: 'images'});
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.loader {
    margin-top: 2.5rem;
    display: flex;
    justify-content: center;
}

.detail {
    position: fixed;
    top: 2.5rem;
    bottom: 2rem;
    width: calc(50% - 10rem);

    .image {
        max-height: 50%;
        max-width: 65%;
        position: absolute;
        right: 0;
        box-shadow: 0 0 1rem rgba(#1a202c, .3);
        z-index: 10;
    }

    .box {
        user-select: initial;
        position: absolute;
        bottom: 0;
        background: transparent;
        width: 75%;
        height: 50%;
        transform: translate(10%, -20%);
        border: 5px solid #1a202c;
        color: #1a202c;
        box-shadow: -1rem 1rem 0 #1a202c;
        padding: 1rem;
        z-index: 0;
    }

    .name {
        font-weight: 500;
        font-size: 1.2rem;
        max-width: 70%;
    }

    .ext {
        background-color: #718096;
        color: #ffffff;
        display: inline-block;
        padding: .15rem 1rem;
        font-weight: bold;
        margin-top: .25rem;
    }

    .predictions {
        margin-top: 2rem;
        max-height: calc(100% - 6.5rem);
        overflow: hidden;
        overflow-y: auto;
    }

    .prediction {
        margin-bottom: .5rem;
    }

    .class {
        border-bottom: 1px solid #1a202c;
        text-transform: capitalize;
    }

    .score {
        display: flex;
        justify-content: flex-end;
        color: rgba(#1a202c, .5);
        font-size: .8rem;
    }

    .date {
        font-size: .8rem;
        position: absolute;
        bottom: .25rem;
        right: 1rem;
    }
}
</style>
