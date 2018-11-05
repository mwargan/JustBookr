<template>
    <div>
        <card v-if="views && !loading && activePosts.length > 0">
            <card-header :title="'+'+views+' post views in the last month'" subtitle="Share your posts to get more views">
            </card-header>
        </card>
        <card v-for="(post, index) in activePosts" :key="post['post-id']">
            <card-header v-if="post.boosts.length > 0" :title="post.textbook['book-title']" :subtitle="post.price" :image="post.textbook['image-url']" image-shape="square" :link="'/textbook/'+post.isbn" sponsored="Boosted">
            </card-header>
             <card-header v-else :title="post.textbook['book-title']" :subtitle="post.price" :image="post.textbook['image-url']" image-shape="square" :link="'/textbook/'+post.isbn">
            </card-header>
            <card-content :text="post['post-description']">
            </card-content>
            <card-footer v-if="post.status == 1" :loading="post.loading">
                <a class="link" @click="sharePost(post, index)">{{ $t('share') }}</a>
                <a class="link" @click="edit(post, index)">{{ $t('edit') }}</a>
            </card-footer>
        </card>
        <card v-if="!loading && activePosts.length === 0">
            <div class="card-header text-center">
                <div class="head">
                    <div class="face face__sad">
                        <div class="eye-left"></div>
                        <div class="eye-right"></div>
                        <div class="mouth"></div>
                    </div>
                </div>
                <div class="facebook-name m-0 center">{{ $t('you_arent_selling_any_textbooks_right_now') }}</div>
                <div class="facebook-date m-0 center">{{ $t('post_your_textbooks_for_sale') }}</div>
            </div>
            <card-footer>
                <router-link class="link" to="/sell">{{ $t('sell_books') }}</router-link>
            </card-footer>
        </card>
        <card-placeholder v-if="loading"></card-placeholder>
        <!-- Edit Client Modal -->
        <div class="modal fade" id="modal-edit-post" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $t('edit_post') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Edit Client Form -->
                    <form class="form-horizontal" role="form" @submit.prevent="update" @keydown="editForm.onKeydown($event)">
                        <div class="modal-body">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 control-label">{{ $t('post_description') }}</label>
                                <div class="col-md-7">
                                    <textarea class="form-control" name="post-description" v-model="editForm['post-description']" :class="{ 'is-invalid': editForm.errors.has('post-description') }" maxlength="250" minlength="10" required>{{editForm['post-description']}}</textarea>
                                    <has-error :form="editForm" field="post-description"></has-error>
                                </div>
                            </div>
                            <!-- Price -->
                            <div class="form-group row">
                                <label class="col-md-3 control-label">{{ $t('price') }}</label>
                                <div class="input-group col-md-7">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ user.university.country.currency }}</span>
                                    </div>
                                    <input type="number" class="form-control" name="price" v-model="editForm.price" :class="{ 'is-invalid': editForm.errors.has('price') }" maxlength="3" minlength="1" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                    <has-error :form="editForm" field="price"></has-error>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Actions -->
                        <div class="modal-footer">
                            <a class="btn mr-auto text-secondary" v-show="!editForm.busy" @click="markSold(editForm['post-id'], editForm.index)">{{ $t('mark_as_sold') }}</a>
                            <v-button @click="update" :loading="editForm.busy">
                                {{ $t('update') }}
                            </v-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Share Modal -->
        <share-modal :link="share.link" quote="I'm selling my books on JustBookr!" />
    </div>
</template>
<script>
import axios from 'axios'
import Form from 'vform'
import swal from 'sweetalert2'
import ShareModal from '~/components/modals/Share'

export default {
    props: ['user'],
     components: {
        ShareModal
    },
    computed: {
        activePosts() {
            return this.posts.filter(function(post) {
                return post.status === 1;
            })
        }
    },

    data: () => ({
        posts: [],
        page: 1,
        loading: false,
        views: 0,
        share: {
            link: "",
            index: 0
        },
        editForm: new Form({
            'post-description': '',
            price: 0
        })
    }),

    created() {
        this.getPosts()
        this.getViews()
    },

    methods: {
        async getPosts() {
            this.loading = true
            await axios('/api/v1/posts?user=' + this.user['user-id'] + '&available=true&paginate=false').then(response => {
                this.page++
                    this.loading = false
                $.each(response.data, (res, val) => {
                    this.posts.push(val)
                    this.$store.dispatch('book/addBook', val.textbook)
                })
                this.$emit('set-posts', this.posts);
            })
        },
        async getViews() {
            await axios('/api/v1/me/post-views').then(response => {
                this.views = response.data.views_past_month
            })
        },

        edit(post, index) {
            this.editForm['post-id'] = post['post-id']
            this.editForm['post-description'] = post['post-description']
            this.editForm.price = post.price.substr(1)
            this.editForm.index = index

            $('#modal-edit-post').modal('show');
        },
        async update() {
            await this.editForm.put('/api/v1/posts/' + this.editForm['post-id']).then(response => {
                this.$set(this.posts[this.editForm.index], 'price', response.data.price)
                this.$set(this.posts[this.editForm.index], 'post-description', response.data['post-description'])
                $('#modal-edit-post').modal('hide')
                this.$ga.event({
                    eventCategory: 'User Event',
                    eventAction: 'Updated post',
                    eventValue: this.editForm['post-id']
                })
                //data.$store.dispatch('post/updatePost', { post: response.data.post })
            })
        },
        markSold(id, index) {
            this.posts[index].loading = true
            $('#modal-edit-post').modal('hide')
            axios.post('/api/v1/posts/' + id + '/mark-sold').then(response => {
                this.$delete(this.posts, index)
                this.$ga.event({
                    eventCategory: 'User Event',
                    eventAction: 'Marked post as sold',
                    eventValue: id
                })
            })
        },
        sharePost(post, index) {
            this.share.link = "https://justbookr.com/textbook/" + post['isbn']

            $('#shareModal').modal('show')
            this.$ga.event({
                eventCategory: 'User Event',
                eventAction: 'share',
                eventLabel: post.isbn
            })
        }
    }
}
</script>
<style scoped>
.head {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin: auto;
    width: 125px;
    height: 125px;
    background-color: #3C74BF;
    background-image: -webkit-linear-gradient(#FFCC22 0%, #E8B50B 100%);
    background-image: -o-linear-gradient(#FFCC22 0%, #E8B50B 100%);
    background-image: linear-gradient(#FFCC22 0%, #E8B50B 100%);
    border-radius: 50%;
    position: relative;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

.face {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin: auto;
    width: 125px;
    height: 125px;
    position: relative;
}

.face__sad {
    animation: sad-look 5s infinite;
}

.face__sad .eye-left {
    width: 12.5px;
    height: 12.5px;
    background-color: #000;
    border-radius: 50%;
    top: 37.5px;
    left: 22.5px;
    position: absolute;
    animation: blink 5s infinite;
    animation-delay: 3.7s;
}

.face__sad .eye-right {
    width: 12.5px;
    height: 12.5px;
    background-color: #000;
    border-radius: 50%;
    top: 37.5px;
    right: 22.5px;
    position: absolute;
    animation: blink 5s infinite;
    animation-delay: 3.7s;
}

.face__sad .mouth {
    width: 50px;
    height: 25px;
    border-style: solid;
    border-radius: 50%;
    border-width: 4px;
    border-color: #000 transparent transparent transparent;
    left: 34px;
    top: 93px;
    position: absolute;
    animation: sad-mouth 5s infinite;
}

@keyframes blink {
    0% {
        transform: scale(1, 1);
    }
    10% {
        transform: scale(1, 1);
    }
    12% {
        transform: scale(1, .1);
    }
    14% {
        transform: scale(1, 1);
    }
    30% {
        transform: scale(1, 1);
    }
    32% {
        transform: scale(1, .1);
    }
    34% {
        transform: scale(1, 1);
    }
    60% {
        transform: scale(1, 1);
    }
    62% {
        transform: scale(1, .1);
    }
    64% {
        transform: scale(1, 1);
    }
}

@keyframes sad-look {
    0% {
        transform: translate(0px, 0px);
    }
    15% {
        transform: translate(0px, 0px);
    }
    25% {
        transform: translate(0px, 12.5px);
    }
    35% {
        transform: translate(0px, 12.5px);
    }
    45% {
        transform: translate(0px, 0px);
    }
    70% {
        transform: translate(0px, 0px);
    }
    80% {
        transform: translate(7.5px, 12.5px);
    }
    90% {
        transform: translate(7.5px, 12.5px);
    }
    100% {
        transform: translate(0px, 0px);
    }
}

@keyframes sad-mouth {
    0% {
        height: 12.5px;
    }
    15% {
        height: 12.5px;
    }
    12.5% {
        height: 25px;
    }
    35% {
        height: 25px;
    }
    45% {
        height: 12.5px;
    }
    70% {
        height: 12.5px;
    }
    80% {
        height: 25px;
    }
    90% {
        height: 25px;
    }
    100% {
        height: 12.5px;
    }
}
</style>