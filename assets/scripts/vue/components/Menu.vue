<script>
export default {
    props: {
        items: {
            type: Array,
            required: true
        }
    }
};
</script>

<template>
    
        <ul v-if="items && items.length">
            <li v-for="item in items" :key="item.id" >
                <a :href="item.link" :target="item.target">{{ item.title }}</a>
                <!-- Recursively render children if they exist -->
            </li>
        </ul>
 
</template>

<style scoped>


</style>
