<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="shareModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $t('share_your_post') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <social-sharing :url="link" :quote="quote" hashtags="justbookr,university,textbook" inline-template>
                        <div>
                            <div class="row mb-3">
                                <network network="facebook" class="col-3 text-center align-self-center">
                                    <i class="fab fa-facebook fa-3x fa-fw"></i>
                                </network>
                                <network network="whatsapp" class="col-3 text-center align-self-center">
                                    <i class="fab fa-whatsapp fa-3x fa-fw"></i>
                                </network>
                                <network network="email" class="col-3 text-center align-self-center">
                                    <i class="fa fa-envelope fa-3x fa-fw"></i>
                                </network>
                                <network network="googleplus" class="col-3 text-center align-self-center">
                                    <i class="fab fa-google-plus fa-3x fa-fw"></i>
                                </network>
                            </div>
                            <div class="row mb-3">
                                <network network="linkedin" class="col-3 text-center align-self-center">
                                    <i class="fab fa-linkedin fa-3x fa-fw"></i>
                                </network>
                                <network network="reddit" class="col-3 text-center align-self-center">
                                    <i class="fab fa-reddit fa-3x fa-fw"></i>
                                </network>
                                <network network="skype" class="col-3 text-center align-self-center">
                                    <i class="fab fa-skype fa-3x fa-fw"></i>
                                </network>
                                <network network="sms" class="col-3 text-center align-self-center">
                                    <i class="fa fa-comment fa-3x fa-fw"></i>
                                </network>
                            </div>
                            <div class="row">
                                <network network="telegram" class="col-3 text-center align-self-center">
                                    <i class="fab fa-telegram fa-3x fa-fw"></i>
                                </network>
                                <network network="twitter" class="col-3 text-center align-self-center">
                                    <i class="fab fa-twitter fa-3x fa-fw"></i>
                                </network>
                                <network network="vk" class="col-3 text-center align-self-center">
                                    <i class="fab fa-vk fa-3x fa-fw"></i>
                                </network>
                                <network network="weibo" class="col-3 text-center align-self-center">
                                    <i class="fab fa-weibo fa-3x fa-fw"></i>
                                </network>
                            </div>
                        </div>
                    </social-sharing>
                </div>
                <div class="modal-footer" style="justify-content: flex-start;">Use one of the awesome magical buttons at the top to share!</div>
            </div>
        </div>
    </div>
</template>
<script>


import { mapGetters } from 'vuex'

export default {
    props: ['link', 'quote'],

    name: 'share-modal',
    data: () => ({

    }),
    computed: {
        ...mapGetters({
            //user: 'auth/user'
        })
    },
    methods: {
    },
    mounted() {

    }
}
</script>