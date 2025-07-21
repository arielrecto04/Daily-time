<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores';
import { storeToRefs } from 'pinia';

const authStore = useAuthStore();

const { isAuthenticated } = storeToRefs(authStore);

// --- COMPONENT STATE & DATA ---
const isAnnualBilling = ref(true);

const features = [
    {
        icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`,
        title: "Effortless Time Tracking",
        description: "Empower your team with one-click clock-ins, automated break tracking, and seamless timesheet submissions from any device."
    },
    {
        icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>`,
        title: "Real-time Attendance Dashboard",
        description: "Gain instant visibility into who’s working, who’s late, and who’s on leave with a live, easy-to-read dashboard."
    },
    {
        icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h15.75c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 013 21v-7.875zM3 6.375C3 5.754 3.504 5.25 4.125 5.25h15.75c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 013 13.125V6.375z" /></svg>`,
        title: "Simplified Payroll & Reporting",
        description: "Generate accurate, detailed reports in seconds. Export data effortlessly to integrate with your existing payroll software."
    }
];

const faqs = ref([
    {
        question: 'How does the 14-day free trial work?',
        answer: 'You get full access to all features on our Pro plan for 14 days without needing a credit card. At the end of the trial, you can choose a plan to continue, or your account will be paused.',
        open: true,
    },
    {
        question: 'Can I change my plan later?',
        answer: 'Absolutely. You can upgrade, downgrade, or switch between monthly and annual billing at any time from your account dashboard. Changes are pro-rated automatically.',
        open: false,
    },
    {
        question: 'What devices does TimeFlow work on?',
        answer: 'TimeFlow is a web-based application, so it works on any device with a modern browser, including desktops, laptops, tablets, and smartphones. No app installation required!',
        open: false,
    },
    {
        question: 'Is my data secure?',
        answer: 'Yes. Data security is our top priority. We use industry-standard encryption for all data at rest and in transit, and our infrastructure is hosted on secure, compliant cloud servers.',
        open: false,
    },
]);

const toggleFaq = (index) => {
    faqs.value = faqs.value.map((faq, i) => {
        if (i === index) {
            faq.open = !faq.open;
        } else {
            faq.open = false;
        }
        return faq;
    });
};

</script>

<template>
    <div class="bg-gray-50 font-sans text-gray-800">

        <!-- Navbar -->
        <header class="bg-white/80 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
            <div class="container mx-auto flex items-center justify-between p-4">
                <div class="flex items-center">
                    <a href="#" class="text-xl font-bold text-blue-600">TimeFlow</a>
                </div>
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 font-medium">Features</a>
                    <a href="#pricing" class="text-gray-600 hover:text-blue-600 font-medium">Pricing</a>
                    <a href="#testimonials" class="text-gray-600 hover:text-blue-600 font-medium">Testimonials</a>
                </nav>
                <div class="flex items-center space-x-2">
                    <template v-if="isAuthenticated">
                        <router-link to="/dashboard"
                            class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">Dashboard</router-link>
                    </template>
                    <template v-else>
                        <router-link to="/login"
                            class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">Log
                            In </router-link>
                    </template>
                    <a href="#"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">Get
                        Started Free</a>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="bg-white">
                <div class="container mx-auto flex flex-col items-center px-4 py-24 text-center">
                    <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-gray-900">
                        Bring <span class="text-blue-600">Clarity & Control</span> to Your Team's Time
                    </h1>
                    <p class="mt-6 max-w-2xl text-lg text-gray-600">
                        TimeFlow is the all-in-one Daily Time Record platform that eliminates manual tracking, reduces
                        errors, and gives you back your most valuable asset: time.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="#"
                            class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md shadow-sm">Start
                            14-Day Free Trial</a>
                        <a href="#"
                            class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 border border-transparent rounded-md">Request
                            a Demo</a>
                    </div>
                </div>
            </section>

            <!-- Trusted By Section -->
            <section class="py-12 bg-gray-50">
                <div class="container mx-auto px-4">
                    <p class="text-center font-semibold text-gray-500 tracking-wider uppercase">TRUSTED BY TEAMS AT
                        FORWARD-THINKING COMPANIES</p>
                    <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-x-8 gap-y-4 items-center">
                        <!-- Replace with real logos -->
                        <div class="flex justify-center text-gray-400 text-2xl font-bold grayscale opacity-70">
                            InnovateCo</div>
                        <div class="flex justify-center text-gray-400 text-2xl font-bold grayscale opacity-70">Quantum
                        </div>
                        <div class="flex justify-center text-gray-400 text-2xl font-bold grayscale opacity-70">Apex Inc.
                        </div>
                        <div class="flex justify-center text-gray-400 text-2xl font-bold grayscale opacity-70">Strive
                        </div>
                        <div class="flex justify-center text-gray-400 text-2xl font-bold grayscale opacity-70">NextGen
                        </div>
                        <div class="flex justify-center text-gray-400 text-2xl font-bold grayscale opacity-70">Momentum
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section id="features" class="py-24 bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-3xl mx-auto">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">A Better Way to Manage Time</h2>
                        <p class="mt-4 text-lg text-gray-600">TimeFlow isn't just a clock. It's a complete toolkit
                            designed to make time tracking intelligent, seamless, and beneficial for everyone.</p>
                    </div>
                    <div class="mt-20 grid md:grid-cols-3 gap-12">
                        <div v-for="feature in features" :key="feature.title" class="text-center">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 rounded-xl bg-blue-100 text-blue-600">
                                <div v-html="feature.icon"></div>
                            </div>
                            <h3 class="mt-6 text-xl font-bold text-gray-900">{{ feature.title }}</h3>
                            <p class="mt-2 text-gray-600">{{ feature.description }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonial Section -->
            <section id="testimonials" class="bg-indigo-600">
                <div class="container mx-auto px-4 py-20">
                    <figure class="max-w-4xl mx-auto text-center">
                        <blockquote class="text-2xl md:text-3xl font-medium text-white">
                            “Switching to TimeFlow has been a revelation. We’ve cut our payroll processing time in half
                            and the accuracy is impeccable. Our team loves how easy it is to use.”
                        </blockquote>
                        <figcaption class="mt-8">
                            <div class="font-bold text-white">Sarah Johnson</div>
                            <div class="text-indigo-200">HR Director, InnovateCo</div>
                        </figcaption>
                    </figure>
                </div>
            </section>

            <!-- Pricing Section -->
            <section id="pricing" class="py-24 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-3xl mx-auto">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Simple, Transparent Pricing</h2>
                        <p class="mt-4 text-lg text-gray-600">Choose the plan that fits your team's size and needs. No
                            hidden fees, ever.</p>
                    </div>
                    <div class="mt-8 flex justify-center">
                        <div class="relative flex p-1 bg-gray-200 rounded-lg">
                            <button @click="isAnnualBilling = false"
                                :class="!isAnnualBilling ? 'bg-white shadow' : 'bg-transparent'"
                                class="relative w-1/2 rounded-md py-2 text-sm font-medium text-gray-700 whitespace-nowrap focus:outline-none sm:w-auto sm:px-8">Monthly</button>
                            <button @click="isAnnualBilling = true"
                                :class="isAnnualBilling ? 'bg-white shadow' : 'bg-transparent'"
                                class="relative w-1/2 rounded-md py-2 text-sm font-medium text-gray-700 whitespace-nowrap focus:outline-none sm:w-auto sm:px-8">Annually
                                (Save 20%)</button>
                        </div>
                    </div>
                    <div class="mt-12 grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                        <!-- Starter Plan -->
                        <div class="bg-white shadow-lg border rounded-xl overflow-hidden">
                            <div class="p-8">
                                <h3 class="text-lg font-bold text-gray-900">Starter</h3>
                                <p class="text-gray-500 mt-1">For small teams getting started.</p>
                                <p class="text-4xl font-bold my-4 text-gray-900">
                                    {{ isAnnualBilling ? '$15' : '$19' }}
                                    <span class="text-lg font-normal text-gray-500">/ user / month</span>
                                </p>
                                <ul class="space-y-3 text-gray-600">
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Up to 10 Users</li>
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Core Time Tracking</li>
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Basic Reporting</li>
                                </ul>
                                <a href="#"
                                    class="mt-6 block w-full text-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md">Choose
                                    Plan</a>
                            </div>
                        </div>
                        <!-- Pro Plan -->
                        <div class="bg-white shadow-lg border-2 border-blue-600 rounded-xl overflow-hidden relative">
                            <div class="absolute top-0 right-4 -mt-3">
                                <div
                                    class="inline-flex items-center text-sm font-semibold py-1.5 px-3 bg-blue-600 text-white rounded-full">
                                    Most Popular</div>
                            </div>
                            <div class="p-8">
                                <h3 class="text-lg font-bold text-gray-900 mt-2">Pro</h3>
                                <p class="text-gray-500 mt-1">For growing businesses that need more power.</p>
                                <p class="text-4xl font-bold my-4 text-gray-900">
                                    {{ isAnnualBilling ? '$28' : '$35' }}
                                    <span class="text-lg font-normal text-gray-500">/ user / month</span>
                                </p>
                                <ul class="space-y-3 text-gray-600">
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Unlimited Users</li>
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Live Attendance Dashboard</li>
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Advanced Reporting</li>
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Payroll Integrations</li>
                                </ul>
                                <a href="#"
                                    class="mt-6 block w-full text-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">Choose
                                    Plan</a>
                            </div>
                        </div>
                        <!-- Enterprise Plan -->
                        <div class="bg-white shadow-lg border rounded-xl overflow-hidden">
                            <div class="p-8">
                                <h3 class="text-lg font-bold text-gray-900">Enterprise</h3>
                                <p class="text-gray-500 mt-1">For large organizations with custom needs.</p>
                                <p class="text-4xl font-bold my-4 text-gray-900">Contact Us</p>
                                <ul class="space-y-3 text-gray-600">
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Everything in Pro, plus:</li>
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Dedicated Account Manager</li>
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>Custom Integrations & API</li>
                                    <li class="flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-emerald-500">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z"
                                                clip-rule="evenodd" />
                                        </svg>SAML SSO</li>
                                </ul>
                                <a href="#"
                                    class="mt-6 block w-full text-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-md">Contact
                                    Sales</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="py-24 bg-white">
                <div class="container mx-auto px-4 max-w-3xl">
                    <div class="text-center">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Frequently Asked Questions</h2>
                    </div>
                    <div class="mt-12 space-y-4">
                        <div v-for="(faq, index) in faqs" :key="index" class="bg-gray-50 rounded-lg">
                            <button @click="toggleFaq(index)"
                                class="w-full flex justify-between items-center text-left p-6">
                                <span class="text-lg font-medium text-gray-900">{{ faq.question }}</span>
                                <svg :class="{ 'transform rotate-180': faq.open }"
                                    class="w-6 h-6 text-gray-500 transition-transform duration-200"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div v-if="faq.open" class="px-6 pb-6 text-gray-600">
                                <p>{{ faq.answer }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Final CTA -->
            <section class="py-24 bg-gray-50">
                <div class="container mx-auto px-4 text-center max-w-3xl">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Ready to Revolutionize Your Time Tracking?
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">Join hundreds of efficient teams who trust TimeFlow. Get
                        started today and see the difference.</p>
                    <div class="mt-8">
                        <a href="#"
                            class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md shadow-sm">Start
                            Your Free Trial Now</a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-300">
            <div class="container mx-auto px-4 py-16">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-100 tracking-wider uppercase">Product</h3>
                        <ul class="mt-4 space-y-3">
                            <li><a href="#" class="hover:text-white">Features</a></li>
                            <li><a href="#" class="hover:text-white">Pricing</a></li>
                            <li><a href="#" class="hover:text-white">Security</a></li>
                            <li><a href="#" class="hover:text-white">Integrations</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-100 tracking-wider uppercase">Company</h3>
                        <ul class="mt-4 space-y-3">
                            <li><a href="#" class="hover:text-white">About Us</a></li>
                            <li><a href="#" class="hover:text-white">Contact</a></li>
                            <li><a href="#" class="hover:text-white">Careers</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-100 tracking-wider uppercase">Legal</h3>
                        <ul class="mt-4 space-y-3">
                            <li><a href="#" class="hover:text-white">Terms of Use</a></li>
                            <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-white">Cookie Policy</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-100 tracking-wider uppercase">TimeFlow</h3>
                        <p class="mt-4">The modern DTR platform.</p>
                    </div>
                </div>
                <div class="mt-12 border-t border-gray-700 pt-8 text-center">
                    <p class="text-sm text-gray-400">&copy; 2025 TimeFlow Inc. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</template>
