<script setup>
import { onMounted, onUnmounted, defineEmits } from "vue";
import { Html5Qrcode } from "html5-qrcode";

const emit = defineEmits(["scanned"]);
let html5QrCode;

onMounted(async () => {
  const cameras = await Html5Qrcode.getCameras();

  if (cameras && cameras.length) {
    const cameraId = cameras[0].id; // pick first camera
    html5QrCode = new Html5Qrcode("reader");

    html5QrCode
        .start(
            cameraId,
            { fps: 10, qrbox: 250 },
            (decodedText) => {
              emit("scanned", decodedText); // send code to parent
              stopScanner();
            },
            (errorMessage) => {
              console.log("Scanning...", errorMessage);
            }
        )
        .catch((err) => console.error("Camera start failed", err));
  } else {
    alert("No camera found on this device");
  }
});

const stopScanner = () => {
  if (html5QrCode) {
    html5QrCode.stop().then(() => html5QrCode.clear());
  }
};

onUnmounted(stopScanner);
</script>

<template>
  <div class="scanner-container">
    <div id="reader" style="width: 320px; height: 320px;"></div>
  </div>
</template>

<style scoped>
.scanner-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
</style>