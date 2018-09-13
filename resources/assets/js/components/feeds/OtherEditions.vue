<template>
    <div>
        <div class="title" v-if="related && related.length > 0 && loading === false">{{ $t('other_editions') }}</div>
        <card v-if="post && loading === false" v-for="(post, index) in related" :key="post['isbn']">
            <card-header :title="post['edition']+' edition'" :subtitle="post.posts_count +' posts'" :image="post['image-url']" :link="'/textbook/'+post.isbn" imageShape="square">
            </card-header>
        </card>
        <card-placeholder v-else-if="loading"></card-placeholder>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    props: ['book', 'user'],

    computed: {

    },

    data: () => ({
        related: [],
        page: 1,
        loading: false
    }),

    mounted() {
        this.getRelated()
    },

    watch: {
        'book': function(id) {
            this.getRelated()
        }
    },

    methods: {
        async getRelated() {
            this.loading = true
            var data = this
            var uni = ""
            if (this.user && this.user['uni-id']) {
                uni = "?university=" + (this.user['uni-id'])
            }
            //console.log(this.book)
            await axios('/api/v1/suggestions/other-editions/' + this.book.isbn + uni).then(response => {
                this.$set(data, 'related', response.data.data)
                this.loading = false
            })
        }
    }
}
</script>
<style scoped>
label>img {
    display: block;
}

.radio-grp {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    text-align: center;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    max-width: 700px;
    margin: 0 auto;
}

.radio-grp:after {
    display: table;
    clear: both;
    content: ' ';
}

.radio-grp .radio-btn {
    width: 50%;
}

.radio-grp .radio-btn:last-of-type {
    margin-right: 0;
}

.radio-grp .radio-btn input {
    display: none;
}

.radio-grp .radio-btn input[type='radio']:checked~label {
    color: #0c1726;
}

.radio-grp .radio-btn label {
    font-size: 1.4rem;
    display: block;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    width: 90%;
    padding: 1rem 2rem;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-transition: color .2s ease;
    transition: color .2s ease;
    color: #363636;
    color: #bdbdbd;
}

.radio-grp .radio-btn input[type='radio']:checked~label {
    opacity: 1;
}

.radio-grp .radio-btn input[type='radio']:checked~label:after {
    content: "●";
    color: #909090;
    font-size: 0.7rem;
}

label {
    width: 100%!important;
    padding-bottom: 0!important;
    opacity: 0.5;
    transition: all .2s ease!important;
}

label:after {
    content: "●";
    color: transparent;
    font-size: 0.7rem;
}


.st0 {
    fill: #244572;
    stroke: #244572;
    stroke-width: 5;
    stroke-linecap: round;
}

.st1 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-width: 5;
    stroke-linecap: round;
}

.st2 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-width: 5.0001;
    stroke-linecap: round;
}

.st3 {
    fill: #475972;
    stroke: #244572;
    stroke-width: 5.0001;
    stroke-linecap: round;
}

.st4 {
    fill: #244572;
    stroke: #244572;
    stroke-width: 5.0001;
    stroke-linecap: round;
}

.st5 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-linecap: round;
}

.st6 {
    fill: #244572;
    stroke: #244572;
    stroke-linecap: round;
}

.st7 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-width: 5.0002;
    stroke-linecap: round;
}

.st8 {
    fill: #3C74BF;
    stroke: #244572;
    stroke-width: 5.0038;
    stroke-linecap: round;
}

.title {
    max-width: 700px;
    margin: 0 auto;
    color: #b3b3b3;
    font-size: 2rem;
}
</style>