<template>
<div>
    <page-header v-if="stand.business" :title="stand.business.name" :subtext="'Stand '+stand.location.toLowerCase()" :subtitle="'At '+stand.university['uni-name']" :image="stand.business.logo"></page-header>
    <div class="row">
        <div class="col-lg-6 order-lg-2" style="border-left: 1px solid #e3e3e3;border-right: 1px solid #e3e3e3;">
            <div :title="$t('sell')" id="sellbooks">
                <div class="row">
                    <div class="col-md-7 m-auto">
                        <h1 class="text-center mb-3">{{ $t('sell_textbooks') }}</h1>
                    </div>
                </div>
                <checkmark :active="form.successful"></checkmark>
                <form @submit.prevent="post" @keydown="form.onKeydown($event)">
                    <alert-success :form="form" :message="$t('you_posted_a_textbook_for_sale')+'!'"></alert-success>
                    <!-- ISBN -->
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right">{{ $t('isbn') }}</label>
                        <div class="col-md-7">
                            <input v-model="form.isbn" id="isbn" type="number" pattern="[0-9]*" name="isbn" class="form-control" :class="{ 'is-invalid': form.errors.has('isbn') }" maxlength="13" minlength="13" max="9799999999999" min="9780000000000" required placeholder="978xxxxxxxxxx" list="sellSuggestionsList" autofocus>
                            <datalist id="sellSuggestionsList">
                                <option :value="book.isbn" v-for="book in this.allBooks"></option>
                            </datalist>
                            <has-error :form="form" field="isbn"></has-error>
                            <card v-if="book" class="mb-0">
                                <card-header :title="book['book-title']" :subtitle="book.isGoogle ? $t('prefilled_by_google_books') : $t('usually_sold_for')+ ' ' + book.average_price " :image="book['image-url']" imageShape="square">
                                </card-header>
                            </card>
                            <small class="form-text text-muted">This is the book that you are posting for sale at your stand.</small>

                        </div>
                    </div>
                    <template v-if="addBook && form.isbn.length === 13">
                        <!-- Title -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('book-title') }}</label>
                            <div class="col-md-7">
                                <input v-model="form['book-title']" type="text" id="b-title" name="book-title" class="form-control" :class="{ 'is-invalid': form.errors.has('book-title') }" required placeholder="Example: Management an Introduction">
                                <has-error :form="form" field="book-title"></has-error>
                            </div>
                        </div>
                        <!-- Author -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('authors_comma_seperated') }}</label>
                            <div class="col-md-7">
                                <input v-model="form.author" type="text" name="author" class="form-control" :class="{ 'is-invalid': form.errors.has('author') }" required placeholder="Example: Jan R. Williams, Susan F. Haka, Mark S. Bettner">
                                <has-error :form="form" field="author"></has-error>
                            </div>
                        </div>
                        <!-- Image -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('a_picture_of_the_cover') }}</label>
                            <div class="col-md-7">
                                <label class="mb-0 btn btn-white form-control" for="image">
                                        <template v-if="form.image">
                                            1 {{ $t('file_selected').toLowerCase() }}
                                        </template>
                                        <template v-else>
                                            {{ $t('a_picture_of_the_cover') }}
                                        </template>
                                        <input type="file" name="image" @change="selectFile" class="hidden-file" required id="image">
                                    </label>
                                <has-error :form="form" field="image"></has-error>
                            </div>
                        </div>
                    </template>
                    <template v-if="form.isbn && form.isbn.length === 13 && loading === false && (book || addBook)">
                        <!-- Post-text -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('post_description') }}</label>
                            <div class="col-md-7">
                                <textarea v-model="form['description']" type="text" id="description" name="description" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }" maxlength="250" minlength="10" :placeholder="this.description_placeholder_text" required></textarea>
                                <div v-if="texts" class="recent_text_wrapper scroller" v-show="!form['description']">
                                    <button v-for="text in texts" class="recent_text p-2 mb-0" type="button" v-on:click="form['description'] = text">{{ text }}</button>
                                </div>
                                <has-error :form="form" field="description"></has-error>
                                <small class="form-text text-muted">Your description will show up with your post.</small>
                            </div>
                        </div>
                        <!-- Price -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">{{ $t('price') }}</label>
                            <div class="input-group col-md-7">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ user.university.country.currency }}</span>
                                </div>
                                <input v-model="form.price" type="number" pattern="[0-9]*" name="price" class="form-control" :class="{ 'is-invalid': form.errors.has('price') }" maxlength="3" minlength="1" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                                <has-error :form="form" field="price"></has-error>
                                <small class="form-text text-muted">This is the exact amount a buyer will pay. The price must be the final price of the textbook (including tax and expenses).</small>
                            </div>
                        </div>
                    </template>
                    <small v-else class="col-md-7 offset-md-3 form-text text-muted"></small>
                    <!-- Submit Button -->
                    <div class="form-group row">
                        <div class="col-md-7 offset-md-3">
                            <v-button type="primary" class="btn-block" :disabled="isdisabled" :loading="form.busy">{{ $t('post') }}</v-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-3 order-lg-1">
            <div class="row">
                <div class="col-md-7 m-auto">
                    <h1 class="text-center mb-3">{{ $t('stand_textbooks') }}</h1>
                </div>
            </div>
            <card v-for="(post, index) in stand.posts" :key="post.id">
                <card-header :title="post.textbook['book-title']" :subtitle="post.textbook.author" :image="post.textbook['image-url']" image-shape="square" :link="'/textbook/'+post.textbook.isbn">
                </card-header>
            </card>
        </div>
        <div class="col-lg-3 order-lg-3">
            <div class="row">
                <div class="col-md-7 m-auto">
                    <h1 class="text-center mb-3">{{ $t('suggested') }}</h1>
                </div>
            </div>
            <card v-for="(book, index) in suggested" :key="book.isbn" @click.native.stop="selectSuggested(book.isbn)">
                <card-header :title="book['book-title']" :subtitle="book.author" :image="book['image-url']" image-shape="square">
                </card-header>
            </card>
        </div>
    </div>
</div>
</template>
<script>
import axios from 'axios'
import Form from 'vform'
import { mapGetters } from 'vuex'
import objectToFormData from 'object-to-formdata'

export default {

    metaInfo() {
        return { title: this.$t('sell') }
    },
beforeRouteEnter(to, from, next) {
            axios.get('/api/v1/business-stands/'+to.params.stand_id).then(response => {
            next(vm => {
                           vm.stand = response.data
                        vm.texts.unshift(response.data.stand_text)
                       })
            }, error => {
                // handle error here
            })
    },
    data: () => ({
        addBook: false,
        loading: false,
        googleBook: false,
        texts: ['Book is in great condition!', 'My copy is slightly used.', 'Has a little damage but nothing major.'],
        description_placeholder_text: '',
        suggested: [],
        stand: {},
        form: new Form({
            isbn: '978',
            description: '',
            price: '',
            image: null,
            stand_id: null
        })
    }),

    computed: {
        ...mapGetters({
            user: 'auth/user',
            fetchBook: 'book/getBookByIsbn',
            allBooks: 'book/books'
        }),
        isdisabled() {
            return (this.form.isbn.length === 13 && this.form.price > 0) ? false : true

        },
        book() {
            if (this.form.isbn.length === 13) {
                this.loading = true
                var data = this
                this.$store.dispatch('book/fetchBook', this.form.isbn).then(response => {
                    this.loading = false
                    if (response === undefined || this.fetchBook(this.form.isbn)) {
                        this.addBook = false
                        var book = this.fetchBook(this.form.isbn)
                        this.form['book-title'] = book['book-title']
                        this.form['author'] = book.author
                        this.form['book-des'] = book['book-des']
                        this.form['edition'] = book.edition
                        this.form['image-url'] = book['image-url']
                        this.form.price = book.average_price.slice(1)
                        $("#description").focus()
                    } else {
                        this.addBook = true
                        this.form['book-title'] = ''
                        this.form['author'] = ''
                        this.form['book-des'] = ''
                        this.form['edition'] = ''
                        this.form['image-url'] = ''
                    }
                }, error => {
                    console.error("this is error")
                })
                return this.fetchBook(this.form.isbn)
            }
        }
    },
    mounted() {
        if (this.$route.params.isbn) {
            this.form.isbn = this.$route.params.isbn
        }
        $('#isbn').focus()
        //this.getTexts()
        this.getSuggested()
        var placeholders = ['What can you say specifically about your copy? Any valuable notes?', 'What can you say specifically about your copy? Are there coffee stains?', 'What can you say specifically about your copy? Is it still wrapped up?', "My copy of the textbook is..."];
        var self = this;
        (function cycle() {
            var placeholder = placeholders.shift();
            self.description_placeholder_text = placeholder;
            placeholders.push(placeholder);
            setTimeout(cycle, 2000);
        })()
    },

    methods: {
        getSuggested() {
            this.loading = true
            var data = this
            axios('/api/v1/suggestions/textbooks').then(function(response) {
                data.loading = false
                  $.each(response.data.data, function(res, val) {
                      data.suggested.push(val)
                      data.$store.dispatch('book/addBook', val)
                  })
                  data.getRecent()
            })
        },
        getRecent() {
            this.loading = true
            var data = this
            axios('/api/v1/suggestions/recent').then(function(response) {
                data.loading = false
                  $.each(response.data.data, function(res, val) {
                      data.suggested.push(val)
                      data.$store.dispatch('book/addBook', val)
                  })
            })
        },
        async post() {

            var v = this
            this.form.stand_id = this.stand.id
            this.form.submit('post', '/api/v1/stand-posts', {
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
                    v.googleBook = false
                    v.form.reset()
                    v.stand.posts.unshift(data)
                    window.location = (""+window.location).replace(/#[A-Za-z0-9_]*$/,'')+"#isbn"
                    v.$ga.event({
                        eventCategory: 'Business Event',
                        eventAction: 'Posted book',
                        eventValue: data.isbn
                    })
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
        selectSuggested(isbn) {
            this.form.isbn = isbn
            window.location = (""+window.location).replace(/#[A-Za-z0-9_]*$/,'')+"#isbn"
            $("#description").focus()
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
    clip: rect(0,0,0,0);
    border: 0;
}
</style>