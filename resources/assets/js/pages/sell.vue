<template>
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div :title="$t('sell')">
                <div class="row">
                    <div class="col-md-7 m-auto">
                        <h1 class="text-center mb-3">{{ $t('sell_books') }}</h1>
                    </div>
                </div>
                <!--                 <checkmark :active="form.successful"></checkmark>
 -->
                <card v-if="posted && posted.textbook && form.successful">
                    <card-header v-if="posted.boosts && posted.boosts.length > 0" :title="user.name" :subtitle="posted.price" :image="user.profilepic" :link="'/user/'+user['user-id']" sponsored="Boosted">
                    </card-header>
                    <card-header v-else :title="sellAs.name" :subtitle="posted.price" :image="user.profilepic" :link="'/user/'+user['user-id']">
                    </card-header>
                    <card-content :text="posted['post-description']">
                        <card-content-book :title="posted.textbook['book-title']" :subtitle="posted.textbook['author']" :image="posted.textbook['image-url']" :text="posted.textbook['edition']" :isbn="posted.textbook.isbn" />
                    </card-content>
                    <card-footer>
                        <a href="#" class="link" data-toggle="modal" data-target="#boostModal" v-if="posted.boosts.length == 0 && sellAs.id == null">{{$t('boost_your_post')}}</a>
                        <a class="link" @click="sharePost()">{{ $t('share') }}</a>
                    </card-footer>
                </card>
                <alert-success class="mt-2" :form="form" :message="$t('you_posted_a_textbook_for_sale')+'! '+$t('boost_your_post')+'!'">
                </alert-success>
                <hr v-if="posted && form.successful" />
                <form @submit.prevent="post" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
                    <!-- ISBN -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right" for="isbn">{{ $t('isbn') }}</label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <input v-model="form.isbn" id="isbn" type="number" pattern="[0-9]*" name="isbn" class="form-control" :class="{ 'is-invalid': form.errors.has('isbn') }" maxlength="13" minlength="13" max="9799999999999" min="9780000000000" required placeholder="978xxxxxxxxxx" list="sellSuggestionsList" autofocus :disabled="loading">
                                <datalist id="sellSuggestionsList">
                                    <option :value="book.isbn" v-for="book in this.allBooks"></option>
                                </datalist>
                                <div class="input-group-append" v-if="supportsCamera">
                                    <span class="input-group-text">
                                        <a @giveBarcode="giveBarcode" href="#" data-toggle="modal" data-target="#quaggaModal" class="text-dark">
                                            <fa icon="camera" fixed-width/>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <card v-if="book['book-title']" class="mb-0">
                                <card-header :title="book['book-title']" :subtitle="book.isGoogle ? $t('prefilled_by_google_books') : $t('usually_sold_for')+ ' ' + book.average_price " :image="book['image-url']" imageShape="square">
                                </card-header>
                            </card>
                            <card-placeholder v-else-if="loading" class="mb-0" :small="true"></card-placeholder>
                            <has-error :form="form" field="isbn"></has-error>
                            <small class="form-text text-muted">This is the book that you are posting for sale at your university.</small>
                        </div>
                    </div>
                    <template v-if="addBook && form.isbn.length">
                        <!-- Title -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" for="b-title">{{ $t('book-title') }}</label>
                            <div class="col-md-7">
                                <input v-model="form['book-title']" type="text" id="b-title" name="book-title" class="form-control" :class="{ 'is-invalid': form.errors.has('book-title') }" required placeholder="Example: Management an Introduction">
                                <has-error :form="form" field="book-title"></has-error>
                            </div>
                        </div>
                        <!-- Author -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" for="author">{{ $t('authors_comma_seperated') }}</label>
                            <div class="col-md-7">
                                <input v-model="form.author" type="text" name="author" id="author" class="form-control" :class="{ 'is-invalid': form.errors.has('author') }" required placeholder="Example: Jan R. Williams, Susan F. Haka, Mark S. Bettner">
                                <has-error :form="form" field="author"></has-error>
                            </div>
                        </div>
                        <!-- Image -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" for="image">{{ $t('a_picture_of_the_cover') }}</label>
                            <div class="col-md-7">
                                <label class="mb-0 btn btn-white form-control" for="image" :class="{ 'is-invalid': form.errors.hasAny('image', 'image-url') }">
                                    <template v-if="form.image">
                                        1 {{ $t('file_selected').toLowerCase() }}
                                    </template>
                                    <template v-else>
                                        {{ $t('a_picture_of_the_cover') }}
                                    </template>
                                    <input type="file" name="image" @change="selectFile" class="hidden-file" required id="image" accept="image/*">
                                </label>
                                <has-error :form="form" field="image"></has-error>
                                <has-error :form="form" field="image-url"></has-error>
                            </div>
                        </div>
                    </template>
                    <template v-if="form.isbn && form.isbn.length === 13 && loading === false && (book || addBook)">
                        <!-- Post-text -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" for="description">{{ $t('post_description') }}</label>
                            <div class="col-md-7">
                                <textarea v-model="form['post-description']" type="text" id="description" name="post-description" class="form-control" :class="{ 'is-invalid': form.errors.has('post-description') }" maxlength="250" minlength="10" :placeholder="this.description_placeholder_text" required></textarea>
                                <div v-if="texts" class="recent_text_wrapper scroller" v-show="!form['post-description']">
                                    <button v-for="text in texts" class="recent_text p-2 mb-0" type="button" v-on:click="form['post-description'] = text">{{ text }}</button>
                                </div>
                                <has-error :form="form" field="post-description"></has-error>
                                <small class="form-text text-muted">Your description will show up with your post.</small>
                            </div>
                        </div>
                        <!-- Price -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" for="price">{{ $t('price') }}</label>
                            <div class="input-group col-md-7">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ user.university.country.currency }}</span>
                                </div>
                                <input v-model="form.price" type="number" pattern="[0-9]*" name="price" class="form-control" :class="{ 'is-invalid': form.errors.has('price') }" maxlength="3" minlength="1" required id="price">
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                                <has-error :form="form" field="price"></has-error>
                                <small class="form-text text-muted">When you sell your book, the buyer will pay you this amount in cash.</small>
                            </div>
                        </div>
                    </template>
                    <p v-else class="col-md-7 offset-md-3">Type in <span v-if="supportsCamera">or scan </span>the ISBN-13 number, a 13 digit code starting with 97 usually found on the back of the book. Don't use spaces or dashes!<img src="/images/backside_with_isbn_highlighted.jpg" alt="" class="find-isbn"></p>
                        <!-- Submit Button -->
                        <div class="form-group row">
                            <div class="col-md-7 offset-md-3">
                                <v-button type="primary" class="btn-block" :disabled="isdisabled" :loading="form.busy">{{ $t('post') }}</v-button>
                                <span class="mt-2" v-if="user.businesses && user.businesses.length > 0">Selling as <a class="dropdown-toggle" href="#" role="button"
                                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{sellAs.name}}</a>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"
                                    @click.prevent="setSellAs(null, user.name)">
                                    {{ user.name }}
                                  </a>
                                  <a v-if="user.businesses && value.stands.length > 0" v-for="(value, key) in user.businesses" class="dropdown-item" href="#"
                                    @click.prevent="setSellAs(value.stands[0]['id'], value.name)">
                                    {{ value.name }} {{ value.stands[0]['location'].toLowerCase() }}
                                  </a>
                                </div>
                                </span>
                            </div>
                        </div>
                </form>
            </div>
            <quagga-modal @giveBarcode="giveBarcode" v-if="supportsCamera" />
            <boost-modal :post="posted" @postPromoted="boostPost" />
            <share-modal :link="posted_link" :quote="'I\'m selling my copy of '+posted_title+' on JustBookr!'" />
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import Form from 'vform'
import { mapGetters } from 'vuex'
import objectToFormData from 'object-to-formdata'
import QuaggaModal from '~/components/QuaggaModal'
import BoostModal from '~/components/modals/PostBoost'
import ShareModal from '~/components/modals/Share'

export default {

    metaInfo() {
        return { title: this.$t('sell') }
    },
    components: {
        QuaggaModal,
        BoostModal,
        ShareModal
    },
    data: () => ({
        addBook: false,
        loading: false,
        googleBook: false,
        posted_link: "",
        posted_title: "",
        posted: {},
        book: {},
        sellAs: {
            id: null,
            name: null
        },
        texts: ['Book is in great condition!', 'My copy is slightly used.', 'Has a little damage but nothing major.'],
        description_placeholder_text: '',
        form: new Form({
            isbn: '978',
            'post-description': '',
            price: '',
            image: null
        })
    }),
    computed: {
        ...mapGetters({
            user: 'auth/user',
            fetchBook: 'book/getBookByIsbn',
            allBooks: 'book/books'
        }),
        isdisabled() {
            return (this.form.isbn.length === 13 && this.form['post-description'].length >= 10 && this.form.price > 0) ? false : true

        },
        supportsCamera() {
            if (navigator.mediaDevices && typeof navigator.mediaDevices.getUserMedia === 'function') {
                return true
            }
            return false
        }
    },
    mounted() {
        if (this.$route.params.isbn) {
            this.form.isbn = this.$route.params.isbn
        }
        this.sellAs.name = this.user.name
        $('#isbn').focus()
        this.getTexts()
        var placeholders = ['What can you say specifically about your copy? Any valuable notes?', 'What can you say specifically about your copy? Are there coffee stains?', 'What can you say specifically about your copy? Is it still wrapped up?', "My copy of the book is..."];
        var self = this;
        (function cycle() {
            var placeholder = placeholders.shift();
            self.description_placeholder_text = placeholder;
            placeholders.push(placeholder);
            setTimeout(cycle, 2000);
        })()
    },
    watch: {
        'form.isbn': function(id) {
            if (this.form.isbn.length === 13) {
                this.getBook()
            } else {
                this.book = []
            }
        }
    },
    methods: {
        getBook() {
            if (this.form.isbn.length === 13) {
                this.loading = true
                this.book = []
                this.form['book-title'] = ''
                this.form['author'] = ''
                this.form['book-des'] = ''
                this.form['edition'] = ''
                this.form.image = null
                this.form.price = null
                this.$store.dispatch('book/fetchBook', this.form.isbn).then(response => {
                    this.loading = false

                    if (this.book = this.fetchBook(this.form.isbn)) {
                        this.addBook = false
                        this.form['book-title'] = this.book['book-title']
                        this.form['author'] = this.book.author
                        this.form['book-des'] = this.book['book-des']
                        this.form['edition'] = this.book.edition
                        this.form['image-url'] = this.book['image-url']
                        if (this.book.average_price && this.book.average_price.slice(1) > 0) {
                            this.form.price = this.book.average_price.slice(1)
                        }
                        $("#description").focus()
                    } else {
                        this.addBook = true
                        $("#b-title").focus()
                    }
                }, error => {
                    this.loading = false
                    this.addBook = true
                    console.error(error)
                })
            }
        },
        async post() {
            this.form.successful = false
            var v = this
            var submitUrl = '/api/v1/posts'
            if (this.sellAs.id) {
                this.form.stand_id = this.sellAs.id
                submitUrl = '/api/v1/stand-posts'
            }
            this.form.submit('post', submitUrl, {
                    // Transform form data to FormData
                    transformRequest: [function(data, headers) {
                        return objectToFormData(v.form)
                    }],
                    onUploadProgress: e => {
                        // Do whatever you want with the progress event
                        //console.log(e)
                    }
                })
                .then(({ data }) => {
                    this.googleBook = false
                    this.book = []
                    this.addBook = false
                    this.posted_title = data.textbook['book-title']
                    data.boosts = []
                    this.posted = data
                    this.form.reset()
                    this.posted_link = "https://justbookr.com/textbook/" + data.isbn
                    this.$ga.event({
                        eventCategory: 'User Event',
                        eventAction: 'Posted book',
                        eventValue: data.isbn
                    })
                    scroll(0, 0)
                })
                .catch( data  => {
                    console.log(data)
                })
        },
        async getTexts() {
            var data = this
            await axios('/api/v1/suggestions/post-descriptions').then(function(response) {
                $.each(response.data, function(res, val) {
                    data.texts.unshift(val['post-description'])
                })
            })
        },
        selectFile(e) {
            const file = e.target.files[0]
            this.form.image = file
        },
        giveBarcode: function(barcode) {
            this.form.isbn = barcode
        },
        boostPost(response) {
            this.posted.boosts = [true]
        },
        setSellAs(id, name) {
            this.sellAs.id = id
            this.sellAs.name = name
        },
        sharePost() {
            $('#shareModal').modal('show')
            this.$ga.event({
                eventCategory: 'User Event',
                eventAction: 'share',
                eventLabel: this.posted.isbn
            })
        }
    }
}
</script>
<style scoped>
button {
    -webkit-transition: all .15s ease-in-out 0s;
    transition: all .15s ease-in-out 0s;
}




/*! CSS Used from: Embedded */

.recent_text_wrapper {
    display: flex;
}

.recent_text_wrapper button:first-child {
    margin-left: 0;
}

.recent_text {
    font-size: 0.8rem;
    padding: 0.5rem;
    background-color: white;
    margin: 0.5rem 0.5rem;
    border-radius: 5rem;
    border: 1px solid #ced4da;
}

.recent_text:hover {
    -webkit-box-shadow: 0 .25rem .5rem rgba(0, 0, 0, .3);
    box-shadow: 0 .25rem .5rem rgba(0, 0, 0, .3);
}

.scroller {
    overflow-x: visible;
    overflow-y: hidden;
    max-width: 100%;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    align-items: center;
}

.scroller button {
    float: left;
    display: block;
    white-space: nowrap;
    -webkit-transition: .20s ease all;
    transition: .20s ease all;
}

img.find-isbn {
    max-height: 250px;
    display: block;
    margin: 0 auto;
}

.btn.form-control {
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.5rem;
}

.hidden-file {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
}

.invalid-feedback {
    display: block;
}
</style>