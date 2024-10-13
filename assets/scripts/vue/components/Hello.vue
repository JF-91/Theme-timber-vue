<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
           
            counter: 0,
        };
    },
    methods: {
        incrementCounter() {
            this.counter++;
        },
    },
}
</script>

<template>
    <div>
        <h1>this is about : {{ name }}</h1>
        <button @click="incrementCounter">Incrementar contador</button>
        <p>Contador: {{ counter }}</p>
    </div>
</template>

<style lang="scss" scoped>
</style>