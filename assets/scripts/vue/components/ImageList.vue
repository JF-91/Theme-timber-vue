<script>
export default {
    props: {
        images: {
            type: Array,
            required: true
        },
    },
    setup(props) {
        return {};
    },
     methods: {
        sanitizeUrl(url) {
            // Verifica que la URL sea válida antes de usarla
            try {
                return new URL(url).href;
            } catch (e) {
                console.error('Invalid URL:', url);
                return '';
            }
        }
    }
}
</script>

<template>    
    <div class="container">
        <div class="image-container" v-for="image in images" :key="image">
            <img  class="image" :src="image">    
        </div>
    </div>
</template>

<style lang="scss" scoped>
.container {
    margin-top: 100px;
    padding: 0 20px;
    width: 100%;
    max-width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-container {
    margin: 10px;
    max-width: 300px;
    min-height: 150px;
    height: 100%;
}

.image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>