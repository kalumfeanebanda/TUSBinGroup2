<template>
  <div v-if="showFeedback" class="p-6 max-w-md mx-auto bg-white shadow-lg rounded-2xl">
    <h2 class="text-xl font-semibold mb-4 text-green-700">Item Not Found</h2>
    <p class="text-gray-600 mb-4">
      We couldn’t find this item in our database. Please help us improve by filling out this short form.
    </p>

    <form @submit.prevent="submitFeedback">
      <!-- Item Name -->
      <div class="mb-3">
        <label class="block text-gray-700 mb-1">Item Name *</label>
        <input v-model="feedback.itemName" type="text" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-300"
               placeholder="e.g. Plastic water bottle" />
      </div>

      <!-- Suggested Category -->
      <div class="mb-3">
        <label class="block text-gray-700 mb-1">Suggested Bin Category *</label>
        <select v-model="feedback.category" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-300">
          <option disabled value="">Select a category</option>
          <option>Recyclable</option>
          <option>Compost</option>
          <option>General Waste</option>
          <option>Glass</option>
          <option>Other</option>
        </select>
      </div>

      <!-- Description -->
      <div class="mb-3">
        <label class="block text-gray-700 mb-1">Item Description</label>
        <textarea v-model="feedback.description"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-300"
                  placeholder="Add more details about the item (optional)"></textarea>
      </div>

      <!-- Image Upload -->
      <div class="mb-3">
        <label class="block text-gray-700 mb-1">Upload Image (optional)</label>
        <input type="file" @change="handleFileUpload" accept="image/*"
               class="w-full text-gray-600 border border-gray-300 rounded-lg px-3 py-2" />
      </div>

      <!-- Email (optional) -->
      <div class="mb-3">
        <label class="block text-gray-700 mb-1">Email (optional)</label>
        <input v-model="feedback.email" type="email"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-green-300"
               placeholder="e.g. name@example.com" />
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end">
        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
          Submit Feedback
        </button>
      </div>
    </form>

    <!-- Confirmation Message -->
    <div v-if="submitted" class="mt-4 text-green-700 font-medium">
      ✅ Thank you! Your suggestion has been submitted successfully.
    </div>
  </div>
</template>

<script>
export default {
  name: "FeedbackForm",
  props: {
    showFeedback: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      feedback: {
        itemName: "",
        category: "",
        description: "",
        image: null,
        email: ""
      },
      submitted: false
    };
  },
  methods: {
    handleFileUpload(event) {
      this.feedback.image = event.target.files[0];
    },
    async submitFeedback() {
      try {
        const formData = new FormData();
        formData.append("itemName", this.feedback.itemName);
        formData.append("category", this.feedback.category);
        formData.append("description", this.feedback.description);
        formData.append("email", this.feedback.email);
        if (this.feedback.image) formData.append("image", this.feedback.image);


        await this.$axios.post("/api/feedback/submit", formData, {
          headers: { "Content-Type": "multipart/form-data" }
        });

        this.submitted = true;
        this.feedback = { itemName: "", category: "", description: "", image: null, email: "" };
      } catch (error) {
        console.error("Feedback submission failed:", error);
        alert("There was an error submitting your feedback. Please try again later.");
      }
    }
  }
};
</script>

