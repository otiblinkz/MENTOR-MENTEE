<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue'
import { StarIcon } from '@heroicons/vue/20/solid'
import { Head, usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import axios from 'axios';

const page = usePage()

const authuser = computed(() => page.props.auth.user)

defineProps({
    user: {
        type: Object,
        required: true,
    },
    mentor: {
        type: Object,
        required: true,
    },
    is_mentor: {
        required: true,
    },
    mentee_list: {
        type: Object,
        required: true,
    },
    mine: {
        required: true,
    },
});

const requestData = {
      requestSent: false,
      buttonText: 'Request to be a Mentee',
    };

const sendRequest = (userId,mentorId) => {

    // this.$refs.myButton.innerText = 'Button clicked';
      // Make a request to your Laravel API to insert the request into the database
      try {
        axios.get(route('request.to.become.mentee')+"?id="+userId+"&&mentor="+mentorId).then(response => {
            // console.log(response.data.success);
            requestData.requestSent = response.data.success ?? false;
            window.location.reload();
        });
      } catch (error) {
        console.error('Error sending request:', error);
      }
    }
const acceptRequest = (userId,mentorId) => {

    // this.$refs.myButton.innerText = 'Button clicked';
      // Make a request to your Laravel API to insert the request into the database
      try {
        axios.get(route('accept.to.become.mentor')+"?id="+userId+"&&mentor="+mentorId).then(response => {
            // console.log(response.data.success);
            requestData.requestSent = response.data.success ?? false;
            window.location.reload();
        });
      } catch (error) {
        console.error('Error sending request:', error);
      }
    }





const reviews = {
    average: 4,
    featured: [
        {
            id: 1,
            rating: 5,
            content: `
                <p>They were a pleasure to work with, I was very impressed with their development skills and their ability to explain complex concepts in a simple way</p>
            `,
            date: 'July 16, 2021',
            datetime: '2021-07-16',
            author: 'Emily Selman',
            avatarSrc:
                'https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80',
        },
        {
            id: 2,
            rating: 5,
            content: `
                <p>Loved our pairing session, thanks so much!</p>
            `,
            date: 'July 12, 2021',
            datetime: '2021-07-12',
            author: 'Hector Gibbons',
            avatarSrc:
                'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80',
        },
        // More reviews...
    ],
}
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">@{{ user.username }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="mx-auto px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                    <div class="lg:grid lg:grid-cols-7 lg:grid-rows-1 lg:gap-x-8 lg:gap-y-10 xl:gap-x-16">
                        <div class="lg:col-span-4 lg:row-end-1">
                            <div class="aspect-h-3 w-64 h-64 aspect-w-4 overflow-hidden rounded-lg flex justify-center">
                                <img :src="user.avatar" :alt="user.name" class="object-cover w-full h-full object-center rounded-lg" />
                            </div>
                        </div>

                        <div class="mx-auto mt-14 max-w-2xl sm:mt-16 lg:col-span-3 lg:row-span-2 lg:row-end-2 lg:mt-0 lg:max-w-none">
                        <div class="flex flex-col-reverse">
                            <div class="mt-4">
                                <div class="flex items-baseline">
                                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-3xl">{{ user.name }}</h1>
                                    <Link v-if="user.id == authuser.id" :href="route('profile.edit')" class="ml-4 text-sm text-indigo-600 hover:text-indigo-500">Edit Profile</Link>
                                </div>

                                <p v-if="user.is_mentor" class="text-lg text-gray-900 dark:text-gray-100">{{ mentor.job_title }} {{ user.mentor.company ? 'at '+ user.mentor.company : '' }}</p>

                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-200">
                                    {{ user.timezone }}
                                </p>
                            </div>

                            <div>
                                <div v-if="user.is_mentor" class="flex items-center">
                                    <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[reviews.average > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                                </div>
                            </div>
                        </div>

                        <p class="mt-6 text-gray-800 dark:text-gray-200">{{ user.bio }}</p>

                        <div v-if="user.is_mentor && is_mentor==2 && user.id != authuser.id" class="mt-10">
                            <button type="button" @click="sendRequest(authuser.id,user.id)" class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Request to be a Mentee</button>
                        </div>
                        <!-- <p>{{ mine }}</p> -->
                        <div v-if="authuser.is_mentor && mine==0" class="mt-10">
                            <button type="button" @click="acceptRequest(user.id,authuser.id)" class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-8 py-3 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-50">Accept Request</button>
                        </div>

                        <div v-if="user.is_mentor && is_mentor==0" class="mt-10">
                            <button type="button" class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Your Request is Pending...</button>
                        </div>
                        <!-- <p>{{ mentor }}</p> -->

                        <div v-if="user.is_mentor && mentor.mentor.skills.length > 0" class="mt-10 border-t border-gray-200 pt-10">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-200">Skills</h3>
                            <div class="prose prose-sm mt-4 text-gray-800 dark:text-gray-200">
                                <ul role="list">
                                    <li v-for="skill in mentor.mentor.skills" :key="skill.id">{{ skill.name }}</li>
                                </ul>
                            </div>
                        </div>

                        <!-- <div class="mt-10 border-t border-gray-200 pt-10">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Disclaimer</h3>
                            <p class="mt-4 text-sm text-gray-800 dark:text-gray-200">This mentor App is still under construction <a class="font-medium text-indigo-600 hover:text-indigo-500">Read full Terms and Conditions</a></p>
                        </div> -->

                        </div>

                        <div class="mx-auto mt-16 w-full max-w-2xl lg:col-span-4 lg:mt-0 lg:max-w-none">
                        <TabGroup as="div">
                            <div class="border-b border-gray-200">
                            <TabList class="-mb-px flex space-x-8">
                                <!-- <Tab as="template" v-slot="{ selected }" v-if="user.id == authuser.id">
                                    <button :class="[selected ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-700 dark:text-gray-300 hover:border-gray-300 hover:text-gray-800 dark:hover:text-gray-200', 'whitespace-nowrap border-b-2 py-6 text-sm font-medium']">Upcoming Sessions</button>
                                </Tab> -->
                                <Tab as="template" v-slot="{ selected }" v-if="user.is_mentor">
                                    <button :class="[selected ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-700 dark:text-gray-300 hover:border-gray-300 hover:text-gray-800 dark:hover:text-gray-200', 'whitespace-nowrap border-b-2 py-6 text-sm font-medium']">Mentees</button>
                                </Tab>
                            </TabList>
                            </div>
                            <TabPanels as="template">
                                <TabPanel class="text-sm text-gray-800 dark:text-gray-200" v-if="user.id == authuser.id">
                                    <!-- <div v-if="user.is_mentor">
                                        <div v-for="(session, sessionIdx) in user.mentor.sessions" :key="session.id" class="flex space-x-4 text-sm text-gray-800 dark:text-gray-200">
                                            <div class="flex-none py-10">
                                                <img :src="session.mentee.user.avatar" alt="" class="h-10 w-10 rounded-full bg-gray-100" />
                                            </div>
                                            <div :class="[sessionIdx === 0 ? '' : 'border-t border-gray-200', 'py-10']">
                                                <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ session.author }}</h3>
                                                <p>
                                                <time :datetime="session.datetime">{{ session.date }}</time>
                                                </p>

                                                <div class="mt-4 flex items-center">
                                                <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[session.rating > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                                                </div>
                                                <p class="sr-only">{{ session.rating }} out of 5 stars</p>

                                                <div class="prose prose-sm mt-4 max-w-none text-gray-800 dark:text-gray-200" v-html="session.content" />
                                            </div>
                                        </div>
                                        <div v-if="user.mentor.sessions.length == 0" class="pt-10">
                                            No upcoming mentor sessions
                                        </div>
                                    </div> -->
                                    <!-- <div v-if="authuser.is_mentee">
                                        <div v-for="(session, sessionIdx) in session.sessions" :key="session.id" class="flex space-x-4 text-sm text-gray-800 dark:text-gray-200">
                                            <div class="flex-none py-10">
                                                <img :src="session.mentor.user.avatar" alt="" class="h-10 w-10 rounded-full bg-gray-100" />
                                            </div>
                                            <div :class="[sessionIdx === 0 ? '' : 'border-t border-gray-200', 'py-10']">
                                                <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ session.author }}</h3>
                                                <p>
                                                <time :datetime="session.datetime">{{ session.date }}</time>
                                                </p>

                                                <div class="mt-4 flex items-center">
                                                <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[session.rating > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                                                </div>
                                                <p class="sr-only">{{ session.rating }} out of 5 stars</p>

                                                <div class="prose prose-sm mt-4 max-w-none text-gray-800 dark:text-gray-200" v-html="session.content" />
                                            </div>
                                        </div>
                                        <div v-if="user.mentee.sessions.length == 0" class="pt-10">
                                            No upcoming sessions
                                        </div>
                                    </div> -->

                                </TabPanel>

                                <TabPanel class="-mb-10" v-if="user.is_mentor">
                                    <div v-for="review in mentee_list" :key="review.id" class="flex space-x-4 text-sm text-gray-800 dark:text-gray-200">
                                        <div class="flex-none py-10">
                                            <img :src="review.user.avatar_url" alt="" class="h-10 w-10 rounded-full bg-gray-100" />
                                        </div>
                                        <div :class="[reviewIdx === 0 ? '' : 'border-t border-gray-200', 'py-10']">
                                            <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ review.user.name }}</h3>
                                            <p>
                                            <time :datetime="review.created_at">{{ review.created_at }}</time>
                                            </p>

                                            <div class="mt-4 flex items-center">
                                            <!-- <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[review.rating > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" /> -->
                                                <p class=" font-medium text-gray-900 dark:text-gray-100">{{ review.user.timezone }}</p>
                                            </div>
                                            <p class="sr-only">{{ review.rating }} out of 5 stars</p>

                                            <!-- <div class="prose prose-sm mt-4 max-w-none text-gray-800 dark:text-gray-200" v-html="review.user.bio" /> -->
                                        </div>
                                    </div>
                                </TabPanel>

                            </TabPanels>
                        </TabGroup>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
