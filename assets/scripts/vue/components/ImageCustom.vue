<script>
export default {
    props: {
        image: {
            type: String,
            required: true
        },
        index: {
            type: Number,
            required: false
        }
    },
    setup(props) {
        return {};
    },
}
</script>

<template>
    <div class="carousel-item">
        <img class="carousel-image" :src="image">
    </div>
</template>

<style lang="scss" scoped>
.carousel-image {
    width: 100%;
    height: auto;
    display: block;
}

.carousel-image {
    width: 100%;
    height: auto;
    display: block;
}
</style>