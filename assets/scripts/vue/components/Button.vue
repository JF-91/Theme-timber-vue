<script>
export default {
    props: {
        text: {
            type: String,
            required: true,
        },
        link: {
            type: String,
            required: false,
        },
    }
}
</script>

<template>
    <div class="container">
        <a  :href="link" >
            {{ text }}
        </a>
    </div>
</template>

<style lang="scss" scoped>
.container {
    display: flex;
    justify-content: center;
    padding: 12px 12px;
    align-items: center;
    font-size: 1rem;
    font-weight: bold;
    color:  white;
    border-radius: 1rem;
    background-color: black;
    cursor: pointer;
}
</style>