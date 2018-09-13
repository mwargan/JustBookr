<template>
    <div>
        <div class="facebook-card card row">
            <div class="card-body">
                <h5 class="card-title">{{ university['uni-name'] }}
                    <small class="d-block text-muted" v-if="university['en-name']">{{ university['en-name'] }}</small>
                </h5>
                <p class="card-text" v-if="university['description']">{{ university['description'] }}</p>
            </div>
            <card-footer v-if="university.url">
                    <a v-if="university['uni-tel']" class="link" target="_BLANK" rel="noopener" :href="'tel:'+university['uni-tel']">{{ $t('call') }}
                    </a>
                    <a v-if="university.url" class="link" target="_BLANK" rel="noopener" :href="university.url">{{ $t('visit_website') }}
                    </a>
            </card-footer>
        </div>
        <div class="facebook-card card row mt-3" v-if="university.address">
            <card-header :title="$t('campus')" />
            <iframe width="100%" height="450" frameborder="0" style="border:0" :src="'https://www.google.com/maps/embed/v1/place?key=AIzaSyABuVktz7YCHnbo2jWc3k2RT0x3EQaLpTA&q='+ university['uni-name']+', '+university.address+', '+university.country.name" allowfullscreen>
            </iframe>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{{ university.address+', '+university.country.name }}</li>
            </ul>
        </div>
        <transition name="fade" mode="out-in">
            <card>
                <card-header :title="$t('more_info')" />
                <card-content class="mt-2 mb-1">
                    <dl v-if="university['en-name']">
                        <dt>{{ $t('alternate_name') }}</dt>
                        <dd>{{ university['en-name'] }}</dd>
                    </dl>
                    <dl v-if="university.abr">
                        <dt>{{ $t('abr') }}</dt>
                        <dd>{{ university.abr }}</dd>
                    </dl>
                    <dl v-if="university.url">
                        <dt>{{ $t('link') }}</dt>
                        <dd><a :href="university.url">{{ university.url }}</a></dd>
                    </dl>
                    <dl v-if="university.tags">
                        <dt>{{ $t('classification') }} <small class="text-muted"><i>{{ $t('beta') }}</i></small></dt>
                        <dd v-for="tag in university.tags"><span v-if="tag['tag-id'] <= 1000">{{ $t('dewey_decimal') }}: {{ tag['tag-id']-1 }}, </span>{{ tag['t-data'] }}</dd>
                    </dl>
                    <dl>
                        <dt>{{ $t('university_id') }}</dt>
                        <dd>{{ university['uni-id'] }}</dd>
                    </dl>
                    <dl>
                        <details>
                            <summary>
                                <dt class="d-inline">{{ $t('share') }}</dt>
                            </summary>
                            <p>
                                <dd>
                                    <social-sharing quote="Check out this university on JustBookr!" hashtags="justbookr,university,textbook" inline-template>
                                        <div>
                                            <div class="row mb-2">
                                                <network network="facebook" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-facebook fa-2x fa-fw"></i>
                                                </network>
                                                <network network="whatsapp" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-whatsapp fa-2x fa-fw"></i>
                                                </network>
                                                <network network="email" class="col-3 text-center align-self-center">
                                                    <i class="fa fa-envelope fa-2x fa-fw"></i>
                                                </network>
                                                <network network="googleplus" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-google-plus fa-2x fa-fw"></i>
                                                </network>
                                            </div>
                                            <div class="row mb-2">
                                                <network network="linkedin" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-linkedin fa-2x fa-fw"></i>
                                                </network>
                                                <network network="reddit" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-reddit fa-2x fa-fw"></i>
                                                </network>
                                                <network network="skype" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-skype fa-2x fa-fw"></i>
                                                </network>
                                                <network network="sms" class="col-3 text-center align-self-center">
                                                    <i class="fa fa-comment fa-2x fa-fw"></i>
                                                </network>
                                            </div>
                                            <div class="row">
                                                <network network="telegram" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-telegram fa-2x fa-fw"></i>
                                                </network>
                                                <network network="twitter" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-twitter fa-2x fa-fw"></i>
                                                </network>
                                                <network network="vk" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-vk fa-2x fa-fw"></i>
                                                </network>
                                                <network network="weibo" class="col-3 text-center align-self-center">
                                                    <i class="fab fa-weibo fa-2x fa-fw"></i>
                                                </network>
                                            </div>
                                        </div>
                                    </social-sharing>
                                </dd>
                            </p>
                        </details>
                    </dl>
                </card-content>
            </card>
        </transition>
        <div style="text-align: center;">
            <small class="text-muted">This page is automatically generated and not affiliated with the educational institution presented.</small>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    scrollToTop: false,
    props: ['university'],
    metaInfo() {
        return { title: this.university['uni-name'] + ' - ' + this.$t('info') }
    },

    data: () => ({
        //university: null
    }),
    computed: mapGetters({
        // thisuniversity: 'university/getUniversityById'
    })

}
</script>