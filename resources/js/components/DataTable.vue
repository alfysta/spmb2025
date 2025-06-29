<script setup>
import { router } from '@inertiajs/vue3';
import debounce from 'lodash.debounce';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    data: Object, // paginated data (users, etc.)
    search: String,
    perPage: Number,
    routeName: String,
    searchPlaceholder: {
        type: String,
        default: 'Cari data...',
    },
    perPageOptions: {
        type: Array,
        default: () => [5, 10, 25, 50, 100],
    },
});

const localSearch = ref(props.search || '');
const localPerPage = ref(props.perPage || 10);

watch(
    localSearch,
    debounce((val) => {
        router.get(
            route(props.routeName),
            {
                search: val,
                per_page: localPerPage.value,
            },
            {
                preserveState: true,
                replace: true,
            },
        );
    }, 500),
);

const updatePerPage = () => {
    router.get(
        route(props.routeName),
        {
            search: localSearch.value,
            per_page: localPerPage.value,
        },
        {
            preserveState: false,
        },
    );
};

const goToPage = (url) => {
    if (url) {
        router.visit(url, {
            preserveState: true,
            preserveScroll: true,
        });
    }
};

const getPageUrl = (page) => {
    const base = new URL(props.data.path, window.location.origin);
    base.searchParams.set('search', localSearch.value);
    base.searchParams.set('per_page', localPerPage.value);
    base.searchParams.set('page', page);
    return base.toString();
};

const paginationRange = computed(() => {
    const total = props.data.last_page;
    const current = props.data.current_page;
    const delta = 2;
    const range = [];

    for (let i = Math.max(1, current - delta); i <= Math.min(total, current + delta); i++) {
        range.push(i);
    }

    return range;
});

const from = computed(() => (props.data.data.length === 0 ? 0 : (props.data.current_page - 1) * props.data.per_page + 1));

const to = computed(() => Math.min(props.data.total, props.data.current_page * props.data.per_page));
</script>

<template>
    <div>
        <!-- Search & Per Page -->

        <div class="flex-column flex flex-wrap items-center justify-between space-y-4 pb-4 md:flex-row md:space-y-0">
            <div>
                <select v-model="localPerPage" @change="updatePerPage" class="bg-card w-32 rounded-full border px-2 py-2 text-sm">
                    <option v-for="option in perPageOptions" :key="option" :value="option">{{ option }} per page</option>
                </select>
            </div>

            <div class="relative">
                <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                    <svg class="h-4 w-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                        />
                    </svg>
                </div>
                <input
                    v-model="localSearch"
                    type="text"
                    :placeholder="searchPlaceholder"
                    id="table-search-users"
                    class="dark:bg-card block w-80 rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                />
            </div>
        </div>

        <!-- Slot Tabel -->
        <slot :data="data.data" :from="from" :to="to" />
        <div class="mt-4 flex items-center justify-between gap-2">
            <div class="mt-4 text-sm text-gray-600">
                Menampilkan <strong>{{ from }}</strong> - <strong>{{ to }}</strong> dari <strong>{{ data.total }}</strong> data
            </div>

            <!-- Pagination -->
            <div v-if="data.total > data.per_page" class="mt-4 flex items-center justify-center gap-2">
                <button
                    class="rounded-full bg-gray-800 px-3 py-1 text-sm hover:bg-gray-900"
                    :disabled="!data.prev_page_url"
                    @click="goToPage(data.prev_page_url)"
                >
                    &laquo; Previous
                </button>

                <button
                    v-for="page in paginationRange"
                    :key="page"
                    class="hidden gap-2 rounded-full px-3 py-1 text-sm lg:flex"
                    :class="{
                        'bg-blue-600 text-white': page === data.current_page,
                        'bg-gray-800 hover:bg-gray-200': page !== data.current_page,
                    }"
                    @click="goToPage(getPageUrl(page))"
                >
                    {{ page }}
                </button>

                <button
                    class="rounded-full bg-gray-800 px-3 py-1 text-sm hover:bg-gray-900"
                    :disabled="!data.next_page_url"
                    @click="goToPage(data.next_page_url)"
                >
                    Next &raquo;
                </button>
            </div>
        </div>
        <!-- Info Total -->
    </div>
</template>
