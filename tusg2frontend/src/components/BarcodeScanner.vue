<template>
  <div class="scanner-container">
    <video id="video" width="320" height="240" autoplay></video>
    <p v-if="scannedCode">Scanned Code: {{ scannedCode }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { BrowserMultiFormatReader } from '@zxing/browser'

const scannedCode = ref('')
let codeReader

onMounted(async () => {
  codeReader = new BrowserMultiFormatReader()

  try {
    // Get all cameras
    const devices = await BrowserMultiFormatReader.listVideoInputDevices()

    // Try to pick the back camera if available
    let selectedDeviceId = devices[0].deviceId
    const backCam = devices.find(d => d.label.toLowerCase().includes('back'))
    if (backCam) selectedDeviceId = backCam.deviceId

    // Start scanning
    await codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
      if (result) {
        scannedCode.value = result.getText()
        alert(`Scanned Code: ${scannedCode.value}`)
      }
    })
  } catch (error) {
    console.error('Error starting scanner:', error)
  }
})

onUnmounted(() => {
  if (codeReader) codeReader.reset()
})
</script>

<style scoped>
.scanner-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
}
video {
  border: 3px solid #4caf50;
  border-radius: 10px;
}
</style>
