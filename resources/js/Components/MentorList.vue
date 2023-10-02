<script setup>
import { defineProps } from 'vue'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  mentor: {
    type: Object,
    required: true,
  },
})

// const encodedName = encodeURI(props.mentor.name);
const image = props.mentor.mentorlist[0].avatar;

</script>
<template>
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-7 py-8 transition-all duration-150 mb-12 max-w-screen-md mx-auto text-gray-800 dark:text-gray-200 leading-tight">
    <div class="sm:grid grid-cols-12 sm:space-x-8">
      <div class="col-span-4 md:col-span-5 relative">
        <a
          class="relative w-full h-72 bg-center bg-cover inline-block rounded-lg overflow-hidden"
          :style="{ backgroundImage: `url(${image})`}"
        >
        </a>
      </div>
      <div class="relative col-span-full col-start-5 md:col-start-6">
        <div class="text-xl font-bold">{{  mentor.mentorlist[0].name }}</div>
        <div class="flex text-xs">
          <!-- <div class="">{{ mentor.job_title }}</div> -->
          <div class="ml-2">({{ mentor.mentorlist[0].timezone }})</div>
        </div>
        <div class="mt-4 text-sm line-clamp-5">{{ mentor.mentorlist[0].bio }}</div>
        <!-- <div class="flex items-center flex-wrap justify-start space-x-2 mt-3">
          <div  v-bind:key="skill" v-for="skill in mentor.skills" class="bg-indigo-100 text-indigo-600 rounded-full py-0.5 px-2.5 text-xs font-bold md:inline-block hover:bg-indigo-200">
            {{ skill.name }}
          </div>
        </div> -->
        <div :class="[mentor.status == 0 ? 'text-red-600 mt-4 dark:text-indigo-500 leading-none' : 'text-indigo-600 mt-4 dark:text-indigo-500 leading-none']">
          <span class="text-2xl font-black">{{ mentor.status == 0 ? 'Inactive' : 'Active'}}</span>
        </div>
        <Link
          :href="route('profile.show', mentor.mentorlist[0].username)"
          type="button"
          class="mt-3 rounded-md bg-indigo-600 dark:bg-indigo-500 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
          View Profile
        </Link>
      </div>
    </div>
  </div>
</template>
