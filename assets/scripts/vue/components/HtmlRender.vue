<script>
import { computed } from 'vue';
import DOMPurify from 'dompurify';

function cleanStyle(style) {
    return style.replace(/background[^;]*;?/gi, '');
}

function addLineBreaks(content) {
    return content.replace(/\./g, '.<br>').replace(/:/g, ':<br><br>');
}

export default {
    props: {
        content: {
            type: String,
            required: true
        }
    },
    setup(props) {
        const sanitizedContent = computed(() => {
            const contentWithBreaks = addLineBreaks(props.content);

            // Luego sanitizamos el contenido modificado
            return DOMPurify.sanitize(contentWithBreaks, {
                FORBID_TAGS: ['script', 'style'], 
                FORBID_ATTR: ['style', 'onclick', 'onload', 'onerror'],
                ADD_ATTR: ['style'],     
                BEFORE_SANITIZE_ATTRIBUTES: (node) => {
                    if (node.hasAttribute && node.hasAttribute('style')) {
                        const clean = cleanStyle(node.getAttribute('style'));
                        node.setAttribute('style', clean);  // Asigna el estilo limpio sin 'background'
                    }
                }
            });
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
    
    
        p {
            font-size: 0.875rem;
            line-height: 1.375rem;
    
    
            &.title {
                text-align: center;
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 2rem;
            }
    
    
    
            &.list-paragraph {
                &:first-child {
                    margin-top: 32px;
                }
    
                &:last-child {
                    margin-bottom: 32px;
                }
            }
    
        }
    
    
        div {
            .footer {
                display: none;
            }
        }
}
</style>
