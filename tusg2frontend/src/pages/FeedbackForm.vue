<template>
  <div class="max-w-sm mx-auto mt-10 p-6 border rounded-xl bg-[#fdfcf8] shadow-sm">
    <h2 class="text-xl font-bold text-center mb-4">GIVE FEEDBACK</h2>

    <p class="text-gray-700 text-center mb-4">How was this item scanning result?</p>

    <!-- Radio Options -->
    <div class="flex flex-col gap-2 mb-4">
      <label class="flex items-center gap-2">
        <input type="radio" v-model="feedback.rating" value="Great" class="accent-green-600" />
        Great
      </label>
      <label class="flex items-center gap-2">
        <input type="radio" v-model="feedback.rating" value="Okay" class="accent-green-600" />
        Okay
      </label>
      <label class="flex items-center gap-2">
        <input type="radio" v-model="feedback.rating" value="Unsure" class="accent-green-600" />
        Unsure
      </label>
    </div>

    <!-- Item Suggestion -->
    <div class="mb-4">
      <label class="font-semibold block mb-1">ITEM SUGGESTION</label>
      <input
          v-model="feedback.suggestion"
          type="text"
          placeholder="Bin suggestion name"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-300"
      />
    </div>

    <!-- Submit Button -->
    <button
        @click="submitFeedback"
        class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg transition"
    >
      Submit
    </button>

    <!-- Confirmation -->
    <p v-if="submitted" class="mt-4 text-green-700 text-center font-medium">
      ✅ Thank you for your feedback!
    </p>
  </div>
</template>

<script>
export default {
  name: "FeedbackForm",
  data() {
    return {
      feedback: {
        rating: "",
        suggestion: "",
      },
      submitted: false,
    };
  },
  methods: {
    async submitFeedback() {
      if (!this.feedback.rating) {
        alert("Please select a rating before submitting!");
        return;
      }

      try {
        // 可替换为你的 CodeIgniter API endpoint
        await this.$axios.post("/api/feedback", this.feedback);
        this.submitted = true;
        this.feedback = { rating: "", suggestion: "" };
      } catch (error) {
        console.error("Error submitting feedback:", error);
        alert("Failed to submit feedback. Please try again later.");
      }
    },
  },
};
</script>

<style scoped>
/* 保持简约的浅色风格 */
body {
  font-family: Arial, sans-serif;
}
</style>
