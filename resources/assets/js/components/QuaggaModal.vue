<template>
    <div class="modal fade" id="quaggaModal" tabindex="-1" role="dialog" ref="vuemodal">
        <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">{{ $t('scan_your_books_barcode') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div id="scanner-container"></div>
                </div>
                <div class="modal-footer" style="justify-content: flex-start;">Hold the barcode close and inside the green square until you see a blue square.</div>
            </div>
        </div>
    </div>
</template>

<script>
import Quagga from 'quagga'
export default {
    name: 'quagga-modal',
    methods: {
        init() {
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#scanner-container'),
                    constraints: {
                        facingMode: "environment"
                    },
                },
                decoder: {
                    readers: ["ean_reader"],
                    halfSample: true,
                    patchSize: "medium",
                    debug: {
                        showCanvas: true,
                        showPatches: true,
                        showFoundPatches: true,
                        showSkeleton: true,
                        showLabels: true,
                        showPatchLabels: true,
                        showRemainingPatchLabels: true,
                        boxFromPatches: {
                            showTransformed: true,
                            showTransformedBox: true,
                            showBB: true
                        }
                    }
                },
            }, function (err) {
                if (err) {
                    console.log(err)
                    alert("We couldn't start your camera")
                    document.getElementById('quaggaModal').modal('hide')
                    return false
                }
                Quagga.start()
            })
            Quagga.onProcessed(function (result) {
                var drawingCtx = Quagga.canvas.ctx.overlay
                var drawingCanvas = Quagga.canvas.dom.overlay
                if (result) {
                    if (result.boxes) {
                        drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")))
                        result.boxes.filter(function (box) {
                            return box !== result.box
                        }).forEach(function (box) {
                            Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 })
                        })
                    }
                    if (result.box) {
                        Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 })
                    }
                    if (result.codeResult && result.codeResult.code) {
                        Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 })
                    }
                }
            })
            let detectionHash = {}
            Quagga.onDetected( (result) => {
              detectionHash[result.codeResult.code] = (detectionHash[result.codeResult.code] || 0) + 1
              if(detectionHash[result.codeResult.code] >= 5 && result.codeResult.format == "ean_13") {
                detectionHash = {}
                this.$emit('giveBarcode', result.codeResult.code)
                document.getElementById('quaggaModal').modal('hide')
              }
            })
        },
        stop() {
          Quagga.stop()
        },
        startRecording() {
          this.init()
        }
    },
    mounted() {
        $(this.$refs.vuemodal).on("hide.bs.modal", this.stop)
        $(this.$refs.vuemodal).on("show.bs.modal", this.startRecording)
    },
    beforeDestroy() {
      this.stop()
    }
}
</script>

<style>
/* scopedをつけると何故か上手く行かないのでここだけとりあえずこれで！ */
#scanner-container video {
  width: 100%;
  height: 100%;
}
#scanner-container canvas {
  top: 0px;
  left: 0px;
  position: absolute;
}
</style>