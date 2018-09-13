<template>
	<div class="timeline-wrapper">
	  <div class="timeline-item card facebook-card">
	    <div class="animated-background facebook" style="height: 36px;" v-if="small">
	      <div class="background-masker rounded-circle"></div>
	      <div class="background-masker header-top"></div>
	      <div class="background-masker header-left"></div>
	      <div class="background-masker header-right"></div>
	      <div class="background-masker header-bottom"></div>
	      <div class="background-masker subheader-left"></div>
	      <div class="background-masker subheader-right"></div>
	      <div class="background-masker subheader-bottom"></div>
	    </div>
	    <div class="animated-background facebook" v-else>
	      <div class="background-masker rounded-circle"></div>
	      <div class="background-masker header-top"></div>
	      <div class="background-masker header-left"></div>
	      <div class="background-masker header-right"></div>
	      <div class="background-masker header-bottom"></div>
	      <div class="background-masker subheader-left"></div>
	      <div class="background-masker subheader-right"></div>
	      <div class="background-masker subheader-bottom"></div>
	      <div class="background-masker content-top"></div>
	    </div>
	  </div>
	</div>
</template>

<script>
export default {
  name: 'CardPlaceholder',
  props: ['small']
}
</script>
<style scoped>

	@-webkit-keyframes placeHolderShimmer {
	  0% {
	    background-position: -468px 0
	  }
	  100% {
	    background-position: 468px 0
	  }
	}

	@keyframes placeHolderShimmer {
	  0% {
	    background-position: -468px 0
	  }
	  100% {
	    background-position: 468px 0
	  }
	}

	.timeline-item {
	  border-radius: 1rem;
	  padding: 12px;
	}

	.animated-background {
	  -webkit-animation-duration: 1.3s;
	  animation-duration: 1.3s;
	  -webkit-animation-fill-mode: forwards;
	  animation-fill-mode: forwards;
	  -webkit-animation-iteration-count: infinite;
	  animation-iteration-count: infinite;
	  -webkit-animation-name: placeHolderShimmer;
	  animation-name: placeHolderShimmer;
	  -webkit-animation-timing-function: linear;
	  animation-timing-function: linear;
	  background: #f7f9fb;
	  background: #eeeeee;
	  background: -webkit-gradient(linear, left top, right top, color-stop(8%, #f7f9fb), color-stop(18%, #eeeeee), color-stop(33%, #f7f9fb));
	  background: -webkit-linear-gradient(left, #f7f9fb 8%, #eeeeee 18%, #f7f9fb 33%);
	  background: linear-gradient(to right, #f7f9fb 8%, #eeeeee 18%, #f7f9fb 33%);
	  -webkit-background-size: 1000px 104px;
	  background-size: 1000px 104px;
	  height: 76px;
	  position: relative;
	}

	.background-masker {
	  background: #fff;
	  position: absolute;
	  -webkit-box-sizing: border-box;
	  -moz-box-sizing: border-box;
	  box-sizing: border-box;
	}

	.outlined .background-masker {
	  border: 1px solid #ddd;
	}

	.outlined:hover .background-masker {
	  border: none;
	}

	.outlined:hover .background-masker:hover {
	  border: 1px solid #ccc;
	  z-index: 1;
	}

	.background-masker.header-top,
	.background-masker.header-bottom,
	.background-masker.subheader-bottom {
	  top: 0;
	  left: 40px;
	  right: 0;
	  height: 10px;
	}

	.background-masker.header-left,
	.background-masker.subheader-left,
	.background-masker.header-right,
	.background-masker.subheader-right {
	  top: 10px;
	  left: 40px;
	  height: 8px;
	  width: 10px;
	}

	.background-masker.header-bottom {
	  top: 18px;
	  height: 6px;
	}

	.background-masker.subheader-left,
	.background-masker.subheader-right {
	  top: 24px;
	  height: 6px;
	}

	.background-masker.header-right,
	.background-masker.subheader-right {
	  width: auto;
	  left: 300px;
	  right: 0;
	}

	.background-masker.subheader-right {
	  left: 230px;
	}

	.background-masker.subheader-bottom {
	  top: 30px;
	  height: 10px;
	}

	.background-masker.content-top,
	.background-masker.content-second-line,
	.background-masker.content-third-line,
	.background-masker.content-second-end,
	.background-masker.content-third-end,
	.background-masker.content-first-end {
	  top: 40px;
	  left: 0;
	  right: 0;
	  height: 6px;
	}

	.background-masker.content-top {
	  height: 20px;
	}

	.background-masker.content-first-end,
	.background-masker.content-second-end,
	.background-masker.content-third-end {
	  width: auto;
	  left: 380px;
	  right: 0;
	  top: 60px;
	  height: 8px;
	}

	.background-masker.content-second-line {
	  top: 68px;
	}

	.background-masker.content-second-end {
	  left: 420px;
	  top: 74px;
	}

	.background-masker.content-third-line {
	  top: 82px;
	}

	.background-masker.content-third-end {
	  left: 300px;
	  top: 88px;
	}
</style>