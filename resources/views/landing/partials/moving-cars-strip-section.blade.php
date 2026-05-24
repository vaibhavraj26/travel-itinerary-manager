<section class="py-2 bg-none overflow-hidden" aria-label="Moving cars animation">
  <div class="max-w-6xl mx-auto px-6 flex justify-center">
    <canvas id="canvas" width="260" height="120" class="pointer-events-none w-[260px] h-[120px]"></canvas>
  </div>

  <script type="module">
    import { DotLottie } from "https://cdn.jsdelivr.net/npm/@lottiefiles/dotlottie-web/+esm";

    new DotLottie({
      autoplay: true,
      loop: true,
      mode: "reverse",
      canvas: document.getElementById("canvas"),
      src: "https://lottie.host/f5389794-bfbd-4a4d-b21d-d0f3f5b12b18/ZHwDHbpjZL.lottie",
    });
  </script>
</section>