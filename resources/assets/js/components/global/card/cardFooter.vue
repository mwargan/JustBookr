<template>
    <div class="card-footer">
        <template v-if="loading">
            <v-button class="link" :loading="true"></v-button>
        </template>
        <template v-else>
            <slot>
                <router-link :to="{ name: 'post.buy', params: {id: postId } }" class="link">
                    {{ $t('buy') }}
                </router-link>
            </slot>
        </template>
    </div>
</template>
<script>
export default {
    name: 'card-footer',
    props: ['po', 'postId', 'loading']
}
</script>
<style scoped>
.btn-loading {
    background-color: #fff;
    border-color: #fff;
    opacity: 1;
    position: initial;
}
</style>