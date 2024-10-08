<script>
import { ref, computed } from 'vue';
import DOMPurify from 'dompurify';

export default {
    props: {
        content: {
            type: String,
            required: true
        }
    },
    setup(props) {
        const sanitizedContent = computed(() => {

            return DOMPurify.sanitize(props.content);
        });

        return { sanitizedContent };
    }
};
</script>

<template>
    <div class="container">
        <div class="html-viewer" v-html="sanitizedContent"></div>
    </div>
</template>

<style scoped lang="scss">
.container {
    margin-top: 100px;
    padding: 0 20px;
    width: 100%;
    max-width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;

}
</style>

<style lang="scss">
.html-viewer {
    padding: 0 20px;
    span {
        font-size: 1.2em;
        color: black;
    }
}
</style>
