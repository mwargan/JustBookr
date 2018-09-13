<template>
    <div>
        <transition-group name="fade" mode="out-in">
            <card v-for="(post, index) in activePosts" :key="post['post-id']">
                <card-header v-if="post.boosts.length > 0" :title="user.name" :subtitle="post.price" :image="user.profilepic" sponsored="Boosted" />
                <card-header v-else :title="user.name" :subtitle="post.price" :image="user.profilepic" />
                <card-content :text="post['post-description']">
                    <card-content-book style="margin-top: -1rem;" :title="post.textbook['book-title']" :subtitle="post.textbook['author']" :image="post.textbook['image-url']" :text="post.textbook['edition']" :isbn="post.textbook.isbn"></card-content-book>
                </card-content>
                <card-footer :post-id="post['post-id']" v-if="(me && user['user-id'] != me['user-id']) || !me"></card-footer>
            </card>
        </transition-group>
        <card-placeholder v-if="loading"></card-placeholder>
        <card v-if="!loading && activePosts.length === 0">
            <div class="card-header text-center">
                <div class="head">
                    <div class="face face__sad">
                        <div class="eye-left"></div>
                        <div class="eye-right"></div>
                        <div class="mouth"></div>
                    </div>
                </div>
                <div class="facebook-name m-0 center">{{ user.name }} isn't selling any textbooks right now.</div>
            </div>
        </card>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: true,
    props: ['user'],
    metaInfo() {
        return { title: this.user.name+' '+this.$t('textbooks') }
    },

    computed: {
      ...mapGetters({
            me: 'auth/user',
            allUsers: 'user/users',
        }),

        fullName() {
            return this.user.name;
        },

        activePosts() {
            return this.posts.filter(function(post) {
                return post.status === 1;
            })
        },

        soldPosts() {
            return this.posts.filter(function(post) {
                return post.status === 0;
            })
        },
    },

    data: () => ({
        posts: [],
        page: 1,
        loading: false
    }),

    created() {
        this.getPosts()
        //window.addEventListener('scroll', this.handleScroll)
    },

    destroyed() {
        //window.removeEventListener('scroll', this.handleScroll)
    },

    methods: {
        async getPosts() {
            this.loading = true
            var data = this
            await axios('/api/v1/posts?active=true&user=' + this.$route.params.id +'&paginate=false&available=true').then(function(response) {
                data.page++
                data.loading = false
                $.each(response.data, function(res, val) {
                    val.user = data.user
                    data.posts.push(val)
                    data.$store.dispatch('post/addPost', val)
                    data.$store.dispatch('book/addBook', val.textbook)
                })
            })
        },
        handleScroll() {

            if (((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 1300) && this.loading === false) {
                this.getPosts()
            }
        },
        subtitle(b) {
                //var price = `${this.user.university.country.currency}${b.price}`
                var availability = this.$t('sold')
                if (b.status) {
                    availability = this.$t('selling')
                }
                return `${availability} <i>${b.textbook['book-title']}</i> ${this.$t('for').toLowerCase()} $3`
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