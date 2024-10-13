<script>
export default {
    props: {
        images: {
            type: Array,
            required: true
        }
    },
    mounted() {
        this.startAutoSlide();
    },
    beforeUnmount() {
        this.stopAutoSlide();
    },
    data() {
        return {
            currentIndex: 0,
            interval: null,
        };
    },
    methods: {
        nextSlide() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },
        prevSlide() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        },
        startAutoSlide() {
            this.interval = setInterval(() => {
                this.nextSlide();
            }, 3000);
        },
        stopAutoSlide() {
            clearInterval(this.interval);
        },
        handleManualNavigation(direction) {
            this.stopAutoSlide();
            if (direction === 'next') {
                this.nextSlide();
            } else if (direction === 'prev') {
                this.prevSlide();
            }
            this.startAutoSlide();
        },
    },

};
</script>

<template>
    <div class="carousel">
        <div class="carousel-container">
            <div class="carousel-slide" :style="{ transform: 'translateX(-' + currentIndex * 100 + '%)' }">
                <div v-for="(image, index) in images" :key="index" class="carousel-item">
                    <img :src="image" class="carousel-image" alt="carousel image">
                </div>
            </div>
        </div>

        <button class="carousel-button prev" @click="handleManualNavigation('prev')">Prev</button>
        <button class="carousel-button next" @click="handleManualNavigation('next')">Next</button>
    </div>
</template>

<style scoped lang="scss">
.carousel {
    position: relative;
    width: 100%;
    max-width: 37.5rem;
    overflow: hidden;
    margin: 0 auto;
}

.carousel-container {
    display: flex;
    transition: transform 0.5s ease-in-out;
    
    height: 600px;
    width: 100%;
}

.carousel-slide {
    display: flex;
    align-items: center;
}

.carousel-item {
    min-width: 100%;
}

.carousel-image {
    display: block;
    width: 100%;
    height: auto;
    object-fit: cover;
}

.carousel-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 0.625rem;
    cursor: pointer;
    font-size: 1.125rem;
}

.prev {
    left: 0.625rem;
}

.next {
    right: 0.625rem;
}
</style>
