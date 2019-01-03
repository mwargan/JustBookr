<template>
    <div>
        <div class="p-3 row bg-primary text-white mb-5" style="min-height: 75px;margin-top: -1.5rem !important;">
            <div class="col-12 text-center align-self-center">
                <h1 class="display-4 mb-4 mx-auto mt-auto mb-auto">
                    {{ $t('faq') }}
                </h1>
            </div>
        </div>
        <h4 class="display-5 row w-75 mx-auto"><span class="light">General</span></h4>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">What is JustBookr?</dt>
            </summary>
            <p>JustBookr is a free student built platform for trading books with other students on your university campus.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Is JustBookr free?</dt>
            </summary>
            <p>
                <b>Yes.</b> You can sign up, order, buy, post, and sell for free on JustBookr. You may choose to boost your post to show your offer before all the others, but you don't have to (more info below).<br/><br/>
                JustBookr for businesses has pricing <router-link :to="{ name: 'business' }">available here</router-link>.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">What makes JustBookr better than posting on, for example, Facebook groups?</dt>
            </summary>
            <p>
                On JustBookr, you can easily see all the available posts for a specific book you might need, get suggestions on how to price your books competitively when you're ready to sell, and so much more things all geared towards your book needs. If you want to then share your posts on Facebook, WhatsApp, or anywhere else, we've made it easy for you to do so at the tap of a button. And, it's free.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Is my university on JustBookr?</dt>
            </summary>
            <p>
                There's a <b>99% chance</b> that it is. JustBookr has 22,000 universites from all over the world. If you're not finding your university, try alternative names such as the English or Native language name.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Is there a JustBookr app?</dt>
            </summary>
            <p>
                <b>We're working on it!</b> iOS will be out soon with Android following suite!
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">How can I get in touch with JustBookr?</dt>
            </summary>
            <p>
                In the welcome email we sent you and subsequent emails later (if you have not unsubscribed), <b>there's a support email link at the bottom of every email</b>. Click on that and you'll be set to fire away your comments, suggestions, and questions!
                <br/><br/>
                Otherwise, you can get in touch with us <b>via Facebook Messenger</b>, but make sure to tell our ChatBot you want to speak to a human!
            </p>
        </details>
        <h4 class="display-5 row w-75 mx-auto mt-3"><span class="light">Selling</span></h4>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">How do I post my book for sale?</dt>
            </summary>
            <p>It's super easy.<b> Just head over to the <router-link :to="{ name: 'sell' }">{{ $t("sell_textbooks") }}</router-link> page and fill in the ISBN-13 of your book, write a few words about your copy, and set the price</b> that you want to sell at. Done in less than 30 seconds!
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">What price should I set for my book?</dt>
            </summary>
            <p>For books that others have posted before, <b>you'll see a suggested average price</b> based on all of those previous posts; that's a good starting point for pricing your book competitively. Otherwise, if you're the first to post the book - <b>a good rule of thumb is between 30% and 50% less than you bought it for</b>, depending on the condition.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">What should I write in my post description?</dt>
            </summary>
            <p>The post description is the place to <b>describe the condition of your book and really sell yourself</b>. Try to stand out of the crowd by showing a bit of your personality - it can go a long way to selling your book faster!
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Can I post more than one copy of the same book?</dt>
            </summary>
            <p>Unless you have signed up as a business, <b>no</b>.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Can I post any book or only textbooks?</dt>
            </summary>
            <p><b>Yes</b>, JustBookr supports over 25 million titles so you're more than welcome to post any book!
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Is my book visible to everyone on JustBookr when I post it?</dt>
            </summary>
            <p><b>Yes, your post will be visible to everyone that is also at your university on JustBookr.</b> It will not show to students at other universities.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">How long will my post stay visible?</dt>
            </summary>
            <p><b>Indefinitely, unless one of three things happen</b>: someone orders your book, you mark your post as sold, or you don't log in to JustBookr for more than 3 months.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Can I post my book for sale on multiple campuses?</dt>
            </summary>
            <p>Right now, <b>no</b>. We have found that students generally don't like to go through the whole process of shipping books or going long distance to other campuses to deliver them. However, if this is something you would be interested in, please do contact us and let us know!
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">What happens when someone buys my book?</dt>
            </summary>
            <p><b>You'll get a new message in your inbox on JustBookr and an email notifying you of a new order.</b> You'll see when the buyer would like to meet and where (on campus). Once you accept the order, you can suggest new times, and the buyer will be notified of the changes automatically. On the day, just bring your book and meet on campus!
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">I already sold my book, how can I mark my post as unavailable on JustBookr?</dt>
            </summary>
            <p><b>Go over to your books, find your post, press "Edit", and then press "Mark as sold".</b> It's very important that if you sell your book outside of JustBookr, you mark it as sold (if you sell it here then it's all automatic). This makes sure JustBookr stays relevant and also gives you a little boost in ranking for your other and future posts.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Nobody has bought my books yet - how can I sell them faster?</dt>
            </summary>
            <p>
                There's two ways that can directly increase your chances of selling your book; <b>you can boost your posts on JustBookr (more info below), and you can share your posts on your other social media networks</b>. Do both of these to maximize your chances!
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">I own a business that sells books - can I use JustBookr to show my offers to students?</dt>
            </summary>
            <p>
                <b>Yes.</b> Check out our offer for businesses, <router-link :to="{ name: 'business' }">available here</router-link>.
            </p>
        </details>
        <h4 class="display-5 row w-75 mx-auto mt-3"><span class="light">Buying</span></h4>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">How do I buy a book?</dt>
            </summary>
            <p>Easy as one two three. <b><router-link :to="{ name: 'home' }">Find a book</router-link> you need then tap on "Buy".</b> You'll meet on campus to exchange money and book. If there currently isn't anyone selling the book you need at your campus, you can turn on notifications to get notfied of new posts, and check the pricing and availability on Amazon.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">How do I pay for the book?</dt>
            </summary>
            <p>After seeing the book in person, you <b>pay the seller directly, in cash, on campus</b>. If you buy a book from a business on JustBookr, that business may support other payment and shipping methods; it'll be clear if and when they do.
            </p>
        </details>
        <h4 class="display-5 row w-75 mx-auto mt-3"><span class="light">Managing orders</span></h4>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Where do I manage my orders?</dt>
            </summary>
            <p><b>If you are the seller, check your <router-link :to="'/inbox'">inbox</router-link>, otherwise it's in <router-link :to="'/your-textbooks'">your books</router-link>.</b>
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Can I reschedule or change the meeting place for one of my orders?</dt>
            </summary>
            <p>
                <b>Yes,</b> as long as the meeting has not already occured.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">The seller hasn’t confirmed my order yet - what should I do?</dt>
            </summary>
            <p>
               If the seller hasn't accepted or declined your order before the meeting time, you can <b>reschedule or cancel</b> the order.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">The seller/buyer didn’t show up at the agreed time and place. Now what?</dt>
            </summary>
            <p>
               If the order was confirmed and everything looked fine but it was a no-show, the best thing you can do is <b>leave a thumbs-down rating</b>. These are anonymous but help the JustBookr algorithm filter out bad apples and unfair sellers by punishing their post ranking.
            </p>
        </details>
        <h4 class="display-5 row w-75 mx-auto mt-3"><span class="light">Rating</span></h4>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">How do I rate someone?</dt>
            </summary>
            <p><b>After the meeting has already occured, if you are the seller, you can rate the buyer in your <router-link :to="'/inbox'">inbox</router-link>, otherwise you can rate the seller in <router-link :to="'/your-textbooks'">your books</router-link>.</b>
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Can I see all of the ratings I received?</dt>
            </summary>
            <p><b>No,</b> you can only see a count of positive ratings you've received.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Do ratings affect anything?</dt>
            </summary>
            <p><b>Yes,</b> They have an effect on how your posts rank on JustBookr. Too many negative posts may lead to your account being suspended.
            </p>
        </details>
        <h4 class="display-5 row w-75 mx-auto mt-3"><span class="light">Boosting posts</span></h4>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">How do I boost my post?</dt>
            </summary>
            <p><b>Go to <router-link :to="'/your-textbooks'">your books</router-link>, tap on the book post you want to post, then tap on "Boost".</b>
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">Why should I boost my post?</dt>
            </summary>
            <p>Boosting your post is a good idea <b>because it increases your chance of selling your book faster</b> by showing your post before all the other posts, and on more pages.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">How much does it cost to boost my post?</dt>
            </summary>
            <p>Pricing is calculated by our algorithm and is <b>based on the duration that you want to boost your post and the value of the book</b> that you have posted. As an example, if you post a book for sale that is valued at €50 (regardless of your price), it would cost €3 to boost for a week, €6 for two weeks, and €8 for 3 weeks.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">How do I pay for a post boost?</dt>
            </summary>
            <p>You can pay <b>with your credit or debit card</b>. You only have to fill in your card details once; JustBookr will remember a reference to an encrypted version of them until you choose to update your card.
            </p>
        </details>
        <details class="row w-75 mx-auto mb-2">
            <summary>
                <dt class="d-inline">What happens when I boost my post?</dt>
            </summary>
            <p><b>Your post becomes visible on more pages and is shown above other offers.</b> A "Boosted" text will appear in the top right corner to let you know that the post is boosted.
            </p>
        </details>
    </div>
</template>
<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    layout: 'app',

    metaInfo() {
        return { title: this.$t('home') }
    },

    data: () => ({
        title: window.config.appName
    })
}
</script>
<style scoped>
a.btn-primary {
    border-radius: 5px;
    height: 30px;
    line-height: 30px;
    color: white;
}

.title {
    font-size: 75px;
}

.light {
    font-weight: 200;
}

summary {
 margin-bottom: 0.57rem;
}

p {
    font-size: 1.05rem;
}
</style>