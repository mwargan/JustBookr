<template>
    <div class="mb-2">
        <div class="row page-header">
            <div class="col-sm-6">
                <img class="profile-photo" :class="shape" onerror="this.src='/images/image_error.svg'" :src="image" :alt="title">
            </div>
            <div class="col-sm-6 m-auto">
                <h1 class="mt-1">{{ title }}</h1>
                <h5 v-if="subtitle" v-html="subtitle"></h5>
                <transition name="fade">
                    <span class="text-muted" v-if="subtext" v-html="subtext"></span>
                </transition>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    name: 'page-header',
    props: ['image', 'title', 'subtitle', 'subtext', 'image-shape'],
    computed: {
        shape () {
            if (this['image-shape'] == "circle")
                return "rounded-circle"
            }
    }
}
</script>
<style scoped>
.profile-photo {
    max-height:200px;
    max-width: 400px;
    width:100%;
    object-fit: scale-down;
    min-height:125px;
    margin: 0 auto;
    display:block;
    border-radius: 0.3rem;
}
@media (max-width: 768px) {
    .page-header {
        text-align: center;
    }
}
</style>
