<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        link: {
            type: String,
            required: true
        },
    },
    setup(props) {
        return {};
    }
}
</script>

<template>
    <div class="container">
        <a class="link" :href="link">{{ title }}</a>
    </div>
</template>

<style lang="scss" scoped>
.container {
    margin-top: 100px;
    padding: 0 20px;
    width: 100%;
    max-width: 100%;
    display: flex;
    justify-content: start;
    align-items: center;
}

.link {
    color: #000;
    text-decoration: underline;
    text-decoration-thickness: 4px;
    text-underline-offset: 8px;
    font-size: 1.125rem;
    font-weight: 700;
}
</style>