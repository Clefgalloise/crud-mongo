<template>
    <div class="spinning__dots" :style="spinningDotsStyle" ref="spinningDots">
        <svg :width="trailWidth" :height="trailWidth" :viewBox="viewBox(trailWidth)" :style="trailStyle"
             class="spinning__trail">
            <circle :cx="trailWidth / 2" :cy="trailWidth / 2" :r="radius" stroke="currentColor"
                    :stroke-width="stroke" stroke-linecap="round" fill="none"/>
        </svg>

        <svg :width="width" :height="width" :viewBox="viewBox(width)" class="spinning__circles">
            <template v-for="n in circles">
                <circle :key="n" :cx="circlePosition(n).x" :cy="circlePosition(n).y" :r="circleRadius"
                        fill="currentColor"/>
            </template>
        </svg>
    </div>
</template>

<script>
export default {
    name: 'SpinningDots',

    props: {
        width: {type: Number, default: 28},
        circles: {type: Number, default: 8},
        circleRadius: {type: Number, default: 2}
    },

    data() {
        return {
            isMounted: false,
            trailAnimationInterval: null
        }
    },

    computed: {
        spinningDotsStyle: function () {
            if (!this.isMounted) {
                return {};
            }

            return {
                width: this.width + 'px',
                height: this.width + 'px'
            };
        },
        radius: function () {
            return this.width / 2 - this.circleRadius;
        },
        stroke: function () {
            return this.circleRadius * 2;
        },
        trailWidth: function () {
            return this.radius * 2 + this.stroke;
        },
        trailStyle: function () {
            const perimeter = Math.PI * (this.width - this.stroke);

            return {
                strokeDasharray: perimeter,
                strokeDashoffset: perimeter + perimeter / this.circles,
                '--stroke-dashoffset-0': perimeter + perimeter / this.circles,
                '--stroke-dashoffset-50': perimeter + 2.5 * perimeter / this.circles,
                '--stroke-dashoffset-100': perimeter + perimeter / this.circles
            }
        }
    },

    methods: {
        viewBox: function (width) {
            return '0 0 ' + width + ' ' + width;
        },
        circlePosition: function (index) {
            const a = index * (Math.PI * 2) / this.circles;
            const x = this.radius * Math.sin(a) + this.width / 2;
            const y = this.radius * Math.cos(a) + this.width / 2;

            return {x, y};
        },
        intFromPx: function (value, initial, threshold = 0) {
            if (value === undefined || value === null) {
                return initial;
            }

            let int = parseInt(value.replace('px', ''), 10);

            if (int <= threshold) {
                return initial;
            }

            return int;
        }
    },

    mounted() {
        const style = window.getComputedStyle(this.$refs.spinningDots);

        this.width = this.intFromPx(style.width, this.width);
        this.circleRadius = this.intFromPx(style.strokeWidth, (this.circleRadius / this.width) * this.width, 1);

        this.isMounted = true;
    }
}
</script>

<style lang="scss" scoped>
.spinning__dots {
    display: inline-block;
    position: relative;
}

svg {
    position: absolute;
    top: 0;
    left: 0;
}

.spinning__circles {
    animation: spinning__spin 16s linear infinite;
    display: none;
}

@keyframes spinning__spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.spinning__trail {
    stroke-dasharray: 4;
    animation: spinning__spin2 1.6s cubic-bezier(.5, .15, .5, .85) infinite;
}

.spinning__trail circle {
    animation: trail 1.6s cubic-bezier(.5, .15, .5, .85) infinite;
}

@keyframes spinning__spin2 {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(720deg);
    }
}

@keyframes trail {
    0% {
        stroke-dashoffset: var(--stroke-dashoffset-0);
    }
    50% {
        stroke-dashoffset: var(--stroke-dashoffset-50);
    }
    100% {
        stroke-dashoffset: var(--stroke-dashoffset-100);
    }
}
</style>
