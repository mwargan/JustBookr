import Vue from 'vue'
import { library, dom } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

Vue.component('fa', FontAwesomeIcon)

dom.watch()
// import { } from '@fortawesome/fontawesome-free-regular'

import { faUser, faLock, faSignOutAlt, faCog, faEnvelope, faInbox, faUsers, faBook, faCompass, faComment, faInfo, faBriefcase, faChartBar, faBell, faCamera, faMoneyBill, faPlus, faHeart } from '@fortawesome/free-solid-svg-icons'

import { faGithub, faFacebook, faWhatsapp, faGooglePlus, faLinkedin, faReddit, faSkype, faTelegram, faTwitter, faVk, faWeibo, faAmazon, faCcVisa, faCcAmex, faCcMastercard } from '@fortawesome/free-brands-svg-icons'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faEnvelope, faInbox, faUsers, faBook, faCompass, faComment, faInfo, faBriefcase, faChartBar, faBell, faCamera, faGithub, faFacebook, faWhatsapp, faGooglePlus, faLinkedin, faReddit, faSkype, faTelegram, faTwitter, faVk, faWeibo, faAmazon, faCcVisa, faCcAmex, faCcMastercard, faMoneyBill, faPlus, faHeart
)
