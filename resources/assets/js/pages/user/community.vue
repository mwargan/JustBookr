<template>
    <div>
      <transition-group name="fade" mode="out-in">
    	<card :po="post" v-for="(post, index) in posts" :key="post['activity-id']">
        <card-header :title="fullNames[index]"
          :subtitle="subtitle[index]"
          :image="image[index]">
        </card-header>
        <card-content v-if="post.post"
          :text="post.post['post-description']"
        >
          <card-content-book v-if="post.type === 'TEXTBOOKPOST'" :title="post.post.textbook['book-title']"
          :subtitle="post.post.textbook['author']"
          :image="post.post.textbook['image-url']"
          :text="edition[index]"
          :isbn="post.post.textbook.isbn"></card-content-book>
        </card-content>
        <card-footer v-if="post.post && post.user['user-id'] != user['user-id'] && post.post.status === 1" :id="post.post['post-id']"></card-footer>
    	</card>
      </transition-group>
      <transition name="fade" mode="out-in">
        <card-placeholder v-if="loading"></card-placeholder>
      </transition>
    </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('community') }
  },

  data: () => ({
    posts: [],
    page: 1,
    loading: false
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user'
    }),
    fullNames () {
          return this.posts.map(item => {
            if (item.type === "ADMINPOST") {
              return "JustBookr";
            } else {
              return item.user.name;
            }
          })
    },
    image () {
          return this.posts.map(item => {
            if (item.type === "ADMINPOST") {
              return "https://justbookr.com/images/logoDark.svg";
            } else {
              return item.user.profilepic;
            }
          })
    },
    subtitle () {
        return this.posts.map( (b) => {
          if (b.type === "TEXTBOOKPOST" && b.post.price) {
            var price = `${b.user.university.country.currency}${b.post.price}`
            var availability = this.$t('sold')
            if (b.post.status) {
              availability = this.$t('selling')
            }
            return `${availability} <i>${b.post.textbook['book-title']}</i> ${this.$t('for').toLowerCase()} ${price}`
          } else {
            return b.title
          }
        })
    },
    edition () {
        return this.posts.map( (b) => {
          if (b.type === "TEXTBOOKPOST" && b.post.textbook['edition']) {
            return `${b.post.textbook['edition']} ${this.$t('edition').toLowerCase()}`
          }
        })
    }
  },

  created () {
  	this.getPosts()
  	window.addEventListener('scroll', this.handleScroll)
  },

  destroyed () {
    window.removeEventListener('scroll', this.handleScroll)
  },

  methods: {
    async getPosts () {
      this.loading = true
      var data = this
      await axios('/api/v1/me/feed?page='+this.page).then(function(response){
      	data.page++
      	data.loading = false
      	$.each(response.data.data, function (res, val) {
      		data.posts.push(val)
      	})
      })
    },
    handleScroll () {

		  if (((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 1300) && this.loading === false) {
		    this.getPosts()
		  }
    }
  }

}

</script>
