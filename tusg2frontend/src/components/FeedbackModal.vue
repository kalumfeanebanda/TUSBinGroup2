<template>
  <div v-if="show" class="modal-overlay">
    <div class="modal-box">

      <button class="close-btn" @click="$emit('close')">×</button>
      

      <Feedback :showFeedback="true" />
    </div>
  </div>
</template>

<script>
import Feedback from "@/pages/Feedback.vue";

export default {
  props: { show: Boolean },
  components: { Feedback }
}
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal-box {
  background: white;
  width: 500px;
  max-width: 90%;
  padding: 20px 25px;
  border-radius: 16px;
  position: relative;
  box-shadow: 0 10px 35px rgba(0,0,0,0.2);
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 12px;
  background: transparent;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #444;
}

.modal-title {
  font-size: 24px;
  font-weight: bold;
  color: #1d8348;
  margin-bottom: 8px;
}

.modal-text {
  font-size: 14px;
  color: #555;
  margin-bottom: 16px;
}
</style>
