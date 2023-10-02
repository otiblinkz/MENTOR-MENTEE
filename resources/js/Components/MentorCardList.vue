<script setup>
import MentorList from '@/Components/MentorList.vue'

const props = defineProps({
  mentors: {
    type: Array,
    required: true,
  },
})

</script>
<template>
  <ul role="list" class="flex flex-col">
    <li v-for="mentor in mentors" :key="mentor.id">
        <!-- <p>{{ mentor.mentorlist[0].name }}</p> -->
      <MentorList :mentor="mentor" />
    </li>
  </ul>
</template>
