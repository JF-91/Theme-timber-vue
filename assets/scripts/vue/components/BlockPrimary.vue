<script>
export default {
    props: {
        headline: {
            type: String,
            required: true,
        },
        textarea: {
            type: String,
            required: true,
        },
        image: {
            type: String,
            required: true,
        },
        buttonMain: {
            type: String,
            required: true,
        },
        buttonSecondary: {
            type: String,
            required: true,
        },
        linkOne: {
            type: String,
            required: true,
        },
        linkTwo: {
            type: String,
            required: true,
        },
    },
}
</script>

<template>
    <div class="container">
        <div class="text-container">
            <div class="headline">
                {{ headline }}
            </div>
    
            <div class="textarea">
                {{ textarea }}
            </div>
        </div>

        <div class="image-cotnainer">
            <img class="image" :src="image" :alt="headline" />
        </div>
    </div>

    <div class="buttons-container">
        <Button  :text="buttonMain"  :link="linkOne"/>

        <Button :text="buttonSecondary" :link="linkTwo"/>
    </div>
</template>

<style lang="scss" scoped>

.container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.text-container {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.headline {
    font-size: 2rem;
    font-weight: 700;
}

.textarea {
    font-size: 1.5rem;
}

.image-container {
    display: flex;
    justify-content: center;
}

.image {
    width: 100%;
    max-height: 20rem;
    object-fit: cover;
}

.buttons-container {
    display: flex;
    margin-top: 2rem;
    gap: 2rem;

}
</style>