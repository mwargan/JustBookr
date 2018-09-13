<template>
        <svg v-if="active" id="checkmark" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 193.3 193.3" :class="{run: active}" ><circle class="cls-1 circle" cx="96.65" cy="96.65" r="94.15"/><polyline class="cls-1 checkmark" points="46.9 101.4 76.9 131.4 146.4 61.9"/></svg>
</template>
<script>
export default {
    name: 'checkmark',
    props: ['active']
}
</script>

<style scoped>
.cls-1 {
  fill: none;
  stroke: #018e42;
  stroke-miterlimit: 10;
  stroke-width: 5px;
}
#checkmark {
  margin: 0 auto;
  width: 150px;
  height: 150px;
  display: block;
  margin-bottom: 1rem;
}

.circle {
  stroke-dasharray: 700;
  stroke-dashoffset: 700;
}

.checkmark {
  stroke-dasharray: 150;
  stroke-dashoffset: 150;
}

.run .circle {
  -webkit-animation: 1.5s circleDraw forwards;
          animation: 1.5s circleDraw forwards;
}
.run .checkmark {
  -webkit-animation: 0.75s checkmarkDraw forwards;
          animation: 0.75s checkmarkDraw forwards;
  -webkit-animation-delay: 0.5s;
          animation-delay: 0.5s;
}

@-webkit-keyframes circleDraw {
  from {
    stroke-dashoffset: 700;
  }
  to {
    stroke-dashoffset: 0;
  }
}

@keyframes circleDraw {
  from {
    stroke-dashoffset: 700;
  }
  to {
    stroke-dashoffset: 0;
  }
}
@-webkit-keyframes checkmarkDraw {
  from {
    stroke-dashoffset: 150;
  }
  to {
    stroke-dashoffset: 0;
  }
}
@keyframes checkmarkDraw {
  from {
    stroke-dashoffset: 150;
  }
  to {
    stroke-dashoffset: 0;
  }
}
</style>
